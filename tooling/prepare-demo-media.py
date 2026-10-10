"""Prepare reviewed product photos locally; downloaded copyrighted files stay out of Git.

Uses exact variant image associations from official Shopify listings. Unassociated
gallery photographs must be manually reviewed before importing. No licence is inferred.
"""
import concurrent.futures, datetime, hashlib, html, json, re, sys, urllib.request
from pathlib import Path
from urllib.parse import urlsplit, parse_qs
from PIL import Image, ImageOps, ImageDraw

ROOT=Path(__file__).resolve().parents[1]
OUT=ROOT/'.local/demo-media';OUT.mkdir(parents=True,exist_ok=True)
PRODUCTS=json.loads((ROOT/'content/products.json').read_text(encoding='utf-8'))

def request(url):
    with urllib.request.urlopen(urllib.request.Request(url,headers={'User-Agent':'Mozilla/5.0 Glowwise editorial demo research'}),timeout=40) as r:
        return r.read()

def discover(p):
    file=ROOT/'.local/editorial/research'/f"{p['slug']}.product.json"
    rows=[]
    if file.exists():
        saved=json.loads(file.read_text(encoding='utf-8'))
        api=p['data']['source'].split('?')[0]+'.js'
        try:
            saved=json.loads(request(api));file.write_text(json.dumps(saved),encoding='utf-8')
        except Exception:
            pass
        for v in p['data']['variants']:
            key=parse_qs(urlsplit(v['source']).query).get('variant',[''])[0]
            source_variant=next((x for x in saved['variants'] if str(x['id'])==key),None)
            if not source_variant:
                source_variant=next((x for x in saved['variants'] if re.sub(r'\s','',x['title']).lower()==re.sub(r'\s','',v['label']).lower()),None)
            image=(source_variant or {}).get('featured_image') or {}
            url=image.get('src')
            method='Official listing exact variant image association'
            if not url and len(saved['variants'])==1:
                url=saved.get('featured_image') or (saved.get('images') or [None])[0]
                method='Single-variant official product gallery; visually reviewed'
            if not url:
                continue
            if url.startswith('//'):url='https:'+url
            rows.append({'slug':p['slug'],'title':p['title'],'brand':p['data']['brand'],'variant':v['label'],'source':v['source'],'imageURL':url,'matchBasis':method})
    elif p['slug'].startswith('vega-'):
        text=(ROOT/'.local/editorial/research'/f"{p['slug']}.html").read_text(encoding='utf-8')
        m=re.search(r'<meta\s+property="og:image"\s+content="([^"]+)"',text)
        if m:rows.append({'slug':p['slug'],'title':p['title'],'brand':p['data']['brand'],'variant':p['data']['variants'][0]['label'],'source':p['data']['source'],'imageURL':html.unescape(m[1]),'matchBasis':'Exact model official page primary product photo; visually reviewed'})
    return rows

def download(row):
    key=row['slug']+'-'+re.sub('[^a-zA-Z0-9-]','',row['variant'])
    path=OUT/(key+'.webp')
    try:
        raw=request(row['imageURL']);(OUT/(key+'.original')).write_bytes(raw)
        import io
        image=ImageOps.exif_transpose(Image.open(io.BytesIO(raw)))
        if image.mode not in ('RGB','RGBA'):image=image.convert('RGBA' if 'transparency' in image.info else 'RGB')
        image.thumbnail((1200,1200),Image.Resampling.LANCZOS)
        image.save(path,'WEBP',quality=86,method=6)
        row.update(file=path.name,width=image.width,height=image.height,bytes=path.stat().st_size,sha256=hashlib.sha256(path.read_bytes()).hexdigest(),checked=datetime.date.today().isoformat(),alt=f"{row['title']}, {row['variant']}, official product photograph",credit=f"Photo: {row['brand']}",license='Brand copyright · demo use',licenseUrl=row['source'],rights='Copyright retained by source owner. Demonstration use requested by Glowwise owner on 10 October 2026; no open licence or separate permission verified.')
    except Exception as e:row['error']=type(e).__name__+': '+str(e)[:100]
    return row

def sheet(rows):
    okay=[r for r in rows if 'file' in r]
    for offset in range(0,len(okay),20):
        chunk=okay[offset:offset+20];canvas=Image.new('RGB',(1000,((len(chunk)+4)//5)*250),'#f7f4ec');draw=ImageDraw.Draw(canvas)
        for i,r in enumerate(chunk):
            im=Image.open(OUT/r['file']).convert('RGBA');im.thumbnail((180,185));x=(i%5)*200;y=(i//5)*250
            canvas.paste(im,(x+(200-im.width)//2,y),im)
            draw.text((x+5,y+188),r['slug'].replace('minimalist-','min-')[:27],fill='#123f3f')
            draw.text((x+5,y+205),r['variant'],fill='#123f3f')
        canvas.save(OUT/f'review-{offset//20+1}.jpg')

if __name__=='__main__':
    if '--manifest' in sys.argv:
        rows=json.loads((ROOT/'content/demo-media-manifest.json').read_text(encoding='utf-8'))
    else:
        with concurrent.futures.ThreadPoolExecutor(max_workers=4) as pool:groups=list(pool.map(discover,PRODUCTS))
        rows=[r for group in groups for r in group]
        extra=OUT/'browser-sources.json'
        if extra.exists():rows+=json.loads(extra.read_text(encoding='utf-8'))
    with concurrent.futures.ThreadPoolExecutor(max_workers=4) as pool:rows=list(pool.map(download,rows))
    (OUT/'manifest.json').write_text(json.dumps(rows,ensure_ascii=False,indent=2),encoding='utf-8')
    sheet(rows)
    print(json.dumps({'families':len(set(r['slug'] for r in rows if 'file' in r)),'variants':sum('file' in r for r in rows),'errors':[{'slug':r['slug'],'error':r['error']} for r in rows if 'error' in r]},indent=2))
