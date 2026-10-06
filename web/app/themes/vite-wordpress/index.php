<?php

/**
 * Main template.
 *
 * @package ViteWordPressStarter
 */

get_header(); ?>

<main class="site-main">
    <section class="hero">
        <p class="hero__eyebrow">WordPress + Vite</p>
        <h1>Viteが動いています</h1>
        <p class="hero__lead">
            このカードの色や余白を <code>src/scss/main.scss</code> で変更すると、開発サーバーが即座に反映します。
        </p>
        <button class="demo-button" type="button" data-demo-button>
            JavaScriptを試す
        </button>
        <p class="demo-message" data-demo-message aria-live="polite"></p>
    </section>

    <?php if (have_posts()): ?>
        <section class="posts">
            <h2>投稿</h2>
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

<?php get_footer();
