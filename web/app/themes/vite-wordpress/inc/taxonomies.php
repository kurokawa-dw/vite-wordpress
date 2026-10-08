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

    register_taxonomy('product_brand', ['products'], [
        'labels' => [
            'name' => 'ブランド',
            'singular_name' => 'ブランド',
            'search_items' => 'ブランドを検索',
            'all_items' => 'ブランド一覧',
            'parent_item' => '親ブランド',
            'parent_item_colon' => '親ブランド:',
            'edit_item' => 'ブランドを編集',
            'update_item' => 'ブランドを更新',
            'add_new_item' => 'ブランドを追加',
            'new_item_name' => '新しいブランド名',
            'menu_name' => 'ブランド',
        ],
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite' => [
            'slug' => 'brand',
        ],
    ]);
}

add_action('init', 'vite_wordpress_register_custom_taxonomies');
