# Glowwise — Documentation, Proof & Evidence Quality

> **Current release — 10 October 2026:** Glowwise is live with 40 researched product families, 55 variants and seven founder-credited guides. All 40 families have photographs; 54/55 exact variants are pictured. The Minimalist Maleic Shampoo 100 ml pack remains a labelled fallback. Brand photographs have source attribution and disclosed demo-use status; reuse permission has not been independently verified. Published revision: `c55b1bd`. See the [release handoff](../Implementation/DEMO_MEDIA_RELEASE.md) and [current report](MILESTONE_I_SUBMISSION_REPORT.md). Research estimates and older evidence retain their original dates.

**Milestone 1 · Criterion 9 · 2 marks**  
**Prepared and evidence reviewed:** 10 October 2026, IST  
**Course:** CSET489 SEO Mini Project  
**Status:** Criterion evidence and consolidated report prepared; academic identity, actual submission and assessment remain pending.

**Product reference:** [Source of Truth](../../GLOWWISE_SOURCE_OF_TRUTH.md)  
**Live product:** [glowwise.tech](https://glowwise.tech/) · [GitHub repository](https://github.com/aakash-kr-7/glowwise)  
**Supporting package:** [Evidence index](<../References/Milestone 1/09 Documentation Proof Evidence/Evidence_Index.md>) · [Keyword matrix](<../References/Milestone 1/09 Documentation Proof Evidence/Keyword_Evidence_Matrix.csv>) · [Integrity and link review](<../References/Milestone 1/09 Documentation Proof Evidence/Documentation_Review.json>)

## 1. Assessment requirement and evidence standard

The handbook requires well-organised technical documentation, terminal logs, DNS propagation screenshots and keyword matrices. Its Excellent descriptor calls for complete, logically arranged evidence with traceable deliverables.

Glowwise's evidence is arranged so that an evaluator can move from **requirement → explanation → actual configuration or research → supporting observation**. This criterion document is an evidence guide: detailed niche, keyword, infrastructure and implementation arguments remain in their owning documents.

| Required evidence | Provided material | How it can be checked |
|---|---|---|
| Technical documentation | Source of Truth, architecture/decision records, deployment documents, operations and criterion files. | Follow the linked document and its dated implementation artifacts. |
| Terminal logs | Actual SSH version, effective-policy, service, network, configuration and recovery output. | Compare complete logs with the collector and selected command/output excerpts. |
| DNS propagation screenshots | Two genuine Google Public DNS browser captures, showing apex A and NS answers. | Compare displayed domain/type/results with the four-resolver raw DNS record. |
| Keyword matrices | 15 focus/secondary keywords and 10 long-tail/related records; metrics, intent, relevance and page ownership documented. | Inspect the original research tables, provider evidence and reusable ownership CSV. |
| Traceability | Ten separate Milestone 1 criterion rows plus product and Milestone 2 requirements. | Read the requirements register and this document's coverage table. |
| Evidence integrity | Capture provenance, source dates, screenshot treatment, local SHA-256 manifest and link review. | Inspect the supporting package and original artifact paths. |

Evidence volume is not used as a substitute for relevance. A small selection of useful screenshots is paired with complete machine-readable observations and logs.

## 2. Documentation organisation

```text
Glowwise/
├── GLOWWISE_SOURCE_OF_TRUTH.md
├── Assets/                         Original brand assets
├── Documentation/
│   ├── Milestone 1/                Formal criterion documents
│   ├── References/
│   │   ├── Milestone 1/            Research and criterion evidence packages
│   │   ├── Deployment/             Actual infrastructure/SSH/HTTP/recovery proof
│   │   ├── Implementation/         Actual browser and product evidence
│   │   └── Visual_Refinement/      Dated design/media verification
│   ├── Implementation/             Decisions, traceability and current handoffs
│   └── Deployment/                 Operations, cost and technical records
├── theme/glowwise/                 Presentation source
├── plugins/glowwise-core/          Persistent functionality source
├── content/                        Reviewed content and data
├── deploy/                         Infrastructure/stack/operations source
└── tooling/                        Build and content tooling
```

This describes the actual layout; root-level `Assets/` and supplied source materials are preserved. Application code is distinct from assessment documentation. Original `Reference/` and `milestone_1/` materials remain traceable historical inputs rather than being presented as final submissions.

The [Source of Truth](../../GLOWWISE_SOURCE_OF_TRUTH.md) defines the agreed product. [BUILD_STATE](../Implementation/BUILD_STATE.md) identifies the latest operational state. [DECISIONS](../Implementation/DECISIONS.md) records the reasons for major choices. [REQUIREMENTS_TRACEABILITY](../Implementation/REQUIREMENTS_TRACEABILITY.md) distinguishes implemented, verified, pending and externally dependent work.

Historical documents are not silently rewritten to make earlier stages appear complete. For example, Stage 2 correctly describes a protected fresh WordPress installation; the later launch/editorial handoffs describe the subsequent public product. Their evidence dates and content counts remain distinct.

## 3. Keyword tables and research provenance

The original [keyword research document](02_Keyword_Research_LSI_and_Search_Intent_Mapping.md) provides:

- **15 K-records:** focus/secondary keywords, estimated volume, Semrush KD, intent, clusters and source references.
- **10 L-records:** long-tail/related terms, competition, transparent relevance scores and semantic coverage.
- Definitions separating provider estimates, editorial intent/relevance judgments and unavailable data.
- India/English query context, capture dates, source screenshots, report text and connector limitations.

The supporting [keyword evidence matrix CSV](<../References/Milestone 1/09 Documentation Proof Evidence/Keyword_Evidence_Matrix.csv>) is a **byte-identical copy** of the existing ownership matrix. It preserves all 25 records and their provider/date/source lineage. It contains **21 distinct phrases assigned to seven guide owners**; repeated wording across K/L records preserves research lineage rather than creating competing pages.

Its columns include exact keyword, source role, volume estimate, KD, original relevance where applicable, owner/page URL, duplicate relationship, provider, market, observed date and evidence reference. Detailed keyword-level intent remains in the original research document; it is not falsely described as an extra column in this CSV.

### Representative focus-keyword evidence

All estimates below were observed in **Semrush India on 8 October 2026**. They are retained historical research, not freshly measured traffic or ranking results.

| ID | Keyword | Est. monthly volume | KD /100 | Documented intent | Evidence route |
|---|---|---:|---:|---|---|
| K01 | shampoo for dry and frizzy hair | 6,600 | 18 | Commercial + informational | Keyword document R01/E01–E02 |
| K02 | which is the best sunscreen for oily skin | 1,600 | 18 | Commercial | R07/E13 |
| K03 | perfume under 1000 | 1,300 | 19 | Commercial + informational | R09/E17–E18 |
| K04 | which body lotion is good for dry skin | 140 | 13 | Commercial | R05/E09 |
| K05 | which face wash is best for sensitive skin | 390 | 20 | Commercial | R06/E11 |
| K06 | beard oil benefits | 590 | 24 | Informational | R08/E14 |
| K07 | best trimmer under 1500 | 720 | 29 | Commercial | R03/E06 |

Four focus candidates meet the preferred KD-below-20 threshold; the other three retain documented exceptions. Volumes are not summed into a traffic forecast. Semrush KD, Ubersuggest SD and paid-search advertiser competition are not substituted for one another.

The [keyword research evidence index](<../References/Milestone 1/02 Keyword Research Intent Mapping/Evidence_Index.md>) links original report screenshots, saved text and successful tool responses. Missing/blocked provider requests remain limitations. The [keyword-to-page document](04_Keyword_to_Page_and_Content_Mapping.md) explains ownership, duplicate-wording handling and URL taxonomy. Current product/guide exports supplement the original plan without relabelling its metrics as current measurements.

## 4. Actual terminal and technical evidence

The [VPS criterion document](08_VPS_Deployment_and_Functional_WordPress_Setup.md) explains the Azure/WordPress installation, with a [dedicated SSH command-evidence file](<../References/Milestone 1/08 VPS WordPress Setup/SSH_Command_Evidence.md>) and links to complete output.

| Evidence | What it establishes | Limitation preserved |
|---|---|---|
| SSH versions/health | Actual Ubuntu, Docker, Apache/PHP, MariaDB, Caddy, WP-CLI and WordPress versions; healthy services and internal DB network. | Executed 9 October; no new SSH run claimed by this document. |
| Effective SSH policy and NSG readback | Key authentication, disabled root/password access and operator-source restriction. | Scoped records; not a security certification. |
| Administrator acceptance | Real WordPress sign-in/dashboard200 with secure cookie attributes. | Credential/session values excluded; dated initial acceptance. |
| Configuration and recovery logs | Valid configuration, healthy services after recovery and isolated SQL/file restoration. | Live DB was not replaced; new-VM failover is not inferred. |
| Fresh public delivery readback | Homepage, Explore, guide and public products API200; admin redirects to login. | Selected HTTP observation, not a complete browser/user-journey rerun. |

The terminal excerpts are copied from real execution and paired with collection commands. They are not artificial screenshots or a tutorial transcript. Shortening an excerpt is disclosed, and complete logs remain available.

The [domain/Cloudflare criterion](07_Domain_DNS_and_Cloudflare_Configuration.md) separately links actual DNS, SSL-mode and cache-rule screenshots, trusted origin/edge certificate observations, redirects and CDN HITs. It accurately states that **Caddy issued the Let's Encrypt certificate; Certbot is absent**, and that retired Cloudflare Auto Minify is replaced by documented build-time CSS/JS minification.

## 5. DNS propagation screenshots and corroborating records

Two actual Google Public DNS query pages were captured through the browser on **10 October 2026**. [Capture provenance](<../References/Milestone 1/09 Documentation Proof Evidence/DNS_Screenshot_Provenance.json>) was recorded at **06:01:37 UTC / 11:31:37 IST** after capture; it identifies the page URLs and observed results. The supporting manifest retains the files' save timestamps.

### Nameserver lookup

![Genuine Google Public DNS nameserver response for glowwise.tech](<../References/Milestone 1/09 Documentation Proof Evidence/2026-10-10_Google_DNS_NS.jpg>)

*Figure 1. Public recursive lookup returns `NOERROR` and the assigned `angela.ns.cloudflare.com` / `trace.ns.cloudflare.com` nameservers. Actual browser screenshot, unedited.*

### Address lookup

![Genuine Google Public DNS A-record response for glowwise.tech](<../References/Milestone 1/09 Documentation Proof Evidence/2026-10-10_Google_DNS_A.jpg>)

*Figure 2. Public recursive lookup returns `NOERROR` and Cloudflare edge addresses `172.67.144.188` / `104.21.95.116`. Actual browser screenshot, unedited.*

These captures substantiate publicly available NS/A answers and complement the [12-observation DNS record](<../References/Milestone 1/07 Domain DNS Cloudflare/2026-10-10_DNS_Refresh.json>) from both authoritative nameservers plus `1.1.1.1` and `8.8.8.8`. They do not claim universal geographic propagation, origin-address disclosure through proxied DNS or an authenticated DNSSEC chain. The displayed `AD: false` is retained; no DNSSEC completion claim is introduced.

## 6. Traceability across the ten Milestone 1 criteria

| Criterion | Owning document / supporting record | Documentation state |
|---|---|---|
| 1. Niche/audience/problem | [01 — niche and problem](01_Niche_Target_Audience_and_SEO_Problem_Identification.md) and its reference index. | Formal research document exists. |
| 2. Keyword research/intent | [02 — keywords](02_Keyword_Research_LSI_and_Search_Intent_Mapping.md), original evidence index and reusable matrix. | Formal research document exists. |
| 3. SERP analysis | [03 — competitor/SERP document](03_Competitor_Analysis_and_SERP_Breakdown.md), SERP captures and structured records. | [Standalone SERP criterion](03A_SERP_and_Ranking_Analysis.md) prepared; original combined record retained. |
| 4. Competitors/gaps | Same document, competitor keyword/backlink samples and limitations. | [Standalone competitor criterion](03B_Competitor_Analysis_and_Content_Gap.md) prepared; same dated source evidence retained. |
| 5. Keyword-to-page mapping | [04 — mapping](04_Keyword_to_Page_and_Content_Mapping.md), ownership CSV and live-content exports. | Formal planning document exists; current implementation records supplement it. |
| 6. SEO roadmap | [SEO implementation register](../Implementation/SEO_IMPLEMENTATION_REGISTER.md) and execution plan. | [Formal roadmap](06_SEO_Strategy_and_Roadmap.md) prepared with dependencies, priorities, owners and acceptance criteria. |
| 7. Domain/DNS/Cloudflare | [07 — domain configuration](07_Domain_DNS_and_Cloudflare_Configuration.md) and its evidence index. | Formal document with dated proof exists. |
| 8. VPS/WordPress | [08 — functional deployment](08_VPS_Deployment_and_Functional_WordPress_Setup.md), SSH logs and supporting index. | Formal document with dated proof exists. |
| 9. Evidence/submission quality | This document and the linked quality package. | Evidence organisation documented; final report packaging remains. |
| 10. Demonstration/timeliness | [Demo runbook](../Implementation/MILESTONE_1_DEMO_RUNBOOK.md) and submission checklist. | [Formal demonstration record](10_Live_Demonstration_and_Submission_Readiness.md) prepared; actual human demonstration/submission remains. |

Filename sequence is not used to infer marks: existing `03` covers two criteria, and existing `04` covers handbook criterion5. All ten are explicitly accounted for. The current [review/index](00_Milestone_1_Review_and_Submission_Index.md) maps ten owning documents and reports actual submission gates. Evidence organisation does not establish a score or completed human assessment.

## 7. Integrity, privacy and review

The [quality package](<../References/Milestone 1/09 Documentation Proof Evidence/Evidence_Index.md>) records artifact purpose, date, provenance and limitations. [Artifact_Manifest.json](<../References/Milestone 1/09 Documentation Proof Evidence/Artifact_Manifest.json>) records SHA-256 values and sizes for selected documents, matrices, logs and screenshots. Hashes establish the identity of reviewed copies; they do not prove the underlying claim independently.

The initial [documentation review](<../References/Milestone 1/09 Documentation Proof Evidence/Documentation_Review.json>) recorded **15 reviewed Markdown files and278 local link occurrences**. The broader current [workspace review](<../References/Milestone 1/00 Full Review/Workspace_Review.json>) supersedes that coverage and checks all non-private Markdown/JSON/CSV and raster decoding, with its exact scope recorded. All code-fence counts are balanced. The original25-row matrix remains a byte-identical historical copy. The [current matrix](<../References/Milestone 1/00 Full Review/Current_Keyword_Intent_Ownership.csv>) adds intent/current status and holds K15; active repeated phrases have no conflicting owners. This is document-integrity review, not a rerun of website tests, external-link availability check or exhaustive secret/security audit.

Privacy boundaries are deliberate:

- Public DNS, website configuration, sanitised logs and anonymous website screenshots support the report.
- Existing account/dashboard screenshots are labelled redacted copies where applicable; relevant configuration remains visible.
- Private keys, passwords, tokens, inbox messages, account identifiers and raw production backups are excluded.
- Historical estimates, new observations and editorial judgments retain distinct provenance.
- Only sources actually inspected are described as reviewed; inaccessible external resources remain documented limitations.

No original research metrics, application code or hosting configuration were changed for this criterion. The new matrix is a faithful submission copy, and the two DNS images are genuine new captures.

## 8. Final report assembly and outstanding evidence

For submission, combine the formal criterion material into the handbook's single structured PDF/DOCX, with labelled figures, legible tables, source references and the live URL. Use [SUBMISSION_READINESS](../Implementation/SUBMISSION_READINESS.md) for the required naming convention, owner-supplied identity, backup/public-link requirements and final checks. Markdown existence does not establish final PDF/DOCX layout quality.

Retain an accompanying evidence directory/index so an evaluator can inspect full logs and matrices beyond the report excerpts. Before export, verify that images remain readable, local links are resolved or supplied in the accompanying bundle, and no private material is included.

Roadmap/demo files and a consolidated report are now prepared. Outstanding boundaries: final academic identity/naming and actual upload, registrar receipt if requested, instructor interpretation if Certbot is required literally, human demonstration/submission, and separately sanitised restore-tested public-backup sharing. No public raw backup, elapsed certificate renewal, timely submission or assessment score is claimed.

The hosting lease in the operational records ends **16 October 2026 at 09:31:49 IST**. Check live availability before assessment and address the hosting lifecycle within the owner's total budget.

## 9. Criterion conclusion

Glowwise's submission evidence is organised around the actual assessed requirements: research matrices and source captures, technical decisions and deployment records, real SSH command output, visible DNS-resolution proof and explicitly dated verification. Cross-links and integrity records make the evidence inspectable without conflating historical research, current implementation and unfinished submission actions.

This provides a traceable evidence foundation for the two-mark documentation criterion and for assembling the remaining Milestone 1 submission; marks remain the evaluator's decision.

## 10. Current product screenshots and release proof

The implementation has progressed beyond the earlier one-photo release. The latest release contains 40 photographed families and 54/55 pictured variants, with founder credits on all seven guides. The one missing pack is Minimalist Maleic Shampoo 100 ml. The preserved 50 g Plum outer-carton photograph has a recorded CC BY-SA 3.0 licence; new brand photographs are separately labelled for demo use, without claiming verified permission.

![Desktop fragrance cards with exact products and visible photo attribution](<../References/Deployment/Demo_Media/after-fragrance-desktop.png>)

*Figure 3. Genuine desktop catalog capture from the 10 October media release; source attribution and demo-use status are visible. Saved at 10:09:17 UTC. The image is unaltered.*

![Mobile shampoo guide showing Aakash Kumar's byline and research disclosure](<../References/Deployment/Demo_Media/after-guide-mobile.png>)

*Figure 4. Genuine mobile guide capture from the same release, saved at 10:09:17 UTC. This view demonstrates the byline and reading layout; the complete seven-guide browser record supplies article and overflow checks.*

![Mobile SKINN Celeste product page with its source-attributed photograph](<../References/Deployment/Demo_Media/after-product-mobile.png>)

*Figure 5. Genuine mobile product capture, saved at 10:11:23 UTC. The selected pack and visible rights credit are preserved; it is not a purchase or licence grant.*

The [release handoff](../Implementation/DEMO_MEDIA_RELEASE.md), [80 live media/byline checks](../References/Deployment/Demo_Media/acceptance.json), [197 content checks](../References/Deployment/Editorial/content-http.json), [nine media/security checks](../References/Deployment/Demo_Media/media-integration.json), [native coverage export](../Implementation/exports/demo-image-coverage.json) and [browser observations](../References/Deployment/Demo_Media/browser-checks.json) explain the 286-check result. The screenshots are original saved captures from that work, inspected again for this report; no new screenshot capture is claimed. Our [fresh HTTP readback](<../References/Milestone 1/00 Full Review/Release_Update/Public_Readback.json>) independently checks all seven guides, founder credits, the catalog total and sitemap.
