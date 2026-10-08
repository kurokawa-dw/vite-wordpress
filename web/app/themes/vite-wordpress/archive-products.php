<?php

/**
 * Products archive template.
 *
 * @package ViteWordPressStarter
 */

get_header();

$published_product_count = (int) wp_count_posts('products')->publish;
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

        <?php if (have_posts()): ?>
            <div class="products-grid">
                <?php while (have_posts()): ?>
                    <?php
                    the_post();
                    $product_excerpt = get_the_excerpt();
                    $product_image = function_exists('get_field')
                        ? get_field('product_image')
                        : get_post_meta(get_the_ID(), 'product_image', true);
                    $product_image_id = 0;
                    $product_image_url = '';
                    $product_image_alt = get_the_title();

                    if (is_array($product_image)) {
                        $product_image_id = (int) ($product_image['ID'] ?? $product_image['id'] ?? 0);
                        $product_image_url = (string) ($product_image['url'] ?? '');
                        $custom_image_alt = trim((string) ($product_image['alt'] ?? ''));

                        if ($custom_image_alt !== '') {
                            $product_image_alt = $custom_image_alt;
                        }
                    } elseif (is_numeric($product_image)) {
                        $product_image_id = (int) $product_image;
                    } elseif (is_string($product_image)) {
                        $product_image_url = $product_image;
                    }
                    ?>
                    <article <?php post_class('product-card'); ?> data-products-reveal>
                        <a class="product-card__link" href="<?php the_permalink(); ?>">
                            <div class="product-card__media">
                                <?php if ($product_image_id > 0): ?>
                                    <?php
                                    echo wp_get_attachment_image($product_image_id, 'large', false, [
                                        'class' => 'product-card__image',
                                        'loading' => 'lazy',
                                        'alt' => $product_image_alt,
                                    ]);
                                    ?>
                                <?php elseif ($product_image_url !== ''): ?>
                                    <img
                                        class="product-card__image"
                                        src="<?php echo esc_url($product_image_url); ?>"
                                        alt="<?php echo esc_attr($product_image_alt); ?>"
                                        loading="lazy"
                                    >
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
                <h2>商品を準備しています</h2>
                <p>新しい商品をまもなくご紹介します。公開までしばらくお待ちください。</p>
                <a href="<?php echo esc_url(home_url('/')); ?>">トップページへ戻る</a>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
