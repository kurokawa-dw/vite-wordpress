<?php

/**
 * News archive template.
 *
 * @package ViteWordPressStarter
 */

get_header();
?>

<main class="site-main news-archive">
    <?php if (have_posts()): ?>
        <section class="posts">
            <h2>Notebook（メイン投稿）</h2>
            <?php while (have_posts()): ?>
                <?php the_post(); ?>
                <article <?php post_class('post-card'); ?>>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
        </section>
    <?php endif; ?>


</main>

<?php get_footer(); ?>
