# Glowwise lifetime cost ledger

Updated 9 October 2026, approximately 11:00 UTC / 16:30 IST. **US$10 TOTAL**, including consumption covered by Azure student credit. No monthly reset, subscription upgrade, card or new allowance is authorized. This ledger must continue across later stages.

| Observation | Amount / implication |
|---|---|
| Before resources | ActualCost query had no usage rows; portal 0.00. Spending limit On. |
| Resource creation | 9 October, approximately 03:57 UTC; named network resources existed shortly beforehand during a rejected Standard-security attempt. Final VM Trusted Launch succeeded. |
| Latest ActualCost readback, 9 October ~10:50 UTC | No usage rows yet, reported aggregate US$0.00. This is delayed reporting, **not zero incurred consumption**. Query includes subscription usage and does not hide any other resource costs. |
| Guard at 10:50:33 UTC | Conservative model US$0.1451 since 04:01:49 UTC, reported US$0, measured outbound 35,199,615 bytes; decision continue. |
| Planning exposure at ~11:00 UTC | About US$0.15 retail fallback, plus the small earlier IP-allocation interval and unreported variable operations/traffic. Hold the original US$3.20 reserves; do not spend the nominal US$9.85 as confirmed balance. |
| Expected steady state | US$0.2304/day / US$7.01 per 730 hours with the expected compute benefit. |
| Fallback steady state | US$0.5112/day / US$15.55 per 730 hours without compute benefit. |
| Deallocated retention | US$0.2104/day disk/mount/IPv4 plus transactions. Deallocation does not stop every meter. |
| Initial finite plan | Seven operating days + seven retained days + US$1.20 traffic and US$2 uncertainty = US$8.39 worst modeled exposure. |

Rates/benefit assumptions and line items are in [pre-creation estimate](Cost_Estimate_2026-10-09.md). Free-services panel matched Linux Basv2 B2ats v2 750 hours, expiring 8 October 2027; no managed-disk/Standard-IP benefit was assumed. Recheck actual meter usage as it arrives. The region and 1-GiB limits are appropriate to protected initial development with swap/tuning; an upgrade is not silently authorized.

## Active controls and checkpoints

- Subscription spending protection **On** protects the subscription credit boundary; it is not a configurable project US$10 limit.
- `glowwise-total-guard`: annual US$8 budget, actual alerts at US$2/4/6/8 and forecast US$6 to the private subscription-account recipient. Annual period does not grant future spend. Alert delivery has not been triggered/tested at a real threshold.
- Provider schedule enabled: deallocate `glowwise-vm` daily **18:30 UTC / midnight IST**, no automatic start. Site goes offline after deallocation.
- Root timer enabled: every 15 minutes, managed identity Cost Management Reader plus self-deallocation only for this VM. Checks use the higher of reported subscription cost and fallback elapsed-time exposure, without discounting unobserved free benefits. **US$6** exposure, **10 GiB** measured host outbound, or **16 October 2026, 09:31:49 IST** lease expiry requests deallocation. Timer/identity cost read operation succeeded; reaching a threshold/deallocation was not artificially forced. The measured-traffic counter is a guard, not the Azure billable-egress meter; initial transfers and reboot intervals can be undercounted. The reserve is still needed.
- Check daily during work: timer failures, ActualCost and free-meter usage, elapsed exposure, retained resource inventory and disk space. Account queries/notification recipients/IDs stay in `.local/deployment/`. Guard state is `/srv/glowwise/private/cost-guard-state.json`; never publish its private configuration.
- Review by **16 October** before any operation beyond the initial lease. Before the further retention window ends **23 October**, decide whether to export/remove resources or retain within a fresh estimate of the same remaining allowance. These dates derive from the chosen seven-day windows, not invented coursework deadlines.
- At US$6, stop new spending and deallocate; at US$8, resolve retained-cost exposure promptly with a separately approved lifecycle action. Do not wait for lagged email alerts to enforce these actions. Never leave disk/IP indefinitely.

No automatic deletion of VM, disk, IP or backups is installed. Monitoring/identity/API outages can impair guest controls; provider shutdown is a fallback and manual review remains required. A strict custom hard cap cannot be asserted. The modeled finite window fits the owner ceiling with a conservative buffer, and preserving spending protection avoids an open paid-subscription exposure. [Budget behavior](https://learn.microsoft.com/en-us/azure/cost-management-billing/costs/tutorial-acm-create-budgets), [subscription spending limit](https://learn.microsoft.com/en-us/azure/cost-management-billing/manage/spending-limit), [public-IP charges](https://azure.microsoft.com/en-us/pricing/details/ip-addresses/).

## How to append the next entry

Record UTC time, cumulative actual consumption since creation, billing currency, any reporting lag, current resources/benefit usage, modeled missing exposure, buffer, planned run + retained duration and decision. Use USD; investigate a changed currency rather than equating it to USD. Do not subtract student credits from consumption. Do not overwrite this initial history or count a budget reset as new permission. Before restart, check the lease and remaining forecast. Stop/start and eventual teardown procedure are in [operations](OPERATIONS.md).

## Stage 3 observation — 2026-10-09T12:52:59.335928+00:00

Existing guard reports modeled US$0.1886, reported US$0 and measured total outbound 84993816 bytes. This is a positive fallback estimate; delayed reported zero is not a zero-consumption claim. No new Azure resource, SKU upgrade, lease extension, paid monitoring or subscription upgrade occurred. Current stack development, source builds/tests and private recovery fit the original finite plan and reserves. Daily deallocation, US$6 guard, 16 October lease and 23 October retention-review decision remain unchanged. Disk/IP continue billing while deallocated.

Stage 3 refresh: 9 October 2026 13:23:32 UTC guard modeled **US$0.1994**, delayed Azure feed **US$0**, host transmitted **164,730,548 bytes** including the checkpoint recovery export. Same resources, daily shutdown/lease and continuing deallocated disk/IP meters; no new allowance or extension. Subsequent final recovery traffic must be included in the next snapshot.

Final Stage 3 refresh: **2026-10-09T13:51:58.321332+00:00**, modeled cumulative **US$0.2095**, delayed reported **US$0**, transmitted **277,096,560 bytes** including the final 107 MB private recovery export. Guard decision continue; no additional resource/subscription/lease change. Remaining allowance is conservatively US$9.7905 against the model, not a guaranteed bill balance. The original US$8.39 fallback finite plan remains the planning ceiling; existing shutdown/guard/retained-cost lifecycle requirements still apply.
