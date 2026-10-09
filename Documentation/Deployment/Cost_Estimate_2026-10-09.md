# Azure cost gate — 9 October 2026

Prepared before resource creation, before the successful 03:57 UTC / 09:27 IST VM creation (the earlier approximate 09:35 label was corrected during final handoff). Owner authorization: Stage 2 infrastructure, maximum **US$10 total lifetime consumption**, including student-credit consumption. This estimate is not a provider quote or a custom spending cap.

## Verified candidate

Azure for Students subscription is Enabled, Owner access works, `spendingLimit=On`. Resource inventory is empty; Cost Management ActualCost query for 1–9 October returns no usage rows; portal displays 0.00. Usage reports lag. The enforced allowed regions are Malaysia West, India South Central, Poland Central, Korea Central and Indonesia Central. Providers required for VM/network preparation were registered; no billable service was created by that action.

Selected candidate: **Korea Central, Standard_B2ats_v2, x64, 2 vCPU, 1 GiB, non-zonal**, Canonical Ubuntu 24.04 LTS Gen2 `24.04.202609040`, no paid image plan. SKU API has no restrictions for this pair; total-vCPU quota 0/6 and Basv2 quota 0/10. Actual deployment validation/capacity still must succeed. B1s is restricted here; ARM B2pts is absent from the candidate inventory. No ARM compatibility claim is needed.

One 32-GiB Standard SSD LRS OS disk, one Standard regional static IPv4, NIC, NSG, VNet/subnet. No other chargeable service selected. One GiB is a constrained development configuration: tune MariaDB/Apache, add disk-backed swap, serialize builds and verify memory/service health before acceptance. It is not a load-capacity promise.

## Itemized USD estimate

Official Retail Prices API queried today, raw responses privately retained. Monthly comparison uses 730 hours; actual billing follows the meter. Free-services panel expires **8 October 2027**, lists Linux Basv2 B2ats v2 0/750 hours. Do not assume the generic IP-hours or Premium Page Blob P6 allowance covers these chosen managed-disk/Standard-IP meters.

| Meter | Rate / assumption | Expected daily | 730-hour comparison |
|---|---|---:|---:|
| B2ats v2 Linux compute | $0.0117/hour retail; matching 750-hour benefit expected | $0 with benefit; $0.2808 fallback | $0 expected; $8.541 fallback |
| E4 LRS managed SSD, 32 GiB | $2.40/month, no disk benefit credited | $0.0789 | $2.40 |
| E4 disk mount | $0.351/month listed separately; conservatively include although applicability uncertain | $0.0115 | $0.351 |
| SSD transactions | $0.002/10,000; allowance model 100,000/day | $0.0200 | about $0.61 |
| Standard regional public IPv4 | $0.005/hour; no free match credited | $0.1200 | $3.65 |
| Internet outbound | First 100 GB retail tier $0; account also lists 15 GB free; target <=10 GB for initial window | $0 expected | $0 within allowance; $0.12/GB next tier |
| OS license, VNet, subnet, NIC, NSG, Compose, containers, Cloudflare Free | No paid image/add-on; no peering/gateway | $0 | $0 |
| Backup and logs | Bounded local/OS-disk storage, off-VM copy on existing local disk; no Azure backup account, snapshots or paid monitoring | included above | included above |

Expected baseline **$0.2304/day / $7.01 per 730 hours** including conservative transaction/mount estimates. Compute-benefit failure baseline **$0.5112/day / $15.55 per 730 hours**. Traffic/transaction spikes are variable; protected development access and conservative monitoring reduce exposure. Reserve **$1.20** for ten unexpected billable GB and **$2** additional uncertainty. No paid subscription upgrade or card is authorized.

Initial cost-control window: **seven days of operation**, then deallocate unless reviewed and explicitly extended within the same remaining allowance. Allow a further **seven days retained disk/IP** for recovery/lifecycle review. Worst modeled exposure: 7 × $0.5112 + 7 × $0.2304 + $1.20 + $2 = **$8.39**, below $10. Retained transaction rate is intentionally overestimated while deallocated. This is a finite operating plan, not permission to leave resources indefinitely. With reserves held, baseline operating runway is about **29.5 days with compute benefit**, **13.3 days without it**; actual runway must be recalculated from incurred usage and residual costs.

## Controls required before accepting the foundation

- Annual $8 budget, actual alerts at $2/$4/$6/$8 and forecast warning if supported; annual reset is not lifetime permission. Maintain a separate lifetime ledger starting today. Query actual costs daily and compare with elapsed-time retail exposure, allowing for delayed reports.
- Daily Azure deallocation schedule as a fallback for compute; no automatic restart. A seven-day operational lease must block unattended continuing compute after the initial window. Keep data recoverable. Deallocation leaves approximately **$0.2104/day** disk/mount/IP (plus any transactions); stopping inside the guest alone does not deallocate Azure compute.
- At $6 estimated lifetime exposure, stop additional spending and deallocate; at $8 operating threshold, resolve retained resources promptly using a separately approved lifecycle action. Budget alerts are delayed notifications and **do not enforce a custom $10 cap**. Preserve Azure subscription spending protection, which protects the credit limit rather than this custom project ceiling.
- Do not automatically delete the live project, disk or backups. Before the retention window ends, obtain a lifecycle decision to retain within the recalculated allowance, export and remove resources, or release the public IP while preserving an offline backup. A safe teardown runbook must list lingering disks/IP/snapshots and verify the resulting inventory.

Sources: [Retail Prices API](https://learn.microsoft.com/en-us/rest/api/cost-management/retail-prices/azure-retail-prices), [IP pricing and retained allocation](https://azure.microsoft.com/en-us/pricing/details/ip-addresses/), [spending protection](https://learn.microsoft.com/en-us/azure/cost-management-billing/manage/spending-limit), [budget delays and behavior](https://learn.microsoft.com/en-us/azure/cost-management-billing/costs/tutorial-acm-create-budgets), [auto-shutdown](https://learn.microsoft.com/en-us/azure/virtual-machines/auto-shutdown-vm). Private subscription identifiers, account email and unredacted responses are outside public Git.
