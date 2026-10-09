# Current lifetime cost checkpoint — 10 October 2026 IST

Actual readback **2026-10-09T21:17:31.586799+00:00**: Azure for Students Enabled, spending protection **On**, same seven resources, VM running. Provider daily shutdown Disabled for the original finite lease only. Guard modeled **US$0.3677**, lagged reported **INR 10.56099557**, conservatively normalized **US$0.15087** using70INR/USD. Host TX **535,919,823bytes**, decision continue. Remaining student-credit balance is not independently verified.

Fallback US$0.5112/running day (~US$15.55/730h month); expected benefit0.2304/day (~US$7.01/month), not deducted from fallback. Retained disk/IP0.2104/day plus transactions (0.2304 conservative planning). Original7running+7retained+1.20traffic+2buffer≈**US$8.39**. Original lease **16 October09:31:49IST**; resolve retention by23October. US$10 is TOTAL, not monthly. Model leaves about **US$9.63 nominal allowance**, not a verified spendable balance; lagged billing, traffic and retention must be reconciled.

INR560 budget notifications, US$6/max(model,normalizedreported)15m guard,10GiB TX and lease controls remain. Alerts delayed, guest/identity failure possible; daily manual review/deallocation remains necessary. No new billable resources/upgrade/card/paid monitoring, automatic deletion or lease extension. Actual budget/readback evidence and safe eventual teardown are in OPERATIONS/Stage4 index. Earlier observations below are historical, superseded by this checkpoint and billing-unit correction.

---

## Historical cost observations (preserved)

# Glowwise lifetime cost ledger

## Stage 4 billing-unit correction — 9 October 2026

Actual usage is now available in **INR**: 1.8285020806 reported for 9 October. This is lagged consumption, not the final bill. Earlier budget descriptions as US$8 were incorrect: Azure's amount uses billing currency. The existing annual budget has been corrected to INR 560, with actual 140/280/420/560 and forecast 420 notifications, using a conservative 70 INR/USD factor. Actual readback: `../References/Deployment/2026-10-09_Launch_Budget.json`. This is not a hard cap or new monthly allowance. Subscription spending protection remains unchanged.

The real guard at **16:47:48 UTC** reports fallback modeled **US$0.2719**, INR **1.8285** normalized conservatively to **US$0.02612**, 314,880,163 transmitted bytes and continue. It takes the higher model/normalized value. INR is never equated to USD; unexpected currency/response fails closed. Six conversion/aggregation/error checks pass. The reviewed 70 INR/USD floor overestimates cost compared with the approximately 96.73 rate implied by current ECB references; see LAUNCH_COST_ESTIMATE. Refresh actuals and exchange assumptions daily. Previous unavailable/zero observations remain historical.

Finite continuous launch is planned within the same original seven-full-day lease ending 16 October 04:01:49 UTC; it does not authorize indefinite hosting. Until launch, daily shutdown remains enabled. At launch it may be disabled only after the documented finite estimate and guard verification. Disk/IP retention costs and 23 October lifecycle review remain.

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

Preview-access change 2026-10-09T15:43:51.978950+00:00: existing VM/proxy only, no new resource or lease change. Latest guard snapshot 15:24:51 UTC modeled US$0.2425, reported value unavailable (null), decision continue. No zero-actual-consumption claim; existing lifetime allowance and shutdown/retained-cost controls remain.
