"""Read-only live editorial acceptance against reviewed, portable sources."""
from pathlib import Path
import datetime, html, json, re, urllib.request
ROOT=Path(__file__).resolve().parents[1];origin='https://glowwise.tech'
sources=json.loads((ROOT/'content/products.json').read_text(encoding='utf-8'))
guides=json.loads((ROOT/'content/guides.json').read_text(encoding='utf-8'))
checks=[]
def check(name,condition):
 checks.append({'test':name,'pass':bool(condition)})
 if not condition:raise AssertionError(name)
def get(path):
 with urllib.request.urlopen(urllib.request.Request(origin+path,headers={'User-Agent':'Glowwise-owned-editorial-acceptance/1.0'}),timeout=40) as r:
  return r.status,r.read().decode('utf-8'),dict(r.headers)
live=[]
for page in [1,2]:
 _,body,_=get('/wp-json/glowwise/v1/products?per-page=24&page='+str(page));live.extend(json.loads(body)['products'])
by_slug={p['slug']:p for p in live};check('Exactly 40 unique published products',len(live)==len(by_slug)==40)
before=json.loads((ROOT/'.local/editorial/pre-release-live-products.json').read_text(encoding='utf-8')) if (ROOT/'.local/editorial/pre-release-live-products.json').exists() else []
if isinstance(before,dict):before=before.get('products',before.get('items',[]))
check('All 36 existing product IDs and canonical URLs retained',all(by_slug[p['slug']]['id']==p['id'] and by_slug[p['slug']]['url']==p['url'] for p in before) and len(before)==36)
for s in sources:
 p=by_slug[s['slug']];d=s['data']
 check(s['slug']+' exact title, price/variant/source/date match',p['name']==s['title'] and p['variants']==d['variants'] and p['checked']==d['checked'] and p['source']==d['source'])
 check(s['slug']+' verified attributes and editorial distinctions match',p['attributes']==d['attributes'] and p['strength']==d['strength'] and p['limitation']==d['limitation'])
 status,body,headers=get('/products/'+s['slug']+'/')
 check(s['slug']+' substantive native body and truthful purchase label',status==200 and 'Who should investigate it?' in body and ('View at Tira' if s['slug']=='ustraa-woody-beard-oil' else 'View official product') in body)
 check(s['slug']+' exact variant CTA, no public HTML cache',html.escape(d['variants'][0]['source'],quote=True) in body and 'no-store' in headers.get('Cache-Control',''))
for g in guides:
 path='/guides/'+g['slug']+'/';status,body,headers=get(path)
 check(g['slug']+' real article, correct title, check date and one H1',status==200 and html.escape(g['title']) in body and g['checked'] in body and len(re.findall(r'<h1\b',body))==1)
 check(g['slug']+' every substantive product section published',all(''.join(re.findall(r'[A-Za-z0-9]+',html.unescape(re.sub('<[^>]+>',' ',s)))) in ''.join(re.findall(r'[A-Za-z0-9]+',html.unescape(re.sub('<[^>]+>',' ',body)))) for s in re.findall(r'<p>(.*?)</p>',g['html'],re.S)))
 check(g['slug']+' complete recommendations and supporting references',all('/products/'+slug+'/' in body for slug in g['guide_products']) and 'Supporting references' in body and 'Common questions' in body)
 check(g['slug']+' single correct canonical and single schema graph',re.findall(r'<link rel="canonical" href="([^"]+)"',body)==[origin+path] and len(re.findall(r'<script type="application/ld\+json"',body))==1)
 check(g['slug']+' indexable article and private HTML cache policy','noindex' not in re.search(r'<meta name="robots" content="([^"]+)"',body).group(1) and 'no-store' in headers.get('Cache-Control',''))
out={'capturedUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),'purpose':'Actual published editorial source/ID/variant/body/metadata consistency; no forms or private data','products':len(live),'guides':len(guides),'checks':checks,'limitations':['No real purchase or delivery-postcode transaction','External source verification is recorded separately','Browser reading/reflow and image rights are separate observations']}
dest=ROOT/'.local/deployment/editorial-http.json';dest.write_bytes((json.dumps(out,indent=2)+'\n').encode('utf-8'))
print('PASS',len(checks),'live editorial assertions; 40 products and seven guides.')
