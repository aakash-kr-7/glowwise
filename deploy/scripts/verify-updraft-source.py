import datetime,hashlib,json,subprocess,zipfile
from pathlib import Path
base=Path('/srv/glowwise');folder=base/'private/updraft'
db=max(folder.glob('backup_*-db.gz'),key=lambda p:p.stat().st_mtime);stem=db.name.removesuffix('-db.gz')
checks=[]
for suffix,root,prefix in [('themes',base/'source/theme/glowwise','themes/glowwise/'),('plugins',base/'source/plugins/glowwise-core','plugins/glowwise-core/')]:
 with zipfile.ZipFile(folder/(stem+'-'+suffix+'.zip')) as z:
  names=z.namelist()
  for f in root.rglob('*'):
   if not f.is_file():continue
   relative=f.relative_to(root).as_posix();expected=prefix+relative
   matches=[n for n in names if n.endswith(expected)]
   assert len(matches)==1,relative
   assert hashlib.sha256(z.read(matches[0])).digest()==hashlib.sha256(f.read_bytes()).digest(),relative
   checks.append({'entity':suffix,'relativePath':relative,'sha256':hashlib.sha256(f.read_bytes()).hexdigest(),'matchesLiveSourceOrGeneratedAsset':True})
revision=subprocess.check_output(['git','-C',str(base/'source'),'rev-parse','HEAD'],text=True).strip()
print(json.dumps({'capturedUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),'purpose':'Every actual custom theme/core source, licensed font and generated asset in the final UpdraftPlus archives matches the live deployment; archive names/content stay private','sourceRevision':revision,'checks':checks},indent=2))
