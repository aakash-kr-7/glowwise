"""Collect reviewed original articles into the repeatable WordPress import."""
from pathlib import Path
import re,json,csv
root=Path(__file__).resolve().parents[1]
guides=[
('shampoo-for-dry-frizzy-hair','Shampoo for dry, frizzy hair: a considered starting point','Compare four checked shampoo packs, understand conditioning claims and choose a practical wash-day starting point.','haircare',['minimalist-hydrating-factors-shampoo','minimalist-maleic-shampoo','plum-coconut-peptides-shampoo','plum-avocado-argan-shampoo']),
('sunscreen-for-oily-skin','Sunscreen for oily skin: protection, finish and a useful shortlist','Compare identified sunscreen variants, verified finish labels and protection information without a hidden performance score.','skincare',['plum-green-tea-zinc-spf-50','minimalist-light-fluid-spf-50','plum-rice-water-spf-50','minimalist-spf-50']),
('perfumes-under-1000','Perfumes under ₹1,000: the checked 20 ml edit','Six identified eau de parfum variants, actual item prices and visible stock limitations for an honest fragrance shortlist.','fragrance',['skinn-raw-20ml','skinn-steele-20ml','skinn-celeste-20ml','skinn-sheer-20ml','skinn-nude-20ml','skinn-verge-20ml']),
('body-lotion-for-dry-skin','Body lotion for dry skin: comfort, scent and clear choices','Compare a fragrance-free starting point with scented alternatives, keeping pack units and personal tolerance visible.','bodycare',['minimalist-niacinamide-body-lotion','plum-vanilla-caramello-lotion','plum-hawaiian-rumba-lotion']),
('face-wash-for-sensitive-skin','Face wash for sensitive skin: a simpler, source-checked shortlist','Two fragrance-free cleanser records, different pack sizes and clear limits on what gentle-label claims can tell you.','skincare',['minimalist-b12-oat-cleanser','minimalist-aquaporin-cleanser']),
('beard-oil-benefits','Beard-oil benefits: conditioning without growth promises','Understand the conditioning role, compare two checked oil packs and separate manufacturer growth language from evidence.','beard-grooming',['beardo-godfather-oil','beardo-beard-hair-oil']),
('trimmers-under-1500','Trimmers under ₹1,500: six identified models, useful differences','Compare checked Vega models by item price, charging, manufacturer runtime and cleaning limits, with stock notices visible.','grooming-tools',['vega-power-lite','vega-power-p1','vega-smartone-s3','vega-turboone','vega-smartone-s2','vega-turbolite'])]
records=[];register=[]
for slug,title,intro,category,products in guides:
 html=(root/'content/guides'/f'{slug}.html').read_text(encoding='utf-8')
 sources=list(dict.fromkeys(re.findall(r'href="(https://[^"]+)"',html)))
 words=len(re.findall(r'\b[\w₹]+\b',re.sub('<[^>]+>',' ',html)))
 assert words>=500,(slug,words)
 records.append({'kind':'post','slug':slug,'title':title,'excerpt':intro,'description':intro,'checked':'2026-10-09','category':category,'guide_products':products,'sources':sources,'html':html})
 register.append({'slug':slug,'canonical':'https://glowwise.tech/guides/'+slug+'/','category':category,'wordCountExcludingTemplate':words,'checked':'2026-10-09','sources':sources,'method':'Original desk research; manufacturer claims distinguished; no personal testing','sourcePath':'content/guides/'+slug+'.html'})
(root/'content/guides.json').write_text(json.dumps(records,ensure_ascii=False,indent=2)+'\n',encoding='utf-8')
(root/'Documentation/Implementation/GUIDE_SOURCE_REGISTER.json').write_text(json.dumps(register,ensure_ascii=False,indent=2)+'\n',encoding='utf-8')
print('Seven original guides:',[(r['slug'],r['wordCountExcludingTemplate']) for r in register])
