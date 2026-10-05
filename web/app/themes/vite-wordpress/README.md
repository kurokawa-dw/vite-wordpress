# Vite WordPress Theme

このディレクトリが独自テーマ本体です。通常はプロジェクトルートから操作します。

```bash
pnpm dev
pnpm build
```

開発環境ではVite開発サーバーからアセットを読み込み、本番環境では `dist/.vite/manifest.json` からビルド済みアセットを読み込みます。

## 固定ページ固有のアセット

固定ページの階層と `src/js/pages` 以下のディレクトリ階層を揃えます。各 `index.js` から対応するSCSSを読み込んでください。

```text
/about/
├── src/js/pages/about/index.js
└── src/scss/pages/about/index.scss

/about/company/
├── src/js/pages/about/company/index.js
└── src/scss/pages/about/company/index.scss
```

```js
import '@scss/pages/about/index.scss';
```

ページ用のJavaScriptエントリーはViteが再帰的に検出します。WordPress側では、現在の固定ページに対応するエントリーが存在するときだけ読み込みます。
