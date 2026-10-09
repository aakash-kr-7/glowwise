# Stage 1 access observations

9 October 2026, Asia/Calcutta. Read-only checks made during the Stage 1 session (initial provider/DNS checks approximately 08:45–08:52 IST; Resources view confirmed again before finalization). This is a sanitized observation record, not a credential archive. Private account, tenant and subscription identifiers are intentionally omitted. Refresh these facts before execution.

| ID | Surface and check | Current observation | Limit / next use |
|---|---|---|---|
| A01 | Local `git status --short --branch`, remote and log | Initialized `main`, no commits; origin `https://github.com/aakash-kr-7/glowwise`. Supplied files untracked. | No commit, staging or push performed. Recheck before publication. |
| A02 | Rediscovered GitHub connector: profile, repository permissions, branches | Authenticated as `aakash-kr-7`; `glowwise` is public, size 0, default main, admin/push permission; branch query returns an empty list. | Working connector access is independent of local CLI credentials. No repository changes made. |
| A03 | Local `gh auth status`; `git ls-remote origin` | CLI check attempts a different account (`aakashkr07`) and times out. Remote lookup fails with “Could not resolve host: github.com”. | Current test does not prove expired credentials. Earlier invalid-token finding remains historical. Do not assume CLI push works or print tokens. |
| A04 | Available tool/command discovery | No callable Azure or Cloudflare connector discovered; Azure CLI absent from PATH. SSH and gh commands exist. | Use authenticated browser for preparation; choose a working deployment interface next stage. No plugin installation attempted. |
| A05 | Azure portal, subscription overview | Existing signed-in session; Azure for Students Active, role Owner; displayed current cost and forecast 0.00. | Display may lag. Actual spending-protection switch, chosen configuration and lifetime exposure not verified. No upgrade/action selected. |
| A06 | Azure subscription Resources, all resource-group/type/location filters | 0 results; overview also showed no resources. | No VM exists in this subscription view at inspection. No creation or capacity selection this stage. |
| A07 | Azure Free services panel | Linux B1s, B2ats v2, B2pts v2 each 0/750 hours; P6 disk 0/2.2 per month as displayed; public IP 0/1,500 hours; outbound data 0/15 GB. Free-service expiry displayed 8 October 2027. | Benefits are not a deployable-price guarantee. Disk/IP SKU matching and exact billing terms remain open. Panel warns recent usage may be inaccurate. |
| A08 | `Resolve-DnsName glowwise.tech -Type NS -Server 1.1.1.1` and same with 8.8.8.8 | Both return `angela.ns.cloudflare.com` and `trace.ns.cloudflare.com`; observed NS TTLs 86,400 and 21,600 seconds respectively. | Confirms public resolver delegation, not every resolver or authenticated zone status. |
| A09 | Apex A query through 1.1.1.1 | No A answer; Cloudflare SOA returned (`dns.cloudflare.com`, serial 2417000680). | No live origin or HTTP/TLS behavior established. No DNS record modified. |
| A10 | Cloudflare dashboard in in-app browser | Sign-in page; no authenticated dashboard session established. | Zone Active status, plan, records, DNSSEC, edge certificate, Full (strict) and cache settings unverified. Owner sign-in is needed before those actions. |
| A11 | Rediscovered Ubersuggest authentication tool | Authenticated on free tier. | No SEO report invoked and no report credits intentionally consumed. Current report capacity/competitor exports not tested. Private account email omitted. Historical research metrics remain dated. |

## Historical record and stage boundary

`Readiness_2026-10-09.md` is preserved byte-for-byte. Its earlier Cloudflare Pending, local GitHub credential failure, no VM and bounded SKU failures describe that earlier inspection. Public NS now resolve to Cloudflare, but dashboard activation remains unknown. Prior B2ats v2 unavailability in Central India, Southeast Asia and East US 2, plus the recorded B1s/security-profile check, must not become a claim of global unavailability.

The old strict zero-consumption and local-runtime assumptions are superseded by Source of Truth v1.1 and the owner's current instructions. Tool access is not resource-creation or publication evidence. No billable resource, account upgrade, paid plugin/API report, website development runtime, certificate, deployment, commit or push was performed in Stage 1.
