<?php

/**
 * Company page template.
 *
 * @package ViteWordPressStarter
 */

get_header(); ?>

<?php while (have_posts()): ?>
    <?php
    the_post();

    $product_image = function_exists('get_field')
        ? get_field('product_image')
        : get_post_meta(get_the_ID(), 'product_image', true);
    $product_description = function_exists('get_field')
        ? get_field('product_discription')
        : get_post_meta(get_the_ID(), 'product_discription', true);
    $product_price = function_exists('get_field')
        ? get_field('prodcut_price')
        : get_post_meta(get_the_ID(), 'prodcut_price', true);
    $normalized_product_price = str_replace(',', '', (string) $product_price);
    $formatted_product_price = is_numeric($normalized_product_price)
        ? number_format_i18n((float) $normalized_product_price)
        : $product_price;
    $product_type_terms = get_the_terms(get_the_ID(), 'product_type');
    $product_type_terms = is_array($product_type_terms) ? $product_type_terms : [];
    $product_type_ids = array_map(
        static fn(WP_Term $term): int => $term->term_id,
        $product_type_terms,
    );
    $related_gallery_query = null;

    if ($product_type_ids !== []) {
        $related_gallery_query = new WP_Query([
            'post_type' => 'gallery',
            'post_status' => 'publish',
            'posts_per_page' => 6,
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
            'tax_query' => [
                [
                    'taxonomy' => 'product_type',
                    'field' => 'term_id',
                    'terms' => $product_type_ids,
                    'include_children' => false,
                ],
            ],
        ]);
    }
    ?>

    <main class="site-main">
        <h1 id="page-title"><?php the_title(); ?></h1>

        <?php if ($product_image): ?>
            <div>
                <?php if (is_array($product_image) && !empty($product_image['ID'])): ?>
                    <?php
                    echo wp_get_attachment_image(
                        (int) $product_image['ID'],
                        'large',
                        false,
                        ['alt' => $product_image['alt'] ?: get_the_title()],
                    );
                    ?>
                <?php elseif (is_numeric($product_image)): ?>
                    <?php echo wp_get_attachment_image((int) $product_image, 'large'); ?>
                <?php elseif (is_string($product_image)): ?>
                    <img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($product_description): ?>
            <div>
                <?php echo wp_kses_post($product_description); ?>
            </div>
        <?php endif; ?>

        <?php if ($product_price !== '' && $product_price !== null && $product_price !== false): ?>
            <p>価格：<?php echo esc_html($formatted_product_price); ?></p>
        <?php endif; ?>

        <div>
            <?php the_content(); ?>
        </div>

        <!-- カスタム投稿galleryにメインクエリと同一の product_type があれば表示 -->
        <?php if ($related_gallery_query instanceof WP_Query && $related_gallery_query->have_posts()): ?>
            <?php
            $gallery_archive_url = get_post_type_archive_link('gallery');
            $gallery_archive_url = is_string($gallery_archive_url)
                ? $gallery_archive_url
                : home_url('/gallery/');
            $filtered_gallery_url = add_query_arg(
                ['product_type' => wp_list_pluck($product_type_terms, 'slug')],
                $gallery_archive_url,
            );
            ?>
            <section class="related-gallery" aria-labelledby="related-gallery-title">
                <header class="related-gallery__header">
                    <div>
                        <p class="related-gallery__eyebrow">Gallery</p>
                        <h2 id="related-gallery-title">関連ギャラリー</h2>
                    </div>
                    <a href="<?php echo esc_url($filtered_gallery_url); ?>">同じタイプの作品をすべて見る</a>
                </header>

                <div class="products-grid">
                    <?php while ($related_gallery_query->have_posts()): ?>
                        <?php
                        $related_gallery_query->the_post();
                        $gallery_excerpt = get_the_excerpt();
                        $gallery_image = function_exists('get_field')
                            ? get_field('product_image')
                            : get_post_meta(get_the_ID(), 'product_image', true);
                        ?>
                        <article <?php post_class('product-card'); ?>>
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
                                                'alt' => $gallery_image['alt'] ?? get_the_title(),
                                            ],
                                        );
                                        ?>
                                    <?php elseif (is_numeric($gallery_image)): ?>
                                        <?php
                                        echo wp_get_attachment_image(
                                            (int) $gallery_image,
                                            'large',
                                            false,
                                            [
                                                'class' => 'product-card__image',
                                                'loading' => 'lazy',
                                            ],
                                        );
                                        ?>
                                    <?php elseif (is_string($gallery_image) && $gallery_image !== ''): ?>
                                        <img
                                            class="product-card__image"
                                            src="<?php echo esc_url($gallery_image); ?>"
                                            alt="<?php echo esc_attr(get_the_title()); ?>"
                                            loading="lazy">
                                    <?php elseif (has_post_thumbnail()): ?>
                                        <?php
                                        the_post_thumbnail('large', [
                                            'class' => 'product-card__image',
                                            'loading' => 'lazy',
                                        ]);
                                        ?>
                                    <?php else: ?>
                                        <div class="product-card__placeholder" aria-hidden="true">
                                            <span><?php echo esc_html(sprintf('%02d', $related_gallery_query->current_post + 1)); ?></span>
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
            </section>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </main>
<?php endwhile; ?>

<?php get_footer();
