"""Transfer a reviewed local commit through pinned SSH, without Git credentials.

Run from repository root with --revision <full SHA>. Back up first. Refuses
unexpected VM changes or deletions; preserves runtime volumes and WP edits.
Build locked assets on the VM after executable changes, then test affected paths.
"""
import argparse, datetime, json, re, subprocess
from pathlib import Path

parser=argparse.ArgumentParser()
parser.add_argument('--revision',required=True)
parser.add_argument('--ssh-config',default='.local/deployment/ssh_config')
parser.add_argument('--host',default='glowwise-dev')
parser.add_argument('--evidence',default='.local/deployment/deployed-revision.json')
args=parser.parse_args()
assert re.fullmatch(r'[0-9a-f]{40}',args.revision),'Use reviewed full commit SHA'
assert re.fullmatch(r'[a-zA-Z0-9-]+',args.host)
def run(command,**kw):return subprocess.run(command,check=True,capture_output=True,**kw)
assert run(['git','rev-parse',args.revision],text=True).stdout.strip()==args.revision
assert run(['git','rev-parse','HEAD'],text=True).stdout.strip()==args.revision,'Checkout the reviewed revision first'
work=Path('.local/deployment');work.mkdir(parents=True,exist_ok=True)
archive=work/'reviewed-source.tar';bundle=work/'reviewed-source.bundle'
run(['git','archive','--format=tar','--output='+str(archive),args.revision])
run(['git','bundle','create',str(bundle),'HEAD'])
for path in [archive,bundle]:
    run(['scp','-F',args.ssh_config,str(path),args.host+':/tmp/'+path.name])
remote=r'''
import datetime,hashlib,io,json,subprocess,tarfile
from pathlib import Path
root=Path('/srv/glowwise/source')
revision='REVISION'
def git(*args):return subprocess.check_output(['git','-C',str(root),*args],text=True).strip()
git('fetch','/tmp/reviewed-source.bundle',revision)
assert git('rev-parse','FETCH_HEAD')==revision
incoming={}
with tarfile.open('/tmp/reviewed-source.tar') as archive:
    for item in archive.getmembers():
        assert not item.issym() and not item.islnk()
        if item.isfile():incoming[item.name]=archive.extractfile(item).read()
old=git('ls-files').splitlines()
assert not set(old)-set(incoming),'Reviewed deletion needs explicit manual reconciliation'
changed=git('diff','--name-only','HEAD').splitlines()
for name in changed:
    current=(root/name).read_bytes()
    assert name in incoming and (current==incoming[name] or current.replace(b'\r\n',b'\n')==incoming[name]), 'Unexpected VM edit: '+name
for name,data in incoming.items():
    if name not in old and (root/name).exists():
        current=(root/name).read_bytes()
        assert current==data or current.replace(b'\r\n',b'\n')==data,'Unexpected untracked VM file: '+name
with tarfile.open('/tmp/reviewed-source.tar') as archive:archive.extractall(root,filter='data')
git('reset','--mixed',revision)
assert git('rev-parse','HEAD')==revision
checks=[]
for name,data in incoming.items():
    actual=(root/name).read_bytes()
    assert actual==data,'Tracked blob mismatch: '+name
    checks.append({'path':name,'sha256':hashlib.sha256(actual).hexdigest(),'matchesReviewedArchive':True})
assert not git('status','--porcelain','--untracked-files=no')
manifest=root/'theme/glowwise/assets/dist/manifest.json'
result={'capturedUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),
 'purpose':'Actual reviewed Git commit deployed through pinned SSH; every tracked blob matches, no credentials/runtime data transferred',
 'revision':revision,'trackedFiles':len(checks),'trackedWorkingTreeClean':True,
 'generatedManifestSHA256':hashlib.sha256(manifest.read_bytes()).hexdigest(),'checks':checks}
print(json.dumps(result,indent=2))
for name in ['reviewed-source.tar','reviewed-source.bundle']:(Path('/tmp')/name).unlink()
'''.replace('REVISION',args.revision)
result=run(['ssh','-F',args.ssh_config,args.host,'python3 -'],input=remote,text=True,encoding='utf-8')
parsed=json.loads(result.stdout)
Path(args.evidence).write_text(json.dumps(parsed,indent=2)+'\n',encoding='utf-8')
print('Verified deployed revision',parsed['revision'],';',parsed['trackedFiles'],'tracked blobs match')
