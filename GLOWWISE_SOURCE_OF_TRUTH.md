# Glowwise — Source of Truth

**Status:** Agreed product definition  
**Version:** 1.1  
**Agreed and saved:** 8 October 2026  
**Owner amendments recorded:** 9 October 2026  
**Project root:** `C:\Users\aakash09\Desktop\Glowwise`

This document is the definitive reference for the Glowwise product: its purpose, audience, experience, design, functionality, architecture, deployment direction, quality standards and remaining work. The product definition was agreed through an interactive review with the project owner.

Approval of this document establishes the intended product. It does not mean the website has been implemented, deployed or verified. Implementation status and evidence must be recorded accurately as work proceeds.

## 1. Canonical document and project foundation

This file describes the actual product, its experience, implementation, scope, quality standards, decisions and remaining work. The decision register records the reasoning behind major choices.

### Authority and evidence

- User-approved decisions define the product.
- The supplied handbook defines assessment requirements. The shorter milestone document and professor’s notes provide supporting context.
- Research informs decisions, with sources and access dates recorded.
- Existing temporary research remains historical material until its claims and evidence are reviewed.
- Planned capabilities, implemented capabilities and verified results must remain clearly distinguishable.
- When an agreed product decision changes, update this document and record the reason in its change history.

### Project organization

```text
Glowwise/
├── GLOWWISE_SOURCE_OF_TRUTH.md
├── Assets/
├── Documentation/
│   ├── Milestone 1/
│   └── References/
└── [Website source, configuration and deployment files]
```

Assets remain at the root. Research and assessment documentation remain separate from application code. Preserve the existing source materials and logo originals when organizing the workspace.

**Current state at version 1.0:** the workspace contains reference documents, an unfinished Milestone 1 draft, six brand asset files and this Source of Truth. Website implementation and deployment remain to be built. The directory structure above is the agreed target; saving this document does not reorganize the existing folders.

### Supplied project sources

The following original files inform this definition and must remain traceable when the directory is organized:

- `Reference/Mini-Project Handbook.docx`
- `Reference/Milestone 1 and 2 details with reference material links.md`
- `Reference/SEO prof notes.md`
- `milestone_1/Milestone1  someparts temporary.md`
- The six existing logo and display assets under `assets/`.

The coursework is the CSET489 SEO Mini Project, with 40 marks across two milestones. Milestone 1 carries 20 marks across ten individual two-mark criteria. The temporary draft is incomplete research material; it is not a final submission or proof that any criterion has been achieved.

## 2. Product, content and visitor experience

### Product definition

**Glowwise helps Indian young adults choose grooming products confidently through understandable guidance, researched selections and useful comparison tools.**

Its primary audience is approximately **18–30 years old, across genders**, reading English. Budget and midrange products lead; premium alternatives may appear when their additional value can be explained.

Glowwise covers six categories:

1. Skincare
2. Haircare
3. Bodycare
4. Fragrance
5. Beard and men’s grooming
6. Grooming tools

The central problem is the difficulty of navigating product claims, unfamiliar terminology, prices and competing recommendations. Glowwise makes the relevant differences understandable and helps visitors build a shortlist.

### Editorial approach

The website uses an **editorial-led hybrid**: guides and curated collections introduce useful choices, while structured product information supports discovery, filtering and comparison.

Every selection must explain:

- Who it may suit and why.
- Relevant features and limitations.
- Meaningful alternatives.
- Sources supporting factual claims.
- When product information and prices were checked.

Content is published under **Glowwise Editorial**, with transparent project ownership and selection methods. Research-based recommendations must not imply hands-on testing or professional medical endorsement.

The publisher is **Imagine Utopia**. The founders are **Aakash Kumar and Disa Bandhu**. These owner-supplied names do not establish incorporation, registration, an address, social profiles or a public contact email. Publish only separately verified and authorized contact details; do not infer a public address from a student account email.

Prices are manually checked, displayed in INR, and accompanied by a source and check date. Retailer prices and availability remain authoritative at purchase time.

### Working functionality

| Capability | Required behavior |
|---|---|
| Product discovery | Search published products and filter by category, product type, budget and relevant verified attributes. |
| Preference finder | Ask category, budget and relevant preferences; return matching products with understandable reasons. |
| Comparison | Compare up to three products of the same product type using consistent attributes. |
| Saved shortlist | Save and remove products in the current browser without creating an account. |
| Guides | Read substantial original articles connected to relevant categories and products. |
| Retailer links | Open real brand or retailer destinations for purchase. |
| Contact and corrections | Submit a real message to a private administrative inbox and receive an accurate confirmation. |

