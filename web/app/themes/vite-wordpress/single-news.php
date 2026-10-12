<?php

/**
 * News single template.
 *
 * @package ViteWordPressStarter
 */

get_header(); ?>

<main class="site-main single-news-main">
    <?php while (have_posts()): ?>
        <?php the_post(); ?>

        <article <?php post_class('single-news-entry'); ?>>
            <header class="single-news-entry__header">
                <p class="single-news-entry__date">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                </p>
                <h1 class="single-news-entry__title"><?php the_title(); ?></h1>
            </header>

            <?php if (has_post_thumbnail()): ?>
                <figure class="single-news-entry__thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </figure>
            <?php endif; ?>

            <div class="single-news-entry__content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer();
