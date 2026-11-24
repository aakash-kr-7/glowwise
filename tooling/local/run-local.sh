#!/usr/bin/env bash
# Disposable local Glowwise: real WordPress + Yoast + glowwise-core + theme + seed content,
# running in WordPress Playground (PHP/SQLite in WASM). No Docker, MySQL or PHP install needed.
# Data lives in memory/temp and is discarded on exit. Usage: bash tooling/local/run-local.sh [port]
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
PORT="${1:-8890}"
RT="$ROOT/.runtime/playground"          # git-ignored
mkdir -p "$RT"
[ -x "$RT/node_modules/.bin/wp-playground-cli" ] || (cd "$RT" && npm init -y >/dev/null && npm install @wp-playground/cli)
(cd "$ROOT" && npm ci >/dev/null && node tooling/build-assets.mjs)   # hashed CSS/JS into theme/assets/dist (ignored)
exec "$RT/node_modules/.bin/wp-playground-cli" server --port="$PORT" \
  --blueprint="$ROOT/tooling/local/blueprint.json" \
  --mount="$ROOT/plugins/glowwise-core:/wordpress/wp-content/plugins/glowwise-core" \
  --mount="$ROOT/theme/glowwise:/wordpress/wp-content/themes/glowwise" \
  --mount="$ROOT/content/seed.json:/wordpress/seed.json"
