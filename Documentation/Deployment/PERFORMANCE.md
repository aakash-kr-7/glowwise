# Real performance measurements

10 October 2026 IST. All runs target the actual canonical homepage on the existing VM. Measurements are lab samples, not audience/field evidence. No CrUX data exists in the official report, and TBT is not INP.

| Test | Desktop LCP / CLS / TBT | Mobile LCP / CLS / TBT | Scope |
|---|---|---|---|
| Pre-fix Ubersuggest forced run, 9 October | 522ms / .015 / 0ms | 2.0s / .064 / 0ms | Baseline revision 3935534. Provider omits exact timestamp, Lighthouse version/throttle, scores/field data. |
| Same requested provider/device/domain after fixes, 17:06 UTC | 535ms / .015 / 0ms | 2.3s / .063 / 0ms | Desktop/mobile LCP worsened slightly; mobile Speed Index 4.3 → 3.8s. Variability/unknown cache conditions prevent attributing change to code. |
| Official PSI prelaunch, 16:58:16 UTC | 415ms / .013 / 0ms | 1951ms / .063 / 0ms | Performance 100/95; SEO 69 due deliberate global noindex gate. |
| Official PSI launched, 17:24:53 UTC | 444ms / .013 / 0ms | 1989ms / .063 / 0ms | Performance 100/97; SEO 100 both. Lighthouse13.5, Chrome153; desktop custom throttle / MotoGPower Slow4G, single initial load. |
| Final PSI analytics-v3,21:01:41UTC |419ms / .023 /0ms |2028ms /.003 /3ms calculator (UI rounds0) |Performance100/96; SEO100, same LH13.5/Chrome153/device/throttling; no field data. |
| Free GTmetrix, 16:58 UTC | 1.1s / .04 / 0ms | Not run | Seattle, Chrome154/Lighthouse12.6.1, unthrottled. Performance95%, structure93%; full detail/export requires account. No paid plan/trial created. |

Actual changes: safe public static headers/edge cache, eager product hero with dimensions/high fetch priority, hashed VM-built CSS/JS, self-hosted fonts and small original SVGs. Existing baseline already minified assets: no false claim that minification first began in this pass. Dynamic HTML/API remain private/no-store for privacy; installed WP Super Cache page caching remains disabled. Never cache everything to improve a number. Cloudflare Auto Minify is retired.

Observed LCP/CLS targets pass these samples. Field INP <=200ms remains unmeasured, not substituted by TBT. Residual lab opportunities include render blocking, approximately29KiB cache-lifetime savings and 21KiB unused JS estimate; animation code is confined to homepage. HSTS preload is intentionally not enabled. Further optimization needs a fresh baseline and affected rechecks, not speculative rewrites for a perfect score.

Exact JSON/report URLs/screenshots: ../References/Implementation/2026-10-09_Performance_Baseline.json, Performance_After.json, Performance_Browser.json, PSI_Mobile/ Desktop_Prelaunch/Launched.png and GTmetrix.png (full dated prefix applies). A final source-specific sample after the fixed-name event addition is recorded separately.
