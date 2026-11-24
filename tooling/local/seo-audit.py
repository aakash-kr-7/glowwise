#!/usr/bin/env python3
"""Crawl the local site from its sitemap; report titles, descriptions, H1s, canonicals, OG, schema, link health.
Usage: python3 tooling/local/seo-audit.py http://127.0.0.1:8890 > audit.json"""
import sys,re,json,urllib.request,urllib.parse
base=sys.argv[1].rstrip('/')
def get(u):
    try:
        r=urllib.request.urlopen(urllib.request.Request(u,headers={'User-Agent':'gw-audit'}),timeout=60);return r.status,r.read().decode('utf-8','replace'),r.geturl()
    except urllib.error.HTTPError as e: return e.code,'',u
    except Exception as e: return 0,'',u
_,idx,_=get(base+'/sitemap_index.xml');urls=[]
for sm in re.findall(r'<loc>([^<]+)',idx):
    _,x,_=get(sm.replace('http://127.0.0.1:8890',base));urls+=re.findall(r'<loc>([^<]+)',x)
urls=[u.replace('http://127.0.0.1:8890',base) for u in urls]
rows=[];broken={}
for u in urls:
    st,h,fin=get(u)
    t=re.search(r'<title>([^<]*)',h);d=re.search(r'<meta name="description" content="([^"]*)"',h)
    can=re.search(r'<link rel="canonical" href="([^"]*)"',h)
    g=re.findall(r'"@type":"([A-Za-z]+)"',h)
    ld=re.findall(r'<script type="application/ld\+json"[^>]*>(.*?)</script>',h,re.S)
    rows.append(dict(url=u,status=st,title=t and t.group(1),desc_len=len(d.group(1)) if d else 0,h1=len(re.findall(r'<h1[ >]',h)),canonical=can and can.group(1),og=bool(re.search(r'property="og:title"',h)),robots=bool(re.search(r'name="robots"[^>]*noindex',h)),schema=sorted(set(g)),jsonld_blocks=len(ld),
      internal=len(re.findall(r'<a [^>]*href="(?:/|'+re.escape(base)+')',h)),imgs_no_alt=len(re.findall(r'<img(?![^>]*\balt=)[^>]*>',h)),words=len(re.sub(r'<[^>]+>',' ',re.sub(r'<(script|style)[^>]*>.*?</\1>','',h,flags=re.S)).split())))
    for l in set(re.findall(r'href="(/[^"#]*)"',h)):
        if l not in broken:
            broken[l]=get(base+l)[0]
bad={k:v for k,v in broken.items() if v!=200}
print(json.dumps(dict(count=len(rows),pages=rows,internal_links_checked=len(broken),non200_internal_links=bad),indent=1))
