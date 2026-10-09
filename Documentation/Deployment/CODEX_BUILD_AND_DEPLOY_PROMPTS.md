# Glowwise — Codex build, deployment and evaluation prompts

Prepared: 9 October 2026.

Use these five prompts **in order, in the same Codex chat**, with `C:\Users\aakash09\Desktop\Glowwise` open as the workspace. Paste one prompt at a time. Let Codex finish its stage and review its completion report before sending the next. If a stage has a genuine blocker, resolve that blocker before proceeding with dependent work.

These prompts authorise implementation, testing, GitHub publication of appropriate project code, and deployment within the constraints below. They do not guarantee provider capacity, access to unavailable connectors, search-engine indexing, rankings, assessment marks, or completion of human submission requirements.

The build agent must create supporting implementation records and evidence. The remaining formal Milestone 1 criterion documents and final submission report will be prepared separately after the build.

---

## Prompt 1 — Understand the complete project and establish the execution contract

```text
You are implementing Glowwise as a complete product and preparing its actual technical foundation and evidence for the CSET489 SEO mini-project. Work in C:\Users\aakash09\Desktop\Glowwise. Carry this project through the staged prompts in this chat; keep a persistent implementation handoff so progress survives context changes.

FIRST READ THE MATERIALS
Inspect the entire project inventory, applicable AGENTS.md and relevant skills. Read GLOWWISE_SOURCE_OF_TRUTH.md completely. Read Reference/Mini-Project Handbook.docx, Reference/Milestone 1 and 2 details with reference material links.md, Reference/SEO prof notes.md, all four existing Documentation/Milestone 1 documents, their relevant supporting references, Documentation/Deployment/Readiness_2026-10-09.md, and existing brand assets. Treat milestone_1/Milestone1  someparts temporary.md as historical research, not approved final evidence. Extract DOCX paragraphs and tables, including the detailed evaluation descriptors. Inspect linked resources when relevant; use current official documentation for technical decisions and record inaccessible sources honestly.

AUTHORITY AND NEW OWNER DECISIONS
The Source of Truth is the product authority; the handbook defines assessment requirements. Later explicit owner decisions supersede older contradictory operational details:
- glowwise.tech is already registered through Namify / .Tech Domains / Radix. Do not buy another domain.
- GitHub: https://github.com/aakash-kr-7/glowwise. Local Git was initialised on main with this origin; no commit or push was recorded. Inspect current state before modifying it.
- Publisher: Imagine Utopia. Founders: Aakash Kumar and Disa Bandhu. Do not invent incorporation, registration details, address, social profiles or public contact email. Do not publish the student's account email by assumption.
- Azure for Students is active. The owner authorises at most US$10 TOTAL Azure consumption for this project, across all project resources and time, preferably covered by student credit. This replaces the old strictly zero-consumption deployment constraint. It is not $10 per month. No card, paid subscription upgrade or unrelated paid service is authorised.
- Develop and run the website on the Azure VM. Local files may hold source, documentation, assets and deployment tooling, but do not start a local website development runtime as the default workflow.
- The owner reports changing registrar nameservers to angela.ns.cloudflare.com and trace.ns.cloudflare.com. Activation is not yet independently confirmed.

Do not assume historical checks are still current. Previously, GitHub connector access worked, local gh credentials were invalid for a different account, Cloudflare was Pending, and no Azure VM existed. B2ats_v2 was unavailable for this subscription in three checked region/configurations; that does not prove all configurations are unavailable. Rediscover live tools and account access.

RECONCILE, THEN PLAN
Preserve custom WordPress theme + separate glowwise-core plugin, server-rendered pages, and progressive JavaScript enhancement. Preserve the selected Docker Compose / official WordPress Apache-PHP / MariaDB / Caddy architecture unless an actual incompatibility requires a documented owner decision. The rubric says Let's Encrypt / Certbot: assess Caddy's Let's Encrypt issuance against that wording, record the actual mechanism, and do not claim Certbot was installed if it was not. If literal Certbot is necessary, explain a concrete compatible alternative before changing the selected stack. Do not silently switch to a static site, headless application, managed WordPress, Vercel or Netlify as a substitute for the assessed VPS installation.

Update the Source of Truth's outdated domain, publisher, spending and development-location facts with these explicit owner decisions and a dated change history. Preserve unrelated approved decisions. Keep the old readiness record traceable rather than erasing historical observations.

Create concise operational files under Documentation/Implementation and Documentation/Deployment:
1. BUILD_STATE.md: current state, verified facts, blockers, next action and how to resume.
2. REQUIREMENTS_TRACEABILITY.md: every product requirement plus all TEN two-mark Milestone 1 criteria, mapped to implementation tasks, planned evidence, status and actual evidence paths. Include the Milestone 2 foundations separately. Existing combined competitor/SERP documentation must still map to both distinct criteria.
3. EXECUTION_PLAN.md: dependency-ordered tasks and acceptance gates, without invented deadlines.
4. DECISIONS.md: material implementation decisions, reasoning, source and any pending approval.

Use useful available plugins/connectors and official documentation; inspect their skills when applicable. Rediscover tools rather than assuming a plugin is callable because its name appeared in an earlier chat. Do not install every plugin or spend API credits without purpose. An unavailable plugin must not become a fabricated result.

Preserve supplied source documents, existing research and original assets. Avoid unnecessary renames or duplicate codebases. The public repository must not receive secrets, raw private tool output, private contact data, database backups, private keys or unreviewed copyrighted source material.

This stage is inspection and execution preparation. Do not provision billable resources or begin the full website build yet. Report the concrete architecture, current access findings, rubric mapping, infrastructure plan and any decisions that genuinely require my input. Explain only material blockers; make routine implementation choices yourself.
```

