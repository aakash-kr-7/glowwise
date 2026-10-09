# Glowwise build state

Updated 9 October 2026, 13:55 UTC.  **Stage 3 product implementation deployed; browser acceptance blocked on preview access.** The real custom WordPress installation is protected at https://glowwise.tech. It is not publicly launched. Stages 1/2 infrastructure remain in place. See `../Deployment/Stage_3_2026-10-09.md` for actual scope and limits.

## Resume first

1. Read approved SoT v1.1, this state, DECISIONS, EXECUTION_PLAN, REQUIREMENTS_TRACEABILITY, the Stage 3 checkpoint and `../Deployment/OPERATIONS.md`. Preserve original research/assets and canonical guide ownership.
2. Refresh cost/lease/resource/power state before any restart. US$10 is **total lifetime** Azure consumption, including student credit. Existing daily midnight-IST deallocation, US$6 guard and **16 October 09:31:49 IST** lease persist. Disk/IP continue charging after deallocation; resolve retention by 23 October without a silent extension or destructive teardown.
3. SSH with `ssh -F .local/deployment/ssh_config glowwise-dev`. Secrets/preview/admin credentials are only in ACL-restricted `.local/deployment/CREDENTIALS.private.json`, with root-only VM counterparts. Never print or commit them. Update only the operator /32 if its address changes.
4. Complete the pending browser handoff: Codex preview shows “This site can’t be reached”; browser security policy blocks inspecting its internal error page. User must establish normal authenticated preview access or report the displayed connection code. Do not bypass the policy using alternate browser/CDP/raw automation. Continue with actual desktop/mobile journeys once access works.
5. Test and fix: homepage/pause/reduced motion, keyboard/menu/filter disclosure, URL/back/forward/reset/no-match, Finder back/skip/restart/reasons, three same-type comparisons/variants/incompatible fourth, save/reload/remove/stale/blocked storage/network recovery, consent reopen/withdrawal and real UI contact/correction receipts/private inbox. Capture useful desktop/mobile screenshots. Native administrative editing should be inspected too.
6. Review updated evidence, source revision and matching private recovery. Public launch remains Prompt 4; Basic Auth, blog_public=0 and private no-store stay closed. Do not equate deployed code or server assertions with completed browser acceptance.

## Current verified state

| Area | Actual state |
|---|---|
| Product | Custom `theme/glowwise` and persistent `plugins/glowwise-core` active on Azure VM. Server-rendered pages plus progressive JS; no local website runtime or replacement architecture. |
| Content | 36 validated/sourced product families across all six categories; seven original mapped native guides; 16 editable native pages; six dynamic hubs; all requested tools/support/footer routes. Product/guide/font/asset registers and repeatable reviewed seed exist. The 18–24-guide target remains expansion. |
| Editing/data | Native product fact/taxonomy/source/check fields, native Post research fields, page editor and homepage Customizer. Stable import signatures preserve later edits; published-only export excludes inbox/accounts/config. |
| Rules/security | Matching/comparison constraints, private contact storage, CSRF/rate/spam/expiry and role denial validated with disposable fixtures. Hourly host WP-Cron timer is enabled and its service succeeds. No email notification or analytics service configured. |
| Tests | 46 WordPress core checks + 10 import/export/SEO-rule checks PASS; 335 HTTP assertions over 69 routes PASS; PHP syntax, VM minification, nine token-pair contrast calculations and original-source preservation PASS. Actual browser journeys/visual reflow/accessibility/motion/storage/consent remain unverified. |
| SEO/cache | Yoast 28.6/WPSC 3.1.4/UpdraftPlus 1.26.8 active. Truthful graph/unique metadata rendered; pagination canonical rule tested. Global private noindex suppresses current canonical/XML output. Protected page cache off with safe exclusions; no public HIT/CWV/rank/indexing claim. |
| Infrastructure | Existing Korea Central B2ats v2 x64, tuned 1-GiB VM/swap, 32-GiB SSD, static IPv4, secure non-root operator-only SSH. Docker 29.9/Compose 5.6; WP 7.1.3/PHP 8.3.35/Apache 2.4.68; MariaDB 11.4.13/Caddy 2.11.7; digest pins retained. Healthy, no OOM restart. |
| DNS/TLS | Cloudflare Free active, angela/trace delegation, proxied apex/www, Full strict, Caddy Let's Encrypt renewal/persistent storage, canonical HTTP/www redirects, HSTS off. Certbot absent. Stage 2 real DNS/TLS evidence remains traceable; Stage 3 authenticated HTTPS routes pass. |
| Recovery | Full private UpdraftPlus ZIP/database completion/integrity/isolated restore PASS (36/7/16 restored). Final matching checkpoint 13:48:56 UTC restored privately/checksums PASS; 107,055,647-byte restricted off-VM archive verified. All 52 custom theme/core/generated assets match the final UpdraftPlus archive. Earlier checkpoints/copies remain preserved. Raw backups never public. |
| Cost | No new resources or upgrades. Latest saved guard 13:51:58 UTC modeled US$0.2095/reported US$0 with lag, measured outbound ~277 MB including final recovery export. Original finite US$8.39 fallback plan/reserves retained; refresh ledger before resuming. Budget alerts are not a custom hard cap. |
| Git | Reviewed initial commit `791f855e6d6d7392db89769fb4c675ac1dd204bd` pushed to supplied origin/main with the correct owner credential manager. VM Git association and all 158 tracked blobs matched. Subsequent handoff annotations are documentation-only; deployed runtime/source baseline and matching recovery remain this commit. Secrets/runtime/raw research excluded; only reviewed sanitized deployment evidence included. |

## Evidence and material remaining work

Actual artifacts are indexed in `../References/Deployment/Evidence_Index.md`; public summary is `../Deployment/Stage_3_2026-10-09.md`. All 36 product requirement rows, ten distinct two-mark M1 criteria (including separate competitor/SERP rows) and separate M2 foundations remain mapped. Fourteen supplied source/reference/research/brand originals remain hash-identical. Earlier Readiness/Stage 1/Stage 2 records are preserved historical observations.

The material Stage 3 blocker is actual browser access/acceptance. Google property access, public launch/crawl/cache/validators/lab measures, instructor backlink domains, expansion and academic packaging/submission belong to later stages. No invented deadline, metric, marking, legal review, certification or launch claim is made. Lifecycle review must preserve the same US$10 allowance.

## Source publication and final recovery

Runtime/source baseline: [791f855](https://github.com/aakash-kr-7/glowwise/commit/791f855e6d6d7392db89769fb4c675ac1dd204bd). Public repository and VM share one codebase; generated dist remains ignored and is built on the VM. All 158 initial tracked blobs matched actual VM files. Final full UpdraftPlus integrity/isolated restore and 52 source/generated-asset comparisons pass. Infrastructure set `20261009T134856Z` plus restricted local `.local/deployment/recovery-stage3-final-2026-10-09.tar.gz` verify all five checksums. No live database was replaced or prior recovery deleted. Later main annotations do not change executable source/content. Resume with browser acceptance after normal user preview handoff, then the separate public launch stage.
