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
    ?>

    <main class="site-main order-page">
        <h1 id="page-title"><?php the_title(); ?></h1>

        <?php if ($product_image): ?>
            <div>
                <?php if (is_array($product_image) && !empty($product_image['ID'])): ?>
                    <?php
                    echo wp_get_attachment_image(
                        (int) $product_image['ID'],
                        'large',
                        false,
                        ['alt' => $product_image['alt'] ?: get_the_title()]
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
    </main>
<?php endwhile; ?>

<?php get_footer();