## Prompt 2 — Provision Azure and establish secure WordPress infrastructure

```text
Continue from BUILD_STATE.md and the approved Source of Truth. Complete the Azure VPS, secure access, reproducible WordPress stack, Cloudflare DNS and HTTPS foundation. I authorise the necessary resource creation and configuration within the existing US$10 TOTAL Azure allowance. Do the work, not just provide instructions.

COST AND ACCESS GATE
Verify the actual Azure subscription, spending protection, allowed regions, quotas and deployable VM sizes. Prefer a suitably sized verified free-eligible Linux VM. Check architecture compatibility for the OS and every container before choosing ARM. Previously unavailable draft configurations are not deployable simply because their prices appear in a picker.

Before creation, write an estimate covering compute, OS disk, public IPv4, outbound traffic and any other chargeable meter, including applicable benefits and uncertainty. Show expected daily/monthly consumption and estimated runway within the TOTAL allowance. Choose the lowest adequate configuration, no unnecessary paid marketplace image, Bastion, NAT Gateway, load balancer, managed database or paid monitoring. Do not upgrade the subscription. Do not deploy a configuration that cannot reasonably stay inside the remaining allowance.

Configure supported budget alerts and practical cost monitoring/shutdown controls with a conservative buffer. Explain that alerts are delayed notifications, not a hard custom $10 cap; stopping/deallocating compute can leave disk and IP charges. Record the continuing costs and a safe eventual teardown procedure. Do not delete the live project or backups automatically without an explicit lifecycle decision. If a strict $10 total limit cannot be responsibly maintained with the available configuration, report the specific blocker before spending. Preserve the subscription's spending protection.

Use existing authorised browser/connector access or an official CLI with normal user authentication. Never extract browser tokens or credentials. Ask for a focused sign-in/MFA/handoff only if required. Check current resources before creating anything and avoid duplicates on retries. Record resource ownership/tags and IDs privately where appropriate.

SERVER AND STACK
Create the VM and minimal associated resources. Use SSH keys and a non-root administrative user, restrict SSH ingress to necessary operator IPs, expose only required web ports, keep the database private, apply OS security updates and configure safe restart behaviour. Protect secrets with restricted permissions outside Git. Preserve recoverable access before disabling authentication methods. Do not expose a development server, database administration tool or debugging interface publicly.

Install the agreed supported, pinned Docker Compose stack with persistent database/uploads storage and the custom theme/plugin source locations ready for development on the VM. Deploy an actual fresh WordPress installation, not a visual imitation. Use strong unique administrator credentials through a secure handoff; do not place them in chat logs or public files. Record actual component versions and compatibility sources.

Verify the Cloudflare zone is active and nameserver delegation has propagated. Configure apex and www DNS using the actual origin, preserve any legitimate existing records, and choose https://glowwise.tech as the canonical public origin unless existing approved decisions say otherwise. Ensure valid origin HTTPS with the agreed Let's Encrypt mechanism, automatic renewal and Cloudflare Full (strict). Avoid redirect loops; redirect HTTP and www consistently. Do not enable HSTS preload prematurely.

Keep unfinished pages out of search indexes and protect incomplete installation/admin setup. The completed site will become indexable at launch. Use only Cloudflare Free features. Cloudflare Auto Minify is deprecated: implement build-time minification and describe the current equivalent truthfully. Configure safe static-asset caching; bypass admin/login, private/contact data, writes, consent-sensitive responses and any endpoint that must stay dynamic. Do not apply blanket cache-everything rules.

EVIDENCE AND HANDOFF
Save sanitised real SSH command logs, resource configuration, exact version output, DNS observations from authoritative/public resolvers, certificate evidence, Cloudflare settings and a small number of useful browser screenshots under Documentation/References/Deployment. Each item needs date/time, purpose and a traceability entry. Do not print environment secrets while collecting logs. Keep originals requiring privacy protection outside public Git.

Record safe SSH access instructions, stack start/stop/update commands, renewal checks, backup locations, cost controls and rollback steps. Verify actual WordPress, HTTPS and service health. Update BUILD_STATE and traceability with what succeeded and what remains. The site may still be a protected development installation; do not claim the complete Glowwise product is launched yet.
```

