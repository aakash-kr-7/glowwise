# Milestone 1 demo runbook

10 October 2026 IST. Use actual live pages and dated fallback evidence; no Milestone1 duration is specified. The handbook's **5–7 minutes applies to the final viva**. Rehearsal does not prove assessment attendance or timely submission.

Before demonstrating: check the lifetime cost/lease and H01 health; open https://glowwise.tech anonymously; have [EVIDENCE_INDEX](EVIDENCE_INDEX.md), [DEPLOYMENT_FACTS](DEPLOYMENT_FACTS.md), preserved R1–R4 and current exports available. Use a consent-rejected/private session so test clicks are not portrayed as organic audience data. Never project account identifiers, credentials, SSH keys, billing recipients or inbox contents.

| Sequence | Demonstrate / explain | Dashboard unavailable fallback |
|---|---|---|
| 1 · Problem and intent | Inclusive India grooming discovery; why source/variant/budget clarity matters. R1 justification, R2 dated keywords, conditional KD exceptions. | R1/E1 and R2/E2; date all estimates. |
| 2 · Search decisions | Explain one saved SERP sample and Smytten/Nykaa gap. Show seven-owner map; repeated terms share owners. | R3/E3 supports separate SERP/competitor criteria; R4 CSV/hierarchy. |
| 3 · Live journey | Categories → skincare → sensitive-skin guide → related cleanser → Finder → same-type Compare → Save → labelled official retailer. Return using Back; change/reset filters; show price/check date and narrow layout. | H08 actual browser scenario record, selected H11 screenshots; screenshots are dated evidence, not current interactivity. |
| 4 · Trust and privacy | Footer/methodology/policies; reopen cookie settings and reject. Explain local saves/private inbox/90-day expiry, no accounts/checkout/testing claims. Do not submit or project personal message data. | H08 labelled delivery/denial record; H12 actual consent/event tests. |
| 5 · Domain and HTTPS | Existing registrar, active delegation, proxied apex/www, canonical redirect, Full(strict). Show redacted DNS/strict settings, trusted origin issuer/expiry. State Caddy ACME, Certbot absent. | H03 fresh resolver/TLS observations; H05 redacted original configuration, H06 settings/H07 redirects. |
| 6 · VPS/WordPress | Key-only non-root SSH, private DB, pinned Compose stack and actual native WordPress editing. Show safe version/health commands below. Explain persistent volumes/theme/core separation. | H01 healthy services/current plugins; H05 sanitized SSH/version logs. Native edit workflow inspected, not a fake admin screen. |
| 7 · Evidence and operations | One graph/canonical,59 sitemap URLs, utility noindex, safe static cache/build minification. Explain actual backup/isolated restore and finite cost controls. | H07/H08/H13; Operations/Cost ledger. A sitemap fetch is not indexing. |

Safe live commands (authenticate privately first):

```powershell
ssh -F .local/deployment/ssh_config glowwise-dev
Resolve-DnsName glowwise.tech -Type NS -Server 1.1.1.1
curl.exe --resolve glowwise.tech:443:20.249.61.80 -I https://glowwise.tech/
```

```bash
cd /srv/glowwise/source/deploy/stack
sudo docker compose ps
sudo docker compose run --rm -T wpcli core version
sudo docker compose run --rm -T wpcli plugin list --fields=name,status,version
sudo docker compose run --rm -T wpcli option get blog_public
systemctl is-active glowwise-cost-guard.timer glowwise-wordpress-cron.timer
```

Do not show `env`, raw `docker inspect`, wp-config, private options/users/inbox or raw backups. Cost/resource account dashboard screenshots require redaction; use sanitized H02 if safe access is unavailable. Normal sign-in/MFA remains owner controlled.

Likely questions:

- **Why WordPress/theme plus plugin?** Native editorial editing and server rendering; durable catalog/rules/inbox stay in core when presentation changes.
- **Why Caddy rather than Certbot?** Approved stack uses Caddy's own Let's Encrypt ACME issuer/automatic renewal. Certbot not installed; literal-client acceptance awaits instructor, compatible fallback in DECISIONS.
- **Why no product photos/ratings?** Reuse rights and real reviews unavailable; original labelled art and sourced facts avoid invented packaging/evidence.
- **What is cached?** Reviewed static assets only. Dynamic HTML, login/admin/API/forms/writes/session/query responses bypass/no-store; WP page cache off.
- **Does $10 mean monthly?** Total lifetime consumption including credit. Alerts lag; buffered model/normalized-actual/traffic/lease guard, retained disk/IP still bill after deallocation.
- **Has SEO succeeded?** Implementation and lab checks exist; indexing/organic traffic/rankings are not established. TBT is not field INP; automated accessibility is not certification.
- **What remains?** 18–24-guide expansion, observation/history, designated backlinks, remaining accessibility matrix, owner lifecycle/submission/demo and sanitized restore-tested public backup.
