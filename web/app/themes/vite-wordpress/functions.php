<?php

/**
 * Vite WordPress Starter functions.
 *
 * @package ViteWordPressStarter
 */

if (!defined('ABSPATH')) {
    exit();
}

/**
 * テーマの初期設定。
 */
function vite_wordpress_starter_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
}
add_action('after_setup_theme', 'vite_wordpress_starter_setup');

/**
 * 現在のページで必要なViteエントリーを返す。
 *
 * 固定ページではページ階層、投稿タイプアーカイブでは投稿タイプ名と
 * src/js以下のディレクトリ階層を対応させる。
 * 例: /about/company/ -> src/js/pages/about/company/index.js
 * 例: /products/ -> src/js/archives/products/index.js
 *
 * @return array<string, string>
 */
function vite_wordpress_starter_get_entries(): array
{
    $entries = [
        'vite-wordpress-starter' => 'src/js/main.js',
    ];

    if (is_post_type_archive('products')) {
        $entries['vite-wordpress-archive-products'] = 'src/js/archives/products/index.js';

        return $entries;
    }

    if (is_post_type_archive('news')) {
        $entries['vite-wordpress-archive-news'] = 'src/js/archives/news/index.js';

        return $entries;
    }

    if (!is_page()) {
        return $entries;
    }

    $page_uri = get_page_uri(get_queried_object_id());

    if (!is_string($page_uri) || $page_uri === '') {
        return $entries;
    }

    $page_uri = trim($page_uri, '/');
    $handle = 'vite-wordpress-page-' . sanitize_title(str_replace('/', '-', $page_uri));
    $entries[$handle] = sprintf('src/js/pages/%s/index.js', $page_uri);

    return $entries;
}

/**
 * 開発時にViteサーバーからアセットを読み込む。
 *
 * @param array<string, string> $entries 読み込むViteエントリー。
 */
function vite_wordpress_starter_enqueue_development_assets(array $entries): void
{
    $vite_server = defined('VITE_DEV_SERVER')
        ? untrailingslashit(VITE_DEV_SERVER)
        : 'http://localhost:5173';

    wp_enqueue_script('vite-client', $vite_server . '/@vite/client', [], null, false);

    foreach ($entries as $handle => $entry_key) {
        if (!file_exists(get_theme_file_path($entry_key))) {
            continue;
        }

        wp_enqueue_script($handle, $vite_server . '/' . $entry_key, [], null, true);
    }
}

/**
 * 本番環境でmanifestからビルド済みアセットを読み込む。
 *
 * @param array<string, string> $entries 読み込むViteエントリー。
 */
function vite_wordpress_starter_enqueue_production_assets(array $entries): void
{
    $manifest_path = get_theme_file_path('dist/.vite/manifest.json');

    if (!file_exists($manifest_path)) {
        if (current_user_can('manage_options')) {
            add_action('wp_footer', static function (): void {
                echo '<p class="vite-build-notice">Viteのビルドファイルがありません。テーマディレクトリで <code>npm run build</code> を実行してください。</p>';
            });
        }

        return;
    }

    $manifest = json_decode((string) file_get_contents($manifest_path), true);

    if (!is_array($manifest)) {
        return;
    }

    $theme_version = wp_get_theme()->get('Version');

    foreach ($entries as $handle => $entry_key) {
        if (!isset($manifest[$entry_key]['file'])) {
            continue;
        }

        $entry = $manifest[$entry_key];

        foreach ($entry['css'] ?? [] as $index => $css_file) {
            wp_enqueue_style(
                $handle . '-style-' . $index,
                get_theme_file_uri('dist/' . $css_file),
                [],
                $theme_version,
            );
        }

        wp_enqueue_script(
            $handle,
            get_theme_file_uri('dist/' . $entry['file']),
            [],
            $theme_version,
            true,
        );
    }
}

/**
 * 開発時はViteサーバー、本番時はmanifestのアセットを読み込む。
 */
function vite_wordpress_starter_enqueue_assets(): void
{
    $entries = vite_wordpress_starter_get_entries();
    $is_local = in_array(wp_get_environment_type(), ['local', 'development'], true);

    if ($is_local) {
        vite_wordpress_starter_enqueue_development_assets($entries);

        return;
    }

    vite_wordpress_starter_enqueue_production_assets($entries);
}
add_action('wp_enqueue_scripts', 'vite_wordpress_starter_enqueue_assets');

/**
 * Viteが生成するJavaScriptをES Modulesとして読み込む。
 *
 * @param string $tag    scriptタグ。
 * @param string $handle 登録済みのハンドル。
 * @return string
 */
function vite_wordpress_starter_module_scripts(string $tag, string $handle): string
{
    if ($handle !== 'vite-client' && !str_starts_with($handle, 'vite-wordpress-')) {
        return $tag;
    }

    return str_replace('<script ', '<script type="module" ', $tag);
}
add_filter('script_loader_tag', 'vite_wordpress_starter_module_scripts', 10, 2);


require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/taxonomies.php';


function mytheme_get_company_group(string $anchor): string
{
    $content = get_post_field(
        'post_content',
        get_queried_object_id()
    );

    // error_log('$content コンテンツ:' . print_r($content, true));

    $blocks = parse_blocks((string) $content);

    foreach ($blocks as $block) {
        if (
            ($block['blockName'] ?? '') === 'core/group' &&
            ($block['attrs']['anchor'] ?? '') === $anchor
        ) {
            return render_block($block);
        }
    }

    return '';
}
