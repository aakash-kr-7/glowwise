# Deployment facts

Recorded 10 October 2026 IST. H IDs resolve in [EVIDENCE_INDEX](EVIDENCE_INDEX.md); configuration observations retain their actual dates. Fresh H01–H03 are smoke/readback checks, not a rerun of every earlier acceptance scenario.

| Fact | Actual configuration / evidence |
|---|---|
| Registrar | Existing Namify / .Tech Domains / Radix registration, per explicit owner decision and Source of Truth v1.1; no second domain bought. Purchase receipt/account not independently reproduced. |
| Delegation | `angela.ns.cloudflare.com`, `trace.ns.cloudflare.com`; authoritative and 1.1.1.1/8.8.8.8 observations in fresh H03. Earlier Pending state is historical. |
| Origin | Existing Azure public IPv4 `20.249.61.80`; Cloudflare proxied apex A and www CNAME → apex. Actual DNS/settings screenshots/readbacks H05/H06; public resolvers show edge addresses, not origin. |
| Canonical | `https://glowwise.tech`; HTTP/www redirect directly, queries preserved. H07 actual redirect/cache assertions; H01 public responses/browser reload. |
| Cloudflare | Free / Active; Full (strict), TLS 1.2 minimum/TLS 1.3; Standard cache/Respect Existing Headers; development mode and Always Online off, HSTS/preload off. H06 browser observation 9 October; fresh TLS H03 independently verifies trusted edge/origin, not every dashboard setting anew. |
| HTTPS | Caddy 2.11.7 explicit Let's Encrypt ACME CA, persisted certificate storage. Origin/edge system-trust/SAN/issuer/expiry verified H03 without `-k`. Origin expiry 7 January2027. Certbot absent; handbook client interpretation awaiting instructor acceptance. |
| Renewal | Caddy automatic renewal while reachable/running; configuration/storage verified. No elapsed renewal cycle/forced issuance claimed. Check Caddy logs and trusted origin expiry per OPERATIONS; deallocation prevents renewal. |
| Stack | Ubuntu 24.04.5 x64; Docker 29.9 / Compose 5.6; official WordPress 7.1.3/Apache 2.4.68/PHP 8.3.35, MariaDB 11.4.13. Exact digest pins in `deploy/stack/compose.yaml` and lock files; H05 versions, H01 current WP/plugins/healthy services. |
| Access/data | Non-root key-only SSH/operator `/32`, root/password authentication disabled, 80/443 web only. DB private/no host mapping, Caddy admin off, IMDS blocked. Persistent DB/uploads/cert volumes; secrets mode 600/root-only paths outside Git. H05 + actual configuration in deploy; private identifiers excluded. |
| Minification | Locked ephemeral Node 24.21.0 / esbuild 0.28.2 builds minified CSS/JS on VM. Self-hosted OFL fonts/original SVG; images have dimensions, eager primary image and lazy below-fold treatment. Cloudflare Auto Minify retired, not enabled. H05/H07 + source. No licensed modern product photographs were supplied. |
| Cache | WP Super Cache 3.1.4 installed, page caching deliberately off. HTML/API/admin/login/forms/contact/writes/private/utility/query/session responses no-store/bypass. Only reviewed CSS/JS/SVG/fonts edge-cache; second requests HIT/compress H07. No blanket cache-everything. |
| Indexing | Production `blog_public=1`, preview auth/global noindex commented; WP admin auth remains. Yoast 28.6 owns one metadata/schema/sitemap output; public59 URLs, utility/filter/search noindex, clean pagination self-canonical H08. |
| Cost | H02: Enabled Azure for Students/spending protection On, seven KoreaCentral resources/VM running. INR560 annual budget with delayed actual140/280/420/560 and forecast420 alerts; not a hard custom cap. Guard/finite lease/tariff/retained costs in FINAL_BUILD_HANDOFF and COST_LEDGER. |

Preserve `Readiness_2026-10-09.md` and earlier access/provisioning records as history. Source edits, updates, rollback, actual backup locations and safe eventual teardown: [OPERATIONS](../Deployment/OPERATIONS.md). No resource was created or subscription upgraded for this handoff.
