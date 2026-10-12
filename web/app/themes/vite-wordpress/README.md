# Vite WordPress Theme

このディレクトリが独自テーマ本体です。通常はプロジェクトルートから操作します。

```bash
pnpm dev
pnpm build
```

開発環境ではVite開発サーバーからアセットを読み込み、本番環境では `dist/.vite/manifest.json` からビルド済みアセットを読み込みます。

## アセットの読み込み仕様

すべての画面で、共通エントリーの `src/js/main.js` を読み込みます。共通スタイルは、このJavaScriptから読み込む `src/scss/main.scss` に記述します。

```js
// src/js/main.js
import '../scss/main.scss';
```

画面固有のエントリーが存在する場合は、共通エントリーに加えて読み込みます。

| 画面                 | JavaScriptエントリー                    | SCSSの配置例                                |
| -------------------- | --------------------------------------- | ------------------------------------------- |
| 共通                 | `src/js/main.js`                        | `src/scss/main.scss`                        |
| フロントページ       | `src/js/pages/front-page/index.js`      | `src/scss/pages/front-page/index.scss`      |
| 固定ページ           | `src/js/pages/{ページ階層}/index.js`    | `src/scss/pages/{ページ階層}/index.scss`    |
| 投稿タイプアーカイブ | `src/js/archives/{投稿タイプ}/index.js` | `src/scss/archives/{投稿タイプ}/index.scss` |
| 個別投稿             | `src/js/singles/{投稿タイプ}/index.js`  | `src/scss/singles/{投稿タイプ}/index.scss`  |

各 `index.js` から、対応するSCSSをimportしてください。

```js
import '@scss/singles/products/index.scss';
```

`vite.config.js` が `pages`、`archives`、`singles` 以下のJavaScriptを再帰的に検出し、個別のビルドエントリーとして登録します。WordPress側では、現在の画面に対応するエントリーが存在する場合だけ読み込みます。対応するファイルがない場合は、共通エントリーだけが読み込まれます。

### 固定ページ

固定ページの階層と `src/js/pages` 以下のディレクトリ階層を揃えます。各 `index.js` から対応するSCSSを読み込んでください。

```text
/about/
├── src/js/pages/about/index.js
└── src/scss/pages/about/index.scss

/about/company/
├── src/js/pages/about/company/index.js
└── src/scss/pages/about/company/index.scss
```

フロントページはページスラッグにかかわらず、`src/js/pages/front-page/index.js` を読み込みます。

### 投稿タイプアーカイブ

カスタム投稿タイプのアーカイブでは、`src/js/archives/{投稿タイプ名}/index.js` から対応するSCSSを読み込みます。

```text
/products/
├── src/js/archives/products/index.js
└── src/scss/archives/products/index.scss
```

現在、`products` と `gallery` のアーカイブはどちらも `archives/products` エントリーを使用します。`news` は `archives/news` エントリーを使用します。新しい投稿タイプのアーカイブを追加する場合は、アセットの作成に加えて `vite_wordpress_starter_get_entries()` に判定を追加してください。

### 個別投稿

個別投稿では、`src/js/singles/{投稿タイプ名}/index.js` から対応するSCSSを読み込みます。通常投稿の投稿タイプ名は `post` です。

```text
/products/{投稿スラッグ}/
├── src/js/singles/products/index.js
└── src/scss/singles/products/index.scss
```

WordPressテンプレートとアセットの対応例は次のとおりです。

| WordPressテンプレート | 投稿タイプ | 固有エントリー                     |
| --------------------- | ---------- | ---------------------------------- |
| `single.php`          | `post`     | `src/js/singles/post/index.js`     |
| `single-products.php` | `products` | `src/js/singles/products/index.js` |
| `single-news.php`     | `news`     | `src/js/singles/news/index.js`     |

現在のテーマには `single-products.php` と `singles/products` エントリーがあります。`single.php` はまだないため、通常投稿の表示はWordPressのテンプレート階層に従って `index.php` にフォールバックします。アセットの判定は使用されたPHPテンプレート名ではなく、表示中の投稿タイプを基準に行います。

## 新しい画面固有アセットの追加手順

例として、`news` の個別投稿用アセットを追加する場合は、次の2ファイルを作成します。

```text
src/js/singles/news/index.js
src/scss/singles/news/index.scss
```

JavaScriptからSCSSをimportします。

```js
// src/js/singles/news/index.js
import '@scss/singles/news/index.scss';
```

追加後に `pnpm dev` を再起動するか、`pnpm build` を実行してください。PHP側への投稿タイプごとの追記は不要です。

## 開発環境と本番環境

### 開発環境

`WP_ENV` が `local` または `development` の場合は、Vite開発サーバーから読み込みます。

- Viteクライアント: `http://localhost:5173/@vite/client`
- JavaScript: `http://localhost:5173/src/js/.../index.js`
- CSS: JavaScriptのSCSS importをViteがブラウザへ反映
- PHPテンプレート変更: フルリロード

Vite開発サーバーのURLは、`VITE_DEV_SERVER` 定数で変更できます。

### 本番環境

`dist/.vite/manifest.json` を参照し、ハッシュ付きのビルド済みJS・CSSを読み込みます。デプロイ前に必ず次を実行してください。

```bash
pnpm build
```

Viteが生成するJavaScriptは、開発・本番ともに `type="module"` で読み込まれます。

ルートにある `style.css` はWordPressがテーマとして認識するためのメタデータ用です。実際の共通スタイルは `src/scss/main.scss` に記述し、`style.css` 自体はフロント画面へenqueueしていません。
