"""Read-only live checks for the owner-requested demonstration media release."""
import concurrent.futures, datetime, json, re, urllib.request
from pathlib import Path
ROOT=Path(__file__).resolve().parents[1];ORIGIN='https://glowwise.tech';checks=[]
def get(path):
    request=urllib.request.Request(path if path.startswith('https://') else ORIGIN+path,headers={'User-Agent':'Glowwise-owned-editorial-acceptance/1.0'})
    with urllib.request.urlopen(request,timeout=40) as r:return r.status,r.read(),dict(r.headers)
def check(name,value):
    checks.append({'test':name,'pass':bool(value)})
    if not value:raise AssertionError(name)
products=[]
for page in [1,2]:products+=json.loads(get('/wp-json/glowwise/v1/products?per-page=24&page='+str(page))[1])['products']
check('40 published families, all with at least one photograph',len(products)==40 and all(p['imageAssets'] for p in products))
check('54 of 55 exact variants pictured',sum(len(p['imageAssets']) for p in products)==54 and sum(len(p['variants']) for p in products)==55)
photos=[(p,v,i) for p in products for v,i in p['imageAssets'].items()]
def verify_photo(row):
    p,v,i=row;status,raw,headers=get(i['src'])
    return p['slug']+' / '+v,status==200 and len(raw)>500 and headers.get('Content-Type','').startswith('image/') and i['width']>0 and i['height']>0 and i['alt'] and i['src'].startswith(ORIGIN+'/wp-content/uploads/')
with concurrent.futures.ThreadPoolExecutor(max_workers=3) as pool:
    for name,passed in pool.map(verify_photo,photos):check(name+' native photograph, dimensions and alternative text',passed)
for g in json.loads((ROOT/'content/guide-metadata.json').read_text(encoding='utf-8')):
    _,raw,h=get('/guides/'+g['slug']+'/');body=raw.decode('utf-8')
    author='Aakash Kumar' if g['slug'] in ['shampoo-for-dry-frizzy-hair','beard-oil-benefits','trimmers-under-1500'] else 'Disa Bandhu'
    graph=json.loads(re.search(r'<script type="application/ld\+json"[^>]*>(.*?)</script>',body,re.S)[1])['@graph']
    articles=[n for n in graph if n.get('@type')=='Article']
    check(g['slug']+' matching visible/schema founder author',author in body and len(articles)==1 and articles[0]['author']['name']==author)
    check(g['slug']+' complete recommendations and accurate disclosure',all('/products/'+s+'/' in body for s in g['items']) and 'AI-assisted drafting' in body and 'Supporting references' in body and 'Cofounder, Imagine Utopia' in body)
    check(g['slug']+' UTF-8, one canonical, private HTML cache',not any(s in body for s in ['Â·','â€”','â€™']) and len(re.findall(r'<link rel="canonical"',body))==1 and 'no-store' in h.get('Cache-Control',''))
for path in ['/explore/','/disclosures/','/how-we-select/']:
    _,raw,_=get(path);body=raw.decode('utf-8')
    check(path+' correct current photograph wording','Photographs where licensed' not in body and 'only where an exact-variant reuse licence' not in body)
out={'capturedUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),'purpose':'Actual native photo, founder byline/schema and content acceptance','families':40,'photographedVariants':54,'variants':55,'checks':checks,'limitations':['Brand photographs have source attribution, not independently verified reuse permission','Maleic 100 ml photo unavailable; 250 ml photograph is not substituted','No new lab performance or hands-on product testing claimed']}
dest=ROOT/'.local/demo-media/acceptance.json';dest.parent.mkdir(parents=True,exist_ok=True);dest.write_bytes((json.dumps(out,indent=2)+'\n').encode('utf-8'))
print('PASS',len(checks),'live demonstration checks; 40 photographed families, 54/55 variants, seven founder-credited guides.')
