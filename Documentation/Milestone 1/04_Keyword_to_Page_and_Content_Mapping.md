# Glowwise — Keyword-to-Page / Content Mapping

**Milestone 1 · Project Design · Part 1 · 2 marks**  
**Planning and source-review date:** 8 October 2026  
**Market:** India · English · affordable and midrange grooming discovery  
**Status:** Detailed architectural recommendation for implementation; pages are not yet built or deployed.

**Product reference:** [Glowwise Source of Truth](../../GLOWWISE_SOURCE_OF_TRUTH.md)  
**Research inputs:** [Keyword Research & Intent](02_Keyword_Research_LSI_and_Search_Intent_Mapping.md) · [Competitor Analysis & SERPs](03_Competitor_Analysis_and_SERP_Breakdown.md)  
**Supporting records:** [Evidence Index](<../References/Milestone 1/04 Keyword Page Content Mapping/Evidence_Index.md>) · [Keyword ownership CSV](<../References/Milestone 1/04 Keyword Page Content Mapping/Keyword_Ownership.csv>)

> **Architectural decision:** Organise Glowwise around six category hubs, a searchable catalog and one substantial guide for each researched selection need. Give products stable individual pages. Keep search/filter states and personal tools outside the search index. Every measured keyword has one designated editorial owner; related wording supports that owner instead of generating competing articles.

## 1. Requirement, scope and evidence basis

The handbook asks for a complete site hierarchy and URL taxonomy, with primary, secondary and “LSI” terms assigned to Homepage, About, Services/Categories and Blog posts without keyword cannibalization. This document supplies:

| Requirement | Deliverable |
|---|---|
| Architectural hierarchy | Complete public page families, working tools, footer destinations and system boundaries. Sections 3–4. |
| URL taxonomy | Exact hub/support routes, seven guide routes, product/variant rules, pagination and parameter conventions. Sections 4, 8 and 10. |
| Keyword mapping | All **15 K-records and 10 L-records** from Criterion 2 assigned to a specific guide; broader page-purpose phrases for Home, About and category hubs separately labelled unmeasured. Sections 5–7. |
| Cannibalization prevention | Defined page roles, overlap cases, canonical/indexing policy, internal links and a publication/change procedure. Sections 8–11. |
| Complete product fit | Mobile/desktop parity, functioning finder/compare/save, editorial accountability and the professional footer required by the Source of Truth. |

**Services/Categories:** Glowwise is a product-discovery and editorial website. The six category hubs fulfil this part of the rubric. A fictional services, appointments or checkout section would misrepresent the agreed product.

**Blog posts:** The public label is **Guides**, and articles use `/guides/{slug}/`. They fulfil the blog-article requirement. Do not publish the same article again under `/blog/`.

**Evidence labels:** K01–K15 and L01–L10 retain the exact phrases and metrics already researched on 8 October. New broad phrases below are proposed page-positioning language, not newly measured SEO opportunities. “LSI” follows the handbook's terminology for related vocabulary; no Google LSI score or ranking benefit is claimed. [Ahrefs terminology explanation](https://ahrefs.com/blog/lsi-keywords/).

