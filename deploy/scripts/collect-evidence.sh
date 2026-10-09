#!/usr/bin/env bash
set -euo pipefail
cd /srv/glowwise/source/deploy/stack
date -u --iso-8601=seconds
cat /etc/os-release
uname -rmo
echo 'SSH effective policy'
sudo sshd -T | grep -E '^(permitrootlogin|passwordauthentication|kbdinteractiveauthentication|pubkeyauthentication|allowusers|maxauthtries) '
ssh-keygen -lf /etc/ssh/ssh_host_ed25519_key.pub
echo 'Pinned host packages'
sudo cat /srv/glowwise/private/docker-packages.lock
sudo docker version --format 'Engine {{.Server.Version}}'
sudo docker compose version
sudo docker compose exec -T wordpress php -v
sudo docker compose exec -T wordpress apache2 -v
sudo docker compose exec -T database mariadb --version
sudo docker compose exec -T caddy caddy version
sudo docker compose run --rm -T wpcli cli version
sudo docker compose run --rm -T wpcli core version
sudo docker compose run --rm -T wpcli core is-installed
sudo docker compose run --rm -T wpcli option get blog_public
sudo docker compose run --rm -T wpcli option get home
sudo docker compose ps
sudo docker stats --no-stream --format '{{.Name}} {{.MemUsage}}'
sudo docker network inspect glowwise_database --format 'Database network internal={{.Internal}}'
sudo ss -lnt
sudo iptables -S DOCKER-USER
free -h
df -h /
sudo systemctl list-timers glowwise-cost-guard.timer --no-pager
sudo journalctl -u glowwise-cost-guard.service -n 8 --no-pager
test ! -e /var/run/reboot-required || echo 'OS reboot still required'
