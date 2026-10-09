#!/usr/bin/env bash
set -euo pipefail
export DEBIAN_FRONTEND=noninteractive
test "$(id -u)" = 0
apt-get update
apt-get -y upgrade
apt-get install -y ca-certificates curl unattended-upgrades python3 git jq
if ! swapon --show | grep -q /swapfile; then
  test -e /swapfile || fallocate -l 2G /swapfile
  chmod 600 /swapfile
  mkswap /swapfile
  swapon /swapfile
  grep -q '^/swapfile ' /etc/fstab || echo '/swapfile none swap sw 0 0' >> /etc/fstab
fi
echo 'vm.swappiness=10' > /etc/sysctl.d/90-glowwise.conf
sysctl --system >/dev/null
install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
chmod a+r /etc/apt/keyrings/docker.asc
cat > /etc/apt/sources.list.d/docker.sources <<'EOF'
Types: deb
URIs: https://download.docker.com/linux/ubuntu
Suites: noble
Components: stable
Architectures: amd64
Signed-By: /etc/apt/keyrings/docker.asc
EOF
apt-get update
install -d -m 700 /srv/glowwise/secrets /srv/glowwise/backups /srv/glowwise/private
install -d -o glowwiseadmin -g glowwiseadmin /srv/glowwise/source
# Initial installation resolved these vendor versions; subsequent runs use its lock.
lock="${GLOWWISE_PACKAGE_LOCK:-$(dirname "${BASH_SOURCE[0]}")/../host/docker-packages.lock}"
test -s "$lock"
install -m 600 "$lock" /srv/glowwise/private/docker-packages.lock
xargs -a /srv/glowwise/private/docker-packages.lock apt-get install -y
install -d /etc/docker
cat > /etc/docker/daemon.json <<'EOF'
{"log-driver":"local","log-opts":{"max-size":"5m","max-file":"3"},"live-restore":true}
EOF
systemctl enable docker unattended-upgrades
systemctl restart docker
# The authorized key was installed by Azure; verify it exists before hardening.
test -s /home/glowwiseadmin/.ssh/authorized_keys
cat > /etc/ssh/sshd_config.d/00-glowwise.conf <<'EOF'
PermitRootLogin no
PasswordAuthentication no
KbdInteractiveAuthentication no
PubkeyAuthentication yes
AllowUsers glowwiseadmin
MaxAuthTries 3
X11Forwarding no
AllowAgentForwarding no
EOF
sshd -t
systemctl reload ssh
cat > /etc/apt/apt.conf.d/52glowwise-unattended <<'EOF'
Unattended-Upgrade::Automatic-Reboot "false";
EOF
date -u --iso-8601=seconds
uname -m
docker version --format '{{.Server.Version}}'
docker compose version
free -h
echo 'Bootstrap complete; reboot if /var/run/reboot-required exists.'
