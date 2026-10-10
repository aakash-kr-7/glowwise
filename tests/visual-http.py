"""Non-disruptive public visual/metadata regression checks; no private responses."""
import argparse,datetime,json,re,urllib.request
from pathlib import Path
parser=argparse.ArgumentParser();parser.add_argument('--output',default='.local/deployment/visual-http.json');args=parser.parse_args()
root=Path(__file__).resolve().parents[1];origin='https://glowwise.tech';checks=[]
def get(path):
    with urllib.request.urlopen(urllib.request.Request(origin+path,headers={'User-Agent':'Glowwise-owned-visual-check/1.0'}),timeout=30) as r:return r.status,r.read().decode(),dict(r.headers)
def check(name,passed,observation=None):
    checks.append({'test':name,'pass':bool(passed),'observation':observation});assert passed,name
seed=json.loads((root/'content/seed.json').read_text(encoding='utf-8'));paths={'/','/explore/','/explore/page/2/','/explore/page/3/','/guides/','/guides/page/2/'}
for r in seed['records']:
    if r['slug'] not in ['home','guides']:paths.add('/'+{'page':'','post':'guides/','gw_product':'products/'}[r['kind']]+r['slug']+'/')
paths.update('/categories/'+slug+'/' for slug in seed['categories'])
for path in sorted(paths):
    status,html,headers=get(path);check(path+' renders with private HTML caching',status==200 and 'no-store' in headers.get('Cache-Control',''),{'status':status,'cacheControl':headers.get('Cache-Control'),'edgeCache':headers.get('CF-Cache-Status')})
    check(path+' no retired artwork and exactly one main heading','/assets/art/' not in html and len(re.findall(r'<h1\b',html))==1)
    check(path+' has at most one canonical',len(re.findall(r'rel=[\'"]canonical[\'"]',html))<=1)
    check(path+' keeps cookie control and complete footer','data-cookie-open' in html and 'site-footer' in html)
products=[]
for page in [1,2]:products.extend(json.loads(get('/wp-json/glowwise/v1/products?per-page=24&page='+str(page))[1])['products'])
check('Exactly 36 published products',len(products)==36)
coverage=[]
for p in products:
    variants=[]
    for label,image in p.get('imageAssets',{}).items() if isinstance(p.get('imageAssets'),dict) else []:
        check(p['slug']+' exact variant image, safe origin, dimensions and credit',label in [v['label'] for v in p['variants']] and image['src'].startswith(origin+'/wp-content/uploads/') and image['width']>0 and image['height']>0 and bool(image['alt']) and bool(image['credit']))
        request=urllib.request.Request(image['src'],headers={'User-Agent':'Glowwise-owned-visual-check/1.0'})
        with urllib.request.urlopen(request,timeout=30) as r:blob=r.read();check(p['slug']+' photograph returns an actual WebP',r.status==200 and blob.startswith(b'RIFF') and blob[8:12]==b'WEBP',{'status':r.status,'contentType':r.headers.get('Content-Type'),'bytes':len(blob)})
        variants.append({'label':label,**image})
    coverage.append({'slug':p['slug'],'url':p['url'],'brand':p['brand'],'category':p['category'],'defaultVariant':p['variants'][0]['label'],'variants':[v['label'] for v in p['variants']],'licensedImages':variants,'rightsStatus':'licensed_exact_variant' if variants else 'permission_gap','rightsChecked':'2026-10-10','productFactsChecked':p['checked']})
for variant,photo in [('50%20g',True),('80%20g',False),('30%20g',False)]:
    _,html,_=get('/products/plum-rice-water-spf-50/?variant='+variant);check('Plum '+variant+' cannot display the wrong pack',('data-product-photo' in html)==photo)
    check('Plum '+variant+' remains base self-canonical','href="'+origin+'/products/plum-rice-water-spf-50/"' in html)
for path in ['/contact/','/corrections/','/wp-login.php','/saved/','/compare/','/wp-json/glowwise/v1/products']:
    _,_,headers=get(path);check(path+' stays non-publicly cached','no-store' in headers.get('Cache-Control','') and headers.get('CF-Cache-Status') not in ['HIT','STALE'])
output={'capturedUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),'purpose':'Public visual/HTML/variant-photo/cache regression, read-only; no credentials/contact content','routes':len(paths),'checks':checks,'products':coverage,'counts':{'publishedProducts':len(products),'catalogVariants':sum(len(p['variants']) for p in products),'familiesWithLicensedPhotos':sum(bool(p['licensedImages']) for p in coverage),'licensedVariants':sum(len(p['licensedImages']) for p in coverage)},'limitations':['Browser/rendering/keyboard observations are recorded separately','No manufacturer photograph permission was inferred from visibility','No lab or field performance claimed by HTTP checks']}
dest=root/args.output;dest.parent.mkdir(parents=True,exist_ok=True);dest.write_text(json.dumps(output,ensure_ascii=False,indent=2)+'\n',encoding='utf-8');print(len(checks),'PASS assertions;',len(paths),'routes;',output['counts'])
