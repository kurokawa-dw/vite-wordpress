import { cp, mkdir, rm, stat } from 'node:fs/promises';
import { spawnSync } from 'node:child_process';
import { dirname, join, relative, sep } from 'node:path';
import { fileURLToPath } from 'node:url';

const projectRoot = dirname(dirname(fileURLToPath(import.meta.url)));
const themeName = 'vite-wordpress';
const themeDirectory = join(projectRoot, 'web', 'app', 'themes', themeName);
const releaseDirectory = join(projectRoot, 'release');
const stagingDirectory = join(releaseDirectory, themeName);
const archivePath = join(releaseDirectory, `${themeName}.zip`);

const excludedNames = new Set([
  '.DS_Store',
  '.editorconfig',
  '.git',
  '.gitignore',
  '.stylelintrc',
  'README.md',
  'node_modules',
  'package-lock.json',
  'package.json',
  'pnpm-lock.yaml',
  'src',
  'vite.config.js',
  'vite.config.mjs',
  'vite.config.ts',
]);

function shouldInclude(source) {
  const relativePath = relative(themeDirectory, source);

  if (!relativePath) {
    return true;
  }

  const pathParts = relativePath.split(sep);
  const fileName = pathParts.at(-1);

  return !pathParts.some((part) => excludedNames.has(part))
    && !fileName.endsWith('.log');
}

await rm(releaseDirectory, { recursive: true, force: true });
await mkdir(releaseDirectory, { recursive: true });

await cp(themeDirectory, stagingDirectory, {
  recursive: true,
  filter: shouldInclude,
});

for (const requiredPath of [
  'style.css',
  'functions.php',
  'index.php',
  'dist/.vite/manifest.json',
]) {
  await stat(join(stagingDirectory, requiredPath));
}

const zipResult = spawnSync('zip', ['-qr', archivePath, themeName], {
  cwd: releaseDirectory,
  stdio: 'inherit',
});

if (zipResult.error) {
  throw zipResult.error;
}

if (zipResult.status !== 0) {
  throw new Error(`zip command failed with exit code ${zipResult.status}`);
}

await rm(stagingDirectory, { recursive: true, force: true });

const archive = await stat(archivePath);
const sizeInKilobytes = Math.ceil(archive.size / 1024);

console.log(`Created ${relative(projectRoot, archivePath)} (${sizeInKilobytes} KB)`);
