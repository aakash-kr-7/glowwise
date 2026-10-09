#!/usr/bin/env bash
set -euo pipefail
cd /srv/glowwise/source
image=$(python3 -c "import json; print(json.load(open('deploy/stack/images.lock.json'))['node-build']['image'])")
sudo docker run --rm --memory=128m --cpus=1 --user "$(id -u):$(id -g)" -v "$PWD:/work" -w /work "$image" sh -c 'node tests/analytics-unit.mjs && node tests/motion-unit.mjs'
python3 tests/cost-units.py
