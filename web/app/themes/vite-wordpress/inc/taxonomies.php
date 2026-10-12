<?php

/**
 * カスタムタクソノミー
 */
function vite_wordpress_register_custom_taxonomies(): void
{
    register_taxonomy('product_category', ['products'], [
        'labels' => [
            'name' => '商品カテゴリー',
            'singular_name' => '商品カテゴリー',
            'search_items' => '商品カテゴリーを検索',
            'all_items' => '商品カテゴリー一覧',
            'parent_item' => '親の商品カテゴリー',
            'parent_item_colon' => '親の商品カテゴリー:',
            'edit_item' => '商品カテゴリーを編集',
            'update_item' => '商品カテゴリーを更新',
            'add_new_item' => '商品カテゴリーを追加',
            'new_item_name' => '新しい商品カテゴリー名',
            'menu_name' => '商品カテゴリー',
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite' => [
            'slug' => 'product-category',
        ],
    ]);

    register_taxonomy('product_type', ['products'], [
        'labels' => [
            'name' => '商品タイプ',
            'singular_name' => '商品タイプ',
            'search_items' => '商品タイプを検索',
            'all_items' => '商品タイプ一覧',
            'parent_item' => '親商品タイプ',
            'parent_item_colon' => '親商品タイプ:',
            'edit_item' => '商品タイプを編集',
            'update_item' => '商品タイプを更新',
            'add_new_item' => '商品タイプを追加',
            'new_item_name' => '新しい商品タイプ名',
            'menu_name' => '商品タイプ',
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite' => [
            'slug' => 'product-type',
        ],
    ]);
}

add_action('init', 'vite_wordpress_register_custom_taxonomies');
