<?php

/**
 * カスタム投稿
 */
function register_custom_post_type()
{
    register_post_type('news', [
        'labels' => [
            'name' => 'お知らせ',
            'singular_name' => 'お知らせ',
            'add_new' => '新規追加',
            'add_new_item' => 'お知らせを追加',
            'edit_item' => 'お知らせを編集',
        ],
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => [
            'title',
            'editor',
            'thumbnail'
        ],
        'menu_position' => 5,
        'menu_icon' => 'dashicons-megaphone',

        'rewrite' => [
            'slug' => 'news'
        ],
    ]);

    register_post_type('products', [
        'labels' => [
            'name' => '商品',
            'singular_name' => '商品',
            'add_new' => '新規追加',
            'add_new_item' => '商品を追加',
            'edit_item' => '商品を編集',
        ],
        'public' => true,
        'has_archive' => true,

        'supports' => [
            'title',
            'thumbnail'
        ],
        'menu_position' => 5,
        'menu_icon' => 'dashicons-megaphone',

        'rewrite' => [
            'slug' => 'products'
        ],
    ]);
}

add_action('init', 'register_custom_post_type');
