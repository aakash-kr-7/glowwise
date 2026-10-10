# Real performance measurements

10 October 2026 IST. All runs target the actual canonical homepage on the existing VM. Measurements are lab samples, not audience/field evidence. No CrUX data exists in the official report, and TBT is not INP.

| Test | Desktop LCP / CLS / TBT | Mobile LCP / CLS / TBT | Scope |
|---|---|---|---|
| Pre-fix Ubersuggest forced run, 9 October | 522ms / .015 / 0ms | 2.0s / .064 / 0ms | Baseline revision 3935534. Provider omits exact timestamp, Lighthouse version/throttle, scores/field data. |
| Same requested provider/device/domain after fixes, 17:06 UTC | 535ms / .015 / 0ms | 2.3s / .063 / 0ms | Desktop/mobile LCP worsened slightly; mobile Speed Index 4.3 â†’ 3.8s. Variability/unknown cache conditions prevent attributing change to code. |
| Official PSI prelaunch, 16:58:16 UTC | 415ms / .013 / 0ms | 1951ms / .063 / 0ms | Performance 100/95; SEO 69 due deliberate global noindex gate. |
| Official PSI launched, 17:24:53 UTC | 444ms / .013 / 0ms | 1989ms / .063 / 0ms | Performance 100/97; SEO 100 both. Lighthouse13.5, Chrome153; desktop custom throttle / MotoGPower Slow4G, single initial load. |
| Final PSI analytics-v3,21:01:41UTC |419ms / .023 /0ms |2028ms /.003 /3ms calculator (UI rounds0) |Performance100/96; SEO100, same LH13.5/Chrome153/device/throttling; no field data. |
| Free GTmetrix, 16:58 UTC | 1.1s / .04 / 0ms | Not run | Seattle, Chrome154/Lighthouse12.6.1, unthrottled. Performance95%, structure93%; full detail/export requires account. No paid plan/trial created. |

Actual changes: safe public static headers/edge cache, eager product hero with dimensions/high fetch priority, hashed VM-built CSS/JS, self-hosted fonts and small original SVGs. Existing baseline already minified assets: no false claim that minification first began in this pass. Dynamic HTML/API remain private/no-store for privacy; installed WP Super Cache page caching remains disabled. Never cache everything to improve a number. Cloudflare Auto Minify is retired.

Observed LCP/CLS targets pass these samples. Field INP <=200ms remains unmeasured, not substituted by TBT. Residual lab opportunities include render blocking, approximately29KiB cache-lifetime savings and 21KiB unused JS estimate; animation code is confined to homepage. HSTS preload is intentionally not enabled. Further optimization needs a fresh baseline and affected rechecks, not speculative rewrites for a perfect score.

Exact JSON/report URLs/screenshots: ../References/Implementation/2026-10-09_Performance_Baseline.json, Performance_After.json, Performance_Browser.json, PSI_Mobile/ Desktop_Prelaunch/Launched.png and GTmetrix.png (full dated prefix applies). A final source-specific sample after the fixed-name event addition is recorded separately.

## Visual refinement â€” 10 October 2026

| Run / actual source | Desktop LCP / CLS / TBT | Mobile LCP / CLS / TBT | Conditions / limitations |
|---|---|---|---|
| First visual pass b58a3ce, provider retrieved03:36:13UTC |611ms /.006 /0ms|2.4s /.124 /0ms|Forced DESKTOP/MOBILE, canonical homepage; provider throttle/version/run time unavailable.|
| Official PSI first visual pass,03:36UTC/09:06IST |538ms /.005 UI /0ms|2213ms /0 /26ms calculator (UI30)|Performance100/95, A11y/Best/SEO100both. LH13.5/Chrome153; MotoGPowerSlow4G/mobile, customdesktop, singleinitialload. NoCrUX.|
| Comparable provider after header/font refinement, ecbbdc7, retrieved03:48:26UTC |591ms /0 /0ms|2.3s /.075 /0ms|Same requested domain/device/forced refresh; individual samples/unknowncache prevent proving causality.|

Original pre-refinement9October baseline is preserved above. Added full-frame licensedWebP/context image, responsive srcset/dimensions, finite12px reveals, exact hashed-font preloads and44px initial header reservation. Below-fold card photos lazy; detail eager. Firstprovider CLS.124 and same-pass officialPSI0 disagree; report variability honestly. Later46eb550 only photo loading/error/native caption refinements, browser/unit verified; not relabelled as a fresh performance run. No fieldINP, TBT substitution, perfect-score or guaranteedvitals claim. Existing GTmetrix sample remains dated9October; no new GTmetrix run in this visual pass. Raw report JSON and genuine PSI captures are indexed in Implementation/VISUAL_EVIDENCE_INDEX.md.
