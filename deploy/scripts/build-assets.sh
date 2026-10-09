#!/usr/bin/env bash
set -euo pipefail
cd /srv/glowwise/source
image=$(python3 -c "import json; print(json.load(open('deploy/stack/images.lock.json'))['node-build']['image'])")
sudo docker run --rm --memory=256m --cpus=1 --user "$(id -u):$(id -g)" \
  -e npm_config_cache=/tmp/npm-cache -v "$PWD:/work" -w /work "$image" \
  sh -c 'npm ci --no-audit --no-fund && npm run build:assets && npm run verify:minify'
