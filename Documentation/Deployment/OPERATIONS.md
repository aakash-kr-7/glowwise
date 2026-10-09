# Glowwise deployment operations

Updated 9 October 2026. Protected development installation at **https://glowwise.tech**. The website runs on the Azure VM; no local website server is required. Read [cost ledger](COST_LEDGER.md) before restarting or extending operation. The total authorization remains US$10 across all resources and time.

## Access and private handoff

From PowerShell in `C:\Users\aakash09\Desktop\Glowwise`:

```powershell
ssh -F .local/deployment/ssh_config glowwise-dev
```

The private config selects the non-root `glowwiseadmin` user, Ed25519 key and pinned known-hosts file. Host key fingerprint: `SHA256:66EQ40f2ejYQUIM+1i2oH7utqO+EEch0YNkY36Z2xPg`. Verify a changed fingerprint through Azure Run Command before accepting it; never disable host checking. Keep the key restricted to the owner. Root/password/keyboard-interactive SSH login is disabled; sudo is available to this administrator. The Docker group is not granted.

Open `.local/deployment/CREDENTIALS.private.json` locally to obtain the separate development Basic Auth and WordPress administrator credentials. Enter development credentials when the browser requests them, then use `/wp-admin/` for WordPress login. Do not paste this file into chat, Git, screenshots or tickets. Private credentials also exist at `/srv/glowwise/private/credentials.json`, root mode 600. The installation administrator email is private account metadata, not a public contact address. Installation used `--skip-email`.

Only the current operator IPv4 /32 may reach SSH. If the operator IP changes, refresh the rule through the already authorized Azure account; do not open port 22 globally:

```powershell
$env:AZURE_CONFIG_DIR = Join-Path $PWD '.local/deployment/azure-auth'
$az = Join-Path $PWD '.local/tooling/azure-cli/bin/az.cmd'
$operatorIPv4 = (Invoke-RestMethod https://api.ipify.org).Trim()
& $az network nsg rule update -g glowwise-dev-rg --nsg-name glowwise-nsg -n SSH-Operator --source-address-prefixes "$operatorIPv4/32" --output none
ssh -F .local/deployment/ssh_config glowwise-dev
```

Validate the returned address is the intended operator connection. Keep the old SSH session until new access works when changing credentials/policy. If the key is lost, recover through normal Azure Owner access/Run Command after verifying account ownership; install a new public key before removing the old one. Never extract browser tokens. The portable official Azure CLI uses its private config directory and normal user authentication; sign in normally if expired. Subscription/resource IDs and raw readbacks are in `.local/deployment/`, not public documents.

## Stack and VM development

On the VM:

```bash
cd /srv/glowwise/source/deploy/stack
sudo docker compose ps
sudo docker compose up -d
sudo docker compose stop
# A stopped stack still leaves the Azure VM billable.
sudo docker compose run --rm -T wpcli core is-installed
sudo docker compose run --rm -T wpcli option get blog_public
sudo docker compose logs --tail=80 caddy
```

`restart: unless-stopped` restores services after VM restart unless deliberately stopped. Database, WordPress/uploads and Caddy state persist in named volumes. MariaDB and Apache have no public port mapping; only Caddy TCP 80/443 and restricted SSH are exposed. Caddy admin API is disabled. Container access to the managed-identity metadata endpoint is blocked by a persistent Docker firewall service.

Source lives at `/srv/glowwise/source`; custom theme and core plugin locations are `theme/glowwise` and `plugins/glowwise-core`. They currently contain reserved README files, with the fresh default WordPress theme active. Implement the product in these locations during the next stage. Synchronize selected source files with `scp -F .local/deployment/ssh_config`; never sync `.local`, credentials, backups or copyrighted research into the public web root. Review diffs before replacing deployed files. Use LF endings for shell/lock files.

```bash
cd /srv/glowwise/source
bash deploy/scripts/build-assets.sh
bash deploy/scripts/collect-evidence.sh
```

Assets build on the VM using the digest-pinned ephemeral Node container and locked esbuild. There is no permanent Node development server. The fixture test passed; product assets are still absent. Serialize builds/backup/maintenance on the constrained 1-GiB VM. Never run another database/site copy concurrently just to test UI.

## Updates and rollback