## Prompt 3 — Build the complete Glowwise product and original content

```text
Continue on the provisioned Azure VM. Build Glowwise to the agreed Source of Truth and existing keyword-to-page map. This stage must produce the complete functional website, editable in WordPress, with polished original design and genuine researched content. Maintain the $10 TOTAL infrastructure constraint.

DESIGN
Use the existing Glowwise identity, deep teal #123F3F, warm cream #F7F4EC, restrained apricot #E5B798, DM Serif Display headings and Manrope interface/body text. Self-host licensed fonts and record rights. Create a consistent token/component system, strong editorial hierarchy, thoughtful spacing, readable articles, high-quality product cards and original compass/sparkle graphics. Use Aesop, Typology and the approved Illoca motion reference as inspiration, never copy their layouts or assets. This should feel like a coherent grooming discovery product, with real content and deliberate composition on every page.

Implement the approved immersive homepage and selected editorial motion with GSAP/ScrollTrigger where useful. Keep normal scrolling, content accessibility and performance. Respect reduced motion, provide pause controls for continuous animation, and avoid motion that blocks navigation. Provide polished loading, empty, success and failure states.

Mobile and desktop have equal functionality and content. Design navigation, touch targets, filter panels, finder steps, comparison tables, dialogs, footer and forms deliberately for narrow and wide screens. Do not rely on hover. Target WCAG 2.2 AA through semantics, contrast, focus, keyboard access and understandable labels; do not claim certification.

IMPLEMENTATION
Build the custom Glowwise theme for presentation and glowwise-core plugin for persistent data and behaviour. Use native Posts for guides, a structured product custom post type, deliberate category/product-type taxonomies and validated attribute fields. Implement administrative editing, source/check-date fields and private contact inbox access. Keep theme changes from destroying catalog data.

Build Home, category directory and all six category hubs, Explore, product details, Guides and article templates, Finder, Compare, Saved, About, How We Select, Contact, Corrections, Privacy, Terms, Cookies and Browser Storage, Disclosures and Accessibility. Every public page must have the complete working footer and cookie-settings control. Use Imagine Utopia and the founders accurately. No invented social links or email address.

Implement real product search and category/type/budget/verified-attribute filtering with clear/reset, URL state and browser back/forward behaviour. Implement a transparent rules-based finder with reasons, back/skip/restart and honest no-match states. Compare up to three products of the same type and explain incompatible selections. Implement browser-local saving/removal/persistence, stale product handling and unavailable-storage recovery. Provide genuine retailer destinations. No accounts, checkout, fake AI, newsletters, invented reviews or simulated visitor functions.

Implement the published-only /wp-json/glowwise/v1 interfaces securely. Contact/correction submissions need server-side validation, length limits, spam/rate controls, CSRF protection appropriate to the request, private WordPress storage, restricted admin access and truthful delivery/error messages. Never expose submissions through public REST/search/sitemaps or put contact text into analytics. Email notifications are optional and must not be claimed if absent.

CONTENT
Research and publish at least 36 verified products across all six categories, selecting coherent same-type groups so comparison is meaningful. Do not invent facts, INR prices, availability, pack sizes or product attributes. Store supporting URLs and check dates. For imagery, verify permission/licence or use an honest original non-packaging visual when rights are unavailable; never fabricate branded packaging or assume retailer photographs are reusable. Record licences and sources in an asset register.

Publish all seven mapped initial guide topics if their factual basis can be verified: dry/frizzy-hair shampoo, oily-skin sunscreen, perfumes under INR 1,000, dry-skin body lotion, sensitive-skin face wash, beard-oil benefits and trimmers under INR 1,500. Preserve the mapped canonical slugs. This exceeds the six-guide first-release minimum and covers all six categories. Each guide must be substantial, original, useful and internally linked, with supported claims, limitations, citations and transparent research methodology. No arbitrary padding, keyword stuffing, invented testing or medical diagnosis. Budget guide eligibility must match the checked variant and price. The later 18–24-guide target remains a documented expansion unless already completed with equal quality.

POLICIES AND CONSENT
Write policy/support pages about the website's actual behaviour: local saves, consent preferences, contact retention/deletion process, analytics if enabled, publisher identity and absence of commercial arrangements where true. Implement practical retention controls matching the stated policy. Do not claim legal review or invent a registered business. Essential functionality must work if analytics is rejected. Cookie settings must allow reopening and withdrawal; no analytics requests or storage before affirmative consent.

SEO FOUNDATION AND SOURCE CONTROL
Implement the existing URL/keyword ownership map, unique page intent, titles/descriptions, heading structure, breadcrumbs, canonicals, sitemap policy and utility/filter noindex rules. Coordinate Yoast with custom routes so metadata/schema are not duplicated. Unfiltered pagination must remain self-canonical. Add truthful Organization/WebSite/Article and appropriate product markup, never fake ratings, offers or merchant status.

Use supported Yoast SEO Free, WP Super Cache and UpdraftPlus Free versions. Install only justified additional dependencies. Keep the repository portable with README, .env.example, pinned deployment/build configuration, reproducible content import/export, asset register and server-development instructions. Imports must be repeatable without duplicate records or destroying edited data. Never track secrets, runtime databases, contact data, uploads or backups. Review tracked files before committing and pushing to the supplied GitHub repository; do not use unrelated credentials or overwrite remote work.

Run relevant implementation tests and browser checks as part of this explicitly authorised build: unit/integration checks for core rules and permissions, and actual user journeys. Fix issues found. Update BUILD_STATE, decisions, source/content registers and traceability. Report actual completed scope and remaining gaps, not only files created. Keep the public launch gate for the next prompt.
```

