#!/usr/bin/env python3
"""Run as root after database/WordPress health checks, before Caddy starts."""
import json
from pathlib import Path
import subprocess
base = Path('/srv/glowwise')
c = json.loads((base / 'private/credentials.json').read_text())
email = (base / 'private/admin-email').read_text().strip()
command = ['docker', 'compose', '-f', str(base / 'source/deploy/stack/compose.yaml'),
           'run', '--rm', '-T', 'wpcli']
def wp(*args, check=True):
    return subprocess.run(command + list(args), check=check, capture_output=True, text=True)
if wp('core', 'is-installed', check=False).returncode == 0:
    raise SystemExit('WordPress already installed; refusing to replace the installation.')
r = wp('core', 'install', '--url=https://glowwise.tech', '--title=Glowwise — Development',
       '--admin_user=' + c['wordpressUsername'], '--admin_password=' + c['wordpressPassword'],
       '--admin_email=' + email, '--skip-email')
print(r.stdout.strip())
for key, value in [('blog_public','0'),('show_avatars','0'),('blogdescription','Protected development installation'),
                   ('default_comment_status','closed'),('default_ping_status','closed')]:
    r = wp('option', 'update', key, value)
    print(r.stdout.strip())
r = wp('rewrite', 'structure', '/%postname%/')
print(r.stdout.strip())
print('WordPress installed with indexing discouraged and avatars disabled.')
