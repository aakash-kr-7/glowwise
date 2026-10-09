#!/usr/bin/env python3
"""Run once as root on the VM; never print generated credentials."""
import json
from pathlib import Path
import secrets
import subprocess

base = Path('/srv/glowwise')
secret_dir = base / 'secrets'
credentials_path = base / 'private/credentials.json'
if credentials_path.exists():
    raise SystemExit('Credentials already exist; refusing to rotate them implicitly.')
for name in ['db-password', 'db-root-password']:
    p = secret_dir / name
    p.write_text(secrets.token_urlsafe(36))
    p.chmod(0o640)
    import os
    os.chown(p, 0, 33)
credentials = {
    'developmentUrl': 'https://glowwise.tech',
    'developmentUsername': 'glowwise-dev',
    'developmentPassword': secrets.token_urlsafe(32),
    'wordpressAdminUrl': 'https://glowwise.tech/wp-admin/',
    'wordpressUsername': 'gw_admin_' + secrets.token_hex(4),
    'wordpressPassword': secrets.token_urlsafe(36),
}
lock = json.loads((base / 'source/deploy/stack/images.lock.json').read_text())
result = subprocess.run(['docker', 'run', '--rm', lock['caddy']['image'],
    'caddy', 'hash-password', '--plaintext', credentials['developmentPassword']],
    capture_output=True, text=True, check=True)
auth = secret_dir / 'development-auth.caddy'
auth.write_text('basic_auth {\n  glowwise-dev ' + result.stdout.strip() + '\n}\n')
auth.chmod(0o600)
credentials_path.write_text(json.dumps(credentials, indent=2))
credentials_path.chmod(0o600)
print('Unique credentials saved privately; no credential values logged.')