## Prompt 4 — Verify quality, correct issues and launch the production website

```text
Continue the existing implementation. You are explicitly authorised to test, audit, fix, deploy and launch the completed Glowwise website on https://glowwise.tech, and push the resulting project code to the supplied GitHub repository. Stay within the US$10 TOTAL Azure allowance. Do not claim completion while core journeys or security are broken.

ACCEPTANCE AND CORRECTIONS
Exercise real desktop and mobile browser journeys: category -> guide -> product -> finder -> compare -> save -> retailer, including direct URLs, refresh, back/forward, changed filters, pagination, empty results, invalid IDs, removed products, blocked storage and network failures. Check touch and keyboard operation, menu/filter dialog focus, Escape/close behaviour, visible focus, contrast, zoom/reflow, reduced motion and every footer link. Test contact and correction delivery into the private inbox using clearly labelled test data; verify public users cannot retrieve those messages and remove test records safely afterwards.

Inspect actual HTTP responses and generated HTML for canonical redirects, genuine 404s, unique titles/descriptions, correct headings, OpenGraph, breadcrumbs, noindex policies, XML sitemap inclusion/exclusion, robots and schema. Validate schema with available official tools. Eliminate duplicate schema/canonical output and broken links. Search must expose published content only. Check relevant unauthenticated permission, validation and request-abuse cases without disruptive load testing.

Verify TLS at edge and origin, renewal configuration, no mixed content, Cloudflare Full (strict), DNS delegation/records, correct proxying and cache behaviour. Demonstrate that admin/login, contact responses, writes and private/personalised data cannot be cached publicly. Check custom CSS/JS minification and compressed modern images, dimensions, lazy loading below the fold and appropriate caching. Do not falsely claim retired Cloudflare Auto Minify is enabled.

PERFORMANCE
Capture a real pre-optimisation baseline before the next optimisation pass, then run comparable mobile/desktop PageSpeed/Lighthouse checks after fixes. Use GTmetrix if accessible without a paid requirement; otherwise record that limitation. Identify pages, dates, device/test conditions and variability. Aim for LCP <=2.5s, INP <=200ms and CLS <=0.1, but distinguish lab results from field metrics. Do not call TBT an INP measurement, invent CrUX data for a new site or promise a perfect score. Preserve before/after evidence and actual changes.

ANALYTICS AND MILESTONE 2 READINESS
Use existing authorised Google account access if available to verify a Search Console domain property, submit the actual sitemap and configure GA4 with consent-gated basic behaviour. If Google access/property information is missing, ask one focused question and continue independent work. Do not fabricate IDs, properties, verification or tracking evidence. Store only non-secret public configuration in an appropriate place. Verify consent rejection/acceptance/withdrawal and actual realtime events where access permits; exclude personal data and free-text input. Distinguish test activity from organic audience data. A submitted sitemap is not proof of indexing, and a new property may have no reportable history yet.

Launch the complete content only after the acceptance gate: remove development noindex/protection from intended public pages, preserve utility/filter noindex, verify crawler access and sitemap, and confirm the canonical domain works in an unauthenticated browser. Do not publish passwords, debug output, placeholder policies or fabricated product information.

BACKUP AND OPERATIONS
Create an actual complete UpdraftPlus backup and verify its components. Test restoration in an isolated temporary environment on the same VM where feasible within capacity/cost, without overwriting production or exposing another public site. Remove temporary resources after preserving results. Record exactly what restored and what was not tested. Keep an encrypted/restricted recovery copy separate from the VM where authorised storage is available. Never place raw database backups or credentials in public Git. A public coursework backup requires a separately sanitised submission copy and appropriate owner-approved sharing; prepare the process without publishing private production data.

FINAL DEPLOYMENT
Push reviewed source/configuration to GitHub with normal authenticated access; record the actual commit SHA. Ensure the deployed revision matches it. Provide tested update/rollback/restart procedures, recovery instructions, certificate renewal checks, remaining credit/budget observations and total-cost exposure. Do not configure a paid CI service or blindly deploy every branch. Where automation cannot be safely configured with available access, provide and verify a reproducible manual deployment.

Capture relevant genuine screenshots/logs and an acceptance report with PASS/FAIL/BLOCKED, exact observation and evidence path. Fix material failures, rerun affected checks and document residual limitations. Update BUILD_STATE and traceability. Finish with the live URL, repository/commit, measured results, completed acceptance scenarios, remaining blockers and current cost position. Do not state that assessment marks or indexing are guaranteed.
```

