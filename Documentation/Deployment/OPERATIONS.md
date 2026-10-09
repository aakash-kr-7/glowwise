# Glowwise operations

Updated 10 October 2026 IST. Live canonical origin: https://glowwise.tech. Initial release acceptance is recorded in ../Implementation/ACCEPTANCE_REPORT.md. The existing Azure VM is the development/runtime environment. US$10 total consumption is the lifetime authorization, including student credit.

## Secure access

From the project PowerShell directory: `ssh -F .local/deployment/ssh_config glowwise-dev`. Non-root glowwiseadmin, restricted Ed25519 key, pinned host fingerprint `SHA256:66EQ40f2ejYQUIM+1i2oH7utqO+EEch0YNkY36Z2xPg`. Root/password/keyboard-interactive SSH is disabled; sudo is available, Docker group is not granted. Recover through normal Azure Owner/Run Command access before removing an old key. Verify a changed host fingerprint independently, never disable host checking.

Private .local/deployment/CREDENTIALS.private.json contains WordPress access; root-only /srv/glowwise/private/credentials.json is the VM counterpart. Open locally, never paste into chat/Git/screenshots. No extra preview password is required. Native /wp-admin/ login remains. Only operator IPv4 /32 may reach SSH; verify a changed IP and retain recoverable access while updating the NSG:

```powershell
$env:AZURE_CONFIG_DIR = Join-Path $PWD '.local/deployment/azure-auth'
$az = Join-Path $PWD '.local/tooling/azure-cli/bin/az.cmd'
$operatorIPv4 = (Invoke-RestMethod https://api.ipify.org).Trim()
& $az network nsg rule update -g glowwise-dev-rg --nsg-name glowwise-nsg -n SSH-Operator --source-address-prefixes "$operatorIPv4/32" --output none
```

Official CLI uses normal user authentication; do not extract browser tokens. Subscription/resource identifiers and raw account outputs stay private.

## Stack, editing and routine checks

```bash
cd /srv/glowwise/source/deploy/stack
sudo docker compose ps
sudo docker compose up -d
sudo docker compose stop
sudo docker compose restart wordpress caddy
sudo docker compose run --rm -T wpcli core is-installed
sudo docker compose run --rm -T wpcli option get blog_public
sudo docker compose logs --tail=60 caddy
cd /srv/glowwise/source
sudo bash deploy/scripts/build-assets.sh
sudo bash deploy/scripts/test-assets.sh
cd deploy/stack
sudo docker compose run --rm -T wpcli eval-file /srv/glowwise/tests/core-integration.php
sudo docker compose run --rm -T wpcli eval-file /srv/glowwise/tests/import-seo-integration.php
sudo docker compose run --rm -T wpcli glowwise import /srv/glowwise/content/seed.json
sudo docker compose run --rm -T wpcli eval-file /srv/glowwise/scripts/configure-public.php
```

Pinned official WordPress Apache/PHP, MariaDB and Caddy use persistent WordPress/uploads and certificate/database volumes. Only Caddy 80/443 is public, plus restricted SSH; DB/Apache/admin API/debug tooling are not publicly mapped. Container IMDS access is blocked. Services restart unless deliberately stopped. Serialize build/backup/restore on the 1-GiB VM; no permanent Node runtime. Locked Node build is ephemeral.

Native Products facts/variants/taxonomies/source/check fields, Posts research fields, Pages and homepage Customizer are editable. Imports use stable identities/signatures, preserve later edits and blog_public; --development deliberately returns to development indexing. Review skips against a published-only export, never routinely --force. Export contains no inbox/accounts/config but review it before Git. Theme changes do not erase core catalog data.

Hourly glowwise-wordpress-cron.timer runs due WordPress events; DISABLE_WP_CRON is true. Check timer and service Result. Daily inbox expiry removes live records after 90 days while running; deallocation delays jobs. Private backups require separate manual retention review. No email notification is configured.

## Reviewed update, deployment and rollback