Search and filters must support clear/reset actions, useful empty states and browser navigation. Missing products, failed requests and unavailable browser storage need understandable recovery paths.

The finder uses transparent rules based on published product attributes. It must support back, skip where appropriate, restart and changed preferences. If nothing matches, it explains which preferences can be adjusted. It does not diagnose conditions or invent suitable matches.

Saved products remain local to the browser. Clearing browser storage removes them; there is no account synchronization.

### Scope boundaries

The first version includes genuine catalog data, working tools, editable content, real outbound links and a deployed website.

It excludes checkout, payments, customer accounts, community features, newsletters, paid AI, live retailer inventory and automatic price feeds. Affiliate links may be introduced later only through an actual approved arrangement with appropriate disclosure.

There are no simulated visitor-facing functions in the agreed release scope. Development placeholders must be replaced before publication.

### Content targets

- **First public release:** at least 36 researched products, at least six substantial guides covering all six categories, and all visitor tools working.
- **Complete content target:** 36–60 researched products and 18–24 substantial original guides.

Product coverage must support meaningful comparisons; each category should not become a collection of unrelated products that cannot be compared.

### Information architecture

| Area | Purpose |
|---|---|
| Home | Explain Glowwise immediately; introduce categories, guides, selections and the finder. |
| Six category hubs | Combine introductory guidance, relevant articles and curated products. |
| Explore | Searchable and filterable catalog. |
| Product pages | Facts, suitability, limitations, checked prices, sources and retailer links. |
| Guides index and articles | Educational and purchase-decision content. |
| Finder | Guided preference-based discovery. |
| Compare | Structured comparison of selected products. |
| Saved | Browser-local shortlist. |
| About and How We Select | Explain ownership, purpose, methodology and limitations. |
| Contact and Corrections | Provide a functioning route for questions and factual corrections. |
| Policies and accessibility | Explain actual website behavior and support needs. |

Use stable, readable addresses such as `/products/{slug}/` and `/guides/{slug}/`. Category hubs, products and guides must link to one another deliberately.

### Footer and supporting pages

Every public page receives a complete footer containing:

- Glowwise identity, short description and copyright.
- Category and guide navigation.
- About, How We Select, Contact and Corrections.
- Privacy Policy, Terms of Use, Cookies and Browser Storage.
- Product-information and commercial disclosures.
- Accessibility statement and a working cookie-settings control.

Every link leads to relevant content or a functioning control. Policies describe the actual storage, analytics, contact handling and commercial relationships.

Desktop uses organized columns; mobile uses readable stacked groups with the same information. Social links appear only when real project profiles exist.

## 3. Brand, design and equal device support

### Visual identity

Retain the existing Glowwise wordmark and monogram. Improve exports, sizing and suitable color variants while preserving their identity.

| Element | Direction |
|---|---|
| Personality | Informed, approachable, thoughtful and visually polished. |
| Main color | Deep teal `#123F3F` |
| Background | Warm cream `#F7F4EC` |
| Accent | Restrained apricot `#E5B798` |
| Headings | DM Serif Display |
| Body and interface | Manrope |
| Theme | Light only |
| Layout | Generous spacing, clear hierarchy, editorial compositions and soft corners. |

Apricot is an accent rather than the default color for small text. Interface color combinations must meet the contrast target.

Use a consistent spacing scale, restrained borders, readable article widths and a shared component system. Product cards need clear names, relevant facts and obvious actions.

### Imagery and original assets

Combine accurate product imagery, appropriately licensed photography and original graphics.

Original visual work should develop the brand’s compass and sparkle motifs into category illustrations, editorial compositions, icons and animated scenes. It must contribute to Glowwise’s identity rather than serve as generic decoration.

Record image sources and usage rights. Do not assume that retailer photography is freely reusable or create fabricated packaging for real products.

### Reference direction

