"""Execute only the production pure conversion function, without private state."""
import ast
from pathlib import Path
tree=ast.parse((Path(__file__).resolve().parents[1]/'deploy/scripts/cost-guard.py').read_text())
function=next(n for n in tree.body if isinstance(n,ast.FunctionDef) and n.name=='normalize_reported_cost')
scope={};exec(compile(ast.Module(body=[function],type_ignores=[]),'<production cost units>','exec'),scope)
normalize=scope['normalize_reported_cost'];columns=['PreTaxCost','UsageDate','Currency']
assert normalize([],columns)==(0,{})
assert normalize([[3,20261009,'USD']],columns)==(3,{'USD':3})
assert normalize([[420,20261009,'INR']],columns)==(6,{'INR':420})
assert normalize([[140,1,'INR'],[140,2,'INR'],[1,2,'USD']],columns)==(5,{'INR':280,'USD':1})
for rows,factor in [([[1,1,'EUR']],70),([],0)]:
    try:normalize(rows,columns,factor)
    except ValueError:pass
    else:raise AssertionError('Unsafe currency/factor accepted')
print('PASS: six cost unit/aggregation/fail-closed cases; INR is not equated to USD.')
