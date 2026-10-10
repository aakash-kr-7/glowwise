# Visual refinement — 10 October 2026

## Observed problem and direction
Actual desktop and 390 × 844 browser captures cover Home, a category hub, Explore, product detail, Guides, article, Finder, Compare and Saved. The same oversized glossy category artwork appears in catalog cards, articles and product details. Skincare's sphere, Haircare's twisted shape and Fragrance's three-lobed form communicate neither a product nor a familiar category. The homepage orbit competes with its message. Repeated art makes products hard to distinguish; large decorative covers delay useful guide content. Filled comparison/saved captures must wait for requests to finish; loading screenshots are not evidence of their finished state.

Keep approved colours and self-hosted type. Use a calm editorial composition: one licensed human-context photograph on Home, labelled original line icons for categories, typographic guide covers and clear product identities. Decoration must explain navigation or content. Remove the large compass/orbit, glossy symbols and oversized empty-state sparkles. Retain the small brand mark. Finite, reduced-motion-aware scroll reveals may remain; no continuous decorative animation.

## Product photographs: hard rights boundary
Research covers all 36 published product families in `VISUAL_IMAGE_RIGHTS_A.json` and `VISUAL_IMAGE_RIGHTS_B.json`. One individually licensed match exists: Plum Rice Water & Niacinamide **2%**, SPF 50 PA++++, **50 g outer carton**, by abhi127 / Open Beauty Facts, CC BY-SA 3.0. It cannot stand for the default 80 g or 30 g pack. All other families require permission or an owner-owned photograph. No brand outreach was sent. Existing product facts, selected variants and prices must remain unchanged.

Use an explicitly disclosed typographic identity where a verified photograph is missing. This improves differentiation without pretending to resolve the rights gap. Photo metadata belongs in the core plugin, linked to a native Media attachment and exact variant, with editable source/licence/credit/alt/check date. Theme removal must not erase it. One resized WebP preserves the full original photograph; no retouching or invented labels. Show attribution alongside every photograph and a truthful failure fallback.

## Representative gate and whole-site gate
First inspect the updated homepage, labelled category navigation and shared product cards in the real browser. Refine their composition before finishing hub/article/tool templates. Then verify all page types at narrow and wide sizes, licensed variant changes, loading/failure/missing-image states, focus, consent and original functional journeys. Preserve genuine before/after evidence, compare asset sizes and inspect layout stability. Final results and exact deployed revision will be added after these checks.

## Licensed editorial asset
Nathan Dumlao's hands-under-running-water photograph: [individual source](https://unsplash.com/photos/a-person-holding-their-hands-under-a-stream-of-water-kDxqbAvEBwI), [Unsplash licence](https://unsplash.com/license), checked 10 October 2026. Self-hosted resized WebP derivatives; credited despite optional attribution. Editorial context only, not a photograph of a listed product or endorsement. A second candidate showed an unrelated branded soap and was rejected; it is not published.

## Verified refinement — 10 October 2026

Runtime tested/deployed: **46eb550d4262adfb7db79676018d7ebee800644a**. Subsequent handoff/evidence commit changes documentation only; the final operator deploy manifest records its actual HEAD and matching tracked blobs. Normal Git push is verified at final publication, not inferred from local commits.

| Gate | Result / evidence |
|---|---|
| Whole-site visual scope | PASS: all nine requested page types inspected at desktop and 390 × 844; all six hubs checked at both sizes. Old glossy art absent from 69 rendered routes. Home photo, six labelled line icons, seven typographic covers, restrained article context, common card/detail/compare media. Originals retained. |
| Native product imagery | PARTIAL / RIGHTS BLOCKED: **1/36 families, 1/51 variants**. Exact Plum 2% 50 g outer carton only; 35 families lack permission. No fictional packaging, unrelated stock bottles, hotlinks or unlicensed brand photos. Default 80 g remains disclosed fallback. |
| Working journeys | PASS: category → guide → product → exact photo/retailer URL; Finder budget400 four matches; changed search/empty/back/forward/clear/page2/refresh; comparison 50→80→50, keyboard table scroll; saved families persist and link to photographed variant. Browser observations are dated separately. |
| Accessibility and states | PASS for observed keyboard menu/Escape/focus, consent-dialog Escape, narrow reflow, meaningful photo alt, decorative SVG aria-hidden, photo loading→ready. Missing-photo state inspected; controlled error/HTML escaping/unit checks pass. OS reduced-motion/zoom and complete assistive-technology certification are not claimed. |
| Regression/security | PASS: 291 HTTP assertions/69 routes; native media 9, existing core46/import10, consent7 and finite-motion/media rules. Private HTML/admin/contact/API remain no-store; single H1/at-most-one canonical/footer intact. No new contact submission or fresh organic telemetry claim. |
| Delivery/performance | PASS sampled: VM-built hashed/minified CSS/JS, responsive WebP with dimensions, eager detail/lazy cards. Final provider mobile LCP2.3s/CLS.075/TBT0; desktop591ms/0/0. Single lab samples, no field INP. First-pass official PSI mobile95/desktop100; provider CLS.124 versus PSI0 shows variability. See PERFORMANCE.md. |
| Recovery/cost | PASS: actual full Updraft integrity and isolated SQL restore;36/7/16, indexing match, all custom files match tested46eb550. Restricted off-VM six-component copy. Same seven resources/spending protection On; modeledUS$0.5137, actual billing unavailable; lease/safeguards unchanged. |

See [visual evidence index](VISUAL_EVIDENCE_INDEX.md), [all-product photo export](exports/product-image-coverage.csv), [rights research A](VISUAL_IMAGE_RIGHTS_A.json) and [B](VISUAL_IMAGE_RIGHTS_B.json). Browser photographs are genuine captures; no reconstructed proof. Loading/failed capture attempts are excluded from the selected evidence set. Attribution is present in shared media and native Media caption; repeat import preserves edited caption and creates no duplicate.

Resume: obtain owner-owned exact-variant photos or written permission covering website hosting/adaptation. Do not send outreach or buy assets without explicit authorization. Upload native Media, fill Verified variant photographs fields, validate the pack/source/licence, repeat affected rendering/error checks, back up, rebuild/deploy reviewed source. Photo database/uploads are distinct from Git. No product-facts/prices were recertified by this visual pass.