Take a private backup first. Review official release/security notes and architecture manifests; change the exact tag **and digest** in `compose.yaml` and `images.lock.json`. Record package/lock changes and hashes. Pull sequentially if memory/disk are constrained, then:

```bash
cd /srv/glowwise/source/deploy/stack
sudo docker compose pull
sudo docker compose up -d
sudo docker compose ps
sudo docker compose run --rm -T wpcli core version
```

Verify WordPress, TLS, auth/noindex, private endpoints and affected functionality. Core automatic updating is disabled to keep image versions reproducible; the operator must review and install security updates promptly. Plugins are a later stage. OS unattended security updates are enabled, automatic reboot disabled; inspect `/var/run/reboot-required`, schedule a controlled `sudo reboot`, then recheck health. Last verified kernel is `7.0.0-1017-azure`; no reboot notice remained at 10:49 UTC today.

Rollback container/source configuration to the prior reviewed pins and files, then `up -d`. A core/database migration can make an image-only downgrade unsafe: restore the matched database and WordPress/config recovery set during a maintenance window instead. Do not use `docker compose down -v`, prune volumes, delete the OS disk or replace the live database as a routine rollback. Stop writes and preserve the current recovery set before a destructive restore. Restoration into production requires an explicit recovery decision and the matching private archive; credentials and ownership must be restored as well.

## TLS, DNS and cache

Cloudflare Free: active delegation to angela/trace, apex A to the origin, www CNAME to apex, both proxied, Full (strict), minimum TLS 1.2, TLS 1.3 enabled, HSTS disabled. Caddy redirects HTTP and www to HTTPS apex and uses its own Let's Encrypt ACME client. Certbot is not installed. Certificate material is private in `glowwise_caddy-data`; renewal is automatic while the VM/Caddy and challenge ports remain reachable. No future renewal cycle has elapsed or been claimed tested.

```powershell
curl.exe --resolve glowwise.tech:443:20.249.61.80 -I https://glowwise.tech/
curl.exe --resolve www.glowwise.tech:443:20.249.61.80 -I https://www.glowwise.tech/
Resolve-DnsName glowwise.tech -Type NS -Server 1.1.1.1
```

An anonymous apex request should return 401, `private, no-store` and noindex; www returns 301 to apex. Never use `-k` to hide a certificate failure. Check issuer/SAN/expiry with a certificate inspection tool and inspect Caddy logs for renewal errors. Current origin certificates expire 7 January 2027; continued hosting cannot be presumed until then under this allowance. Renewals cannot happen while deallocated. Preserve Caddy storage through updates; do not force repeated issuance unnecessarily.

Cloudflare has one active bypass rule for writes, authorization/session cookies, admin/login/REST/contact, queries and non-static paths; Standard caching and Respect Existing Headers remain selected. All development responses, including assets, currently stay private/DYNAMIC. Public static cache HIT testing belongs to the launch gate after suitable public headers are implemented. No blanket cache-everything rule exists. Product assets will be minified during VM builds because Cloudflare Auto Minify is retired.

## Backup and restore checks

```bash
sudo bash /srv/glowwise/source/deploy/scripts/backup.sh
sudo python3 /srv/glowwise/source/deploy/scripts/verify-restore.py
```

The backup script briefly stops Caddy/WordPress to obtain a coherent file/database/config set, keeps MariaDB running for the dump, then starts services via an absolute Compose path even on failure. Check `compose ps` afterwards. Sets are root-only `/srv/glowwise/backups/<UTC stamp>/`: SQL dump, WordPress volume, Caddy data/config, source/secrets/private configuration, SHA256SUMS. Restore-check directories and dependency folders are excluded from subsequent archives. The validation restores into a private directory and a temporary isolated database, compares selected counts/hashes and drops only its disposable database; it never replaces the live database. This proves infrastructure recovery, not future contact/product records or an UpdraftPlus submission bundle.

Restricted off-VM recovery copies: `.local/deployment/recovery-2026-10-09-final.tar.gz` (latest 10:55:46 UTC set), and the preserved earlier `.local/deployment/recovery-2026-10-09.tar.gz`. Verify inner checksums after every export. An owner-approved secure second location may be added later; current ACL protection does not imply encryption at rest. Do not publish this archive. Keep retention bounded and review disk space; no automatic deletion policy is installed. UpdraftPlus Free and a separately sanitized public coursework backup are still later tasks.

