# Glowwise

An editorial grooming discovery product for Indian young adults, published by Imagine Utopia. The approved product authority is `GLOWWISE_SOURCE_OF_TRUTH.md`. This repository contains the WordPress implementation and reviewed research facts; private infrastructure/account records and supplied third-party reference archives are excluded.

The researched editorial release is live at **https://glowwise.tech** with 40 product families (36 core selections plus four retained cleansers), 55 identified variants and seven complete original guides. Exact-product destinations are recorded for all 40; the owner-requested demonstration now uses source-attributed brand photos alongside the existing CC BY-SA photo; these brand photos are not claimed to have an open reuse licence. See `Documentation/Implementation/EDITORIAL_RELEASE_HANDOFF.md` for dated acceptance and the separately recorded demonstration-media pass. Native WordPress administration remains authenticated; public content is indexable while utility/filter states remain noindex. Start with `Documentation/Implementation/BUILD_STATE.md` and `Documentation/Deployment/OPERATIONS.md` for current acceptance, access and cost limits.

## Architecture

- `plugins/glowwise-core`: persistent product data, taxonomies, validation, rules-based matching, published-only REST endpoints, private contact/correction inbox, retention and repeatable content import/export.
- `theme/glowwise`: server-rendered presentation, editorial layouts, design tokens, responsive tools, browser-local shortlists and progressive JavaScript. Homepage copy is editable through Appearance → Customize; Posts, pages and product fact fields use native WordPress editing.
- `content`: reviewed product facts, seven original guide HTML sources, support-page sources and the repeatable seed. Sources/check dates are part of every record. Product media uses separately stored, source-attributed exact-variant photographs where available and disclosed typographic fallbacks otherwise.
- `deploy`: supported digest-pinned WordPress Apache/PHP, MariaDB and Caddy, Compose, private recovery/cost/cron scripts. Database, WordPress uploads and Caddy certificates persist in separate volumes. No database or development-server port is public.
- `tooling`: deterministic artwork/content compilation and VM-only asset build. DM Serif Display and Manrope are self-hosted with SIL OFL notices. GSAP/ScrollTrigger decorates the homepage with normal scrolling, pause and reduced-motion support.

Exact runtime and selected plugin versions are in `deploy/stack/images.lock.json`, `plugins.lock.json` and `package-lock.json`. Yoast owns metadata/schema/XML output; the core plugin extends that graph. WP Super Cache is active with safe exclusions and **page caching disabled for private/dynamic responses**. UpdraftPlus stores manual full backups outside the web root. Consent version 3 gates actual GA4 basic page/tool measurement; rejection/withdrawal loads no SDK and essential tools remain available. Public configuration is in content/public-config.json; no personal/free-text action parameters. GSC domain verification and fetched sitemap are real, not proof of indexing.

## Develop on the VM

Use the owner’s restricted SSH handoff described in the runbook. Do not commit keys, credentials or `.local`. The working source is `/srv/glowwise/source`, with secrets in `/srv/glowwise/secrets` and private operational state/backups outside the checkout.

```bash
cd /srv/glowwise/source
sudo bash deploy/scripts/build-assets.sh
cd deploy/stack
sudo docker compose up -d
sudo docker compose ps
sudo docker compose run --rm --no-deps wpcli glowwise import /srv/glowwise/content/seed.json
```

Build assets on the VM before activating the theme. Hashed CSS/JS/font outputs and `manifest.json` are generated into the ignored `theme/glowwise/assets/dist`. Node is an ephemeral pinned build container, not a public website runtime. Content compilation/artwork generation can run without a website runtime:

```bash
python3 tooling/generate-art.py
python3 tooling/build-guide-manifest.py
python3 tooling/compile-content.py
```

Imports use stable kind/slug identities, source hashes and stored content signatures. A repeat import creates no duplicate; a subsequent WordPress edit is preserved and reported as `editedSkipped`. Review differences manually before using the explicit `--force` override. Never force-import as a routine deployment step. Export includes published content only:

```bash
sudo docker compose run --rm --no-deps wpcli glowwise export > /srv/glowwise/source/content/reviewed-export.json
```

Review an export before adding it to Git. It does not contain accounts, private inbox, configuration, credentials or database backups. Imports preserve the current indexing decision; use --development only to deliberately return to a development profile.

