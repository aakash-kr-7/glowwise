# Glowwise — Live Demonstration and Submission Readiness

> **Current release — 10 October 2026:** Glowwise is live with 40 researched product families, 55 variants and seven founder-credited guides. All 40 families have photographs; 54/55 exact variants are pictured. The Minimalist Maleic Shampoo 100 ml pack remains a labelled fallback. Brand photographs have source attribution and disclosed demo-use status; reuse permission has not been independently verified. Published revision: `c55b1bd`. See the [release handoff](../Implementation/DEMO_MEDIA_RELEASE.md) and [current report](MILESTONE_I_SUBMISSION_REPORT.md). Research estimates and older evidence retain their original dates.

**Milestone I · Criterion 10 · 2 marks**  
**Prepared:** 10 October 2026  
**Live URL:** [glowwise.tech](https://glowwise.tech/)  
**Purpose:** Demonstrate the actual product, explain the keyword and architecture decisions, and retain real submission evidence.

## 1. Assessment and honest status

The supplied handbook's tenth M1 criterion assesses the live website/server demonstration, keyword rationale and timely submission. The user-provided rubric excerpt stops after evidence quality; the original handbook supplies this remaining criterion. No specific M1 demonstration duration is stated. The 5–7-minute instruction applies to the final viva.

The site and supporting demonstration materials exist. A fresh anonymous public check on 10 October confirms working selected pages, 40 products and 63 sitemap URLs. Prior desktop/mobile interactions and actual SSH/WordPress evidence are recorded. **Assessment attendance and on-time submission are not established by those checks.** This document prepares them and provides a receipt record; it does not simulate a completed evaluation.

## 2. Before the live demonstration

1. Check current hosting availability and lifetime cost/lease before any restart. Current operational lease ends 16 October 2026 at 09:31:49 IST; do not extend spend or hosting automatically.
2. Open the site in an anonymous/private session. Reject analytics unless deliberately demonstrating consent; describe all demonstration traffic as testing.
3. Keep the [ten-criterion submission index](00_Milestone_1_Review_and_Submission_Index.md), keyword matrix, actual DNS/SSH logs and dated screenshots ready locally.
4. Authenticate SSH or WordPress privately. Close password managers, billing/account panels, inbox records and token-bearing screens before projecting.
5. Follow the institution's actual deadline and file-upload requirements. The handbook provides Teaching Week 7 / Session 18, not a confirmed calendar date. Confirm the accepted report filename and backup-sharing expectations without inventing dates.

## 3. Demonstration sequence and talking points

| Step | Live action | What to explain / proof |
|---|---|---|
|1 · Product and audience | Open Home and one category hub. | India/English/INR grooming discovery for approximately 18–30 across genders. Sources justify a young digital-shopping audience; personas are hypotheses. |
|2 · Search rationale | Open keyword matrix and shampoo guide. | K01 historical volume 6,600 / KD 18; mixed commercial/informational intent; one owner for reordered variants. Explain KD 20/24/29 exceptions and held K15. |
|3 · Competitive reasoning | Show one saved SERP/PAA example and competitor table. | Seven queries/53 headings/six measured samples. Smytten/Nykaa August baseline; content gaps are bounded sampled improvements, not sitewide missing-topic claims. |
|4 · Real editorial value | Read shortlist/method/sources and open a cited product. | Actual pack/variant, dated INR price, reason/trade-off, availability/watchlist and exact official/retailer link. No firsthand testing/clinical endorsement claim. |
|5 · Working journey | Search/filter → Finder → compatible comparison → save/reload → remove → retailer. | Real rule matching, maximum three same-type products, variant-specific comparison, local saves and honest empty states. Purchases happen at retailer. |
|6 · Mobile and desktop | Show narrow viewport and desktop layout. | Same reading, sources, menu/filter/reset, compare/save/retailer and footer destinations. Tables scroll inside page. Keyboard/focus support; no unsupported accessibility certification. |
|7 · Footer and privacy | Open How We Select/policies; reopen consent settings. | Imagine Utopia/Aakash Kumar/Disa Bandhu; correct actual storage/private inbox; no checkout/customer accounts. 40 photographed families, 54/55 variants; exact missing 100 ml pack and brand-demo rights wording. |
|8 · Domain and server | Show public DNS/strict-mode proof and safe SSH commands. | Registrar owner-confirmed; assigned Cloudflare nameservers / proxied DNS; canonical HTTPS; Caddy → Apache/PHP WordPress → private MariaDB. Actual Let’s Encrypt certificate; Certbot absent. |
|9 · Evidence and recovery | Show log excerpts, sitemap and backup verification summary. | All three services healthy in actual logs; 63 sitemap URLs now; private cache/noindex policies; isolated restoration evidence and finite budget controls. |
|10 · Limitations and next step | Open roadmap and M2 foundations. | No meaningful organic history/guaranteed rank. Explain later observation/designated backlink/content expansion and safe submission backup requirement. |

## 4. Safe server and DNS commands

Run only when the current VM is already available within its original budget controls. Commands below are a demonstration recipe; execution outputs are separately dated in the linked evidence.

```powershell
ssh -F .local/deployment/ssh_config glowwise-dev
Resolve-DnsName glowwise.tech -Type NS -Server 1.1.1.1
curl.exe --resolve glowwise.tech:443:20.249.61.80 -I https://glowwise.tech/
```

```bash
cd /srv/glowwise/source/deploy/stack
sudo docker compose ps
sudo docker compose run --rm -T wpcli core version
sudo docker compose run --rm -T wpcli plugin list --fields=name, status, version
sudo docker compose run --rm -T wpcli option get blog_public
systemctl is-active glowwise-cost-guard.timer glowwise-wordpress-cron.timer
```

Never project `.env`, private keys, raw container inspection, `wp-config.php`, admin/user options, inbox rows, production database contents or raw backup files. Use the [actual sanitized SSH evidence](<../References/Milestone 1/08 VPS WordPress Setup/SSH_Command_Evidence.md>) if a live terminal is unavailable. Explain that fallback as historical evidence rather than pretending the commands just ran.

## 5. Answers to likely evaluation questions

- **Why these keyword owners?** Seven specific tasks connect researched intent to substantial guides. Secondary/related phrases share an answer; hubs browse broadly and products explain exact identities. K15 is held because the present catalog has no verified Cetaphil option.
- **What makes the content useful?** Explained choices, consistent product/variant fields, dated sources, limitations, working comparisons and exact purchase destinations. This is published-information research, not invented hands-on experience.
- **Why WordPress?** Native editing and server rendering suit editorial SEO; persistent data/rules/inbox live in the core plugin and presentation in the theme.
- **Why Caddy?** It is the approved HTTPS proxy and Let’s Encrypt ACME client. Actual certificate issuance is verified; Certbot is not installed and elapsed renewal is not demonstrated.
- **What does Cloudflare cache?** Approved static assets. Dynamic HTML, API, admin, forms, session/query/write responses stay no-store/bypassed. Build minification supplies the capability formerly described asAuto Minify.
- **Is SEO successful already?** Technical delivery and current content are evidenced. Sitemapfetch, indexing, rankings, organic audiences and purchases are different outcomes; meaningful search history is not available.
- **Are all photos finished?** All 40 families are photographed, covering 54/55 variants. Minimalist Maleic Shampoo 100 ml is the one missing pack. Brand images are source-attributed demo assets; independent reuse permission is not established. The preserved Plum 50 g outer carton has its separately recorded CC BY-SA 3.0 licence.
- **Can hosting continue forever?** No. The US$10 total ceiling includes credit-funded consumption. Finite lease/guard/retainedcosts need owner lifecycle action.

## 6. Submission and attendance evidence record

Fill these only from real institutional information or receipts. No fabricated signature, deadline or attendance statement belongs in the report.

| Record | State |
|---|---|
| Approved submitter name and roll number | Await owner confirmation; publisher/founders are not a substitute for academic identity. |
| Institution calendar deadline and timezone | Not supplied; handbook window Teaching Week 7 / Session 18. |
| Actual report filename and final SHA256 | Record after owner identity/name convention and final export. |
| Submission platform/date/time/receipt | Pending actual upload and receipt. |
| Demonstration date/assessor/attendance | Pending actual assessment. |
| Submitted live URL | `https://glowwise.tech/`; check immediately before evaluation. |
| Required backup link | Pending separately sanitized, restore-tested full Updraft submission copy and explicitly approved public sharing. Raw production backup remains private. |

Handbook report convention: `CSET489_SEO_Assignment_[RollNo]_[YourName].pdf`; it accepts a structured PDF/DOCX. Use the [submission checklist](../Implementation/SUBMISSION_READINESS.md) for actual archive/privacy requirements. A draft report or prepared runbook does not prove submission/timeliness.

## 7. Evidence register and conclusion

The [public readback](<../References/Milestone 1/00 Full Review/2026-10-10_Public_Readback.json>), [editorial evidence index](../Implementation/EDITORIAL_EVIDENCE_INDEX.md), [deployment evidence](08_VPS_Deployment_and_Functional_WordPress_Setup.md), [DNS criterion](07_Domain_DNS_and_Cloudflare_Configuration.md) and [operational runbook](../Implementation/MILESTONE_1_DEMO_RUNBOOK.md) support the walkthrough. Historical captures carry actual dates; private sessions and genuine external links are distinguished from simulations.

Glowwise is prepared for a substantive live demonstration. This criterion remains open until the owner performs the assessment and supplies actual submission evidence; marks and punctuality cannot be self-certified.