## Cost control, stop/start and eventual teardown

Every operation must respect the remaining lifetime allowance. Azure schedules daily deallocation at **18:30 UTC / midnight IST**, with no automatic start. Expect the site to go offline then. The root cost guard checks every 15 minutes, stops compute at US$6 conservative exposure, seven-day lease expiry (**16 October, 09:31:49 IST**) or 10-GiB measured host outbound traffic. It uses a narrowly scoped managed identity; budget/reporting outages fall back to the retail model, while identity/deallocation failure can still require manual action. Monitor timer health rather than assuming a hard provider-enforced cap.

```bash
sudo systemctl status glowwise-cost-guard.timer --no-pager
sudo journalctl -u glowwise-cost-guard.service -n 10 --no-pager
```

```powershell
$env:AZURE_CONFIG_DIR = Join-Path $PWD '.local/deployment/azure-auth'
$az = Join-Path $PWD '.local/tooling/azure-cli/bin/az.cmd'
& $az vm deallocate -g glowwise-dev-rg -n glowwise-vm --output none
& $az vm get-instance-view -g glowwise-dev-rg -n glowwise-vm --query instanceView.statuses -o table
# Restart only after refreshing cost/lease; no routine extension of the lease.
& $az vm start -g glowwise-dev-rg -n glowwise-vm --output none
```

Guest shutdown/Compose stop alone does not remove compute billing. Deallocation retains disk/IP at approximately **US$0.2104/day** plus transactions. Budget alerts are delayed and do not enforce the custom US$10 cap. Keep the original subscription spending limit On. Query cumulative ActualCost from 9 October onward and compare with elapsed-time retail exposure; update [ledger](COST_LEDGER.md) daily during active work. No annual/monthly budget reset grants another US$10.

By lease expiry review operation; before the further seven-day retention window ends (23 October) make a lifecycle decision against fresh actuals. Do not leave retained resources indefinitely. **No automatic teardown is configured or authorized.** Safe eventual teardown, once explicitly approved: freeze writes; create/verify/export final private recovery; choose the public DNS outage behavior; deallocate and confirm; review exact named resources and ownership; delete the approved VM/network/disk/IP resources only; inspect for detached disks, NICs, public IPs, snapshots and residual paid resources; remove obsolete VM identity assignments/custom role and shutdown schedule; requery usage until lagged charges settle. The OS disk uses Detach, so deleting the VM alone deliberately preserves it and does not end all charges. Keep offline backups unless their deletion is separately authorized.


## Stage 3 product operations — 9 October 2026

The theme/core and reviewed content now run in the existing source tree. Read Stage_3_2026-10-09.md and BUILD_STATE.md for exact acceptance gaps. Original Stage 2 commands above remain historical; the following product commands are current.

```bash
cd /srv/glowwise/source
sudo bash deploy/scripts/build-assets.sh
cd deploy/stack
sudo docker compose run --rm --no-deps wpcli glowwise import /srv/glowwise/content/seed.json
sudo docker compose run --rm --no-deps wpcli glowwise export > /srv/glowwise/source/content/reviewed-export.json
sudo docker compose run --rm --no-deps wpcli eval-file /srv/glowwise/tests/core-integration.php
sudo docker compose run --rm --no-deps wpcli eval-file /srv/glowwise/tests/import-seo-integration.php
sudo docker compose run --rm --no-deps wpcli eval-file /srv/glowwise/scripts/configure-cache-backup.php
sudo docker compose run --rm --no-deps wpcli eval-file /srv/glowwise/scripts/updraft-backup.php
sudo python3 /srv/glowwise/source/deploy/scripts/verify-updraft.py
sudo systemctl status glowwise-wordpress-cron.timer --no-pager
sudo systemctl show glowwise-wordpress-cron.service --property=Result
```

Do not routinely force-import: existing WordPress edits are intentionally skipped. Review a diff against the published-only export and reconcile the seed manually. No import deletes catalog records or inbox data. Native products have validated fact fields; native Posts have check-date/source/related-product fields; page bodies and homepage Customizer copy are editable. The theme stores presentation only; catalog data stays in core/WordPress.