No new volume, KD, current Glowwise ranking or automated clustering result is claimed. The seven clusters are a manual intent-based architecture informed by the saved SERP study; every secondary variant has not received a separate fresh SERP-overlap test. [Semrush keyword-mapping method](https://www.semrush.com/blog/keyword-mapping/).

## 2. Page roles: what each part owns

| Page type | Visitor's task | Content it owns | Boundary |
|---|---|---|---|
| Homepage | Understand Glowwise and choose a starting point. | Brand promise, six areas, selected guides, finder introduction and trust. | Introduces specific guides with short summaries; does not duplicate their full recommendations. |
| Categories index | Choose a grooming area. | Six category descriptions and links. | Does not become a second full catalog or a collection of seven copied guides. |
| Category hub | Explore a broad grooming area. | Orientation, relevant guides, curated products and links to filtered exploration. | Broad discovery; does not independently target the exact question/budget cluster owned by a guide. |
| Explore | Browse/search the full catalog. | Product discovery and working filters. | The clean catalog is a destination; arbitrary filtered/search states are not SEO landing pages. |
| Guide article | Resolve one learning or buying decision. | A substantive answer, selection method, relevant comparisons, sources and FAQs. | Owns its related question variants. One guide can rank for many terms. |
| Product page | Understand one identifiable product family/formulation/model. | Verified facts, variants/sizes, price checks, suitability, limitations and retailer destinations. | Targets specific product identity, not every generic “best product” phrase. |
| About | Understand the project and who publishes it. | Ownership, audience, purpose and editorial identity. | Does not repeat the homepage sales pitch or the complete selection methodology. |
| How We Select | Understand the recommendation method. | Research, selection, sourcing, updates, commercial relationships and testing limitations. | Methodology owner; About links here instead of reproducing the whole policy. |
| Finder / Compare / Saved | Complete a personal discovery task. | Rules-based matching, up-to-three comparison and browser-local storage. | Functional tools with `noindex`; not competing editorial articles. |

These roles are editorial responsibilities, not a prohibition on naturally mentioning the same words across a site. Multiple pages appearing for a query does not by itself prove harmful cannibalization; intent and performance need inspection. [Ahrefs cannibalization analysis](https://ahrefs.com/blog/keyword-cannibalization/).

## 3. Complete architectural site hierarchy

**Legend:** `[I]` = eligible for indexing when complete and published; `[N]` = public utility/policy page excluded from indexing; `[P]` = planned article/product instance, not a live URL. Index eligibility does not guarantee Google will index or rank a page.

```text
/                                      [I] Home
├── /categories/                       [I] Choose a grooming category
│   ├── /categories/skincare/          [I] Skincare hub
│   │   └── Links to G02, G05 and verified skincare products
│   ├── /categories/haircare/          [I] Haircare hub
│   │   └── Links to G01 and verified haircare products
│   ├── /categories/bodycare/          [I] Bodycare hub
│   │   └── Links to G04 and verified bodycare products
│   ├── /categories/fragrance/         [I] Fragrance hub
│   │   └── Links to G03 and verified fragrances
│   ├── /categories/beard-grooming/    [I] Beard & Men's Grooming hub
│   │   └── Links to G06 and verified beard/grooming products
│   └── /categories/grooming-tools/    [I] Grooming Tools hub
│       └── Links to G07 and verified grooming tools
├── /explore/                          [I] Full product catalog
│   ├── /products/{product-slug}/      [I,P] One page per verified product family
│   └── Search/filter/sort states      [N] Query parameters, not new landing pages
├── /guides/                           [I] Editorial / blog index
│   ├── /guides/shampoo-for-dry-frizzy-hair/          [I,P] G01
│   ├── /guides/sunscreen-for-oily-skin/              [I,P] G02
│   ├── /guides/perfumes-under-1000/                  [I,P] G03
│   ├── /guides/body-lotion-for-dry-skin/             [I,P] G04
│   ├── /guides/face-wash-for-sensitive-skin/         [I,P] G05
│   ├── /guides/beard-oil-benefits/                   [I,P] G06
│   ├── /guides/trimmers-under-1500/                  [I,P] G07
│   └── Additional distinct guides                  [P] Research before publication
├── /finder/                           [N] Preference-based product discovery
├── /compare/                          [N] Compare up to three of the same type
├── /saved/                            [N] Browser-local shortlist
├── /about/                            [I] About Glowwise
├── /how-we-select/                    [I] Editorial and selection methodology
├── /contact/                          [I] General contact
├── /corrections/                      [I] Report product/content inaccuracies
├── /disclosures/                      [I] Product-information/commercial disclosure
├── /accessibility/                    [I] Accessibility statement and support route
├── /privacy/                          [N] Privacy Policy
├── /terms/                            [N] Terms of Use
├── /cookies-and-storage/              [N] Cookies, consent and browser storage
└── /sitemap/                          [N] Human-readable navigation directory

System endpoints (not editorial landing pages)
├── /sitemap_index.xml                 Generated SEO sitemap index
├── /robots.txt                        Crawl directives and sitemap location
├── /wp-json/glowwise/v1/...            Published catalog/finder API; protected mutations
├── /wp-admin/ and authentication      Restricted administration
└── 404 / validation / empty states    Rendered at their proper route; no SEO articles
```

**Logical hierarchy and physical paths differ deliberately.** A product is reachable from its category and Explore but has one `/products/…/` address. A guide is linked from its category and Guides but has one `/guides/…/` address. Changing a category association should not move the product/article URL.

Google uses page links to understand site relationships; a nested URL alone does not establish that relationship. Important content must be reachable through ordinary links, not only through a search form. [Google site-structure guidance](https://developers.google.com/search/docs/specialty/ecommerce/help-google-understand-your-ecommerce-site-structure).

### Navigation and footer

- **Primary navigation:** Categories, Explore, Guides, Find My Products; About as a secondary brand link. Compare and Saved remain readily accessible utilities with clear counts/state.
- **Homepage paths:** Home → category → guide/product, and Home → finder → product/compare. Feature useful guides directly rather than burying all editorial content behind an index.
- **Footer groups:** Explore the six categories and Guides; About/How We Select/Contact/Corrections; Privacy/Terms/Cookies and Storage/Disclosures/Accessibility; HTML Sitemap.
- **Cookie settings:** A working control that reopens consent settings, separate from the explanatory `/cookies-and-storage/` page.
- **Mobile:** The same destinations appear in accessible menus and stacked footer groups. Core pages, sources and actions must not disappear at narrow widths. Essential links must not require hover.
- **Social links:** Add only real project profiles. Do not publish empty social destinations or retailer returns/shipping policies for Glowwise.

## 4. URL taxonomy and complete page register

### URL conventions

1. Use lowercase English words, hyphens and a consistent trailing slash for HTML routes; system files retain their actual extensions.
2. Keep slugs meaningful and stable. Avoid years, temporary sale claims, repeated category nesting and unnecessary IDs in public article URLs.
3. Keep existing researched guide paths unchanged. Do not add a second address just to fit “best,” “which” or changed word order.
4. Use one HTTPS production origin once a domain is actually selected. The relative routes here do not imply ownership of a Glowwise domain.
5. Link directly to canonical paths. Redirect equivalent case/slash/host variants to the chosen form; unknown content must return 404 rather than redirecting everything to Home.
6. Anchors such as `#comparison` or `#spf-50` navigate within one guide. They are not separate pages or separate SEO owners.

These conventions adapt [Google URL guidance](https://developers.google.com/search/docs/crawling-indexing/url-structure) to the product; short URLs alone do not guarantee rankings.

### Brand, discovery and category destinations

All page-positioning phrases in this table are **proposed and unmeasured**. They are not additional KD-qualified keywords.

| ID | Canonical route | Primary page focus | Secondary language / related vocabulary | Intent and ownership |
|---|---|---|---|---|
| N01 | `/` | Glowwise; affordable grooming discovery in India | Grooming guidance, researched selections, compare products, INR prices | Brand navigation + broad discovery. Introduce, then route visitors to specific owners. |
| N02 | `/categories/` | Glowwise grooming categories | Skin, hair, body, fragrance, beard, tools | Category navigation; summary cards and six hub links. |
| N03 | `/explore/` | Glowwise product catalog | Browse grooming products, filter, budget, product type | Catalog navigation; does not own K01–K07. |
| N04 | `/guides/` | Glowwise grooming guides | Buying guidance, explanations, product comparisons | Editorial navigation, with distinct article cards. |
| C01 | `/categories/skincare/` | Skincare product discovery | Face cleansers, sunscreen, product attributes, texture | Broad category. G02 owns oily-skin sunscreen selection; G05 sensitive-skin cleanser selection. |
| C02 | `/categories/haircare/` | Haircare product discovery | Shampoo, conditioner, hair texture, routines | Broad category. G01 owns dry/frizzy shampoo selection. |
| C03 | `/categories/bodycare/` | Bodycare product discovery | Body lotion, moisturisers, texture, fragrance preferences | Broad category. G04 owns dry-skin lotion selection. |
| C04 | `/categories/fragrance/` | Fragrance discovery | Perfumes, EDP/EDT, scent families, sizes | Broad category across budgets. G03 owns the under-₹1,000 selection cluster. |
| C05 | `/categories/beard-grooming/` | Beard & men's grooming discovery | Beard oil, balm, grooming routines, maintenance | Broad category, retaining the agreed category name; avoid treating gender as evidence of product suitability. G06 owns benefits. |
| C06 | `/categories/grooming-tools/` | Grooming tool discovery | Trimmers, attachments, runtime, charging, cleaning | Broad tool category. G07 owns trimmers under ₹1,500. |

### Trust, support, policy and utility destinations

The branded phrases below define intended page purpose; no existing branded demand is asserted.

| ID | Route | Primary / secondary topic | Required content and boundary | Index plan |
|---|---|---|---|---|
| T01 | `/about/` | About Glowwise; project ownership | Who publishes Glowwise, audience and purpose; introduce Glowwise Editorial and link to method/contact. | Index |
| T02 | `/how-we-select/` | How Glowwise selects products; editorial policy | Inclusion/exclusion rules, sources, factual checks, updates and research-versus-testing disclosure. | Index |
| T03 | `/contact/` | Contact Glowwise | Real validated contact form, private administrative inbox and truthful delivery feedback. Link factual reports to Corrections. | Index |
| T04 | `/corrections/` | Glowwise product/content corrections | A distinct correction form/flow with source page, disputed fact and supporting reference; reuse the same secure inbox infrastructure. | Index |
| T05 | `/disclosures/` | Glowwise product information and commercial disclosures | Explain checked prices, retailer authority, non-medical guidance and actual commercial relationships. No invented affiliate participation. | Index |
| T06 | `/accessibility/` | Glowwise accessibility | Current support measures, known limitations and contact route. State goals without claiming an unaudited compliance result. | Index |
| T07 | `/sitemap/` | Glowwise site directory | Human-readable links grouped by actual published section. Navigation utility, not a copy of article text. | Noindex |
| S01 | `/privacy/` | Privacy Policy | Actual contact handling, storage, analytics and retention behavior. | Noindex |
| S02 | `/terms/` | Terms of Use | Actual editorial/discovery service scope and use terms. | Noindex |
| S03 | `/cookies-and-storage/` | Cookies and browser storage | Local shortlist, consent choices, analytics behavior and storage limitations; link to cookie-settings control. | Noindex |
| U01 | `/finder/` | Glowwise product finder | Working category/budget/preference flow, reasons, back/restart and no-match recovery. No diagnosis. | Noindex |
| U02 | `/compare/` | Glowwise product comparison | Up to three products of the same product type; consistent fields and selected variant/size. | Noindex |
| U03 | `/saved/` | Glowwise saved products | Local save/remove, persistence explanation, clear empty state and unavailable-storage recovery. | Noindex |

Noindex policies remain publicly readable and linked from the footer. Their purpose is support rather than organic acquisition. This is an indexing recommendation, not a claim that a search engine is legally prohibited from showing them.

## 5. Primary, secondary and related keyword-to-guide map

**Metric provenance:** Focus volumes and KD below are the saved **Semrush India estimates observed 8 October 2026** in Criterion 2. They have not been recalculated for this document. Intent is Glowwise's working interpretation. The preferred below-20 threshold applies to initial focus selection, not to every category or secondary phrase.

| Guide ID / canonical page | Primary focus and existing estimate | Secondary K-records | Related / long-tail L-records | Intent and priority |
|---|---|---|---|---|
| **G01** `/guides/shampoo-for-dry-frizzy-hair/` | **K01:** shampoo for dry and frizzy hair · 6,600 / KD 18 | **K10:** which shampoo is best for dry and frizzy hair; **K11:** best shampoo for dry and frizzy hair | **L01:** same phrase as K10; **L02:** best shampoo and conditioner for dry frizzy hair; **L10:** which shampoo is best for frizzy and dry hair | C + I; initial focus. Shared selection need; conditioner support is a section. |
| **G02** `/guides/sunscreen-for-oily-skin/` | **K02:** which is the best sunscreen for oily skin · 1,600 / KD 18 | **K13:** best sunscreen for oily skin | **L05:** same phrase as K02; **L06:** best sunscreen for oily skin spf 50 | C; initial, evidence-intensive. SPF 50 comparison is a section, not an automatically separate page. |
| **G03** `/guides/perfumes-under-1000/` | **K03:** perfume under 1000 · 1,300 / KD 19 | No additional K-record assigned | **L07:** best perfume for women under 1000; **L08:** best perfume for men under 1000 | C + I; initial. One inclusive budget guide with relevant sections/preferences and verified variants. |
| **G04** `/guides/body-lotion-for-dry-skin/` | **K04:** which body lotion is good for dry skin · 140 / KD 13 | **K08:** body lotion for dry skin; **K09:** best body lotion for dry skin | **L03:** same phrase as K04 | C; initial, prioritised by the SERP study. Broad and question wording share one decision owner. |
| **G05** `/guides/face-wash-for-sensitive-skin/` | **K05:** which face wash is best for sensitive skin · 390 / KD 20 | **K12:** face wash for sensitive skin; **K15:** cetaphil face wash for sensitive skin | **L04:** same phrase as K05 | C, with C/T overlap for K15; conditional focus. A branded-options section must be backed by actual verified products. |
| **G06** `/guides/beard-oil-benefits/` | **K06:** beard oil benefits · 590 / KD 24 | No additional K-record assigned | No L-record from the ten-term table; use the explanatory vocabulary in Section 6 | I; conditional focus. Explain purpose and limits before optional discovery links. |
| **G07** `/guides/trimmers-under-1500/` | **K07:** best trimmer under 1500 · 720 / KD 29 | **K14:** trimmer under 1500 | **L09:** best trimmer for men under 1500 | C; conditional, comparison-dependent. Specifications and budget eligibility are central. |

**Audit result of the mapping:** 25 source records represent **21 unique exact phrases**, because L01 duplicates K10, L03 duplicates K04, L04 duplicates K05 and L05 duplicates K02. Each duplicate pair has the same owner. L10 is a distinct reordered phrase, also owned by G01. Do not add these rows' search volumes together as independent demand.

**K15 boundary:** The existing brand-specific phrase remains supporting coverage on G05; this does not invent a Cetaphil SKU or product-page URL. Once the catalog is researched, a product page may own its precise brand + formulation/model query. Changing the generic K15 owner requires an explicit map revision based on actual product identity and intent, not a silent duplicate assignment.

The [Keyword Ownership CSV](<../References/Milestone 1/04 Keyword Page Content Mapping/Keyword_Ownership.csv>) records each K/L identifier, exact phrase, original metrics, owner and duplicate relationship individually.

## 6. Article titles, content scope and links

Titles below are proposed editorial titles/H1s; final metadata and copy can be refined without changing ownership. Natural language is preferred over copying awkward query grammar into headings.

### G01 — Shampoo for Dry, Frizzy Hair: How to Choose

- **Answer:** Explain the choice and its limitations; give a useful shortlist with checked product facts.
- **Suggested H2s:** Selection criteria; product comparison; options by relevant hair/scalp preferences; shampoo and conditioner; how to use the comparison; FAQs and sources.
- **H3 coverage:** Specific product sections and useful answers to K10/L10. L02 receives a substantive conditioner-pairing section where verified options support it.
- **Semantic coverage:** Cleansing, conditioner, frizz, texture, formulation, pack size and price per comparable unit.
- **Links:** Haircare hub, relevant product pages, How We Select and the same-type comparison tool.
- **Exclude:** A second “best shampoo” article, a reordered-question page, unsupported dermatologist endorsement or guaranteed repair claims.

### G02 — Sunscreen for Oily Skin: Compare Your Options

- **Answer:** Help compare verified label attributes, budget and preferences; avoid claiming universal suitability.
- **Suggested H2s:** What to compare; checked shortlist; SPF 50 options; finish and other stated attributes; selection limits; FAQs and sources.
- **H3 coverage:** Named verified products and a clear answer to the primary question. L06 stays within the SPF 50 section initially.
- **Semantic coverage:** SPF, UVA/PA label information where verified, finish, white cast claims, format and stated water resistance. Unknown attributes remain unknown.
- **Links:** Skincare hub, product records and source-supported further explanation.
- **Exclude:** Separate generic and “which is best” guides answering the same question, invented medical review or a presumed measured under-₹500 opportunity.

### G03 — Perfumes Under ₹1,000: Find Your Scent

- **Answer:** Show budget-eligible purchasable variants and explain the trade-offs between size, format, scent family and stated positioning.
- **Suggested H2s:** Budget rules and checked prices; comparison; scent families; men's, women's and relevant unisex options; size/format trade-offs; FAQs.
- **H3 coverage:** Useful fragrance groups and verified individual options. L07/L08 are supported without assuming scent preference from gender.
- **Semantic coverage:** EDP/EDT, bottle size, scent family, occasion, manufacturer descriptions and price-check date.
- **Links:** Fragrance hub, eligible product records, Compare and Saved.
- **Exclude:** Separate near-identical gender/budget lists at launch. Define “under ₹1,000” as a displayed item price below ₹1,000 for the identified variant; state how delivery and temporary offers affect the total. Recheck eligibility before publication.

### G04 — Body Lotion for Dry Skin: A Practical Buying Guide

- **Answer:** Provide a relevant adult body-lotion shortlist with reasons and understandable differences.
- **Suggested H2s:** Choosing criteria; product comparison; texture and fragrance preferences; pack size and unit cost; practical limitations; FAQs and sources.
- **H3 coverage:** Product-specific distinctions and answers to the “which” and “best” variants.
- **Semantic coverage:** Moisturiser, texture, humectant/emollient terminology when accurately explained, fragrance information and price per 100 ml or 100 g as applicable.
- **Links:** Bodycare hub, actual body-lotion records and comparison.
- **Exclude:** Unrelated face creams or baby products presented as interchangeable adult body lotions; duplicate K08/K09 articles.

### G05 — Face Wash for Sensitive Skin: What to Compare

- **Answer:** Help evaluate verified cleanser attributes with clear limits on individual suitability.
- **Suggested H2s:** Selection factors; researched options; ingredient/fragrance information; verified Cetaphil options where included; comparison; FAQs and sources.
- **H3 coverage:** Distinguish actual formulations rather than treating a brand as one product.
- **Semantic coverage:** Cleanser, product format, fragrance statements, ingredient list and use directions from reliable sources.
- **Links:** Skincare hub, verified product records and How We Select.
- **Exclude:** A placeholder Cetaphil product, a blanket safety promise or expert endorsement without attributable support.

### G06 — Beard Oil Benefits, Uses and Limitations

- **Answer:** Explain the purpose of beard oil, evidence limits and the distinction between conditioning claims and growth promises.
- **Suggested H2s:** What beard oil does; benefits and evidence; limitations and ingredient cautions; use information; oil versus balm; FAQs and sources.
- **Semantic coverage:** Conditioning, facial hair, carrier/essential oils, fragrance, balm and grooming routine. These are editorial coverage topics, not newly measured keywords.
- **Links:** Beard & Men's Grooming hub and relevant product records after the explanation.
- **Exclude:** Guaranteed beard growth or a second oil-versus-balm article before a distinct need has been established.

### G07 — Trimmers Under ₹1,500: Compare Features and Prices

- **Answer:** Compare verified tool specifications and eligible variants for the stated budget.
- **Suggested H2s:** Budget and selection rules; comparison; settings and attachments; runtime/charging; cleaning and warranty; FAQs and sources.
- **H3 coverage:** Individual models and material trade-offs rather than repeated “best trimmer” headings.
- **Semantic coverage:** Length settings, runtime, charging time, cleaning restrictions, attachments and warranty terms.
- **Links:** Grooming Tools hub, specific model records and up-to-three same-type comparison.
- **Exclude:** Fictional hands-on tests, an above-budget item without explicit alternative labelling, or a second K14/L09 page answering the same task.

## 7. Taxonomy, product ownership and growth

### Classification model

| Classification | Purpose | Public URL policy |
|---|---|---|
| **Grooming category** | Six shared areas connecting guides and products. Assign one primary category for consistent breadcrumbs; additional relevant associations can create links. | The six C01–C06 hubs are the only initial category landing pages. |
| **Product type** | Compare like with like: e.g. face cleanser, sunscreen, shampoo, conditioner, body lotion, perfume, beard oil, balm and trimmer, where catalog coverage exists. | Structured field/filter initially; no automatic indexable archive. |
| **Brand and product identity** | Record actual brand, formulation/model, format and variant information. | Specific product-family page. No thin brand archive at launch. |
| **Preference / attribute** | Verified texture, format, scent family, relevant specifications and product label attributes. | Filters/comparison fields, not hundreds of automatic landing pages. |
| **Budget** | Price-led discovery using checked INR values. | Runtime filter; G03/G07 own the researched budget-guide topics. No duplicate budget collection with the same brief. |
| **Editorial relationship** | Related guides and products referenced in an article. | Explicit contextual links; tagging alone does not establish a useful article cluster. |

### Product pages and variants

- Use `/products/{brand-product-or-model-slug}/` for one real product family. A different formulation or model normally needs a distinct record and meaningful content, not an invented suffix.
- Multiple pack sizes of the same formulation can share that family page. Keep individual variant identifiers, size/unit, source, checked price/date and selected size explicit. A shareable size state may use `?size={verified-size-slug}`, with canonical pointing to the clean family page; it is not a new keyword owner.
- Compare the chosen variants explicitly. Do not silently compare a trial pack's price with a full-size alternative or convert grams into millilitres without valid data.
- Product-specific target language is **brand + actual formulation/model**, with relevant size/format support. This can coexist with generic selection guides because the visitor task differs.
- Products can appear in more than one appropriate context while retaining one URL. Do not create separate product pages under every category, guide, retailer or gender.
- All product names, final slugs and source checks depend on actual catalog research. The route pattern covers the complete planned 36–60-product catalog; this document does not fabricate that inventory.

The existing seven guides cover all six categories. The Source of Truth requires at least six substantial guides initially; seven is a recommended launch set, with K05–K07 still conditional SEO priorities. The eventual 18–24 guides should grow only when a distinct task and useful evidence justify a new owner. The guide count is not a reason to split current variants.

**Candidate future tasks, unmeasured and uncommitted:** interpreting sunscreen labels, understanding fragrance formats, cleaning a trimmer or reading product-price/pack-size information. Research each task and check overlap before reserving a final slug. Keep a short explanation in existing articles until a standalone guide has enough distinct value.

## 8. Cannibalization controls and overlap decisions

| Potential collision | Required architecture decision |
|---|---|
| K01/K10/K11/L01/L10 shampoo variants | One G01 guide. Wording changes do not justify duplicate articles. |
| Shampoo-and-conditioner variant L02 | Substantial supporting section within G01 initially. Split only after evidence shows a distinct pairing task and both briefs remain useful. |
| K02/K13/L05 and SPF 50 L06 | One G02 owner, with specification coverage inside it. |
| Generic/men's/women's perfume budget phrases | One G03 owner initially. Sections and useful filters can serve different preferences without copied lists. |
| K04/K08/K09/L03 body-lotion wording | One G04 guide, distinct from the broad Bodycare hub. |
| K05/K12/L04 and branded K15 | G05 owns the present keyword assignment; specific researched product identities may later receive separate, narrowly defined targets. |
| Beard-oil benefits versus oil/balm comparison | G06 owns benefits; oil/balm explanation remains supporting coverage initially. |
| K07/K14/L09 trimmer variants | One G07 guide, distinct from broad tools browsing and specific model pages. |
| Category hub versus selection guide | Hub orients/browses the category and links to the answer. Guide answers the exact need. Do not copy the same shortlist/article into both. |
| Guide versus Explore filter | Guide supplies durable research and explanation; the filter supplies a functional view of the catalog. Filter state is noindex. |
| About versus How We Select | About owns identity; How We Select owns method. Use summaries and links. |
| Contact versus Corrections | General communication versus structured factual correction. They may share backend infrastructure while retaining distinct content and user tasks. |
| WordPress tag/author/date archives versus Guides index | Do not expose redundant indexable archives that repeat the same single-author guide list. Use the approved Guides index and category hubs. |

### Before adding or changing an article

1. Search the ownership register for the exact phrase, related wording and underlying task.
2. Review the proposed article against the existing owner's audience, intent, product set and answer.
3. If it answers the same task, improve the owner and add a section/anchor instead of a new page.
4. If the task is materially different, research its SERPs, write a distinct brief and record one new owner and links to the related guide.
5. For a genuine published-content consolidation, preserve useful material, select the justified destination, use a permanent redirect where appropriate, and update internal links/sitemaps. Do not delete or redirect useful pages merely because they share a keyword.

Canonical tags address duplicate or substantially equivalent URLs; they do not repair unrelated articles competing through weak briefs. Noindex is reserved here for utility, policy and redundant-view handling, not as a blanket way to suppress useful editorial pages. [Google canonical guidance](https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls), [Ahrefs cannibalization analysis](https://ahrefs.com/blog/keyword-cannibalization/).

## 9. Internal links and breadcrumb architecture

| Source | Required destinations | Example useful anchor |
|---|---|---|
| Home | Six hubs, Explore, selected guides, Finder, About/How We Select | “Explore haircare”; “Choose a shampoo for dry, frizzy hair” |
| Category hub | Every published relevant guide and product, directly or through crawlable pagination; related catalog filter as a user action | “Compare body lotions for dry skin” |
| Guides index | All published guides through real links and pagination | The article's descriptive title |
| Guide | Owning category, actual recommended products, method and any useful related explanation | Actual product/formulation name; “How we select products” |
| Product | Primary category, relevant selection guide, relevant same-type alternatives, retailer destination | “Read the trimmer buying guide”; actual alternative model |
| Trust pages | Relevant methodology, disclosures and support routes | “Report a factual correction” |
| Footer | Full support/policy navigation and human sitemap | Plain page labels |

**Breadcrumb examples:**

- Category: Home → Categories → Haircare.
- Guide: Home → Guides → Shampoo for Dry, Frizzy Hair. The guide separately links its Haircare hub.
- Product: Home → Categories → its primary category → actual product name. This is a logical trail even though the URL is `/products/…/`.
- Support: Home → About Glowwise, or Home → How We Select.

Use matching visible breadcrumbs and structured-data trails when implemented. Standard navigation uses real `<a href>` links. JavaScript can enhance the experience but must not be the only way to discover core content.

**Depth goal:** Feature the seven initial guides from Home or their hubs and make initial products reachable through category browsing. As inventory grows, every published item must remain reachable through clean archive pagination; do not promise that every future product will always be exactly two clicks from Home.

## 10. Indexing, parameters, pagination and duplicate URLs

### Planned policy matrix

| URL family / state | Indexing and canonical policy | Sitemap / linking |
|---|---|---|
| Complete Home, category indexes/hubs, Explore, Guides index, published guides/products and indexable trust pages | Index-eligible; one absolute self-canonical using the selected HTTPS origin. | Include eligible canonical content in XML sitemap; link through normal navigation. |
| Finder, Compare, Saved; utility state URLs | `noindex`; normalize equivalent state ordering. Never imply a personal shortlist is public editorial content. | Exclude XML; keep tools usable from UI. |
| Internal search and arbitrary filters/sorts | `noindex` on the rendered response; normalized self-canonical if a canonical is emitted. Do not signal that a materially different subset is the same content as the unfiltered catalog. | Exclude XML; use form/button controls rather than generating exhaustive crawlable combinations. |
| Pack-size variants of the same product family | Canonical to clean family page; do not create separate article/keyword owners per size. Verify equivalent family content before applying this rule. | Link primary family URLs; retain a size state where useful to visitors. |
| Tracking parameters with unchanged content | Canonical to the same clean content URL; retain any intended attribution behavior. | No tracking parameters in ordinary internal links/XML. |
| Unfiltered archive page 2 onward | Unique `/page/{n}/` URL, index-eligible and self-canonical; never canonical every page to page 1. | Sequential ordinary links and a link to archive start; no need to list every archive page in XML. |
| Privacy, Terms, Cookies/Storage, human Sitemap | Public `noindex`; no competing editorial target. | Exclude XML; retain useful footer links. |
| Unpublished, empty or unverified content | Keep draft/private; do not launch placeholder indexable hubs/products/articles. | Absent from public navigation/XML until useful and ready. |
| Missing product/article or invalid archive page | Actual 404, helpful recovery links; no homepage redirect. | Remove stale internal/XML references or redirect only when a genuinely relevant replacement exists. |
| Internal administrative/API endpoints | Authentication/permissions where appropriate; public APIs expose published information only and are not SEO landing pages. | Exclude XML. Noindex is not security for private records. |

**Faceted-navigation trade-off:** Google warns that filter combinations can waste crawling resources. For the initial small catalog, the recommended baseline is a constrained parameter vocabulary, no exhaustive filter links and crawlable noindex responses. This limits index clutter while letting crawlers see the directive; noindex itself does not save crawl requests. If logs later show a crawl trap, evaluate targeted robots.txt controls after accounting for already indexed URLs. Do not block a URL and simultaneously rely on Google fetching its noindex tag. [Google facets guidance](https://developers.google.com/crawling/docs/faceted-navigation), [Google noindex guidance](https://developers.google.com/search/docs/crawling-indexing/block-indexing).

### Parameter contract

Illustrative valid states, using proposed controlled field names:

```text
/explore/?category=haircare&type=shampoo&max-price=500
/explore/?q=shampoo
/explore/?category=fragrance&sort=price-asc
/products/{verified-product-slug}/?size={verified-size-slug}
/compare/?ids={published-id-1},{published-id-2}
/guides/page/2/
/explore/page/2/
```

- Validate values against actual published records/allowed options; remove empty/default parameters and consistently order equivalent states.
- A global search control should route visitors to the single Explore search experience rather than creating a second indexable site-search section. If native `?s=` remains reachable, exclude that internal-search output from indexing as well.
- Do not expose private contact text, identifiers, sessions or account information in public query strings.
- Valid internal searches/finder preferences with no match show an honest no-results state and reset actions. Missing content URLs, invalid values and out-of-range archive pagination must not masquerade as successful content pages. Decide response handling explicitly during implementation.
- Budget and attribute combinations do not automatically create `/categories/.../under-500/` or similar indexable paths. A future curated landing page requires its own distinct brief and ownership review.
- Clean archive pagination contains different items and keeps its own canonical. Filtered pagination remains part of the noindex filter state. [Google pagination guidance](https://developers.google.com/search/docs/specialty/ecommerce/pagination-and-incremental-page-loading).

## 11. WordPress implementation fit and later measurement

### Content model and routing responsibilities

| Component | Planned responsibility |
|---|---|
| Native WordPress Pages | Home, category chooser, trust/support/policies and tool shells. |
| Native WordPress Posts | Editorial guides, with `/guides/{postname}/` permalinks and `/guides/` as the one editorial index. |
| Product custom post type | Verified product families under `/products/{slug}/`; its catalog archive uses `/explore/`. Do not also create a competing static Explore page at that route. |
| Shared grooming-category taxonomy | The six category associations on guides/products, rendered as the approved `/categories/{slug}/` hub templates. |
| Product fields / controlled classifications | Product type, brand, variants, checked INR prices/dates/sources and verified attributes. Avoid automatic public archives for every attribute. |
| Glowwise core plugin | Durable data types, taxonomy, matching/comparison support and protected contact processing. |
| Custom theme | Templates, navigation, responsive display, breadcrumb presentation and progressive interaction. |
| Yoast SEO Free | Planned metadata/canonical/XML support, coordinated with custom routes and noindex policy; actual output requires implementation verification. |

Register each route once. Reserve `/categories/` for the chooser and `/categories/{slug}/` for approved taxonomy terms. Native category/tag/date/author archives must not silently become additional indexable copies of the same guide lists. Keep the single Glowwise Editorial identity and its methodology information without publishing a thin duplicate author archive.

WordPress supports custom post-type rewrite/archive settings and shared taxonomies; the table above is the proposed Glowwise configuration, not a claim it has been installed. [WordPress post-type reference](https://developer.wordpress.org/reference/functions/register_post_type/), [taxonomy reference](https://developer.wordpress.org/reference/functions/register_taxonomy/).

### Search Console review once there is a verified live property

GSC Wizard is relevant to later query/page and cannibalization review. Discovery confirmed the installed plugin, but no callable GSC Wizard tools were exposed in this session. No Glowwise property or live performance dataset was supplied or queried. Ahrefs' GSC keyword documentation was reviewed; that route also requires an actual connected project/portfolio. None of this supplies present rankings for an unlaunched site.

After deployment and enough real observations:

1. Filter Search Console to Web search, the appropriate country and a recorded date range; inspect mobile and desktop separately as needed.
2. Select a relevant query or tightly defined cluster, then inspect its Pages to see which canonical URLs receive impressions/clicks.
3. Compare the observed landing pages with the ownership register; inspect the actual pages and query intent before treating overlap as a problem.
4. Review changes over time and overall usefulness. Two URLs receiving impressions is a review signal, not proof of harm. Missing/anonymised queries and aggregation limits also constrain conclusions.
5. Record any justified consolidation, brief change or new owner in the map. Verify indexing/canonical output separately; do not confuse provider estimates with GSC observations.

[Google Search Console performance documentation](https://support.google.com/webmasters/answer/7576553?hl=en) describes the query, page, country, device and date dimensions used for this review.

## 12. Decisions carried forward and completion boundary

### Defined in this planning deliverable

- One public Guides section; seven researched guide owners.
- All 25 K/L records mapped, with duplicate wording retained transparently.
- Six category hubs, complete support/footer destinations and functional-tool routes.
- Stable product-family paths and explicit treatment of size variants.
- Controlled filter/search states, clean pagination and separate canonical/noindex responsibilities.
- Deliberate internal links and useful breadcrumbs across mobile and desktop.

### Remaining implementation and evidence

The actual domain, verified product inventory, final product slugs, article writing, responsive templates, forms, SEO output and XML/robots configuration still need implementation. Later growth topics need keyword/SERP validation. Planned architecture reduces avoidable overlap; it does not prove the deployed site is cannibalization-free or that rankings are achieved.

This completes the **mapping and architectural design work for this two-mark criterion**. The separate SEO implementation-roadmap criterion should build on these dependencies. It should not reopen routes or keyword ownership casually, or claim that a planned page is already published.

## 13. References and supporting evidence

- [Supplied Mini-Project Handbook](<../../Reference/Mini-Project Handbook.docx>) — exact criterion, required page types and marking expectations.
- [Agreed Source of Truth](../../GLOWWISE_SOURCE_OF_TRUTH.md) — product scope, all six categories, real functionality, mobile/desktop parity, footer and WordPress foundation.
- [Criterion 2](02_Keyword_Research_LSI_and_Search_Intent_Mapping.md) — original K/L terms, dated provider metrics, intent and evidence.
- [Criterion 3](03_Competitor_Analysis_and_SERP_Breakdown.md) — seven live-query observations, competing page formats and bounded opportunities.
- [Evidence Index](<../References/Milestone 1/04 Keyword Page Content Mapping/Evidence_Index.md>) — source-to-decision register, plugin outcomes and saved ownership data.

External methodology references are linked beside the relevant decisions. The hierarchy, ownership register and content briefs are original Glowwise planning artifacts; no live-site screenshot, indexing result or provider-generated keyword-clustering export is fabricated.
