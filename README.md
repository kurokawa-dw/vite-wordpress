# Vite WordPress Project

WordPress本体をComposerで管理し、独自テーマのSCSSとJavaScriptをViteでビルドするプロジェクトです。構成はRoots Bedrockをベースにしています。

## ディレクトリ構成

```text
vite-wordpress/
├── config/                         # 環境別WordPress設定
├── vendor/                         # Composer依存（Git管理外）
├── web/                            # Webサーバーの公開ディレクトリ
│   ├── app/
│   │   ├── plugins/                # プラグイン
│   │   ├── uploads/                # アップロード（デプロイ間で永続化）
│   │   └── themes/
│   │       └── vite-wordpress/     # 独自テーマ
│   ├── wp/                         # WordPressコア（Composer管理）
│   └── index.php
├── .env                            # ローカル秘密情報（Git管理外）
├── .env.example                    # 環境変数の見本
├── composer.json
└── package.json                    # テーマ操作用のルートコマンド
```

## ローカル起動（MAMP）

### 1. MAMPのDocument Rootを設定

MAMPのDocument Rootを次に設定します。

```text
/Users/keiichi/Sites/_ex/vite-wordpress/web
```

Apacheのポートは `.env` に合わせて `8888`、MySQLのポートは `8889` を想定しています。異なる場合は `.env` の `WP_HOME` または `DB_HOST` を変更してください。

### 2. データベースを作成

MAMPのphpMyAdminなどで、次の空データベースを作ります。

```text
vite_wordpress
```

文字コードは `utf8mb4` を推奨します。MAMPのDBユーザー・パスワードが `root` / `root` でない場合は `.env` を変更してください。

### 3. 依存関係を復元

Composerがインストール済みの環境では、プロジェクトルートで次を実行します。

```bash
composer install
pnpm theme:install
```

この作業環境にはWordPressコア、Composer依存、テーマのpnpm依存をセットアップ済みです。

### 4. Viteを起動

```bash
pnpm dev
```

MAMPを起動して `http://localhost:8888` を開くと、初回のみWordPressのインストール画面が表示されます。Viteの `http://localhost:5173` を直接開く必要はありません。

## 本番ビルド

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
pnpm theme:install
pnpm build
```

テーマだけをWordPress管理画面やFTPでアップロードする場合は、次のコマンドでデプロイ用ZIPを生成できます。

```bash
pnpm package
```

生成先は `release/vite-wordpress.zip` です。Viteの本番ビルドを実行したうえで、`node_modules/`、`src/`、各種設定ファイルなど、本番実行に不要なファイルを自動的に除外します。

本番サーバーではDocument Rootを必ず `web/` に設定し、本番用の `.env` をサーバー上に作成します。

```dotenv
WP_ENV='production'
WP_HOME='https://example.com'
WP_SITEURL="${WP_HOME}/wp"
```

本番の `.env` には実際のDB情報と固有のSaltも設定してください。`.env`、`vendor/`、`web/wp/`、テーマの `node_modules/` と `dist/` はGit管理せず、デプロイ時にComposerとpnpmから再生成します。

## デプロイ時に永続化するもの

- データベース
- `web/app/uploads/`
- 本番サーバーの `.env`

アプリケーションコードとこれらの永続データを分けることで、リリースごとに安全にコードを入れ替えられます。

## 日常の開発

- SCSS: `web/app/themes/vite-wordpress/src/scss/main.scss`
- JavaScript: `web/app/themes/vite-wordpress/src/js/main.js`
- 固定ページ固有のアセット: `web/app/themes/vite-wordpress/src/{js,scss}/pages/{ページ階層}/index.*`
- PHPテンプレート: `web/app/themes/vite-wordpress/*.php`
- 本番アセット生成: `pnpm build`
- WordPressやComposer管理プラグインの更新: `composer update`
# vite-wordpress
