# Glowwise Milestone I Submission Report

**Course:** CSET489 SEO Mini Project  
**Project team:** Aakash Kumar and Disa Bandhu · Imagine Utopia  
**Website:** [glowwise.tech](https://glowwise.tech/) · **Repository:** [aakash-kr-7/glowwise](https://github.com/aakash-kr-7/glowwise)  
**Updated:** 10 October 2026 · **Release:** c55b1bd · **Course submission details:** to be finalised

## Our project

We built Glowwise to make a familiar buying decision easier: choosing a grooming product that suits a need and a budget without opening a long chain of unrelated tabs. Our audience is Indian young adults who want clear explanations, comparable product facts and a practical route to a retailer.

The live website combines researched editorial guides with a working catalog. Readers can browse six categories, filter products, use a rules-based finder, compare compatible choices and save a shortlist in their browser. Product pages keep the exact pack or model, a dated INR price, source links and the purchase destination together. The same information and tools are available on mobile and desktop.

The current release contains **40 researched product families, 55 variants, seven substantial guides, six category hubs and 16 WordPress Pages**. Every product family has a photograph; **54 of 55 exact variants** are pictured. Aakash Kumar and Disa Bandhu are credited on the guides according to their category assignments. The published repository revision is `c55b1bdd181d30eaaa1dfae73e8494eef1b5d4d6`; its tested application source is `d5acbac678dab1e1790aa6632092d055ac19d7d4`.

This report follows the ten Milestone I criteria. We explain the research decisions first, then how they shape the pages and SEO plan, and finally how the product is hosted and verified. Original keyword and competitor figures keep their source periods. Product, browser, DNS and SSH checks keep their execution dates. The evidence demonstrates preparation and implementation; attendance and actual submission still need their own records.

### Reading this report

The criterion table below is the assessment map. Each section includes the evidence needed to understand the decision and links to its full supporting document. The accompanying References folders contain the original screenshots, matrices and logs. Local links require the supplied folder structure; the website and repository links are public.

| Criterion | Marks | Dedicated deliverable |
|---|---:|---|
|1 · Niche audience and SEO problem|2|[Niche audience and SEO problem](01_Niche_Target_Audience_and_SEO_Problem_Identification.md)|
|2 · Keyword research and search intent|2|[Keyword research and search intent](02_Keyword_Research_LSI_and_Search_Intent_Mapping.md)|
|3 · SERP analysis|2|[SERP analysis](03A_SERP_and_Ranking_Analysis.md)|
|4 · Competitor analysis|2|[Competitor analysis](03B_Competitor_Analysis_and_Content_Gap.md)|
|5 · Keyword to page mapping|2|[Keyword to page mapping](04_Keyword_to_Page_and_Content_Mapping.md)|
|6 · SEO strategy and roadmap|2|[SEO strategy and roadmap](06_SEO_Strategy_and_Roadmap.md)|
|7 · Domain DNS and Cloudflare|2|[Domain DNS and Cloudflare](07_Domain_DNS_and_Cloudflare_Configuration.md)|
|8 · VPS and WordPress|2|[VPS and WordPress](08_VPS_Deployment_and_Functional_WordPress_Setup.md)|
|9 · Evidence and submission quality|2|[Evidence and submission quality](09_Documentation_Proof_and_Evidence_Quality.md)|
|10 · Live demonstration and timeliness|2|[Live demonstration and timeliness](10_Live_Demonstration_and_Submission_Readiness.md)|

## The product in practice

The fragrance catalog shows the approach clearly: a visible product photograph, exact 20 ml pack, recorded price, short selection reason and source attribution appear together. A visitor can compare choices without mistaking a different bottle size for the quoted offer. Guides explain the reasoning behind a shortlist; they do not present manufacturer claims as our own laboratory findings.

![Live desktop fragrance catalog with pack-specific products and visible source credits; original capture from 10 October 2026](<../References/Deployment/Demo_Media/after-fragrance-desktop.png>)

On mobile, the guide keeps its full title, founder byline, research date and method link. Product pages retain the photograph, pack and rights credit. The release browser checks cover all seven articles at 390 × 844, along with photographed comparison and saved-product persistence/removal. These are recorded viewport observations, not a claim that every physical device has been tested.

![Mobile shampoo guide with Aakash Kumar's byline and desk-research disclosure; original 10 October capture](<../References/Deployment/Demo_Media/after-guide-mobile.png>)

![Mobile SKINN Celeste product page with actual photograph and visible demo-use attribution; original 10 October capture](<../References/Deployment/Demo_Media/after-product-mobile.png>)

### The seven published guides

| Guide | Editorial credit | Recorded article words | Shortlist and reader value |
|---|---|---:|---|
| Dry, frizzy hair shampoo | Aakash Kumar | 2,047 | Six formulas compared by wash-day need and exact pack. |
| Sunscreen for oily skin | Disa Bandhu | 2,008 | Six choices distinguished by finish, pack and budget. |
| Perfumes under ₹1,000 | Disa Bandhu | 2,023 | Six SKINN 20 ml scents; clear differences and a labelled watchlist. |
| Body lotion for dry skin | Disa Bandhu | 1,958 | Six choices from fragrance-free to scented. |
| Face wash for sensitive skin | Disa Bandhu | 1,527 | Two starting points and two conditional alternatives; no forced six-product ranking. |
| Beard-oil benefits | Aakash Kumar | 1,996 | Conditioning explained with limits and six comparison options. |
| Trimmers under ₹1,500 | Aakash Kumar | 1,980 | Six Vega models; three current purchase options and three watchlisted. |

Counts come from the saved 10 October mobile article observations, not a suggested SEO word-count target. The guides use manufacturer/retailer sources and explain their selection method. Founder credit identifies editorial responsibility; the site's method note also discloses AI-assisted drafting.

### What the release checks establish

| Check set | Passing checks | What was examined |
|---|---:|---|
| Media and byline acceptance | 80 | Published photo coverage and delivery, exact variant metadata, founder credits/schema, recommendations, canonical URLs, rights wording and UTF-8. |
| Product and editorial consistency | 197 | Product IDs, variants, recorded prices, sources, article bodies and canonical relationships. |
| Native media and security integration | 9 | Exact-pack associations, responsive metadata/credit, rejected unsafe or incorrect inputs, permissions and idempotent imports. |
| Total across those three sets | 286 | Their stated scopes; browser observations and backup checks are separate evidence. |

The latest full Updraft backup was integrity-checked and its database restored in isolation, retaining 40 products, seven guides, 16 Pages and the live indexing decision. Custom source and generated assets were compared with the deployed release, and a restricted off-VM copy was checksum-verified. This is private recovery evidence; the required sanitized submission backup is a separate deliverable.

Photographs improve the demonstration, but attribution does not grant reuse rights. The 53 added brand images carry source credits and disclosed demo-use status; no independently verified reuse permission is claimed. The existing Plum Rice Water SPF 50 **50 g outer-carton** photograph retains its recorded CC BY-SA 3.0 licence. The **Minimalist Maleic Shampoo 100 ml** image remains unavailable; its 250 ml photo is not substituted. The website also discloses AI-assisted drafting and published-source research. We have not purchased or personally tested the products.

[Current release and evidence](../Implementation/DEMO_MEDIA_RELEASE.md) · [Current public readback](<../References/Milestone 1/00 Full Review/Release_Update/Public_Readback.json>) · [Photo coverage](../Implementation/exports/demo-image-coverage.json).

## 1 Niche audience and SEO problem

### Data supported justification

Glowwise focuses on affordable grooming product discovery for Indian adults aged approximately 18–30 across genders. Its niche combines practical buying guidance with budget and midrange product comparisons. Bain and Flipkart’s 2026 report estimates that Gen Z accounts for 40–45% of India’s e-retail shoppers, providing context for a young audience focus. NIQ’s 2025 Indian beauty overview highlights ingredient transparency, digital discovery and price clarity, supporting understandable, sourced recommendations. The SEO problem is connecting specific need-and-budget searches with useful pages that explain suitability, limitations and checked prices. Glowwise combines original guides, a filterable catalog, consistent comparisons and saved shortlists, with complete mobile and desktop support. This gives visitors a practical route from research to retailer selection. Our initial long-tail research connects informational and commercial intent with clear page owners; demand estimates and difficulty are documented with their original evidence.

The original 138-word justification remains in the 8 October niche-selection record. This summary reflects the deployed release; keyword and implementation sections explain how we followed through. [Bain/Flipkart 2026](https://www.bain.com/insights/how-india-shops-online-2026/) provides general e-retail context; [NIQ 2025](https://nielseniq.com/global/en/insights/report/2025/the-new-face-of-indian-beauty/) is a public overview, not a reviewed full dataset. The exact 18–30 age range is the approved product decision.

### Audience and problem

The primary audience is Indian English-reading adults approximately 18–30 across genders, especially routine learners/value-conscious buyers. Proposed personas are the 18–22 first-routine learner, 21–27 comparator and 23–30 practical tool buyer; these are design hypotheses rather than interviewed participants. Typical tasks are understanding a routine, comparing need/budget choices and selecting exact tool specifications.

The SEO problem is connecting specific purchase questions with discoverable pages that explain suitability, limits and checked prices. On 8 October a Nykaa under ₹500 category price table displayed an entry at ₹599: one captured mismatch, not a sitewide diagnosis. Existing searches also contain retailer, brand, forum, video and AI formats. Glowwise's opportunity is consistent variant/budget evidence plus useful comparison, rather than claiming the niche has no competition. All six categories share that decision framework.

Full criterion: [Niche audience and SEO problem](01_Niche_Target_Audience_and_SEO_Problem_Identification.md).

## 2 Keyword research and search intent

Semrush India/English estimates captured 8 October 2026 form the comparable baseline. The original set has 15 focus/secondary K and 10 related L records, 21 distinct exact phrases. The matrix below adds the 10 October working intent/owner status without changing estimates. K15 is held because no verified Cetaphil product exists in the release; 14 K records remain active, within the handbook's 10–15 target. L duplicates preserve provenance rather than inflate distinct demand.

|ID|Exact query|Volume|KD|Intent|Owner|
|---|---|---:|---:|---|---|
|K01|shampoo for dry and frizzy hair|6600|18|Commercial + informational|G01|
|K02|which is the best sunscreen for oily skin|1600|18|Commercial investigation|G02|
|K03|perfume under 1000|1300|19|Commercial + informational|G03|
|K04|which body lotion is good for dry skin|140|13|Commercial investigation|G04|
|K05|which face wash is best for sensitive skin|390|20|Commercial investigation|G05|
|K06|beard oil benefits|590|24|Informational|G06|
|K07|best trimmer under 1500|720|29|Commercial investigation|G07|
|K08|body lotion for dry skin|18100|28|Commercial investigation|G04|
|K09|best body lotion for dry skin|6600|23|Commercial investigation|G04|
|K10|which shampoo is best for dry and frizzy hair|1300|13|Commercial investigation|G01|
|K11|best shampoo for dry and frizzy hair|12100|30|Commercial investigation|G01|
|K12|face wash for sensitive skin|5400|32|Commercial investigation|G05|
|K13|best sunscreen for oily skin|60500|22|Commercial investigation|G02|
|K14|trimmer under 1500|260|30|Commercial investigation|G07|
|K15|cetaphil face wash for sensitive skin|1000|33|Commercial + transactional|Hold|
|L01|which shampoo is best for dry and frizzy hair|1300|13|Commercial investigation|G01|
|L02|best shampoo and conditioner for dry frizzy hair|1000|29|Commercial + informational|G01|
|L03|which body lotion is good for dry skin|140|13|Commercial investigation|G04|
|L04|which face wash is best for sensitive skin|390|20|Commercial investigation|G05|
|L05|which is the best sunscreen for oily skin|1600|18|Commercial investigation|G02|
|L06|best sunscreen for oily skin spf 50|2900|26|Commercial investigation|G02|
|L07|best perfume for women under 1000|720|7|Commercial investigation|G03|
|L08|best perfume for men under 1000|3600|17|Commercial investigation|G03|
|L09|best trimmer for men under 1500|320|23|Commercial investigation|G07|
|L10|which shampoo is best for frizzy and dry hair|170|19|Commercial + informational|G01|

The four initial focus candidates K01–K04 meet preferred KD below 20. K05/K06/K07 at 20/24/29 are explicitly conditional; low volume is not proof of easy ranking. L relevance uses category fit 0–2 + decision usefulness 0–2 + explicit budget/extra specification 0–1; L01–L05/L10 score 4 and L06–L09 score 5. Related vocabulary supports natural coverage of cleansing, SPF, texture, scent family, pack size, runtime/cleaning; “LSI” is the rubric's informal semantic label, not a Google metric.

K01's provider informational label is retained in the original research; the observed shopping/guidance mix supports Glowwise's commercial/informational working response. K06 is informational; K15 has commercial/transactional intent but no active landing page commitment. Transactional actions are external retailer handoffs, not on-site checkout. Navigational “Glowwise finder” is an unmeasured future branded example.

Cross-provider values are kept separate: “perfume under 1000” Semrush 1300/KD19 versus Ubersuggest 2400/SD21 and Keyword Tool 4400; different methods/freshness explain why figures are not averaged. Advertiser competition is not organic KD. No fabricated Ahrefs metrics, fresh ranking measurements or summed traffic forecast is included.

![Semrush India shampoo overview captured 8 October 2026](<../References/Milestone 1/02 Keyword Research Intent Mapping/01-semrush-shampoo-overview.jpg>)

Full criterion: [Keyword research and search intent](02_Keyword_Research_LSI_and_Search_Intent_Mapping.md). [Current 25-row matrix](<../References/Milestone 1/00 Full Review/Current_Keyword_Intent_Ownership.csv>).

## 3 SERP and ranking analysis

Seven exact focus queries were inspected 8 October with `hl=en&gl=in`. All 53 standalone headings/URLs are preserved in the standalone criterion and [live SERP register](<../References/Milestone 1/03 Competitor Analysis SERP Breakdown/live-serp-register.json>). Observed order excludes sponsored/AI/carousel cards; standalone videos are labelled. It is not a national rank tracking dataset.

| ID and exact query | Observed intent and result mix | Features positively observed | Consequence for Glowwise |
|---|---|---|---|
| **K01 — shampoo for dry and frizzy hair** | Commercial investigation with explanatory support; retailer search pages, forum discussion, a guide and brand collections. | Product modules, short videos, videos, PAA. AI Overview also appears in the separate September provider snapshot. | Build a selection guide connected to relevant products, with hair/scalp context and comparison. A purely explanatory essay would cover only part of the task. |
| **K02 — which is the best sunscreen for oily skin** | Selection intent; community discussion, shopping results, Indian brand pages and an international editorial guide. | AI Overview, products, videos, images, PAA. | Give an immediate selection framework, then explain differences using verified labels and product sources. Indian availability and price context matter. |
| **K03 — perfume under 1000** | Budget-led investigation and shopping; retailer/brand collections, a discussion, an editorial list and video. | AI Overview, sponsored modules, videos, popular products, deals and local shopping modules. PAA was not observed in the inspected results. | Put genuinely eligible variants first. Explain bottle size, scent family and format; offer filtering and comparison. |
| **K04 — which body lotion is good for dry skin** | Product selection with educational support; brand collections, articles, a retailer collection and a health publisher. | AI Overview, PAA, videos, popular products and local shopping modules. | Combine a quick shortlist with differences in texture, product attributes and cost. Link to sources for factual claims. |
| **K05 — which face wash is best for sensitive skin** | Selection intent; Amazon, a forum, editorial recommendations, brand guidance and Smytten. | PAA, videos and product/local shopping modules. AI Overview status was not established in the saved observation. | Retain as conditional: established publishers and brands occupy results. Avoid an unsupported dermatologist endorsement. |
| **K06 — beard oil benefits** | Primarily informational; brand explainers, a health publisher, community discussion and Smytten. | PAA, videos and images; a result also exposed topical section links. AI Overview status was not established. | Lead with an evidence-based explanation of purpose and limitations. Product discovery should support the answer rather than interrupt it. |
| **K07 — best trimmer under 1500** | Budget-led shopping and comparison; forum, retailer collections, brand catalog, video and specification/price sites. | Videos, PAA, product modules, deals, local shopping and a sponsored result. AI Overview status was not established. | A working specification comparison is essential. Editorial text alone faces strong shopping and demonstration formats. |

### Leading observed URLs

The first three standalone results for each query are shown below; the full 53-heading record is preserved in the standalone analysis. Orders describe one captured desktop context, not stable nationwide ranks.

|Query|Observed order|URL and result format|
|---|---:|---|
|K01|1|[amazon.in — retailer search/collection](https://www.amazon.in/shampoo-for-dry-and-frizzy-hair/s?k=shampoo+for+dry+and+frizzy+hair)|
|K01|2|[reddit.com — community discussion](https://www.reddit.com/r/IndianSkincareAddicts/comments/15ug2uu/dry_damaged_frizzy_hair_looking_for_shampoos_and/)|
|K01|3|[smytten.com — article / editorial guidance](https://smytten.com/blogs/haircare/which-shampoo-for-dry-frizzy-hair-your-top-questions-answered?srsltid=AU7gw4WIKJh8U8eBMtBk5iv3QL_a9KA75yy45-K49V7oATG6RyeFG6Pe)|
|K02|1|[reddit.com — community discussion](https://www.reddit.com/r/IndianSkincareAddicts/comments/1sv4iij/oily_skin_sunscreen_shortlist_which_one_should_i/)|
|K02|2|[amazon.in — retailer search/collection](https://www.amazon.in/s?k=top+10+best+sunscreen+for+oily+skin)|
|K02|3|[deyga.in — article / editorial guidance](https://deyga.in/blogs/news/top-10-sunscreen-for-oily-skin-in-india?srsltid=AU7gw4VgsgTMNxzn1Yo1NnmQQjyFUIK4mmEIctSxT-7_WtHLoUoe1sDG)|
|K03|1|[reddit.com — community discussion](https://www.reddit.com/r/DesiFragranceAddicts/comments/16x4x49/suggest_some_perfumesmen_under_1000rs/)|
|K03|2|[amazon.in — retailer search/collection](https://www.amazon.in/Perfume-Under-%E2%82%B91-000-Fragrance/s?rh=n%3A1374302031%2Cp_36%3A1318503031)|
|K03|3|[in.ajmal.com — product collection](https://in.ajmal.com/collections/under-999?srsltid=AU7gw4V9TZ5mc9uaG2rDVHQkcYAh6caFnM553tmVCj4AuLnc75zmBHiM)|
|K04|1|[reddit.com — community discussion](https://www.reddit.com/r/IndianSkincareAddicts/comments/hsuve7/suggestions_for_all_over_body_lotion_for_dry_skin/)|
|K04|2|[thebodyshop.in — product collection](https://www.thebodyshop.in/body/body-lotions/c/c00022?srsltid=AU7gw4X89UW0iuS-Ike-D1k2nF4fP_PqDWdnLTHxf-2BSKG50x2Z4Huf)|
|K04|3|[yutikanatural.com — article / editorial guidance](https://www.yutikanatural.com/best-body-lotion-in-india-for-dry-oily-sensitive-skin/)|
|K05|1|[amazon.in — retailer search/collection](https://www.amazon.in/facewash-for-dry-and-sensitive-skin/s?k=facewash+for+dry+and+sensitive+skin)|
|K05|2|[reddit.com — community discussion](https://www.reddit.com/r/IndianBeautyTalks/comments/1sl8zt4/which_facewash_to_choose_as_a_gentle_one/)|
|K05|3|[allure.com — article / editorial guidance](https://www.allure.com/gallery/best-face-wash-for-sensitive-skin)|
|K06|1|[gillette.co.in — article / editorial guidance](https://www.gillette.co.in/en-in/tips-for-shaving/skin-care/beard-oil-uses-and-side-effects)|
|K06|2|[healthline.com — article / editorial guidance](https://www.healthline.com/health/does-beard-oil-work-2)|
|K06|3|[reddit.com — community discussion](https://www.reddit.com/r/beards/comments/12puswc/why_should_i_use_beard_oil/)|
|K07|1|[reddit.com — community discussion](https://www.reddit.com/r/GadgetsIndia/comments/1k5vi5j/which_is_the_best_beard_trimmer_in_india_under/)|
|K07|2|[amazon.in — retailer search/collection](https://www.amazon.in/best-trimmer-under-1500/s?k=best+trimmer+under+1500)|
|K07|3|[myntra.com — product collection](https://www.myntra.com/trimmer-for-men-under-1500)|

No traditional standalone featured snippet was positively identified. AI Overviews and PAA were recorded separately; failure to observe is not universal absence. Captured PAA examples include daily oily-skin sunscreen/best SPF, body lotion brands/top three, sensitive facial wash, daily beard oil/disadvantages and budget trimmers. Perfume PAA was not observed. The appropriate response is helpful sourced answers, not a guarantee of rich feature selection.

![Actual sunscreen People Also Ask captured 8 October 2026](<../References/Milestone 1/03 Competitor Analysis SERP Breakdown/02-google-sunscreen-paa.jpg>)

### Content length and structural evidence

| Sample and search relationship | Measured words and boundary | Structure observed | Practical lesson |
|---|---|---|---|
| **P01 Smytten shampoo guide** — K01 order 3 | **1,358**; title through FAQ, before Trending Products; embedded product cards and review quotations included. | Question-led headings, ingredient discussion, Indian shopping section, product cards and trial-oriented conclusion. | Pair explanations with actionable product choices. FAQs and Indian context are already present. |
| **P02 Nykaa body-lotion collection** — K04 order 5 | **575**; collection heading through first-page pagination; filters and rendered product text included, header/footer excluded. **Not article prose.** | 44 products stated overall; 20 cards in the captured first page; sorting, multiple filters, prices, ratings, size counts and an editorial link. | Collections can satisfy selection intent with relatively little prose. Relevant organization and product utility matter. |
| **P03 Deyga sunscreen article** — K02 order 3 | **1,530**; opening paragraph through FAQ questions, before previous/next links; title excluded. | Summary table, ten numbered products, price/pack-size/texture fields, product-specific explanation, conclusion and FAQ prompts. | Tables and consistent fields are established patterns. Glowwise needs verified sources and comparison depth, rather than claiming the format itself is unique. |
| **P04 Gillette beard-oil article** — K06 order 1 | **721**; rendered article title through conclusion, before product promotion; a rendered-content sample, not a guarantee that every dynamic state is included. | Contents overview, benefits, side effects, numbered subtopics and product promotion. | An informational page can be concise while addressing benefits and limitations. |
| **P05 MensXP perfume guide** — K03 order 6 | **1,015**; title through final FAQ; introductory byline biography and pros/cons text included; topic tags and related stories excluded. | Five product sections, individual pros/cons tables, retailer links, FAQs, named writer and reviewer. | Pros/cons and budget titles already exist. Build a consistent verified variant/price comparison; do not imitate first-person use claims without actual testing. |
| **P06 Nykaa body-lotion editorial guide** — linked from P02, **not independently observed ranking for K04** | **1,407**; standfirst through final FAQ; contents included; title/byline and related stories excluded. | Contents links, ingredient discussion, eight numbered recommendations, FAQs and internal topic links. | Nykaa combines education with shopping. A useful Glowwise gap must be more specific than “add a buying guide.” |

Counts use whitespace-separated tokens in saved bounded rendered text, not whole navigation/footer pages. Collection text is not article prose; the Nykaa editorial sample is linked from a ranking collection and was not independently observed ranking for K04. Patterns support quick answers/contents, consistent comparable fields, product connections, byline/method/dates and credible limits. They do not establish causal ranking factors or an ideal word count. The separate Ubersuggest 10 September cached shampoo result counts feature blocks; it is not merged with October positions.

Full criterion: [SERP analysis](03A_SERP_and_Ranking_Analysis.md).

## 4 Competitor analysis and content gaps

Smytten and Nykaa compete for the same grooming discovery/selection task while operating much larger commerce businesses. Smytten's sampled shampoo guide combines questions/product cards/Indian context/trials. Nykaa combines need collections/filtering/price variants and linked editorial guidance. These strengths are acknowledged before proposing gaps.

### Provider reported top organic keywords

### Smytten

| Keyword | Provider intent | Position | Est. monthly volume | Reported traffic share |
|---|---|---:|---:|---:|
| smytten | C + N | 1 | 201,000 | 33.7% |
| smytten app | N | 1 | 6,600 | 1.1% |
| smytten coupon code | T | 1 | 6,600 | 1.1% |
| mcaffeine | N | 3 | 368,000 | 1.07% |
| chemist at play | C | 7 | 165,000 | 1.03% |

### Nykaa

| Keyword | Provider intent | Position | Est. monthly volume | Reported traffic share |
|---|---|---:|---:|---:|
| nykaa | N | 1 | 1,830,000 | 28.73% |
| nykaa beauty | N | 1 | 40,500 | 0.63% |
| lip balm | I | 1 | 201,000 | 0.51% |
| nykaa lipstick | I + T | 1 | 27,100 | 0.42% |
| foundation | C | 1 | 165,000 | 0.29% |

Both tables are Semrush public reports for August 2026, India organic scope, captured 8 October. Only the five leading displayed rows are claimed; landing URLs were not exposed and the tables are not complete portfolios. Displayed traffic shares are provider estimates. Branded navigation and broad product queries demonstrate incumbent strength, not Glowwise achievability.

### Comparable backlink profiles

| Metric | Smytten | Nykaa |
|---|---:|---:|
| Semrush Authority Score, 1–100 | **46** | **75** |
| Referring domains | **2.37 K** ≈ 2,370 | **15.14 K** ≈ 15,140 |
| Backlinks | **16.22 K** ≈ 16,220 | **1.01M** ≈ 1,010,000 |
| Reported monthly backlink change | +7.77% | +11.76% |
| Reported monthly referring-domain change | +2.73% | +0.77% |

| Competitor | External source and actual destination | Anchor and observed attribute | What it establishes |
|---|---|---|---|
| Smytten | [Google Play app listing](https://play.google.com/store/apps/details?id=com.app.smytten) → `https://smytten.com/` | Website link; no `rel` attribute present on this anchor. A separate privacy-policy link was also observed. | A legitimate product listing provides an external route to the brand. Absence of `rel` does not prove that Google passes ranking credit. |
| Nykaa | [Wikipedia Nykaa article](https://en.wikipedia.org/wiki/Nykaa) → `https://www.nykaa.com/` | `www.nykaa.com`; `rel="mw:ExtLink nofollow"`. A linked investor PDF was also observed. | A brand reference creates an external citation; it must not be counted as a confirmed follow link. |

Root domain backlinks/referringdomains are global rounded August totals. Semrush Authority Score is proprietary and not a Google score. Nykaa's referring domain footprint is approximately 6.4 times Smytten's; this is comparative scale, not a target link quota. Actual Google Play→Smytten homepage anchor had no`rel`; Wikipedia→Nykaa had`nofollow`. Neither proves ranking credit or inclusion in provider totals. Full anchor/follow ratios/page-level profiles were unavailable.

![Smytten August backlink profile captured 8 October](<../References/Milestone 1/03 Competitor Analysis SERP Breakdown/06-semrush-smytten-backlinks.jpg>)

![Nykaa August backlink profile captured 8 October](<../References/Milestone 1/03 Competitor Analysis SERP Breakdown/04-semrush-nykaa-backlinks.jpg>)

### Actionable content opportunities

| Query / area | What already exists | Bounded opportunity for Glowwise | Concrete deliverable and verification |
|---|---|---|---|
| **K01 shampoo** | Smytten offers FAQs, product cards, Indian context and trials; Pilgrim and Kérastase offer concern-based collections. | Make differences between eligible products directly comparable. A common comparison grid and per-product price-check dates were not identified in the sampled Smytten primary guide. | One owner guide linked to product records; consistent size, price/date/source, relevant attributes and limitations. Verify every included variant. |
| **K02 sunscreen** | Deyga already provides a ten-product table, prices, pack sizes and texture discussion; other results include brands and a publisher. | Provide a documented selection method and source links per factual attribute. The sampled Deyga conclusion favours its own product; Glowwise can explain its commercial relationships and selection basis openly. | A sourced shortlist and comparison with checked labels, dates and explicitly unverified fields. No universal suitability or borrowed expert endorsement. |
| **K03 perfume budget** | Ajmal and other sites have price collections; MensXP has a five-product list with pros/cons; Nykaa has fragrance-finder budget taxonomy. | Make the exact purchasable variant and budget eligibility obvious. The sampled MensXP primary guide did not present a shared price/size/check-date table. | An inclusive ₹1,000 guide with scent-family/format/size filters and verified eligible variants. Explain whether offers, samples and delivery charges affect the stated budget. |
| **K04 body lotion** | Nykaa supplies filters, an editorial guide and a separate footer price table dated 8 October 2026. Its collection also displays products beyond adult dry-skin body lotion. | Curate tightly for the stated adult body-care task and put relevant distinctions near the shortlist. **Dated prices are not absent from Nykaa**; Glowwise's improvement is consistent contextual presentation. | One guide with verified adult body-lotion options; distinguish face creams, baby products and body products instead of treating them as interchangeable. Show texture/fragrance fields and comparable unit cost where valid. |
| **K05 sensitive-skin cleanser** | Strong publisher/brand coverage and a Smytten dermatologist-recommended title appear in the observed set. | Answer the selection task using evidence and stated limits rather than adopting an expert-endorsement title. A sitewide missing-topic claim is not established. | Conditional guide with attributed product information, research method and links to appropriate sources. No invented expert review or personal results. |
| **K06 beard oil** | Gillette and Smytten already discuss benefits; Healthline and a community result also appear. | Explain the distinction between cosmetic conditioning, marketing claims and demonstrated outcomes. The useful opportunity is evidence quality and clarity, not “nobody covers benefits.” | A concise sourced explainer, relevant oil-versus-balm context and optional product links. Verify claims before publication. |
| **K07 trimmers** | Retailer catalogs, videos, Pricee and Smartprix already support price/specification discovery. | Provide a manageable comparison tied to the exact ₹1,500 cap, with specification sources and maintenance/warranty context. This is a hypothesis for a better decision flow, not an audited absence at those sites. | Working comparison for up to three products: settings, runtime, charging, cleaning, attachments, warranty and checked price. Label missing specifications and avoid fictional testing. |
| **Across guides** | Competitors already combine commerce and information in several ways. | Apply the same evidence and interaction standard across all six grooming categories, reducing the work required to compare options. | Shared content/product fields, readable mobile comparisons, save/compare controls and clearly labelled retailer destinations. |

The gap study is a manual sampled task comparison, not a complete keyword difference export or proof that an entire domain lacks a topic. Priorities are body lotion/shampoo/perfume first, evidence-intensive sunscreen next, then conditional cleanser/beard oil/trimmer. The current seven guides implement the focused answers and linked product data; ranking impact requires later observations.

Full criterion: [Competitor analysis](03B_Competitor_Analysis_and_Content_Gap.md).

## 5 Keyword to page mapping and architecture

Home introduces the brand and routes visitors to six hubs/Explore/Guides/Finder. Category hubs own broad discovery; guides own specific selection tasks; product pages own exact formula/model details. About owns identity; How We Select owns methodology. These roles prevent copying the same full answer into multiple page families.

|Guide owner|Primary query ID|Published path|
|---|---|---|
|G01|K01|/guides/shampoo-for-dry-frizzy-hair/|
|G02|K02|/guides/sunscreen-for-oily-skin/|
|G03|K03|/guides/perfumes-under-1000/|
|G04|K04|/guides/body-lotion-for-dry-skin/|
|G05|K05|/guides/face-wash-for-sensitive-skin/|
|G06|K06|/guides/beard-oil-benefits/|
|G07|K07|/guides/trimmers-under-1500/|

The full hierarchy includes `/categories/` plus skincare, haircare, bodycare, fragrance, beard-grooming, grooming-tools hubs; `/explore/`; `/products/{slug}/`; `/guides/` and these seven owners; `/finder/`, `/compare/`, `/saved/`; About/How We Select/Contact/Corrections/Disclosures/Accessibility/Privacy/Terms/Cookies and Storage/human sitemap. Primary/secondary/related terms are mapped in the current matrix; homepage/About/hub positioning phrases are unmeasured brand/broad language, not invented keyword metrics.

One product family URL serves its pack variants; relevant size states canonicalise to the family when equivalent. Word order changes do not create new guides. Arbitrary filter/search/utility states are noindex and excluded XML; clean archive pagination has a distinct self-canonical. Actual Finder/Compare/Saved pages emit noindex and omit canonical tags. Guides/categories/products have ordinary links/breadcrumbs. Missing content is 404. The public sitemap now contains 63 eligible URLs; sitemap inclusion does not guarantee indexing.

Before adding content, check the existing owner/intent, research a materially distinct task, and record the new brief/links. Use GSC query→Pages/date/country/device evidence before diagnosing harm from overlap. K15 is explicitly held; no false Cetaphil coverage is claimed.

Full criterion: [Keyword to page mapping](04_Keyword_to_Page_and_Content_Mapping.md).

## 6 SEO strategy and prioritised roadmap

Research on 8 October established audience/queries/competitors/owners. Foundation on 9 October established VM/WordPress/DNS/HTTPS. Product/editorial release on 9–10 October produced current content/tools. Coursework review on 10 October completes the ten-file reference and evidence packaging. Future stages depend on actual assessment, sustainable hosting, real reporting periods and designated backlink domains.

P0 protects access/privacy/truthfulfacts and the US$10 total lease. P1 preserves technical indexing, unique on-page content, four initial candidate owners, correct variants/sources/links, mobile parity and real measurement. P2 covers relevant external contributions and justified 18–24-guide expansion.

|Area|Prioritised action|Completion evidence / next dependency|
|---|---|---|
|Technical|Maintain DNS/strict HTTPS/restricted SSH/private DB/recovery; one origin, stable URL/canonicals/noindex/404/XML; minified assets/static cache; budget/lifecycle.|Actual DNS/TLS/SSH/recovery/HTTP checks; refresh before maintenance/assessment.|
|On page|Unique title/description/H1; useful contents/breadcrumbs/internal anchors; one honest schema graph without fake ratings/offers.|Current metadata/link checks and dated validator records; review changed pages.|
|Content|Prioritise K04/K01/K03/K02 improvements; maintain pack/price/date/availability; source claims and selection method; complete the missing 100 ml pack photo and obtain verified brand-image reuse permission.|Current editorial register/exports; recheck facts and obtain exact variant rights.|
|Off page|Create a useful cited resource/contribution on instructor-designated domains with a natural contextual anchor.|Await domains/account access and explicit publication permission; verify real destination/rel/live URL/indexing where available.|
|Measurement|GSC query/page/index review plus consented fixed GA4 events; comparable mobile/desktop lab before/after; issue→fix→retest.|Properties/tests exist; real organic periods/field INP pending. No manufactured improvement.|

The formal roadmap adds 14 action IDs, owner roles, dependencies and acceptance gates. Google [helpful content](https://developers.google.com/search/docs/fundamentals/creating-helpful-content), [canonicals](https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls), [sitemaps](https://developers.google.com/search/docs/crawling-indexing/sitemaps/overview) and [spam policies](https://developers.google.com/search/docs/essentials/spam-policies) guide editorial clarity/discovery and legitimate contributions. Organic results are not promised.

Full criterion: [SEO strategy and roadmap](06_SEO_Strategy_and_Roadmap.md).

## 7 Domain DNS and Cloudflare

`glowwise.tech` registration with Namify/.Tech Domains/Radix is owner-confirmed. Assigned nameservers are `angela.ns.cloudflare.com` and `trace.ns.cloudflare.com`. Actual Cloudflare Free Active screenshots show proxied apex A→`20.249.61.80` and proxied www CNAME→apex, Auto TTL. Public recursive A answers are `104.21.95.116`/`172.67.144.188`, expected Cloudflare edges rather than origin IP.

![Actual Google Public DNS nameserver lookup 10 October 2026](<../References/Milestone 1/09 Documentation Proof Evidence/2026-10-10_Google_DNS_NS.jpg>)

![Actual Google Public DNS A lookup 10 October 2026](<../References/Milestone 1/09 Documentation Proof Evidence/2026-10-10_Google_DNS_A.jpg>)

The 12-query propagation record checks both assigned authorities and 1.1.1.1/8.8.8.8 for NS / apex A / www A. It establishes scoped consistent delegation/resolution, not every global resolver. AD false remains displayed; DNSSEC is not claimed. HTTP apex/HTTP www/HTTPS www 301 directly to HTTPS apex preserving inspected path/query.

Full(strict) is evidenced by actual dashboard capture and valid trusted edge/origin certificates. Origin uses Let's Encrypt YE1, expires 7 January 2027 03:07:36 UTC; edge YE2 expires 7 January 02:03:20 UTC. Caddy uses explicit LE ACME and persistent cert storage. Automatic renewal configuration is evidenced; a completed elapsed renewal cycle is not.

![Actual redacted Cloudflare Full strict screenshot 9 October 2026](<../References/Deployment/2026-10-09_Cloudflare_Full_Strict.jpg>)

CDN caches approved static assets with observed HIT; dynamic HTML/API/forms/admin/session/query/writes bypass/no-store. Hashed CSS/JS one year immutable; other approved static one day; WP Super Cache page cache remains off. Cloudflare Auto Minify was retired; esbuild 0.28.2 build minification on VM supplies real CSS/JS minification. No retired feature toggle is claimed. Registrar receipt would strengthen acquisition proof but does not replace technical evidence.

![Actual redacted Cloudflare dynamic and private bypass rule 9 October 2026](<../References/Deployment/2026-10-09_Cloudflare_Cache_Rule.jpg>)

Full criterion: [Domain DNS and Cloudflare](07_Domain_DNS_and_Cloudflare_Configuration.md).

## 8 VPS deployment and functional WordPress

One Azure for Students VM, Korea Central, `Standard_B2ats_v2`, x64 / 2 vCPU / 1 GiB nominal RAM, Ubuntu 24.04.5 LTS, 32 GiB Standard SSD LRS, 2 GiB swap and Trusted Launch runs the application. The architecture is Cloudflare→Caddy→official WordPress Apache/PHP→private MariaDB, pinned in Docker Compose. No managed database/Bastion/NAT/new paid service was added.

Actual 9 October SSH output establishes Docker 29.9.0/Compose 5.6.0, Apache 2.4.68, PHP 8.3.35, MariaDB 11.4.13, Caddy 2.11.7, WP-CLI 2.12 and WordPress 7.1.3. This is a containerised LAMP-style stack; Caddy supplies Let's Encrypt ACME. **Certbot is absent.** The task specifies Let’s Encrypt/Certbot; client-specific acceptance is a clarification if required.

### Commands and real output excerpts

Commands are recorded in `deploy/scripts/collect-evidence.sh` and the dedicated SSH file. The excerpt below is actual 9 October output, not a new execution or fabricated tutorial:

```text
2026-10-09T10:50:18+00:00
PRETTY_NAME="Ubuntu 24.04.5 LTS"
SSH effective policy
permitrootlogin no
pubkeyauthentication yes
passwordauthentication no
kbdinteractiveauthentication no
allowusers glowwiseadmin
Engine 29.9.0
Docker Compose version v5.6.0
PHP 8.3.35
Server version: Apache/2.4.68 (Debian)
mariadb from 11.4.13-MariaDB
WP-CLI 2.12.0
WordPress core output: 7.1.3
Database network internal=true
```

The “WordPress core output” label abbreviates the adjacent version line; full verbatim log remains linked. Real post-reboot Compose output shows Caddy/WordPress/MariaDB healthy. Host ports 22/80/443 listen; database 3306 is container-internal, not host mapped. SSH is key-only/nonroot/operator/32; containers cannot access IMDS. Persistent DB/WP/certificate volumes and restart policies survive reboot.

The installation guard performed a fresh WP-CLI core install/configure, then native editing/custom theme/core plugin development. Initial `blog_public=0` and preview lock were deliberate development controls; launch removed the extra lock and enabled public indexing. Native WordPress authentication remains. Actual admin acceptance and current public API/Page checks establish real WordPress rather than a static imitation. The 10 October media-release isolated full Updraft backup retained 40 products / seven guides / 16 Pages and indexed state; restricted off-VM copy checksum was verified. New VM failover/restored admin browser login were not repeated.

Full criterion: [VPS and WordPress](08_VPS_Deployment_and_Functional_WordPress_Setup.md). [Complete SSH commands/output](<../References/Milestone 1/08 VPS WordPress Setup/SSH_Command_Evidence.md>).

## 9 Documentation proof and submission quality

We keep runtime code, research references and the ten criterion documents in separate folders. Every criterion links relevant tables/screenshots/logs/source capture dates; the global index maps marks without counting the combined study twice. Current matrix adds explicit intent/active owner status. Selected technical figures are actual captures; account redaction is labelled. Manifests record SHA256/bytes; local Markdown links, fences, JSON/CSV and raster decoding are checked with declared scope.

The [workspace audit](<../References/Milestone 1/00 Full Review/Workspace_Review.json>) and [current manifest](<../References/Milestone 1/00 Full Review/Current_Artifact_Manifest.json>) make reviewed artifacts traceable. Sources preserve 8 October research, August competitor period, September cached SERP and 9–10 October implementation dates. Only successful inspected provider responses supply metrics. Raw credentials/private keys/account identifiers/inbox records/production backups are excluded from this report.

The report's PDF pages are rendered and visually reviewed separately from content/link integrity. The local full references remain the accompanying backing record; local links are not public URLs. A required public Drive backup must be a separately sanitized/restored-and-checked full Updraft copy with explicit owner-approved sharing. The actual production archive remains private. Academic identity/final filename/upload receipt remain owner steps.

Full criterion: [Evidence and submission quality](09_Documentation_Proof_and_Evidence_Quality.md).

## 10 Live demonstration and timely submission

Our prepared walkthrough shows Home/category/audience, dated keywords and ownership, saved SERP/competitors, actual guide/product/variant/source, search/filter/Finder/compatible Compare/save-reload/retailer, narrow desktop/mobile parity and footer/privacy. It then explains DNS/strict HTTPS and the SSH/WordPress/private DB stack with safe version/health commands and actual recovery proof.

Do not project credentials, inbox data or raw backups. Rehearse anonymously and label test traffic. If live account/terminal access is unavailable, describe fallback captures as dated evidence. Explain the remaining exact-pack photo and unverified brand-image permissions, no field INP/meaningful organic history, later designated backlinks, finite US$10 lease. Caddy LE issuance is real; Certbot is not installed.

The handbook sets M1 at Teaching Week 7 / Session 18 and specifies no M1 presentation duration. Final viva 5–7 minutes is separate. Actual deadline/date, assessment attendance and on-time submission receipt are not available here. Before submission, we need to confirm the academic name/roll, name file `CSET489_SEO_Assignment_[RollNo]_[YourName].pdf`, complete actual upload/sharing and retain receipt. This is prepared material, not proof of attendance or awarded marks.

Full criterion: [Live demonstration and timeliness](10_Live_Demonstration_and_Submission_Readiness.md).

## Remaining work and continuity

All 40 families are photographed, covering 54/55 exact variants. Minimalist Maleic Shampoo 100 ml remains missing. The preserved Plum 50 g outer carton has CC BY-SA 3.0 attribution; the added brand-demo photographs do not have independently verified reuse permission. 40 exact purchase destinations are verified, 39 official + 1 Tira; 36 families / 49 variants were listed, three trimmers and Verge 20 ml watchlisted. Claims/prices are dated observations, not live inventory or guaranteed personal results. Desktop/mobile editorial inspection is real but a full assistive technology/device matrix is not complete.

The existing lease ends 16 October 2026 09:31:49 IST; retained disk/IP decision is due 23 October. US$10 means total credit-funded consumption, not monthly budget. Budget alerts are not hard caps; recorded model/buffer/traffic/lease controls remain. No extension is made by this report. Later M2 needs real observation periods/designated backlink contributions/content expansion and actual final viva/submission.

## Sources and complete backing record

The [Mini Project Handbook](<../../Reference/Mini-Project Handbook.docx>), [Milestone requirements](<../../Reference/Milestone 1 and 2 details with reference material links.md>) and [agreed Source of Truth](../../GLOWWISE_SOURCE_OF_TRUTH.md) govern requirements. The ten full criterion documents above link primary references and exact dated source captures. [Editorial handoff](../Implementation/EDITORIAL_RELEASE_HANDOFF.md), [deployment facts](../Implementation/DEPLOYMENT_FACTS.md), [operations](../Deployment/OPERATIONS.md), [performance](../Deployment/PERFORMANCE.md) and [review index](00_Milestone_1_Review_and_Submission_Index.md) document current implementation and limitations.
