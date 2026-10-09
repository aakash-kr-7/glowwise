"""Anonymous real launch output checks. No credentials, message text or tokens saved."""
import datetime,json,re,urllib.request,urllib.error,xml.etree.ElementTree as ET,os,html
from pathlib import Path
root=Path(__file__).resolve().parents[1];origin='https://glowwise.tech'
seed=json.loads((root/'content/seed.json').read_text(encoding='utf-8'))
checks=[];documents={};titles={};descriptions={}
def check(name,condition,observation=''):
    checks.append({'test':name,'pass':bool(condition),'observation':observation})
    if not condition:raise AssertionError(name+' '+observation)
def get(path,method='GET',body=None,extra=None):
    headers={'User-Agent':'Glowwise-owned-launch-acceptance/1.0',**(extra or {})}
    request=urllib.request.Request(origin+path,data=body,method=method,headers=headers)
    try:
        with urllib.request.urlopen(request,timeout=30) as r:return r.status,r.read().decode('utf-8'),dict(r.headers),r.url
    except urllib.error.HTTPError as r:return r.code,r.read().decode('utf-8'),dict(r.headers),r.url
paths=['/','/explore/','/explore/page/2/','/explore/page/3/','/guides/','/guides/page/2/']
for record in seed['records']:
    if record['slug'] not in ['home','guides']:
        paths.append('/'+{'page':'','post':'guides/','gw_product':'products/'}[record['kind']]+record['slug']+'/')
paths+=['/categories/'+slug+'/' for slug in seed['categories']]
utilities={'/finder/','/compare/','/saved/','/privacy/','/terms/','/cookies-and-storage/','/sitemap/'}
for number,path in enumerate(dict.fromkeys(paths),1):
    if number%10==0: print('Checked routes:',number,flush=True)
    status,text,headers,actual=get(path);documents[path]=text
    check(path+' real 200, one h1 and complete footer',status==200 and len(re.findall(r'<h1\b',text))==1 and 'site-footer' in text and 'data-cookie-open' in text)
    title=re.findall(r'<title>(.*?)</title>',text,re.S);desc=re.findall(r'<meta name="description" content="([^"]+)"',text)
    check(path+' unique title/description',len(title)==1 and title[0] not in titles and len(desc)==1 and len(desc[0])>20 and desc[0] not in descriptions)
    titles[title[0]]=path;descriptions[desc[0]]=path
    canonical=re.findall(r'<link rel="canonical" href="([^"]+)"',text)
    robots=re.findall(r'<meta name=[\'\"]robots[\'\"] content=[\'\"]([^\'\"]+)',text)
    check(path+' one robots directive with deliberate intent',len(robots)==1 and ('noindex' in robots[0])==(path in utilities),str(robots))
    check(path+' canonical follows single Yoast presenter',canonical==([] if path in utilities else [origin+path]),str(canonical))
    check(path+' OpenGraph URL/title/description present',all('property="og:'+key+'"' in text for key in ['url','title','description']))
    graphs=re.findall(r'<script type="application/ld\+json"[^>]*>(.*?)</script>',text,re.S)
    check(path+' single JSON-LD graph and no mixed content',len(graphs)==1 and not re.search(r'(?:src|href)=[\'\"]http://',text))
    nodes=json.loads(graphs[0]).get('@graph',[])
    check(path+' no fake reviews/offers or private publisher fields',not any(any(k in n for k in ['aggregateRating','review','offers','email','telephone','address']) for n in nodes))
    check(path+' HTML is not publicly cached', 'no-store' in headers.get('Cache-Control','') and headers.get('CF-Cache-Status','DYNAMIC') not in ['HIT','EXPIRED','STALE'])
    if os.getenv('GW_LAUNCHED')=='1':check(path+' no global development noindex header','noindex' not in headers.get('X-Robots-Tag',''))
check('Empty budget renders an empty valid number input','placeholder="No limit" value=""' in documents['/explore/'])
for path in ['/gw-launch-missing/','/products/gw-launch-missing/','/explore/page/999/','/wp-json/glowwise/v1/products/999999']:
    check(path+' genuine 404',get(path)[0]==404)
