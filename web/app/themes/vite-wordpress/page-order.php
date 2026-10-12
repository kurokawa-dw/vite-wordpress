<?php

/**
 * Company page template.
 *
 * @package ViteWordPressStarter
 */

get_header(); ?>

<?php while (have_posts()): ?>
    <?php the_post(); ?>

    <main class="site-main order-page">
        <h1 id="page-title"><?php the_title(); ?>固定ページ（page-order.php）</h1>
    </main>
<?php endwhile; ?>

<?php get_footer();
