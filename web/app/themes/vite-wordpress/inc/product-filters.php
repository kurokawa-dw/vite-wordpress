<?php

/**
 * 商品絞り込み用のクエリ変数を登録する。
 *
 * @param array<int, string> $query_vars 公開クエリ変数。
 * @return array<int, string>
 */
function vite_wordpress_register_product_filter_query_vars(array $query_vars): array
{
    $query_vars[] = 'product_categories';
    $query_vars[] = 'product_brands';

    return $query_vars;
}
add_filter('query_vars', 'vite_wordpress_register_product_filter_query_vars');

/**
 * 商品絞り込み用のタームスラッグを整形する。
 *
 * @param mixed $terms クエリから取得したターム。
 * @return array<int, string>
 */
function vite_wordpress_sanitize_product_filter_terms(mixed $terms): array
{
    if (!is_array($terms)) {
        $terms = $terms === null || $terms === '' ? [] : [$terms];
    }

    $sanitized_terms = array_map(
        static function (mixed $term): string {
            if (!is_scalar($term)) {
                return '';
            }

            return sanitize_title(wp_unslash((string) $term));
        },
        $terms,
    );

    return array_values(array_unique(array_filter($sanitized_terms)));
}

/**
 * 商品アーカイブのメインクエリをタクソノミーで絞り込む。
 *
 * 同一タクソノミー内は OR、異なるタクソノミー間は AND で検索する。
 */
function vite_wordpress_filter_products_archive(WP_Query $query): void
{
    if (is_admin() || !$query->is_main_query() || !$query->is_post_type_archive('products')) {
        return;
    }

    $product_categories = vite_wordpress_sanitize_product_filter_terms(
        $query->get('product_categories'),
    );
    $product_brands = vite_wordpress_sanitize_product_filter_terms(
        $query->get('product_brands'),
    );

    $query->set('product_categories', $product_categories);
    $query->set('product_brands', $product_brands);

    $tax_query = [
        'relation' => 'AND',
    ];

    if ($product_categories !== []) {
        $tax_query[] = [
            'taxonomy' => 'product_category',
            'field' => 'slug',
            'terms' => $product_categories,
            'operator' => 'IN',
            'include_children' => true,
        ];
    }

    if ($product_brands !== []) {
        $tax_query[] = [
            'taxonomy' => 'product_brand',
            'field' => 'slug',
            'terms' => $product_brands,
            'operator' => 'IN',
            'include_children' => true,
        ];
    }

    if (count($tax_query) > 1) {
        $query->set('tax_query', $tax_query);
    }
}
add_action('pre_get_posts', 'vite_wordpress_filter_products_archive');
