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

## Report draft (kept out of Git: it contains names and enrolment numbers)
`CSET489_M2_114_Imagine Utopia_DRAFT.docx` is delivered directly, built from the official template (12 pages plus a one-page appendix, checked by exporting from Word). Yellow-highlighted text marks every pending item. Code and evidence are tied to tested revision `d7f7e1e`; later commits on the branch add only documentation and figures.
Figures (`evidence/figures/`): 1 rendered SEO output, 2 sitemap, 3 article source with both outbound links, 4 local crawl summary, 5 home before/after.

## Audit issues (report Sections 7-8)
1 public site not responding (owner), 2 body outbound links (fixed), 3 thin Home copy (fixed), 4 no need/budget entry (partly proven), 5 mobile LCP about 2.7 s local (not addressed), 6 About internal links (fixed), 7 WP sample content in local install (check production).

## Owner steps, in order (where each result goes in the Word template)
**Before deployment**
1. **Verify hosting.** glowwise.tech did not respond on 24-11-2026 and the Azure lease was recorded as ending 16-10-2026. Restore the VM or move to a static host, keeping HTTPS. Site must stay live to 31-12-2026. Goes in: Cover "Live Website URL and hosting"; Issue 1 row in Section 8.
2. **Save the missing live "before" baseline on the current live site, before deploying:** PageSpeed Insights mobile for https://glowwise.tech/ (score, LCP, TBT, CLS, page size; note date/time and settings), GTmetrix mobile grade, and a live crawl (Screaming Frog or similar). Goes in: Section 2 "Before" cells (replace the 10-10-2026 values only if you keep the same settings), Section 7 audit-tool line.

**Deploy and verify**
3. Review and merge the PR from `milestone-2/website-polish`.
4. On the host: pull, `sudo bash deploy/scripts/build-assets.sh`, then `wp glowwise import /srv/glowwise/content/seed.json`. Read the JSON summary. `editedSkipped` for `shampoo-for-dry-frizzy-hair`, `home` or `about` means a WordPress edit blocked the update: copy the new text in by hand, or review and rerun with `--force` for that decision only.
5. Run the existing checks from the README (`core-integration.php`, `import-seo-integration.php`) and re-check the sitemap lists no WordPress sample pages (Issue 7).

**Public evidence after deployment**
6. PSI mobile again with identical settings, GTmetrix mobile, live crawl. Goes in: Section 2 "After", Section 8.
7. Google Rich Results Test on https://glowwise.tech/guides/shampoo-for-dry-frizzy-hair/: record detected types, errors, warnings. Goes in: Section 1 schema paragraph.
8. Open the live guide, view source, screenshot both anchors and their rel values (expected: none). Goes in: Section 4 (replace Figure 3 caption note).
9. GSC: confirm Domain property and DNS verification, sitemap status, Pages report, then export Performance for an exact date range (impressions, clicks, CTR, position, top 5 queries, Milestone I flag). Write the 80-120-word interpretation; sparse data is fine. Goes in: Sections 5-6. GA4: confirm G-XC6V3MXTJP stream, accept consent on the live site and capture Realtime with an active user, confirm the custom event trigger and key-event status. Label test events as tests. Goes in: Section 5.

**Backup and submission**
10. Create a sanitized, restore-tested UpdraftPlus backup (never the production database, inbox or credentials), approve it, upload to Google Drive as "Anyone with the link", open it signed out in a private window. Record date, contents, size, link. Goes in: Section 9 and Cover. Link must stay public to 31-12-2026.
11. Confirm contribution assignments and shares (each member leads at least one task; shares total 100%), submission date, AI-use table and declaration. Goes in: Cover, Section 11.
12. Team leader exports `CSET489_M2_114.pdf` from Word after steps 1-11.

## Report items still pending
Hosting, submission date, contributions and shares, public PSI before/after, GTmetrix, Rich Results Test, live source screenshot, GSC property/sitemap/indexing/performance data, GA4 Realtime and event check, interpretation text, Updraft backup details, declaration.
