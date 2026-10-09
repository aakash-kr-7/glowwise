#!/usr/bin/env python3
"""Validate the latest private UpdraftPlus set in an isolated database, not live."""
import datetime, gzip, hashlib, json, subprocess, zipfile
from pathlib import Path
base=Path('/srv/glowwise');folder=base/'private/updraft'
databases=sorted(folder.glob('backup_*-db.gz'),key=lambda p:p.stat().st_mtime)
assert databases,'No UpdraftPlus database archive'
database=databases[-1];stem=database.name.removesuffix('-db.gz')
archives=list(folder.glob(stem+'-*.zip'));assert len(archives)==4,'Expected plugins/themes/uploads/others'
checks=[]
for archive in archives:
    with zipfile.ZipFile(archive) as zipped:
        assert zipped.testzip() is None
        # Test retained custom sources without extracting private material publicly.
        if archive.name.endswith('-themes.zip'):assert any(name.endswith('glowwise/front-page.php') for name in zipped.namelist())
        if archive.name.endswith('-plugins.zip'):assert any(name.endswith('glowwise-core/includes/model.php') for name in zipped.namelist())
    checks.append({'entity':archive.name.rsplit('-',1)[1].removesuffix('.zip'),'bytes':archive.stat().st_size,'sha256':hashlib.sha256(archive.read_bytes()).hexdigest(),'integrity':True})
dump=gzip.decompress(database.read_bytes())
assert b'\nUSE ' not in dump and b'CREATE DATABASE' not in dump,'Refuse a dump that changes database context'
compose=['docker','compose','-f',str(base/'source/deploy/stack/compose.yaml'),'exec','-T','database','sh','-c']
def sql(statement,db=''):
    return subprocess.check_output(compose+['exec mariadb --batch --skip-column-names --user=root --password="$(cat /run/secrets/db-root-password)" '+db],input=statement)
target='glowwise_updraft_disposable_restore'
sql(('CREATE DATABASE '+target+';').encode())
try:
    sql(dump,target)
    for kind,expected in [('gw_product',36),('post',7),('page',16)]:
        count=int(sql(("SELECT COUNT(*) FROM wp_posts WHERE post_status='publish' AND post_type='"+kind+"';").encode(),target))
        assert count==expected,(kind,count)
        checks.append({'contentKind':kind,'restoredPublishedCount':count,'expected':expected,'pass':True})
    assert sql(b"SELECT option_value FROM wp_options WHERE option_name='blog_public';",target).strip()==b'0'
finally:sql(('DROP DATABASE '+target+';').encode())
print(json.dumps({'capturedUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),'purpose':'Actual private full UpdraftPlus archive verification and isolated SQL restore; live DB unchanged; no raw backup content/filename/credentials','checks':checks,'globalNoindexRestored':True,'disposableDatabaseRemoved':True},indent=2))
