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
    <!--
    <?php
    $query = new WP_Query([
        'post_type' => 'news',
        'posts_per_page' => 3
    ]);
    ?>

    <?php if ($query->have_posts()) : ?>
        <?php while ($query->have_posts()) : ?>
            <?php $query->the_post(); ?>
            <article>
                <h3>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h3>
            </article>
        <?php endwhile; ?>
    <?php endif; ?> -->

    <!-- 複数の投稿 -->
    <!-- 通常投稿 -->
    <section>
        <h2>ブログ</h2>

        <?php
        $posts_query = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 3,
        ]);
        ?>

        <?php if ($posts_query->have_posts()) : ?>
            <?php while ($posts_query->have_posts()) : ?>
                <?php $posts_query->the_post(); ?>

                <article>
                    <h3>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                </article>

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </section>


    <!-- お知らせ -->
    <section>
        <h2>お知らせ</h2>

        <?php
        $news_query = new WP_Query([
            'post_type'      => 'news',
            'posts_per_page' => 3,
        ]);
        ?>

        <?php if ($news_query->have_posts()) : ?>
            <?php while ($news_query->have_posts()) : ?>
                <?php $news_query->the_post(); ?>

                <article>
                    <h3>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                </article>

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </section>


    <!-- 商品 -->
    <section>
        <h2>商品</h2>

        <?php
        $products_query = new WP_Query([
            'post_type'      => 'products',
            'posts_per_page' => 3,
        ]);
        ?>

        <?php if ($products_query->have_posts()) : ?>
            <?php while ($products_query->have_posts()) : ?>
                <?php $products_query->the_post(); ?>

                <article>
                    <h3>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                </article>

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </section>
    <!-- 複数の投稿 -->
</main>

<?php get_footer(); ?>