The host timer is enabled hourly with Persistent=true and runs due events through WP-CLI, because Basic Auth blocks ordinary loopback cron. DISABLE_WP_CRON is true. Inbox expiry is a daily WordPress event, deleting expired live records after 90 days while the VM runs; deallocation delays it. Backups can retain older data and need manual retention/deletion review. Early verified deletion requests use the private administrator inbox and its WordPress deletion controls; never claim an automatic email confirmation or backup-wide deletion.

Selected plugins: Yoast 28.6, WP Super Cache 3.1.4, UpdraftPlus 1.26.8. Pins are in plugins.lock.json. Install/update exactly the reviewed version with `wp plugin install <slug> --version=<pin> --activate` after private backup, then repeat affected tests. Page caching is intentionally disabled during private development. Rejected paths include admin/login/REST, contact/corrections, finder/compare/saved and query states; rejected cookies include authenticated sessions and the form guard. Keep Cloudflare private/dynamic bypass. Public cache headers/HIT and WPSC activation are launch decisions, not current evidence.

UpdraftPlus uses `/srv/glowwise/updraft-private` in its containers, mounted from root-restricted `/srv/glowwise/private/updraft` on the VM; it is outside Apache's document root. Four file ZIPs plus a database GZIP completed and restore-checked. Raw plugin logs/archive filenames/content stay private. `verify-updraft.py` tests archive integrity/custom sources and restores into its explicitly disposable database only. Never share these raw production bundles. An eventual separately sanitized public coursework bundle still needs its exact review/approval.

The 12:51:17 UTC infrastructure recovery checkpoint and restricted `.local/deployment/recovery-stage3-2026-10-09.tar.gz` include the actual catalog/guides/inbox schema and private plugin backups. Inner checksums were verified off-VM. Source edits after that checkpoint require the final Git/source revision and a later matching recovery set; do not label an earlier archive as the latest source state. No live DB was replaced during validation.

No analytics service is enabled. Cookie controls save an inactive optional preference and support rejection/reopening/withdrawal; introducing GA4 later requires a newly disclosed consent version and valid property checks. Never include contact text, email, names or free-text search in analytics. Browser journeys remain pending the focused preview-access handoff; server checks alone do not prove browser behaviour.

Final runtime/source baseline is Git commit `791f855e6d6d7392db89769fb4c675ac1dd204bd`, pushed normally to the supplied repository. VM source has a managed Git working tree in the same directory; generated assets/dependencies remain ignored. Before updates, preserve WordPress edits with published-only export and a private backup, inspect `git status`/`git diff`, then `git fetch origin`. Review the incoming diff before a fast-forward. Do not reset over local edits or force-import content. Subsequent handoff-only commits do not alter the runtime baseline.

The matching private infrastructure set is `/srv/glowwise/backups/20261009T134856Z`, exported to restricted `.local/deployment/recovery-stage3-final-2026-10-09.tar.gz`; previous copies are preserved. Exact source/component and isolated-restore/off-VM integrity evidence are indexed. Recover configuration/files/secrets only privately; restore a reviewed matching database using the runbook above, rebuild assets, then check HTTPS/services/noindex and run due retention before reopening the installation. Expired inbox data in a restored backup must not silently return to service. Never replace the live database as part of a verification test.

## Owner-authorized open preview — 2026-10-09T15:43:51.978950+00:00

The site is now viewable directly at https://glowwise.tech without the extra Caddy password. WordPress administration still requires native login. Noindex and no-store remain; no analytics or public-cache launch switch was enabled. The optional `import /run/secrets/development-auth` line in deploy/stack/Caddyfile is commented. To restore the extra lock on a later owner decision, uncomment it, validate Caddy with `sudo docker compose exec -T caddy caddy validate --config /etc/caddy/Caddyfile`, then `sudo docker compose restart caddy` from deploy/stack. Never print the imported file. The prior config copy is root-only under /srv/glowwise/private/Caddyfile-before-preview-*. Earlier full recovery baselines contain the old active lock; review the current Caddy config before reopening a restored installation.

HTTP acceptance now defaults to anonymous public/noindex preview; use `GW_PREVIEW_LOCKED=1` only when the optional lock is actually active. Credential loading remains available for that profile, but default public checks send no Authorization header and need no credentials. New public-preview evidence is stored separately from historical authenticated Stage 3 checks.
