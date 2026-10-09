# Glowwise deployment readiness

Recorded: 9 October 2026. This is an operational record, not evidence of a deployed website.

## Owner-confirmed decisions

- Registered domain: `glowwise.tech`.
- Registrar interface: Namify / .Tech Domains / Radix. Owner confirms editable nameservers and DNS records.
- Repository: https://github.com/aakash-kr-7/glowwise — fresh and empty.
- Publisher team name: Imagine Utopia. Founders: Aakash Kumar and Disa Bandhu. Do not present this as an incorporated company or invent an address, registration number or contact email.
- Owner reports an active Azure for Students subscription, INR 9,599 credit and expiry on 8 October 2027. This is owner-supplied account information; live subscription details have not yet been independently verified.
- Infrastructure must remain within student benefits, with no payment-card requirement or paid subscription upgrade.

## Checks actually performed

- GitHub connector authenticated as `aakash-kr-7`; repository metadata reports administrator and push permissions, size zero and default branch `main`.
- `git ls-remote` returned no refs. Local Git repository initialised on `main`, with the supplied repository configured as `origin`.
- Local GitHub CLI has an expired token for a different username. Connector access works independently; CLI push authentication is not established.
- Cloudflare connector authentication and account/zone listing succeeded. No `glowwise.tech` zone existed at the initial check. Subsequent zone preparation is recorded separately when successful.
- Created the `glowwise.tech` full zone on Cloudflare's Free Website plan (price zero). API creation succeeded; status is `pending`. Assigned nameservers: `angela.ns.cloudflare.com` and `trace.ns.cloudflare.com`. Registrar nameservers have not been changed by the agent. Activation and DNS/HTTPS configuration remain outstanding.
- Public NS lookup returned the four `tech-domains.{earth,venus,mercury,mars}.orderbox-dns.com` nameservers. These differ from the earlier owner-pasted `cont603385` names. Record the live result rather than treating the pasted values as current authority.
- Azure CLI is not installed. No Azure connector is exposed in this session. Opening Azure in the accessible Codex browser reached Microsoft sign-in. Owner sign-in is needed before independent subscription/VM verification.
- Docker executable exists, but the Docker Desktop Linux engine is not running. PHP executable is not available on PATH. No local WordPress runtime has been started.

## Source reconciliation before deployment

The Source of Truth selects Docker Compose, official WordPress Apache/PHP, MariaDB and Caddy. Later conversational guidance suggested Nginx/Certbot; it did not amend that source. Preserve the agreed architecture until a documented deployment decision reconciles it with the rubric's explicit Let's Encrypt / Certbot requirement. Apache/PHP/MariaDB provides the required LAMP-style server components; certificate method and evidence must be explicitly resolved.

Do not assume `Standard_B1s` is free in this subscription solely from a general student-program claim. Verify the subscription's actual free-service entitlement, regional size availability, quotas and costs for compute, disk, public IP and network usage. Deallocation stops compute allocation but does not remove all associated resource costs. Keep the spending limit and avoid upgrades.

## Live follow-up: Azure sign-in and DNS, 9 October

- Owner completed Azure sign-in. Portal independently confirms an Active Azure for Students subscription, Owner role, current cost 0.00 and no existing resources at inspection.
- Subscription free-service panel expires 8 October 2027. It lists Linux B1s: 0/750 hours; Linux B2ats v2: 0/750 hours; Linux B2pts v2: 0/750 hours. It also lists P6 disk and public-IP-related allowances, but exact resource meter matching must still be checked before treating a selected disk or Standard public IP as free.
- Owner reports registrar nameservers changed to Cloudflare. Initial follow-up API status remains Pending; the local public NS resolver still returns the prior Orderbox nameservers. Do not treat that snapshot as evidence the owner failed to save the change; propagation remains unconfirmed.
- No VM, disk, public IP or paid add-on has been created during these checks. Opening the VM wizard and selecting draft options does not provision resources.
- Central India draft with Ubuntu 24.04 x64/Trusted Launch and no availability-zone requirement reports `Standard_B2ats_v2` unavailable for this subscription (`NotAvailableForSubscription`). Its displayed pre-benefit compute estimate is USD 4.49/month; this is not a total-resource quote or an incurred charge. A nearby alternative region is being inspected. Do not replace it with a larger paid VM by default.
- Cost policy: prefer one verified free-eligible small VM, matched disk allowance, no paid database service, Bastion, NAT Gateway, load balancer or paid monitoring add-on. Build locally while possible; create the server once the deployment inputs are ready. Budget alerts are notifications, not a hard resource shutdown. Deallocation does not remove disk/public-IP costs. Preserve subscription spending protection and do not upgrade.
- Further draft checks: B2ats v2 reports `NotAvailableForSubscription` in Southeast Asia and East US 2 as well. East US 2 B1s is disabled with `Size not available` under the Ubuntu 24.04 x64/Trusted Launch configuration. These are bounded configuration checks, not proof that no eligible region/configuration exists. No larger paid size was substituted.
- A follow-up query to public resolver 1.1.1.1 still returns the original Orderbox NS records. Last successful Cloudflare API read reported Pending; a later API attempt became unavailable through the connector, so no later API status is claimed.
- Subscription spending-limit setting, exact total-cost estimate and eligible deployable configuration remain to be verified. No spending controls or budget alerts were changed. No Azure resources were provisioned.

## Publication scope

The repository is public. Local reference documents, raw research/tool records and old coursework drafts are excluded from the initial Git tracking scope pending privacy and usage-rights review. Existing files remain untouched. Secrets, runtime data, database exports and private keys are excluded. No commit, push or resource creation is implied by local Git initialisation.

Use the existing Source of Truth and keyword map for implementation. Mobile and desktop have equal functionality. A public contact address remains unspecified; use the agreed private WordPress inbox when built rather than publishing the student email by assumption.
