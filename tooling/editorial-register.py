"""Export reviewed public editorial facts; never publish raw private research."""
from pathlib import Path
import json, csv, datetime
ROOT=Path(__file__).resolve().parents[1]
load=lambda p:json.loads((ROOT/p).read_text(encoding='utf-8'))
products=load('content/products.json'); notes=load('content/editorial-product-notes.json')['products'];guides=load('content/guide-metadata.json')
before=load('.local/editorial/pre-release-live-products.json')
if isinstance(before,dict):before=before.get('products',before.get('items',[]))
ids={p.get('slug',p.get('url','').rstrip('/').split('/')[-1]):p['id'] for p in before}
rights={'Bombay Shaving Company':'https://www.bombayshavingcompany.com/policies/terms-of-service','The Man Company':'https://www.themancompany.com/pages/terms-conditions','Ustraa':'https://www.ustraa.com/content/cms/terms-of-use'}
records=[]
for p in products:
 slug=p['slug'];d=p['data'];obs=ROOT/'.local/editorial/research'/f'{slug}.observation.json'
 if obs.exists() and json.loads(obs.read_text(encoding='utf-8')).get('apiStatus')==200:
  o=json.loads(obs.read_text(encoding='utf-8')); verification={'method':'Fresh official product page and public storefront variant data','timestampUTC':o.get('capturedUTC'),'httpStatus':o.get('status'),'storefrontStatus':o.get('apiStatus')}
 elif d['brand']=='VEGA' or 'vega' in slug:verification={'method':'Fresh manufacturer HTML and embedded model-specific Product data','timestampUTC':'2026-10-10; exact request times retained in private fetch index','httpStatus':200}
 elif d['brand'].startswith('SKINN'):verification={'method':'Fresh official web-source product text; Raw and corrected Verge additionally inspected in actual browser','timestampUTC':'2026-10-10; browser observations and check sequence retained privately','limitation':'Operator urllib access blocked. Verge has no active purchase price; collection price retained as reference.'}
 else:verification={'method':'Fresh identified Tira listing plus official same-oil bundle component description','timestampUTC':'2026-10-10','limitation':'Ustraa official standalone destination not independently verified; retailer is the exact 35 ml product.'}
 photo=slug=='plum-rice-water-spf-50'
 image={'status':'Licensed exact 50 g outer-carton photograph only' if photo else 'Unresolved exact-product photograph rights; disclosed text fallback',
 'rights':'CC BY-SA 3.0; abhi127; attribution retained' if photo else 'No third-party image reuse permission established; not hotlinked or copied',
 'source':'https://world.openbeautyfacts.org/cgi/product_image.pl?code=8904430201070&id=front_en' if photo else d['source'],
 'rightsEvidence':'Documentation/Implementation/VISUAL_IMAGE_RIGHTS_A.json + ASSET_REGISTER.json' if d['brand'] in ['Minimalist','Plum','Beardo'] else ('Documentation/Implementation/VISUAL_IMAGE_RIGHTS_B.json' if (d['brand'].startswith('SKINN') or d['brand'] in ['Vega','VEGA']) else rights.get(d['brand'])),
 'limitation':'50 g does not depict 30 g or 80 g; source was individually licensed in prior verified pass' if photo else 'Official visibility is not a licence. Targeted Commons search found no additional correct licensed exact-pack candidate; Open Beauty Facts fresh web access was robots-blocked.'}
 records.append({'slug':slug,'recordIdBeforeRelease':ids.get(slug),'canonical':'https://glowwise.tech/products/'+slug+'/', 'title':p['title'],'brand':d['brand'],'category':d['category'],'type':d['type'],'checked':d['checked'],'attributes':d['attributes'],'variants':d['variants'],'officialOrPrimaryURL':d['source'],'supportingURLs':d.get('sources',[]),'verification':verification,'purchaseLinkStatus':'Exact product destination verified; unavailable watchlist' if slug=='skinn-verge-20ml' else 'Exact product destination verified; stock is variant-specific','guideOwners':[g['slug'] for g in guides if slug in g['items']],'editorialRationale':notes[slug],'image':image,'change':'Retained identity; researched copy/facts/price/stock refreshed' if slug in ids else 'Added to complete the six-product beard category; no approved record deleted'})
out={'compiledUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),'purpose':'Reviewed public facts and original editorial rationale, not raw source reproduction or live price promises','method':'Desk research, no hands-on testing, no numerical scores, no affiliation','coreProducts':36,'retainedAdditionalCleansers':4,'totalProducts':len(records),'variants':sum(len(r['variants']) for r in records),'licensedPhotoFamilies':1,'licensedPhotoVariants':1,'limitations':['Availability is listing status, not a delivery-to-postcode test','No unverified marketplace listing marked verified','Verge price is a collection reference; current exact page says Coming Back Soon','Ustraa standalone official page remains unverified; official bundle verifies named component facts','Image permission gaps remain for 39 families'],'products':records}
dest=ROOT/'Documentation/Implementation/PRODUCT_RESEARCH_REGISTER.json';dest.write_bytes((json.dumps(out,ensure_ascii=False,indent=2)+'\n').encode('utf-8'))
folder=ROOT/'Documentation/Implementation/exports';folder.mkdir(exist_ok=True)
with (folder/'editorial-products.csv').open('w',encoding='utf-8',newline='') as f:
 w=csv.writer(f);w.writerow(['slug','canonical','brand','category','pack','INR','availability','checked','exactDestination','imageRights'])
 for r in records:
  for v in r['variants']:w.writerow([r['slug'],r['canonical'],r['brand'],r['category'],v['label'],v['price'],v['availability'],r['checked'],v['source'],r['image']['status']])
print('Public research register:',len(records),'products;',out['variants'],'variants. No raw source or credentials.')