- **[Aesop](https://www.aesop.com/):** warm surfaces, generous spacing, editorial/product composition and organized supporting navigation.
- **[Typology](https://www.typology.com/):** clear product presentation and category discovery.
- **[Illoca](https://illoca.unseen.co/):** animated typography, expanding imagery and original illustrated scenes as motion references.

These references inform an original Glowwise design. Their live interfaces were reviewed on 8 October 2026.

### Motion and interaction

Use immersive scroll storytelling on the homepage and selected editorial sections:

- Layered images and original graphics.
- Animated typography and coordinated reveals.
- Selected pinned sequences where they improve the story.
- Responsive hover, press, save and comparison feedback.

Use GSAP and ScrollTrigger where appropriate; GSAP currently provides its tools without a license charge. [GSAP pricing](https://gsap.com/pricing/)

Core content must remain available without animation. Preserve normal scrolling, keyboard use and browser navigation. Reduced-motion preferences remove intensive movement and pinning. Continuous decorative animation must be pausable.

### Mobile and desktop parity

**Mobile and desktop are equally supported product experiences.**

All core functions must work on both. Adapt navigation, filters, comparison, typography, imagery and motion to available space and input method.

- Mobile filters use an accessible panel with clear apply/reset actions.
- Comparison keeps product identity and attribute labels understandable on narrow screens.
- Controls work through touch, keyboard and pointer.
- Hover effects supplement visible controls.
- Mobile motion retains the visual concept with lighter compositions.
- Content must not overflow horizontally except within deliberately designed comparison regions.

Target WCAG 2.2 AA accessibility, including visible focus, semantic structure, labeled forms, useful alternative text, sufficient contrast and comfortable touch targets. This is a target, not a claim of completed conformance verification.

## 4. Implementation, data and deployment

### Selected architecture

Use **WordPress with a custom Glowwise theme and a separate `glowwise-core` plugin**.

The theme owns layouts, styling, components and motion. The plugin owns catalog structures, product attributes, finder logic and supporting functionality. This keeps product data and behavior reusable through future design changes.

WordPress provides the authenticated editing interface. Public pages are server-rendered, with JavaScript enhancing interactive tools. No separate application backend is required.

WordPress itself recommends keeping presentation in themes and persistent functionality in plugins. [WordPress theme guidance](https://developer.wordpress.org/themes/getting-started/what-is-a-theme/)

### Content and interfaces

Use structured product records with:

- Name, brand, category and product type.
- Checked INR price, quantity or specification, source and date.
- Images with source/rights information.
- Verified category-specific attributes.
- Editorial suitability, strengths and limitations.
- Retailer destinations and supporting references.

Unknown information stays unknown. Guides use native WordPress editorial content linked to relevant product and category records.

Public catalog and finder interfaces belong under `/wp-json/glowwise/v1`. They expose published information only. Editing and private contact records require appropriate WordPress permissions.

Contact submissions use server-side validation and spam controls. Messages are stored in a private inbox; email notification is optional and must not be claimed until configured.

### Technical defaults

- Docker Compose for the reproducible Azure VM development and runtime environment. Develop, build and run the website on the Azure VM. Local files may contain source, documentation, assets and deployment tooling; a local website development runtime is not the default workflow.
- Official WordPress Apache/PHP image, MariaDB and Caddy for HTTPS.
- Supported compatible versions pinned during setup.
- Custom CSS and JavaScript with build-time minification.
- Self-hosted font files.
- Yoast SEO Free for metadata, canonicals, sitemaps and baseline structured data.
- WP Super Cache for page caching.
- UpdraftPlus Free for complete site and database backups.

Keep secrets out of source control. Runtime uploads and database storage remain separate from tracked application source.

### SEO and analytics

Use original, useful content, clear page relationships, readable URLs, descriptive titles and appropriate structured data. Product, article and organization facts must match visible content. Avoid invented ratings or merchant offers.

Index useful public content. Keep internal search, arbitrary filter combinations, finder results, comparison and saved pages out of the search index.

Google’s guidance supports helpful content and clear website structure; it does not prescribe a universal article length. [Google SEO Starter Guide](https://developers.google.com/search/docs/fundamentals/seo-starter-guide)

Integrate Search Console and GA4 early enough to collect real evidence for Milestone 2. Analytics loads only after affirmative consent, using basic consent behavior. Contact text and personal information must not enter analytics events. [Google consent-mode guidance](https://developers.google.com/tag-platform/security/concepts/consent-mode)

Track useful actions such as finder completion, comparison, saves and retailer clicks. Report actual observations without inventing traffic, rankings or conversion figures.

### Azure deployment and total spending ceiling

**Owner decisions, 9 October 2026:** `glowwise.tech` is already registered through Namify / .Tech Domains / Radix. Do not purchase another domain. The GitHub repository is [aakash-kr-7/glowwise](https://github.com/aakash-kr-7/glowwise); local Git is initialized on `main` with this origin. Inspect current state before changing or publishing it.

Azure for Students is active. The owner authorizes **at most US$10 TOTAL Azure consumption across every project resource and all project time**, preferably covered by student credit. This is a lifetime project ceiling, not US$10 per month; credit-funded usage still counts. No payment card, paid subscription upgrade or unrelated paid service is authorized. This supersedes version 1.0's strictly zero-consumption deployment constraint; it does not authorize spending during the inspection stage.

Selected route:

1. Recheck current resources, costs, spending protection, exact region/VM configuration, quota/capacity and benefit eligibility.
2. Establish a full estimate and finite operating/retention window within the total ceiling, accounting for compute, disks, public IP, networking and residual resources. Do not promise indefinite free hosting.
3. Develop and run the selected Docker Compose / official WordPress Apache-PHP / MariaDB / Caddy stack on the Azure VM, preserving a portable installation and separate custom theme/core plugin.
4. Use the existing domain and Cloudflare DNS/CDN with Full (strict). The owner reports nameservers `angela.ns.cloudflare.com` and `trace.ns.cloudflare.com`; both were independently returned by public resolvers on 9 October. Authenticated Cloudflare activation/settings remain unverified.
5. Record actual versions, usage, expiry, backups, recovery and lifecycle actions throughout execution. Keep secrets, raw private output, personal contact data and backups out of the public repository.

Keep Azure spending protection in place. Budgets and student credit are not a custom US$10 hard stop; VM deallocation can leave storage/network costs. The infrastructure gate must address those limits before creation. If no adequate configuration fits the ceiling, record the blocker before provisioning; do not silently replace the assessed VPS installation with another architecture.

Caddy-managed **Let's Encrypt ACME issuance and renewal** is the selected certificate mechanism. Record actual issuer/configuration and renewal evidence; do not claim Certbot is installed. The handbook's wording and a compatible literal-Certbot alternative are assessed in `Documentation/Implementation/DECISIONS.md`.

**External dependencies:** a verified affordable Azure configuration, authenticated Cloudflare configuration access, Google property access and instructor-designated backlink domains. Domain purchase and student eligibility are no longer pending owner decisions. Current access observations and the preserved earlier readiness record are linked from `Documentation/Implementation/BUILD_STATE.md`.

## 5. Milestones, evidence and completion standard

### Milestone 1

After the Source of Truth is saved and accepted, create **ten separate criterion documents**, each covering its own two marks:

| Criterion | Required work and evidence |
|---|---|
| Niche and audience | Data-supported problem, audience and 100–150-word justification. |
| Keyword research | Required primary, secondary and long-tail research with dated metrics and intent. |
| SERP analysis | Actual ranking URLs, snippets, questions, content structure and supporting captures. |
| Competitor analysis | Two direct competitors, keywords, backlinks and defensible gaps. |
| Information architecture | Hierarchy, URLs and keyword-to-page mapping without competing page intent. |
| SEO roadmap | Prioritized technical, content, on-page and off-page work in dependency order. |
| Domain and Cloudflare | Domain, DNS/CDN, HTTPS, propagation, caching and minification evidence. |
| VPS and WordPress | Functional server stack, WordPress, HTTPS, SSH and relevant logs. |
| Evidence organization | Traceable research, screenshots, logs and matrices. |
| Demonstration | Live website and evidence addressing the handbook’s demonstration requirements. |

Each file connects **requirement → research → decision → implementation → evidence → remaining gap**. All ten criteria total 20 marks; marks are not claimed merely because a document or plan exists.

Cloudflare’s former Auto Minify feature has been deprecated. Use build-time minification and document the current equivalent rather than claiming an unavailable setting was enabled. [Cloudflare deprecations](https://developers.cloudflare.com/fundamentals/api/reference/deprecations/)

### Milestone 2 preparation

The architecture must support technical/on-page SEO and schema, performance and security, original content, the required backlink, Search Console and GA4, real reporting, a comprehensive audit, evidenced improvements, the final report, restorable backups and the viva.

Preserve before-and-after observations as work progresses. Keep credentials and private contact data out of publicly shared evidence and backup submissions. The handbook’s full-site/database backup and publicly accessible submission requirements must be addressed explicitly when preparing that deliverable.

Some supplied external resources could not be fully accessed during research, including linked Moz material and YouTube resources. Record those access limitations; do not describe inaccessible videos or pages as reviewed. Their relevant instructions should be investigated further when the corresponding criterion is addressed.

### Planned acceptance scenarios

These are acceptance requirements, **not checks already performed**:

- Complete discovery → finder → product → comparison → save → retailer journeys on mobile and desktop.
- Confirm refresh persistence, changed filters, empty results, missing records and unavailable browser storage.
- Confirm real contact delivery to the private inbox and truthful success/error messages.
- Check navigation, every footer destination, keyboard operation, focus, contrast and reduced motion.
- Confirm analytics remains blocked before consent and cookie settings work.
- Confirm editable content, correct metadata, indexing rules and structured data.
- Confirm domain, HTTPS, caching, server operation and backup restoration.
- Capture actual screenshots and logs with dates and context.

Target Core Web Vitals of **LCP ≤2.5 seconds, INP ≤200 milliseconds and CLS ≤0.1**, assessed with field data when available. Laboratory measurements must be labeled separately. [Core Web Vitals](https://web.dev/articles/vitals)

### Remaining work

Maintain the implementation handoff, establish the budget-compliant Azure VM foundation, research each criterion, build the content and tools on the VM, verify deployment and collect genuine evidence. Stage 1 preparation is recorded separately; no website implementation or resource provisioning is claimed by this amendment.

There is no calendar schedule in this plan. Work proceeds by prerequisites and completion criteria. The Source of Truth changes only when an agreed product decision changes, with the reason recorded.

### Decision register

| Decision | Agreed choice | Reason |
|---|---|---|
| Product purpose | Help people choose grooming products confidently. | Gives the product a clear visitor outcome. |
| Audience | Indian young adults, approximately 18–30, across genders; English. | Defines content, product availability, currency and communication. |
| Coverage | All six grooming categories. | Establishes the complete intended product from the outset. |
| Price positioning | Budget and midrange lead; selective premium alternatives. | Keeps recommendations relevant to the primary audience. |
| Experience | Editorial-led guides plus a structured working catalog. | Connects learning with practical selection. |
| Recommendation basis | Transparent research and verified facts. | Supports credible recommendations without implying hands-on testing. |
| Core tools | Search/filter, rules-based finder, comparison and local saved products. | Makes the site demonstrably useful. |
| Transactions | Real outbound retailer links; no checkout. | Provides a purchase path within the agreed scope. |
| Accounts | Guest use; browser-local saved products. | Avoids unnecessary registration and account infrastructure. |
| Brand | Retain Glowwise wordmark and monogram. | Builds on the existing identity. |
| Visual direction | Warm editorial styling, teal/cream/apricot, DM Serif Display and Manrope. | Creates the agreed approachable and polished experience. |
| Imagery | Accurate product imagery, licensed photography and original graphics. | Combines product clarity with a distinctive identity. |
| Motion | Immersive scroll storytelling with responsive and reduced-motion adaptations. | Delivers the desired visual ambition while retaining usability. |
| Devices | Equal support for mobile and desktop. | Ensures the complete experience works across screen sizes and input methods. |
| Footer | Complete, functional navigation and relevant policy/support pages. | Makes project information, help and policies accessible throughout the site. |
| Architecture | Custom WordPress theme plus separate core plugin. | Supports editorial administration, SEO and future design changes. |
| Release scope | All tools, at least 36 products and six guides initially. | Makes the first public release a functional product. |
| Complete content | 36–60 products and 18–24 substantial guides. | Establishes the intended breadth beyond initial release. |
| Cost | At most US$10 total Azure consumption for the project across all resources and time, preferably student credit; no card, paid subscription upgrade or unrelated paid service. | Supersedes the older zero-consumption constraint with the owner’s 9 October ceiling. |
| Deployment direction | Existing glowwise.tech; active Azure for Students; Cloudflare; portable Compose / WordPress Apache-PHP / MariaDB / Caddy stack. | Uses the registered domain and assessed VPS route without duplicate purchase. |
| Development location | Build, develop and run the website on the Azure VM; local source/docs/assets/tooling allowed. | Follows the owner’s 9 October operational decision. |
| Publisher and founders | Imagine Utopia; Aakash Kumar and Disa Bandhu; Glowwise Editorial byline. | Establishes public attribution without inventing legal or contact facts. |
| Workflow | Product definition first; then criterion-by-criterion Milestone 1 work. | Keeps documentation, evidence and implementation coherent. |
| Scheduling | Prerequisites and completion criteria without a calendar plan. | Reflects the owner’s requested working approach. |

### Reference currency and change history

External research and live design references supporting version 1.0 were reviewed on **8 October 2026**, except where access limitations are stated. Provider offers, eligibility, software compatibility and licensing must be checked again when they are acted upon. Historical keyword and competitor metrics require their original capture dates and must not be presented as freshly measured data.

| Version | Date | Change |
|---|---|---|
| 1.0 | 8 October 2026 | Saved the agreed product definition following interactive discovery, source review, research and final owner confirmation. No website implementation or deployment is claimed. |
| 1.1 | 9 October 2026 | Recorded explicit owner amendments: registered glowwise.tech, repository/origin, publisher/founders, US$10 total Azure ceiling and Azure VM development location. Retained the selected architecture and unrelated product decisions. Added traceable Stage 1 handoff and certificate interpretation; no build, provisioning or publication performed. Earlier readiness remains historical. |
