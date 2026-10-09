"""Real anonymous origin/edge redirect and private-response cache checks."""
import datetime,http.client,json,re,ssl,urllib.request,urllib.error
from pathlib import Path
origin='https://glowwise.tech';checks=[]
def check(name, passed, observation):
    assert passed,(name,observation)
    checks.append({'test':name,'pass':True,'observation':observation})
for secure,host in [(False,'glowwise.tech'),(False,'www.glowwise.tech'),(True,'www.glowwise.tech')]:
    conn=(http.client.HTTPSConnection if secure else http.client.HTTPConnection)(host,timeout=25)
    conn.request('GET','/guides/face-wash-for-sensitive-skin/?owned-check=1')
    r=conn.getresponse();location=r.getheader('Location');r.read();conn.close()
    check(('HTTPS ' if secure else 'HTTP ')+host+' canonical single redirect',r.status in [301,308] and location==origin+'/guides/face-wash-for-sensitive-skin/?owned-check=1',{'status':r.status,'location':location})
for path in ['/wp-login.php','/wp-admin/','/contact/','/corrections/','/saved/','/compare/','/finder/','/wp-json/glowwise/v1/products','/explore/?q=owned-check']:
    conn=http.client.HTTPSConnection('glowwise.tech',timeout=25)
    for attempt in range(2):
        conn.request('GET',path);r=conn.getresponse();r.read()
        observation={k:r.getheader(k) for k in ['Cache-Control','CF-Cache-Status','Age','Location']}
        check(path+' never public cached, request '+str(attempt+1),'no-store' in (r.getheader('Cache-Control') or '') and r.getheader('CF-Cache-Status') not in ['HIT','STALE','EXPIRED'],observation)
        if path in ['/contact/','/corrections/']:
            cookie=r.getheader('Set-Cookie') or ''
            check(path+' form CSRF cookie security flags',all(flag in cookie for flag in ['secure','HttpOnly','SameSite=Strict']),{'flagsVerified':True,'cookieValueExcluded':True})
    conn.close()
conn=http.client.HTTPSConnection('glowwise.tech',timeout=25)
conn.request('POST','/wp-json/glowwise/v1/contact','{}',{'Content-Type':'application/json','Origin':origin})
r=conn.getresponse();r.read()
check('Unauthenticated write without CSRF denied and uncached',r.status in [400,403] and 'no-store' in (r.getheader('Cache-Control') or '') and r.getheader('CF-Cache-Status') not in ['HIT','STALE'],{'status':r.status,'Cache-Control':r.getheader('Cache-Control'),'CF-Cache-Status':r.getheader('CF-Cache-Status')})
conn.close()
text=urllib.request.urlopen(urllib.request.Request(origin,headers={'User-Agent':'Glowwise-owned-launch-acceptance/1.0'}),timeout=30).read().decode()
static=re.findall(r'(?:src|href)="(https://glowwise.tech/wp-content/themes/glowwise/assets/[^"?]+\.(?:css|js|svg|woff2))',text)
for url in dict.fromkeys(static):
    for attempt in range(2):
        request=urllib.request.Request(url,headers={'Accept-Encoding':'gzip','User-Agent':'Glowwise-owned-launch-acceptance/1.0'})
        with urllib.request.urlopen(request,timeout=25) as r:
            r.read();observation={k:r.headers.get(k) for k in ['Cache-Control','CF-Cache-Status','Age','Content-Encoding','X-Robots-Tag']}
        check('Reviewed public static asset cache header '+url,'public' in (observation['Cache-Control'] or '') and not observation['X-Robots-Tag'],observation)
    check('Actual public edge HIT '+url,observation['CF-Cache-Status']=='HIT',observation)
dest=Path(__file__).resolve().parents[1]/'Documentation/References/Deployment/2026-10-09_Launch_Cache_Redirects.json'
dest.write_text(json.dumps({'capturedUTC':datetime.datetime.now(datetime.timezone.utc).isoformat(),'purpose':'Actual own-site origin-independent edge redirects and repeated private/public cache observations, tokens excluded','checks':checks},indent=2)+'\n',encoding='utf-8')
print(len(checks),'actual redirect/cache/cookie assertions PASS')
