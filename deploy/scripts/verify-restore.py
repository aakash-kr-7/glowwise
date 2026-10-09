#!/usr/bin/env python3
"""Verify a private backup in isolated files/database on the same VM."""
import datetime as dt
import gzip
import hashlib
from pathlib import Path
import subprocess
import tarfile

base = Path('/srv/glowwise')
backup = sorted((base / 'backups').iterdir())[-1]
target = base / 'private/restore-check' / backup.name
target.mkdir(parents=True, exist_ok=False)
subprocess.run(['sha256sum', '-c', 'SHA256SUMS'], cwd=backup, check=True)
for name in ['wordpress', 'caddy-data', 'caddy-config', 'config-and-source']:
    dest = target / name
    dest.mkdir()
    with tarfile.open(backup / (name + '.tar.gz')) as archive:
        archive.extractall(dest, filter='data')
print(dt.datetime.now(dt.timezone.utc).isoformat(), 'Restore validation', backup.name)
live = Path(subprocess.check_output(['docker', 'volume', 'inspect',
    'glowwise_wordpress', '--format', '{{.Mountpoint}}'], text=True).strip())
for file in ['wp-config.php', 'wp-includes/version.php']:
    assert hashlib.sha256((live/file).read_bytes()).digest() == hashlib.sha256((target/'wordpress'/file).read_bytes()).digest()
    print(file, 'restored hash matches live persistent volume')
dump = gzip.decompress((backup / 'database.sql.gz').read_bytes())
assert b'\nUSE ' not in dump and b'CREATE DATABASE' not in dump, 'Dump changes database context; aborting'
compose = ['docker', 'compose', '-f', str(base/'source/deploy/stack/compose.yaml'),
           'exec', '-T', 'database', 'sh', '-c']
def sql(statement, database=''):
    cmd = 'exec mariadb --batch --skip-column-names --user=root --password="$(cat /run/secrets/db-root-password)" ' + database
    return subprocess.check_output(compose + [cmd], input=statement)
test_db = 'glowwise_restorecheck'
sql(('CREATE DATABASE ' + test_db + ';').encode())
try:
    sql(dump, test_db)
    for table in ['wp_options', 'wp_posts', 'wp_users', 'wp_postmeta']:
        statement = ('SELECT COUNT(*) FROM ' + table + ';').encode()
        assert sql(statement, 'glowwise') == sql(statement, test_db)
        print(table, 'restored row count matches live database')
    assert sql(b"SELECT option_value FROM wp_options WHERE option_name='blog_public';",test_db).strip()==sql(b"SELECT option_value FROM wp_options WHERE option_name='blog_public';",'glowwise').strip()
    print('Restored indexing decision matches live. Live database was not replaced.')
finally:
    # Only the database created by this validation is disposable.
    sql(('DROP DATABASE ' + test_db + ';').encode())
print('PASS: private archive integrity, isolated file extraction and SQL restore.')
