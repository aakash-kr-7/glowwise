import { build, transform, version } from 'esbuild';
import { readdir, mkdir, writeFile } from 'node:fs/promises';
import { join, extname } from 'node:path';
import { createHash } from 'node:crypto';

if (process.argv.includes('--verify')) {
  for (const [loader, source] of [
    ['js', 'const label = "Glowwise"; console.log(label);\n'],
    ['css', '.glowwise { color: #ffffff; margin: 0px 0px 0px 0px; }\n'],
  ]) {
    const result = await transform(source, { loader, minify: true, target: 'es2020' });
    if (result.code.length >= source.length) throw new Error(`No ${loader} reduction`);
    console.log(`${loader}: ${source.length} -> ${result.code.length} bytes; esbuild ${version}`);
  }
} else {
  const input = 'theme/glowwise/assets/src';
  const output = 'theme/glowwise/assets/dist';
  let files;
  try { files = await readdir(input); }
  catch (error) {
    if (error.code !== 'ENOENT') throw error;
    console.log('No product assets yet; source location reserved.');
    process.exit(0);
  }
  await mkdir(output, { recursive: true });
  const entries = files.filter(f => ['.js', '.css'].includes(extname(f)));
  if (!entries.length) throw new Error('Asset source directory has no JS/CSS entries');
  const result = await build({ entryPoints: entries.map(f => join(input, f)),
    bundle: true, minify: true, target: 'es2020', outdir: output,
    entryNames: '[name].[hash]', assetNames: '[name].[hash]', metafile: true,
    sourcemap: false, legalComments: 'eof', loader: {'.woff2':'file'}, write: true });
  const manifest = Object.fromEntries(Object.entries(result.metafile.outputs)
    .filter(([, info]) => info.entryPoint)
    .map(([file, info]) => [info.entryPoint, file]));
  // Preload exactly the files referenced by compiled CSS, avoiding duplicate fonts.
  for (const [file, info] of Object.entries(result.metafile.outputs)) {
    if (extname(file) === '.woff2') {
      const source = Object.keys(info.inputs)[0];
      if (source) manifest[source] = file;
    }
  }
  await writeFile(join(output, 'manifest.json'), JSON.stringify(manifest, null, 2) + '\n');
  console.log(`Built ${entries.length} entries with esbuild ${version}; manifest ` +
    createHash('sha256').update(JSON.stringify(manifest)).digest('hex'));
}
