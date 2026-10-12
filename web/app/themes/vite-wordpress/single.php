<?php

/**
 * Single post template.
 *
 * @package ViteWordPressStarter
 */

get_header(); ?>

<main class="site-main single-post-main">
    <?php while (have_posts()): ?>
        <?php the_post(); ?>

        <article <?php post_class('single-post-entry'); ?>>
            <header class="single-post-entry__header">
                <p class="single-post-entry__date">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                </p>
                <h1 class="single-post-entry__title"><?php the_title(); ?></h1>
            </header>

            <?php if (has_post_thumbnail()): ?>
                <figure class="single-post-entry__thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </figure>
            <?php endif; ?>

            <div class="single-post-entry__content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer();