for path in ['/?s=STAGE4DISPOSABLECONTACTTEST','/wp-json/glowwise/v1/products?q=STAGE4DISPOSABLECONTACTTEST']:
    status,text,headers,_=get(path);check('Public search does not reveal private test data '+path,status==200 and 'acceptance@example.invalid' not in text and 'clearly labelled disposable' not in text)
for path in ['/wp-json/wp/v2/gw_message','/wp-json/wp/v2/users']:
    check(path+' public retrieval absent',get(path)[0]==404)
for query in ['?q%5B%5D=nested','?page=0','?type=invented','?per-page=1000']:
    check('Bad catalog input rejected '+query,get('/wp-json/glowwise/v1/products'+query)[0]==400)
for body in [{'items':[18,18]},{'items':[18,19,20,21]},{'items':[999999]},{'items':[True]},{'items':[{'id':18,'variant':'missing-pack'}]}]:
    status,_,headers,_=get('/wp-json/glowwise/v1/compare','POST',json.dumps(body).encode(),{'Content-Type':'application/json'})
    check('Invalid comparison denied '+str(body),status in [400,404,422] and 'no-store' in headers.get('Cache-Control',''))
status,text,_,_=get('/explore/?type=sunscreen&max-price=1')
check('Filtered utility noindex and honest empty result',status==200 and 'noindex' in text and 'No match in this edit.' in text)
status,text,headers,_=get('/sitemap_index.xml');check('Real sitemap index available',status==200)
namespace={'s':'http://www.sitemaps.org/schemas/sitemap/0.9'}
sitemap_urls=[e.text for e in ET.fromstring(text).findall('s:sitemap/s:loc',namespace)];included=[]
for sitemap in sitemap_urls:
    status,text,_,_=get(sitemap.removeprefix(origin));check('Sitemap child loads '+sitemap,status==200)
    included += [e.text for e in ET.fromstring(text).findall('s:url/s:loc',namespace)]
required={origin+path for path in paths if path not in utilities and '/page/' not in path and path not in ['/explore/','/guides/']}
check('All intended singular content/category hubs in XML',required.issubset(set(included)),str(sorted(required-set(included))))
check('Utility/inbox/author/query URLs excluded from XML',not any(u in included for u in [origin+p for p in utilities]) and not any('gw_message' in u or '/author/' in u or '?' in u for u in included))
status,robots,_,_=get('/robots.txt');check('Crawler permitted and actual sitemap declared',status==200 and 'Disallow: /\n' not in robots and 'https://glowwise.tech/sitemap_index.xml' in robots)
internal=set()
for text in documents.values():
    for target in re.findall(r'href=[\'\"]([^\'\"]+)',text):
        target=html.unescape(target).split('#')[0]
        if target.startswith(origin):target=target[len(origin):]
        if target.startswith('/') and not target.startswith('//') and not any(x in target for x in ['/wp-content/','/wp-json/','/wp-admin/','wp-login']):internal.add(target)
for target in sorted(internal-set(documents)):
    check('Internal link loads '+target,get(target)[0]==200)
dest=root/('Documentation/References/Deployment/2026-10-09_'+('Launched' if os.getenv('GW_LAUNCHED')=='1' else 'Prelaunch')+'_HTTP.json')
result={'capturedUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),'purpose':'Actual anonymous HTTP/HTML/canonical/robots/schema/sitemap/link/permissions checks','profile':'launched' if os.getenv('GW_LAUNCHED')=='1' else 'Caddy noindex gate retained','routes':len(set(paths)),'sitemapLocations':len(included),'checks':checks,'limitations':['Schema structure assertions are separate from official validator results','Yoast intentionally omits canonical on noindex pages','No field analytics or organic indexing claim']}
dest.write_text(json.dumps(result,indent=2)+'\n',encoding='utf-8');print(len(checks),'assertions PASS;',len(set(paths)),'routes;',len(included),'sitemap URLs')
