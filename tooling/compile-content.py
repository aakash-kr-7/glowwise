"""Compile reviewed, portable content sources. This never reads users/inbox/backups."""
from pathlib import Path
import json
root=Path(__file__).resolve().parents[1]
records=json.loads((root/'content/products.json').read_text(encoding='utf-8'))
for file in ['pages.json','guides.json']:
 if (root/'content'/file).exists():records+=json.loads((root/'content'/file).read_text(encoding='utf-8'))
categories={
'skincare':{'description':'Cleansing and sun protection, with the label details that help you choose. Explore face cleansers and sunscreens without treating a skin concern as a diagnosis.'},
'haircare':{'description':'A considered wash-day starting point. Compare shampoos by their identified pack, named formula and source claims, then build a routine around how your hair actually feels.'},
'bodycare':{'description':'Everyday comfort, from a fragrance-free lotion to a scent you enjoy. Check the pack size, read the limitations and keep personal tolerance at the centre of your choice.'},
'fragrance':{'description':'Your scent, your preference. Discover checked eau de parfum variants and useful note descriptions—without pretending that a note list proves longevity or personal fit.'},
'beard-grooming':{'description':'Conditioning, grooming and a little clarity about growth claims. Choose care for the beard and the skin underneath, with the product facts kept separate from marketing.'},
'grooming-tools':{'description':'Practical details before the first trim. Compare identified beard-trimmer models, manufacturer runtime and cleaning instructions—not an invented performance score.'}}
identities=[(r['kind'],r['slug']) for r in records];assert len(identities)==len(set(identities)),'Duplicate identity'
out={'schemaVersion':1,'categories':categories,'records':records}
(root/'content/seed.json').write_text(json.dumps(out,indent=2,ensure_ascii=False)+'\n',encoding='utf-8')
print('Reviewed content records:',len(records))
