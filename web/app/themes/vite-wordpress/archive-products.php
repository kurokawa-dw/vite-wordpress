<?php

/**
 * Products archive template.
 *
 * @package ViteWordPressStarter
 */

get_header();

$product_counts = wp_count_posts('products');

// echo '<pre>';
// print_r($product_counts);
// echo '</pre>';
$published_product_count = isset($product_counts->publish) ? (int) $product_counts->publish : 0;
$products_archive_url = get_post_type_archive_link('products');
$selected_product_category = sanitize_title((string) get_query_var('product_category'));
$selected_product_brand = sanitize_title((string) get_query_var('product_brand'));

// 「すべて」を選択した場合、wp_dropdown_categories() は 0 を送信する。
$selected_product_category = $selected_product_category === '0' ? '' : $selected_product_category;
$selected_product_brand = $selected_product_brand === '0' ? '' : $selected_product_brand;
$has_product_filters = $selected_product_category !== '' || $selected_product_brand !== '';
?>

<main class="site-main products-archive">
    <section class="products-hero" aria-labelledby="products-title">
        <div class="products-hero__copy">
            <p class="products-eyebrow">Our collection</p>
            <h1 id="products-title">Products</h1>
            <p class="products-hero__lead">日々の景色を、<br>少しだけ心地よく。</p>
        </div>

        <div class="products-hero__side">
            <p>
                素材、かたち、使い心地。ひとつひとつを丁寧に考え、
                暮らしに自然となじむプロダクトをお届けします。
            </p>
            <?php if ($published_product_count > 0): ?>
                <p class="products-hero__count">
                    <span><?php echo esc_html(sprintf('%02d', $published_product_count)); ?></span>
                    items in collection
                </p>
            <?php endif; ?>
        </div>

        <div class="products-hero__shape" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </section>

    <section class="products-catalogue" aria-labelledby="products-list-title">
        <header class="products-catalogue__header" data-products-reveal>
            <div>
                <p class="products-eyebrow">All products</p>
                <h2 id="products-list-title">商品一覧</h2>
            </div>
            <p>気になる商品を選んで、詳しい特徴をご覧ください。</p>
        </header>

        <form
            class="products-filter"
            method="get"
            action="<?php echo esc_url($products_archive_url); ?>"
            aria-label="商品を絞り込む"
            data-products-reveal
        >
            <div class="products-filter__field">
                <label for="product-category">商品カテゴリー</label>
                <?php
                wp_dropdown_categories([
                    'taxonomy' => 'product_category',
                    'name' => 'product_category',
                    'id' => 'product-category',
                    'class' => 'products-filter__select',
                    'value_field' => 'slug',
                    'selected' => $selected_product_category,
                    'show_option_all' => 'すべての商品カテゴリー',
                    'hierarchical' => true,
                    'hide_empty' => true,
                ]);
                ?>
            </div>

            <div class="products-filter__field">
                <label for="product-brand">ブランド</label>
                <?php
                wp_dropdown_categories([
                    'taxonomy' => 'product_brand',
                    'name' => 'product_brand',
                    'id' => 'product-brand',
                    'class' => 'products-filter__select',
                    'value_field' => 'slug',
                    'selected' => $selected_product_brand,
                    'show_option_all' => 'すべてのブランド',
                    'hierarchical' => true,
                    'hide_empty' => true,
                ]);
                ?>
            </div>

            <div class="products-filter__actions">
                <button type="submit">絞り込む</button>

                <?php if ($has_product_filters): ?>
                    <a href="<?php echo esc_url($products_archive_url); ?>">条件をクリア</a>
                <?php endif; ?>
            </div>

            <p class="products-filter__result">
                <?php echo esc_html(sprintf('該当商品 %d件', (int) $wp_query->found_posts)); ?>
            </p>
        </form>

        <?php if (have_posts()): ?>
            <div class="products-grid">
                <?php while (have_posts()): ?>
                    <?php
                    the_post();
                    $product_excerpt = get_the_excerpt();
                    $product_image = function_exists('get_field')
                        ? get_field('product_image')
                        : null;
                    ?>
                    <article <?php post_class('product-card'); ?> data-products-reveal>
                        <a class="product-card__link" href="<?php the_permalink(); ?>">
                            <div class="product-card__media">
                                <?php if (is_array($product_image) && !empty($product_image['ID'])): ?>
                                    <?php
                                    echo wp_get_attachment_image(
                                        (int) $product_image['ID'],
                                        'large',
                                        false,
                                        [
                                            'class' => 'product-card__image',
                                            'loading' => 'lazy',
                                            'alt' => $product_image['alt'] ?: get_the_title(),
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
                                    <span>Product</span>
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date('Y.m.d')); ?>
                                    </time>
                                </p>
                                <h3><?php the_title(); ?></h3>
                                <?php if ($product_excerpt !== ''): ?>
                                    <p class="product-card__excerpt"><?php echo esc_html(wp_trim_words($product_excerpt, 42, '…')); ?></p>
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
                    'product_category' => $selected_product_category,
                    'product_brand' => $selected_product_brand,
                ]),
                'prev_text' => '<span aria-hidden="true">&#8592;</span><span class="screen-reader-text">前のページ</span>',
                'next_text' => '<span class="screen-reader-text">次のページ</span><span aria-hidden="true">&#8594;</span>',
            ]);
            ?>
            <?php if ($pagination): ?>
                <nav class="products-pagination" aria-label="商品一覧のページ送り">
                    <?php echo wp_kses_post($pagination); ?>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="products-empty" data-products-reveal>
                <span aria-hidden="true">○</span>
                <?php if ($has_product_filters): ?>
                    <h2>条件に一致する商品がありません</h2>
                    <p>商品カテゴリーまたはブランドを変更してお試しください。</p>
                    <a href="<?php echo esc_url($products_archive_url); ?>">すべての商品を表示</a>
                <?php else: ?>
                    <h2>商品を準備しています</h2>
                    <p>新しい商品をまもなくご紹介します。公開までしばらくお待ちください。</p>
                    <a href="<?php echo esc_url(home_url('/')); ?>">トップページへ戻る</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
