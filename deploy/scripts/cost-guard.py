#!/usr/bin/env python3
"""Root timer, managed identity, no persisted token; project-specific shutdown."""
import datetime as dt
import json
from pathlib import Path
import urllib.request

PRIVATE = Path('/srv/glowwise/private')
cfg = json.loads((PRIVATE / 'cost-guard.json').read_text())
now = dt.datetime.now(dt.timezone.utc)
started = dt.datetime.fromisoformat(cfg['started'])
lease = dt.datetime.fromisoformat(cfg['leaseExpires'])
elapsed_days = max(0, (now - started).total_seconds() / 86400)
# Never discount an unobserved free benefit in the safety calculation.
modeled = elapsed_days * cfg['fallbackDailyUSD']
token_url = ('http://169.254.169.254/metadata/identity/oauth2/token'
             '?api-version=2018-02-01&resource=https%3A%2F%2Fmanagement.azure.com%2F')
req = urllib.request.Request(token_url, headers={'Metadata': 'true'})
with urllib.request.urlopen(req, timeout=10) as r:
    token = json.load(r)['access_token']

def arm(path, body):
    request = urllib.request.Request('https://management.azure.com' + path,
        data=json.dumps(body).encode(), method='POST',
        headers={'Authorization': 'Bearer ' + token, 'Content-Type': 'application/json'})
    with urllib.request.urlopen(request, timeout=45) as response:
        return json.loads(response.read() or b'{}')

reported = None
try:
    result = arm('/subscriptions/' + cfg['subscriptionId'] +
        '/providers/Microsoft.CostManagement/query?api-version=2025-03-01',
        {'type': 'ActualCost', 'timeframe': 'Custom',
         'timePeriod': {'from': cfg['started'], 'to': now.isoformat()},
         'dataset': {'granularity': 'Daily',
                     'aggregation': {'totalCost': {'name': 'PreTaxCost', 'function': 'Sum'}}}})
    columns = [c['name'] for c in result['properties']['columns']]
    rows = result['properties']['rows']
    currencies = {row[columns.index('Currency')] for row in rows}
    if currencies - {'USD'}:
        raise ValueError('Unexpected billing currency: manual review required')
    reported = sum(float(row[columns.index('PreTaxCost')]) for row in rows)
except Exception as error:
    # Do not log response bodies, access tokens or private account identifiers.
    print('Cost query unavailable:', type(error).__name__, '; retail exposure model remains active')

state_file = PRIVATE / 'cost-guard-state.json'
state = json.loads(state_file.read_text()) if state_file.exists() else {}
counter_file = Path('/sys/class/net/eth0/statistics/tx_bytes')
tx = int(counter_file.read_text()) if counter_file.exists() else 0
previous = state.get('lastTx', tx)
total_tx = state.get('totalTx', 0) + (tx - previous if tx >= previous else tx)
exposure = max(modeled, reported or 0)
reason = None
if now >= lease:
    reason = 'seven-day lease expired'
elif exposure >= cfg['shutdownUSD']:
    reason = 'conservative lifetime exposure threshold reached'
elif total_tx >= cfg['txLimitBytes']:
    reason = 'development outbound traffic guard reached'
state.update({'checked': now.isoformat(), 'lastTx': tx, 'totalTx': total_tx,
              'modeledUSD': round(modeled, 4), 'reportedUSD': reported,
              'decision': reason or 'continue'})
state_file.write_text(json.dumps(state, indent=2))
state_file.chmod(0o600)
print('Cost guard:', json.dumps({k: state[k] for k in
      ['checked', 'modeledUSD', 'reportedUSD', 'totalTx', 'decision']}))
if reason:
    arm(cfg['vmId'] + '/deallocate?api-version=2024-07-01', {})
    print('Azure deallocation requested; disk/IP remain chargeable. No data deleted.')
