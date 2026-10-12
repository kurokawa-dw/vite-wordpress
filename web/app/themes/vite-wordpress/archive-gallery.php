<?php

/**
 * Gallery archive template.
 *
 * @package ViteWordPressStarter
 */

get_header();

$gallery_counts = wp_count_posts('gallery');
$published_gallery_count = isset($gallery_counts->publish) ? (int) $gallery_counts->publish : 0;

$gallery_archive_url = get_post_type_archive_link('gallery');
$selected_product_categories = vite_wordpress_sanitize_product_filter_terms(
    get_query_var('product_categories', [])
);
$selected_product_type = vite_wordpress_sanitize_product_filter_terms(
    get_query_var('product_type', [])
);
$has_product_filters = $selected_product_categories !== [] || $selected_product_type !== [];

// 管理画面で設定されている product_category の term を取得
$product_category_terms = get_terms([
    'taxonomy' => 'product_category',
    'hide_empty' => true,
    'orderby' => 'name',
]);

// 管理画面で設定されている product_type の term を取得
$product_type_terms = get_terms([
    'taxonomy' => 'product_type',
    'hide_empty' => true,
    'orderby' => 'name',
]);

$product_category_terms = is_wp_error($product_category_terms) ? [] : $product_category_terms;
$product_type_terms = is_wp_error($product_type_terms) ? [] : $product_type_terms;
?>

<main class="site-main products-archive">


    <section class="products-catalogue" aria-labelledby="gallery-list-title">
        <header class="products-catalogue__header" data-products-reveal>
            <div>
                <p class="products-eyebrow">Gallery</p>
                <h2 id="gallery-list-title">ギャラリー一覧</h2>
                <?php if ($published_gallery_count > 0): ?>
                    <p class="products-hero__count">
                        <span><?php echo esc_html(sprintf('%02d', $published_gallery_count)); ?></span>
                        items in collection
                    </p>
                <?php endif; ?>
            </div>

        </header>

        <form
            class="products-filter"
            method="get"
            action="<?php echo esc_url($gallery_archive_url); ?>"
            aria-label="ギャラリーを絞り込む"
            data-products-reveal>
            <fieldset class="products-filter__group">
                <legend>商品カテゴリー</legend>
                <?php if ($product_category_terms !== []): ?>
                    <div class="products-filter__options">
                        <?php foreach ($product_category_terms as $term): ?>
                            <label class="products-filter__option">
                                <input
                                    type="checkbox"
                                    name="product_categories[]"
                                    value="<?php echo esc_attr($term->slug); ?>"
                                    <?php checked(in_array($term->slug, $selected_product_categories, true)); ?>>
                                <span><?php echo esc_html($term->name); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="products-filter__empty">選択できる商品カテゴリーはありません。</p>
                <?php endif; ?>
            </fieldset>

            <fieldset class="products-filter__group">
                <legend>タイプ</legend>
                <?php if ($product_type_terms !== []): ?>
                    <div class="products-filter__options">
                        <?php foreach ($product_type_terms as $term): ?>
                            <label class="products-filter__option">
                                <input
                                    type="checkbox"
                                    name="product_type[]"
                                    value="<?php echo esc_attr($term->slug); ?>"
                                    <?php checked(in_array($term->slug, $selected_product_type, true)); ?>>
                                <span><?php echo esc_html($term->name); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="products-filter__empty">選択できるタイプはありません。</p>
                <?php endif; ?>
            </fieldset>

            <div class="products-filter__actions">
                <button type="submit">絞り込む</button>

                <?php if ($has_product_filters): ?>
                    <a href="<?php echo esc_url($gallery_archive_url); ?>">条件をクリア</a>
                <?php endif; ?>
            </div>

            <p class="products-filter__result">
                <?php echo esc_html(sprintf('該当作品 %d件', (int) $wp_query->found_posts)); ?>
            </p>
        </form>

        <?php if (have_posts()): ?>
            <div class="products-grid">
                <?php while (have_posts()): ?>
                    <?php
                    the_post();
                    $gallery_excerpt = get_the_excerpt();
                    $gallery_image = function_exists('get_field')
                        ? get_field('product_image')
                        : null;
                    ?>
                    <article <?php post_class('product-card'); ?> data-products-reveal>
                        <a class="product-card__link" href="<?php the_permalink(); ?>">
                            <div class="product-card__media">
                                <?php if (is_array($gallery_image) && !empty($gallery_image['ID'])): ?>
                                    <?php
                                    echo wp_get_attachment_image(
                                        (int) $gallery_image['ID'],
                                        'large',
                                        false,
                                        [
                                            'class' => 'product-card__image',
                                            'loading' => 'lazy',
                                            'alt' => $gallery_image['alt'] ?: get_the_title(),
                                        ]
                                    );
                                    ?>
                                <?php elseif (has_post_thumbnail()): ?>
                                    <?php
                                    the_post_thumbnail('large', [
                                        'class' => 'product-card__image',
                                        'loading' => 'lazy',
                                    ]);
                                    ?>
                                <?php else: ?>
                                    <div class="product-card__placeholder" aria-hidden="true">
                                        <span><?php echo esc_html(sprintf('%02d', $wp_query->current_post + 1)); ?></span>
                                    </div>
                                <?php endif; ?>

                                <span class="product-card__arrow" aria-hidden="true">&#8599;</span>
                            </div>

                            <div class="product-card__body">
                                <p class="product-card__meta">
                                    <span>Gallery</span>
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date('Y.m.d')); ?>
                                    </time>
                                </p>
                                <h3><?php the_title(); ?></h3>
                                <?php if ($gallery_excerpt !== ''): ?>
                                    <p class="product-card__excerpt"><?php echo esc_html(wp_trim_words($gallery_excerpt, 42, '…')); ?></p>
                                <?php endif; ?>
                                <span class="product-card__more">詳しく見る</span>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            $pagination = paginate_links([
                'type' => 'list',
                'add_args' => array_filter([
                    'product_categories' => $selected_product_categories,
                    'product_type' => $selected_product_type,
                ]),
                'prev_text' => '<span aria-hidden="true">&#8592;</span><span class="screen-reader-text">前のページ</span>',
                'next_text' => '<span class="screen-reader-text">次のページ</span><span aria-hidden="true">&#8594;</span>',
            ]);
            ?>
            <?php if ($pagination): ?>
                <nav class="products-pagination" aria-label="ギャラリー一覧のページ送り">
                    <?php echo wp_kses_post($pagination); ?>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="products-empty" data-products-reveal>
                <span aria-hidden="true">○</span>
                <?php if ($has_product_filters): ?>
                    <h2>条件に一致する作品がありません</h2>
                    <p>商品カテゴリーまたはタイプを変更してお試しください。</p>
                    <a href="<?php echo esc_url($gallery_archive_url); ?>">すべての作品を表示</a>
                <?php else: ?>
                    <h2>ギャラリーを準備しています</h2>
                    <p>新しい作品をまもなくご紹介します。公開までしばらくお待ちください。</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>">トップページへ戻る</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
