import { readdirSync } from 'node:fs';
import { relative, resolve } from 'node:path';
import { defineConfig } from 'vite';
import FullReload from 'vite-plugin-full-reload';

const themeRoot = import.meta.dirname;
const pageRoot = resolve(themeRoot, 'src/js/pages');

function findJavaScriptFiles(directory) {
  return readdirSync(directory, { withFileTypes: true }).flatMap((entry) => {
    const path = resolve(directory, entry.name);

    if (entry.isDirectory()) {
      return findJavaScriptFiles(path);
    }

    return entry.name.endsWith('.js') ? [path] : [];
  });
}

const pageEntries = Object.fromEntries(
  findJavaScriptFiles(pageRoot).map((file) => {
    const name = relative(pageRoot, file)
      .replaceAll('\\', '/')
      .replace(/\/index\.js$/, '')
      .replace(/\.js$/, '')
      .replaceAll('/', '-');

    return [`page-${name}`, file];
  }),
);

export default defineConfig({
  base: './',
  resolve: {
    alias: {
      '@scss': resolve(themeRoot, 'src/scss'),
    },
  },
  plugins: [FullReload(['**/*.php'])],
  build: {
    manifest: true,
    outDir: 'dist',
    emptyOutDir: true,
    rollupOptions: {
      input: {
        main: resolve(themeRoot, 'src/js/main.js'),
        ...pageEntries,
      },
    },
  },
  server: {
    host: 'localhost',
    port: 5173,
    strictPort: true,
    cors: true,
    origin: 'http://localhost:5173',
  },
});