## Checks and recovery

```bash
sudo docker compose run --rm --no-deps wpcli eval-file /srv/glowwise/tests/core-integration.php
sudo docker compose run --rm --no-deps wpcli eval-file /srv/glowwise/tests/import-seo-integration.php
sudo docker compose run --rm --no-deps wpcli eval-file /srv/glowwise/scripts/configure-cache-backup.php
sudo docker compose run --rm --no-deps wpcli eval-file /srv/glowwise/scripts/updraft-backup.php
sudo python3 /srv/glowwise/source/deploy/scripts/verify-updraft.py
sudo bash /srv/glowwise/source/deploy/scripts/backup.sh
sudo python3 /srv/glowwise/source/deploy/scripts/verify-restore.py
```

The tests create and clean only explicitly disposable synthetic fixtures in the owned installation. `python tests/http-acceptance.py` is an operator-side HTTP client, not a local website runtime; private preview credentials come from the ignored handoff or `GW_PREVIEW_USER`/`GW_PREVIEW_PASSWORD`. Actual browser interaction acceptance is separately recorded. The hourly host timer runs due WordPress cron events behind authentication, including daily 90-day private inbox expiry. Paused/deallocated periods delay execution; private backup retention/deletion requires operator review.

Back up before updates. Change a reviewed tag **and digest**, review plugin release notes, deploy pinned plugin versions, rebuild locked assets, then run affected checks. Roll back matching source/configuration; restore a matching private database/file set if a migration prevents a safe image-only downgrade. Never use `docker compose down -v` as a routine stop/update.

## Cost and publication boundary

The owner authorizes **US$10 total lifetime Azure consumption**, including student credit. Spending protection and conservative US$6/model/normalized-actual, traffic and finite-lease guards remain active. Daily midnight deallocation is disabled for the original lease ending 16 October 09:31:49 IST; no automatic start or extension. Disk/IP charges continue after compute deallocation. Budget alerts are delayed notifications, not a hard custom cap. Refresh `Documentation/Deployment/COST_LEDGER.md` before any restart or lease extension; no new allowance is implied by a budget reset.

Keep secrets, uploads, caches, databases, contact data, private logs/keys and raw backups out of Git. Original supplied references remain preserved locally under their publication-review exclusions. Asset/source registers identify rights and limitations. Original WordPress code declares GPL-2.0-or-later; supplied identity, editorial content, fonts and third-party dependencies retain their respective rights—this is not a blanket license to third-party material.

Current launch checks: `GW_LAUNCHED=1 python tests/launch-http.py`, `python tests/cache-redirects.py` (operator HTTP clients, no local server). VM `sudo bash deploy/scripts/test-assets.sh` verifies analytics/motion/currency behavior. Run isolated recovered runtime with `sudo python3 deploy/scripts/verify-restored-runtime.py` after verify-restore. Actual observations and limits are in the acceptance report; no organic/field-INP or certification claim.

## Visual refinement — 10 October 2026

Use Products → Verified variant photographs for exact variant-keyed native Media attachments and public source/licence/credit/alt/check date. Empty records produce disclosed text fallback, never invented packaging. Licensed source notices are adjacent to theme/assets/editorial and content/licensed-media. `sudo docker compose run --rm -T wpcli eval-file /srv/glowwise/scripts/import-visual-media.php` imports the reviewed exact50g image once, preserves edited captions/metadata. Never substitute it for80g/30g. Native files/database belong in private backups; companion exports/product-image-coverage.csv/json are public attribution, not a restore database. See VISUAL_REFINEMENT.md and VISUAL_EVIDENCE_INDEX.md for actual scope/rights gaps/tests.

### Demonstration media (10 October 2026)

`content/demo-media-manifest.json` records the official/listing photo source, exact variant, checked date, dimensions, hash and honest copyright status. Original/downloaded brand photos are excluded from Git. `tooling/prepare-demo-media.py` prepares reviewed local WebP files; transfer the approved files to ignored `content/demo-media/` on the VM, then run `wp eval-file /srv/glowwise/scripts/import-demo-media.php`. The importer validates hashes/variants and preserves existing images/edits. Brand copyright is retained; owner-authorised demo use is not a verified licence. Guide founder credit is editable in Posts → Glowwise editorial byline, independently of login accounts.
