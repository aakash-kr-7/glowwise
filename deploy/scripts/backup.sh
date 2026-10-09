#!/usr/bin/env bash
set -euo pipefail
umask 077
test "$(id -u)" = 0
cd /srv/glowwise/source/deploy/stack
stamp=$(date -u +%Y%m%dT%H%M%SZ)
dest=/srv/glowwise/backups/$stamp
install -d -m 700 "$dest"
restart() { docker compose -f /srv/glowwise/source/deploy/stack/compose.yaml up -d wordpress caddy >/dev/null; }
trap restart EXIT
docker compose stop caddy wordpress
# Dump exactly the application database; credentials remain inside the container.
docker compose exec -T database sh -c 'exec mariadb-dump --user=root --password="$(cat /run/secrets/db-root-password)" --single-transaction --routines --triggers --events glowwise' | gzip > "$dest/database.sql.gz"
for volume in wordpress caddy-data caddy-config; do
  source=$(docker volume inspect "glowwise_$volume" --format '{{.Mountpoint}}')
  tar -C "$source" -czf "$dest/$volume.tar.gz" .
done
tar -C /srv/glowwise -czf "$dest/config-and-source.tar.gz" \
  --exclude=source/node_modules --exclude=source/.git \
  --exclude=private/restore-check source secrets private
cd "$dest"
sha256sum *.gz > SHA256SUMS
printf 'Private recovery set: %s\n' "$stamp"
du -sh "$dest"