## Prompt 5 — Prepare the evidence package and complete handoff for Milestone 1 documentation

```text
The website build/deployment is now complete or has explicitly recorded blockers. Prepare a clean, source-faithful implementation and evaluation handoff so the next documentation agent can produce the remaining formal Milestone 1 files without guessing. Verify current live state before describing it as working. Do not manufacture evidence to fill a gap.

Create Documentation/Implementation/FINAL_BUILD_HANDOFF.md covering:
- Product scope actually delivered versus the Source of Truth and keyword map.
- Public URLs, deployed Git commit, source layout, theme/plugin responsibilities, content counts and editing workflow.
- Azure resource/stack architecture, versions, origin/certificate mechanism, Cloudflare/DNS/caching decisions, spending controls and continuing costs.
- User journeys, responsive/accessibility behaviour, contact privacy and consent/analytics state.
- Test/audit results, known defects, deferred content expansion, rollback, backups and recovery.
- Exact remaining human actions or unavailable account dependencies.

Complete the ten-row Milestone 1 traceability matrix, preserving all TEN separate two-mark criteria: niche/problem; keyword research/intent; SERP; competitors/gaps; keyword-page mapping; SEO roadmap; domain/DNS/Cloudflare; VPS/WordPress; evidence/submission quality; demonstration/timeliness. Link existing research documents rather than rewriting their historical metrics as current measurements. Combined existing files may support multiple criteria, but keep criterion status/evidence distinct. Do not claim a score.

Produce supporting records rather than the final academic criterion submissions:
1. SEO_IMPLEMENTATION_REGISTER.md: dependency-ordered technical, on-page, content and off-page actions with implemented/verified/pending status, rationale and evidence. Include future instructor-designated backlink work as pending until domains and publication permission exist. Do not publish externally or send outreach messages without explicit authorisation.
2. DEPLOYMENT_FACTS.md: actual registrar, DNS delegation, origin routing, Full (strict), Let's Encrypt issuance, renewal, minification and cache exclusions with dated evidence.
3. EVIDENCE_INDEX.md: evidence ID, criterion, claim supported, timestamp/timezone, screenshot/log/source path, privacy treatment and limitations. Keep a small strong screenshot set; never use reconstructed screenshots as proof. Redacted copies must be identified and preserve relevant configuration facts.
4. CONTENT_AND_ASSET_REGISTER.md plus reusable data exports: product/guide URLs, keyword owner, sources/check dates, image rights and publication status. Separate inherited tool estimates from live site observations.
5. MILESTONE_1_DEMO_RUNBOOK.md: practical walkthrough of the live product, domain/Cloudflare settings, SSH/server configuration and keyword rationale, with backup evidence if a dashboard is unavailable. Include likely technical/SEO questions and answers grounded in the actual build. Do not invent a Milestone 1 presentation duration; the handbook's 5–7 minutes applies to the final viva.
6. MILESTONE_2_BASELINE_AND_NEXT_STEPS.md: real baseline measurements, GSC/GA4 state, content expansion, designated-domain backlink dependency, audit/corrections and backup/submission needs. No invented traffic, rankings or guaranteed future results.
7. SUBMISSION_READINESS.md: checklist for the later single PDF/DOCX report, live URL, filename convention, backup components and public Drive sharing requirement. Flag owner-controlled submission/deadline actions; do not claim timely submission has happened. Prepare a privacy-safe backup-sharing plan instead of publicly uploading raw production data.

Ensure every claim can be traced to the implementation, a live check or a dated source. Mark unavailable evidence and unperformed checks clearly. Preserve restricted originals securely and keep public-repository evidence safe. Do not include account tokens, student account identifiers, contact messages, database credentials or private keys in a report or screenshot.

Review repository hygiene, push the final appropriate source/documentation changes and record the deployed commit relation. Update BUILD_STATE with a concise completed-stage summary and an explicit resume point for the documentation agent. End with a short handoff: live site, GitHub URL, primary evidence/handoff paths, what is verified, what is blocked and what still needs the owner. The remaining formal Milestone 1 documentation will be written in the original planning chat after this handoff.
```