Back up first; preserve WordPress edits and inspect git status/diff. Fetch the supplied origin normally, review incoming changes and avoid overwriting remote/local work. No paid CI or automatic branch deployment is configured. The final publication evidence verifies all tracked blobs and VM HEAD. A reproducible credential-free transfer is a reviewed Git bundle + git archive sent via pinned SSH; fetch that bundle on VM and verify the intended commit, extract only reviewed tracked files, then associate HEAD and compare every blob. Inspect VM differences before changing HEAD; never discard owner edits. Generated dist/dependencies remain ignored and must be rebuilt on VM.

For version updates inspect official release/security notes and architecture manifests, change tag **and digest** in compose/image lock, install only reviewed plugin versions, rebuild and repeat affected checks:

```bash
cd /srv/glowwise/source/deploy/stack
sudo docker compose pull
sudo docker compose up -d
sudo docker compose ps
sudo docker compose run --rm -T wpcli core version
# Example form, substitute the reviewed pin from plugins.lock.json:
# sudo docker compose run --rm -T wpcli plugin install <slug> --version=<pin> --activate
```

Core auto-updates are disabled for image reproducibility; promptly review security releases. OS unattended security updates enabled; automatic reboot disabled. Check /var/run/reboot-required, plan controlled reboot and recheck health. Source/config rollback to a reviewed prior revision and up -d was verified through controlled Caddy fault restoration; restarts and persistence are tested. Older backups contain old noindex/auth/analytics decisions—review current production configuration before reopening a recovered site.

A database migration may require matching full recovery rather than image downgrade. Production destructive restoration needs an explicit recovery decision. Freeze writes, create/export current recovery, restore matched private source/files/secrets and SQL during maintenance, rebuild, run due retention so expired messages do not silently return, then validate before reopening. Never down -v/prune/delete disks as routine stop/update.

## DNS, HTTPS, cache and analytics

Cloudflare Free active angela/trace delegation; proxied apex A and www CNAME; Full (strict), TLS1.2 minimum/TLS1.3, HSTS/preload off. Caddy's own Let's Encrypt ACME client and persistent caddy-data automatically renew while running/reachable. **Certbot absent**; no elapsed renewal cycle is claimed. Origin certificate expires 7 January 2027; this budget does not promise operation until then.

```powershell
curl.exe --resolve glowwise.tech:443:20.249.61.80 -I https://glowwise.tech/
curl.exe -I http://glowwise.tech/
curl.exe -I https://www.glowwise.tech/
Resolve-DnsName glowwise.tech -Type NS -Server 1.1.1.1
```

Apex HTTPS should be 200; HTTP/www redirect directly to canonical HTTPS apex, preserving queries. Never -k. Inspect issuer/SAN/expiry and Caddy renewal errors. Deallocated VM cannot renew. Optional auth import and global development noindex are commented; restoring a preview requires reviewing both WordPress indexing and those lines, validating Caddy and restarting, with private credential file retained.

Yoast owns metadata/schema/sitemap; custom hooks extend one graph. Public content is indexable, utility/filter/search noindex and clean pagination self-canonical. WP Super Cache remains installed with exclusions and **page caching disabled** for private/dynamic responses. HTML/REST/admin/login/forms/shortlists stay private,no-store; CF bypass covers non-static, queries, writes and session cookies. Static CSS/JS/SVG/fonts cache safely and actual edge HIT/compression is verified. No blanket cache-everything. CSS/JS build-minified; Cloudflare Auto Minify retired.

GA4 public ID only in content/public-config.json; apply configure-public.php after review. Consent v3 requires affirmation before SDK/storage; fixed events only, sanitized page path without query/referrer/contact/search data. Enhanced measurement/ads off; 2-month retention. Reject/withdraw/reopen tested, essential tools independent. GSC sitemap fetched with zero errors, zero indexed at checkpoint; test events are not organic data.

## Private backup and isolated recovery

Run serially, preferably after reviewed deployment and before further edits:

