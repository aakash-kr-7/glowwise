# Milestone II: evidence index and owner steps

Branch `milestone-2/website-polish`, based on origin/main `3b11609`. Environment for every result: **local, disposable** WordPress (latest) + Yoast + glowwise-core + theme, PHP 8.3 in WordPress Playground, 24 Nov 2026. Local numbers are not public-site numbers.

## Launch locally
```bash
bash tooling/local/run-local.sh 8890      # then open http://127.0.0.1:8890/
python3 tooling/local/seo-audit.py http://127.0.0.1:8890 > audit.json
```
First run installs the Playground CLI into git-ignored `.runtime/`, builds assets and imports `content/seed.json`.

## What changed
- Home: new "Start here" block (need → guide, budget → `/explore/?max-price=`), plus richer Home page body with internal links (`content/pages.json`).
- About: added "How a Glowwise guide is built" with internal links.
- Guide `shampoo-for-dry-frizzy-hair` (K01): quick picks with exact pack + INR, five decision criteria with per-100 ml arithmetic, body link to seonalabs.com ("SEO and search topic research") and to AAD ("healthy hair tips", supports: apply shampoo to scalp; dry/textured hair as needed, at least every 2-3 weeks), more internal links. No rel attributes on either. Source edited: `content/guides/*.html`; regenerated with `build-guide-manifest.py` and `compile-content.py`. Do not rerun `editorial-guides.py` (it would overwrite hand edits).

## Evidence (folder `Documentation/Milestone 2/evidence/`)
| Report section | Evidence | Result |
|---|---|---|
| 2 Performance (local, mobile, Lighthouse 13.6, simulated Moto-class throttling, 3 runs, no gzip/cache locally) | `baseline/lh-mobile-home-run*.json` (rev 3b11609) vs `after/lh-mobile-home-run*.json` (this branch) | Perf 96-97 → 96; LCP 2.3-2.8 s → 2.7 s; TBT 0-20 ms → 0; CLS 0-0.075 → 0; 321 → 325 KiB. Partial/neutral: no regression, no gain. Public PSI/GTmetrix baseline **not possible**: glowwise.tech did not respond on 24 Nov 2026 |
| 1/3 On-page, links | `after/seo-audit.json` | 65 sitemap URLs: all 200, 1 H1, OG present, one JSON-LD graph each (Organization/WebSite/WebPage/BreadcrumbList; Article on guides); 0 non-200 internal links. Only gaps: WP default `hello-world`, `sample-page` (no description) exist only on this disposable install |
| 3 Word count / links | guide source: 2,356 words, 26 internal, 15 external links | |
| 4 Outbound links | `after/article-source-outbound-links.png`; both URLs returned HTTP 200 on 24 Nov 2026 | rel absent on both |
| Visuals | `baseline/screens`, `after/screens` (desktop 1280x900, mobile 390x844; fold PNG, full-page JPG); `after/start-here-*.png` | No horizontal overflow on any of 8 pages |
| Tests | `after/node-tests.txt`; cost-units | analytics (7), motion, product-media, cost units all PASS |

## Not done (be explicit)
- Google Rich Results Test: needs a public URL or pasted code through Google's UI; not run. Owner: after deploy, test `https://glowwise.tech/guides/shampoo-for-dry-frizzy-hair/`, record detected types and warnings.
- PHP/WP-CLI suites (`tests/core-integration.php`, `import-seo-integration.php`, etc.) not run: they need the VM's WP-CLI. Run them on the VM (see README).
- Keyboard/focus/reduced-motion not re-tested interactively this pass beyond existing unit tests; catalogue/compare/save logic is unmodified.
- Audit issue table with severities, GSC/GA4, Updraft, GTmetrix: owner-side.

## Owner steps, in order
1. Review and open the PR from `milestone-2/website-polish`; merge.
2. On the VM: `git pull`, `sudo bash deploy/scripts/build-assets.sh`, then `wp glowwise import /srv/glowwise/content/seed.json`.
3. Read the JSON result. If it reports `editedSkipped` for `shampoo-for-dry-frizzy-hair`, `home` or `about`, someone edited them in WordPress. Either paste the new text into the editor by hand (Posts/Pages), or review the differences and then rerun with `--force` for only that decision (it overwrites the WordPress edit). Never use `--force` routinely.
4. After deploy, capture: public PSI mobile (same URL as the baseline), Rich Results Test, rendered source of the guide on the live domain, GSC sitemap status, GA4 realtime.
5. Take the UpdraftPlus backup and Drive link (Section 9).
