"""Exercise the protected real origin without printing credentials, tokens or form text.

Run with Python 3 on the operator machine; this is a client, not a local site runtime.
Credentials come from the ignored private handoff or GW_PREVIEW_USER/PASSWORD.
"""
import base64, datetime, http.cookiejar, json, os, re, urllib.error, urllib.request
from pathlib import Path

root=Path(__file__).resolve().parents[1]
private=root/'.local/deployment/CREDENTIALS.private.json'
credentials=json.loads(private.read_text(encoding='utf-8-sig')) if private.exists() else {}
user=os.getenv('GW_PREVIEW_USER',credentials.get('developmentUsername',''))
password=os.getenv('GW_PREVIEW_PASSWORD',credentials.get('developmentPassword',''))
assert user and password,'Provide the private preview credentials through the documented handoff.'
origin='https://glowwise.tech';jar=http.cookiejar.CookieJar()
client=urllib.request.build_opener(urllib.request.HTTPCookieProcessor(jar))
authorization='Basic '+base64.b64encode((user+':'+password).encode()).decode()
checks=[];titles={}
def get(path,auth=True,data=None,headers=None):
    h={'User-Agent':'Glowwise-owned-acceptance/1.0'}
    if auth:h['Authorization']=authorization
    if headers:h.update(headers)
    r=urllib.request.Request(origin+path,data=data,headers=h)
    try:
        with client.open(r,timeout=30) as response:return response.status,response.read().decode(),dict(response.headers)
    except urllib.error.HTTPError as error:return error.code,error.read().decode(),dict(error.headers)
def check(name,condition):
    checks.append({'test':name,'pass':bool(condition)})
    if not condition:raise AssertionError(name)
seed=json.loads((root/'content/seed.json').read_text(encoding='utf-8'))
guide_paths={'/guides/'+record['slug']+'/' for record in seed['records'] if record['kind']=='post'}
paths=['/','/explore/','/explore/page/2/','/explore/page/3/','/guides/','/guides/page/2/']
for record in seed['records']:
    prefix={'page':'','post':'guides/','gw_product':'products/'}[record['kind']]
    if record['slug'] not in ['home','guides']:paths.append('/'+prefix+record['slug']+'/')
paths+=['/categories/'+slug+'/' for slug in seed['categories']]
for path in dict.fromkeys(paths):
    status,body,headers=get(path)
    check(path+' renders one h1, footer, private no-store and noindex',status==200 and len(re.findall(r'<h1\b',body))==1 and 'site-footer' in body and 'data-cookie-open' in body and 'no-store' in headers.get('Cache-Control','') and 'noindex' in body and 'critical error' not in body.lower())
    title=re.search(r'<title>(.*?)</title>',body,re.S)
    description=re.search(r'<meta name="description" content="([^"]+)"',body)
    check(path+' has a unique title and meaningful description',title is not None and title.group(1) not in titles and description is not None and len(description.group(1))>20)
    titles[title.group(1)]=path
    check(path+' has no analytics/external font SDK',not any(x in body for x in ['googletagmanager.com','google-analytics.com','fonts.googleapis.com','fonts.gstatic.com']))
    graphs=re.findall(r'<script type="application/ld\+json"[^>]*>(.*?)</script>',body,re.S)
    nodes=[]
    for graph in graphs:nodes+=json.loads(graph).get('@graph',[])
    orgs=[n for n in nodes if n.get('@type')=='Organization']
    check(path+' uses one truthful publisher graph',len(orgs)==1 and orgs[0]['name']=='Imagine Utopia' and not any(k in orgs[0] for k in ['address','email','telephone']))
    if path in guide_paths:
        articles=[n for n in nodes if n.get('@type')=='Article']
        pages=[n for n in nodes if n.get('@type')=='WebPage']
        check(path+' uses a coherent editorial Article/WebPage author',len(articles)==1 and articles[0].get('author',{}).get('name')=='Glowwise Editorial' and len(pages)==1 and pages[0].get('author',{}).get('name')=='Glowwise Editorial' and not any(n.get('@type')=='Person' for n in nodes))
    if path.startswith('/products/'):
        products=[n for n in nodes if n.get('@type')=='Product']
        check(path+' product has no invented offer/rating',len(products)==1 and not any(k in products[0] for k in ['offers','aggregateRating','review']))
print('Rendered and checked',len(set(paths)),'routes',flush=True)
for path in ['/','/wp-json/glowwise/v1/products','/wp-login.php']:
    check(path+' requires private preview access',get(path,auth=False)[0]==401)
check('Unknown page returns actual 404',get('/gw-acceptance-missing-page/')[0]==404)
for query in ['?type=sunscreen&max-price=350','?fragrance-free=yes','?category=fragrance','?type=beard-trimmer&max-price=1']:
    status,body,headers=get('/wp-json/glowwise/v1/products'+query);result=json.loads(body)
    check('Catalog '+query+' succeeds privately',status==200 and 'no-store' in headers.get('Cache-Control',''))
    if 'max-price=350' in query:check('Budget uses selected checked variant',all(p['selectedVariant']['price']<=350 for p in result['products']))
    if 'fragrance-free=yes' in query:check('Unknown fragrance attributes never pass',all(p['attributes'].get('fragrance-free')=='yes' for p in result['products']))
    if 'max-price=1' in query:check('Budget no-match returns no substitute',result['total']==0)
check('Malformed REST filters return 400',get('/wp-json/glowwise/v1/products?q%5B%5D=nested')[0]==400)
check('Anonymous account directory is absent',get('/wp-json/wp/v2/users')[0]==404)
check('Private contact type is absent',get('/wp-json/wp/v2/gw_message')[0]==404)
status,body,headers=get('/wp-json/glowwise/v1/contact-token');token=json.loads(body)['token']
guard=[cookie for cookie in jar if cookie.name=='gw_form_guard']
check('Contact token uses Secure HttpOnly SameSite security cookie',status==200 and bool(guard) and guard[0].secure and 'HttpOnly' in guard[0]._rest and guard[0]._rest.get('SameSite')=='Strict')
status,_,_=get('/wp-json/glowwise/v1/contact',data=json.dumps({'token':token}).encode(),headers={'Content-Type':'application/json','Origin':origin})
check('Invalid contact fails with truthful client error',status in [400,422])
out={'capturedUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),'purpose':'Real authenticated HTTP route/content/schema/API/permission checks; no private body, token or credential captured','checks':checks,'limitations':['No browser rendering/interaction claim','Global private noindex intentionally suppresses Yoast canonical/XML output; launch checks remain required']}
dest=root/'Documentation/References/Deployment/2026-10-09_Stage3_HTTP_Tests.json';dest.parent.mkdir(parents=True,exist_ok=True);dest.write_text(json.dumps(out,indent=2)+'\n',encoding='utf-8')
print(len(checks),'HTTP assertions passed')