```bash
cd /srv/glowwise/source/deploy/stack
sudo docker compose run --rm -T wpcli eval-file /srv/glowwise/scripts/updraft-backup.php
sudo python3 /srv/glowwise/source/deploy/scripts/verify-updraft.py
sudo bash /srv/glowwise/source/deploy/scripts/backup.sh
sudo python3 /srv/glowwise/source/deploy/scripts/verify-restore.py
sudo python3 /srv/glowwise/source/deploy/scripts/verify-restored-runtime.py
sudo docker compose ps
```

Actual full Updraft components: database, plugins, themes, uploads, others and optional empty mu-plugins archive; root-restricted /srv/glowwise/private/updraft mounted outside webroot. Verify ZIP integrity/checksums, restored SQL/content counts and source/asset correspondence. Infrastructure sets /srv/glowwise/backups/<UTC stamp> include SQL, full WordPress, Caddy data/config, source/private/secrets and SHA256SUMS. backup.sh briefly stops WP/Caddy for coherent files, restarts through trap; this maintenance outage is expected.

verify-restore checks selected file hashes/table counts without replacing production. verify-restored-runtime boots recovered WordPress, themes/core/database on an internal isolated container with **no host ports**, probes actual routes and removes only its disposable container/DB/extraction. DNS failover, full admin editing and restoration to another VM are not tested. Updraft and infrastructure restore are distinct evidence.

Export the latest **sorted UTC set**, not filesystem find order, through a temporary mode600 file and pinned SCP to ACL-restricted .local/deployment/recovery-stage4-2026-10-09.tar.gz; verify all five inner SHA256 entries off-VM. Earlier copies are preserved. This is restricted, not proven encrypted storage. Never publish raw recovery/credentials. Public coursework backup requires separate private clone, removal of accounts/messages/tokens/transients/keys, fresh salts/admin/config, rights review, sanitized restore test and exact owner-approved sharing; no production Drive link exists.

## Lifetime cost and eventual teardown

Azure for Students spending protection stays On. INR560 budget notifications use conservative70INR/USD (actual140/280/420/560, forecast420); delayed alerts are **not a custom US$10 hard cap**. Guard checks every15m, deallocates at max(normalized reported,modeled)≥US$6,10GiB host TX or original lease **16 October 09:31:49 IST**. Unsupported currency fails closed. Daily midnight provider shutdown is disabled for the finite launch lease; no automatic start/extension. Guard/identity outage can require manual Azure deallocation. Check timer/ledger daily:

```bash
sudo systemctl status glowwise-cost-guard.timer --no-pager
sudo journalctl -u glowwise-cost-guard.service -n 10 --no-pager
sudo python3 /srv/glowwise/source/deploy/scripts/cost-guard.py
```

```powershell
$env:AZURE_CONFIG_DIR = Join-Path $PWD '.local/deployment/azure-auth'
$az = Join-Path $PWD '.local/tooling/azure-cli/bin/az.cmd'
& $az vm deallocate -g glowwise-dev-rg -n glowwise-vm --output none
& $az vm get-instance-view -g glowwise-dev-rg -n glowwise-vm --query instanceView.statuses -o table
# Start only after fresh cost/lease review:
& $az vm start -g glowwise-dev-rg -n glowwise-vm --output none
```

Compose/guest stop is not deallocation. Retained disk/IP ≈US$.2104/day plus transactions (conservative .2304/day planning). Fallback running .5112/day; expected benefit .2304/day, benefits not deducted from fallback. Original7running+7retained+1.20traffic+2buffer ≈US$8.39. Refresh actuals (INR), modeled lifetime exposure and lag; unavailable cost/remaining credit is unknown, never zero.

Resolve retention by23October against fresh costs. **No automatic teardown/deletion.** After explicit lifecycle approval: freeze writes; create/verify/export recovery; choose DNS outage handling; deallocate/confirm; inspect exact owned resources; delete approved VM/disk/IP/network only; inspect detached disks/NIC/IP/snapshots/residual meters; remove obsolete identity/role/schedule; requery lagged usage. OS disk Detach deliberately survives VM deletion and keeps billing. Keep offline backups unless separately authorized to delete.
