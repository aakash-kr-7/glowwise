"""Collect reviewed original articles into the repeatable WordPress import."""
from pathlib import Path
import re,json,csv
root=Path(__file__).resolve().parents[1]
metadata=json.loads((root/'content/guide-metadata.json').read_text(encoding='utf-8'))
guides=[(g['slug'],g['title'],g['intro'],g['category'],g['items']) for g in metadata]
assert len(guides)==7 and len({g[0] for g in guides})==7
records=[];register=[]
for slug,title,intro,category,products in guides:
 html=(root/'content/guides'/f'{slug}.html').read_text(encoding='utf-8')
 sources=list(dict.fromkeys(re.findall(r'href="(https://[^"]+)"',html)))
 words=len(re.findall(r'\b[\w₹]+\b',re.sub('<[^>]+>',' ',html)))
 assert all(section in html for section in ['How we selected','shortlist','Practical buying guidance','Common questions','Supporting references']),(slug,'Missing editorial section')
 assert all('/products/'+p+'/' in html for p in products),(slug,'Missing recommendation')
 records.append({'kind':'post','slug':slug,'title':title,'excerpt':intro,'description':intro,'checked':'2026-10-10','category':category,'guide_products':products,'sources':sources,'html':html})
 register.append({'slug':slug,'canonical':'https://glowwise.tech/guides/'+slug+'/','category':category,'wordCountExcludingTemplate':words,'checked':'2026-10-10','sources':sources,'method':'Original desk research; manufacturer claims distinguished; no personal testing','sourcePath':'content/guides/'+slug+'.html'})
(root/'content/guides.json').write_text(json.dumps(records,ensure_ascii=False,indent=2)+'\n',encoding='utf-8')
(root/'Documentation/Implementation/GUIDE_SOURCE_REGISTER.json').write_text(json.dumps(register,ensure_ascii=False,indent=2)+'\n',encoding='utf-8')
print('Seven original guides:',[(r['slug'],r['wordCountExcludingTemplate']) for r in register])
