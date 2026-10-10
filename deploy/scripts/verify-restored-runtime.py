#!/usr/bin/env python3
"""Boot recovered WordPress privately against a disposable restored DB. Run as root.

No public port, live DB changes, credentials in output or additional Azure resources.
Uses the latest full infrastructure backup after verify-restore.py extracts it.
"""
import datetime, gzip, json, os, shutil, subprocess, time, urllib.request
from pathlib import Path

assert os.geteuid() == 0
base = Path('/srv/glowwise')
backup = sorted((base/'backups').iterdir())[-1]
target = base/'private/restore-check'/backup.name
assert target.is_dir() and target.resolve().parent == (base/'private/restore-check').resolve()
compose = ['docker','compose','-f',str(base/'source/deploy/stack/compose.yaml')]
database = 'glowwise_runtime_disposable_restore'
container = 'glowwise-private-restore-check'
def sql(statement, name=''):
    return subprocess.check_output(compose+['exec','-T','database','sh','-c',
        'exec mariadb --batch --skip-column-names --user=root --password="$(cat /run/secrets/db-root-password)" '+name],input=statement)

image = json.loads((base/'source/deploy/stack/images.lock.json').read_text())['wordpress']['image']
dump = gzip.decompress((backup/'database.sql.gz').read_bytes())
assert b'\nUSE ' not in dump and b'CREATE DATABASE' not in dump
assert not subprocess.check_output(['docker','ps','-aq','--filter','name=^/'+container+'$']).strip()
sql(('CREATE DATABASE '+database+';').encode())
checks=[]
try:
    sql(dump,database)
    recovered=target/'config-and-source/source'
    command=['docker','run','-d','--name',container,'--memory=192m','--cpus=1',
        '--network=glowwise_database',
        '-e','WORDPRESS_DB_HOST=glowwise-database-1:3306','-e','WORDPRESS_DB_NAME='+database,
        '-e','WORDPRESS_DB_USER=root','-e','WORDPRESS_DB_PASSWORD_FILE=/run/secrets/db-root-password',
        '-e',"WORDPRESS_CONFIG_EXTRA=define('WP_HOME', 'https://glowwise.tech'); define('WP_SITEURL', 'https://glowwise.tech'); define('DISABLE_WP_CRON', true); define('DISALLOW_FILE_EDIT', true); $_SERVER['HTTPS']='on';",
        '-v',str(target/'wordpress')+':/var/www/html',
        '-v',str(recovered/'theme/glowwise')+':/var/www/html/wp-content/themes/glowwise:ro',
        '-v',str(recovered/'plugins/glowwise-core')+':/var/www/html/wp-content/plugins/glowwise-core:ro',
        '-v',str(base/'secrets/db-root-password')+':/run/secrets/db-root-password:ro',image]
    subprocess.run(command,check=True,stdout=subprocess.DEVNULL)
    def http(path):
        return subprocess.check_output(['docker','exec',container,'curl','--fail','--silent',
            '--max-time','10','-H','Host: glowwise.tech','-H','X-Forwarded-Proto: https','http://127.0.0.1'+path],stderr=subprocess.DEVNULL)
    for attempt in range(20):
        try:
            body=http('/').decode()
            break
        except (OSError,subprocess.CalledProcessError):
            if attempt==19:raise
            time.sleep(1)
    assert 'site-footer' in body and 'data-cookie-open' in body and 'Find your' in body
    checks.append({'test':'Restored native WordPress boots and renders actual custom homepage/footer','pass':True})
    catalog=json.loads(http('/wp-json/glowwise/v1/products'))
    assert catalog['total']==40
    checks.append({'test':'Recovered custom plugin/API serves 40 published products','pass':True})
    for kind, count in [('post',7),('page',16)]:
        actual=int(sql(("SELECT COUNT(*) FROM wp_posts WHERE post_status='publish' AND post_type='"+kind+"';").encode(),database))
        assert actual==count
        checks.append({'test':'Restored published '+kind+' count','count':actual,'pass':True})
    ports=json.loads(subprocess.check_output(['docker','inspect','--format','{{json .NetworkSettings.Ports}}',container]))
    assert not any(value for value in ports.values())
    checks.append({'test':'Temporary HTTP has no host port binding; isolated internal network, request from inside container','pass':True})
finally:
    subprocess.run(['docker','rm','-f',container],stdout=subprocess.DEVNULL,stderr=subprocess.DEVNULL)
    sql(('DROP DATABASE '+database+';').encode())
    shutil.rmtree(target)
print(json.dumps({'capturedUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),
    'purpose':'Actual isolated restored WordPress runtime; recovered files and SQL, no production overwrite or public second site',
    'checks':checks,'temporaryContainerDatabaseAndExtractedFilesRemoved':True,
    'notTested':['A new Azure VM rebuild','Restored administrator browser login','Disaster DNS failover']},indent=2))
