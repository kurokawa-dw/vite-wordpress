<?php

/**
 * Main template.
 *
 * @package ViteWordPressStarter
 */

get_header(); ?>

<main class="site-main">
    <div class="hero">
        viteテーマ開発サンプルトップページ（front-page.php）
    </div>

    <!-- お知らせ -->
    <section class="section section-news">
        <h2>お知らせ（カスタム投稿 news）</h2>

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

            <p class="all-view"><a href="<?php echo esc_url(get_post_type_archive_link('news')); ?>">All view →</a></p>

            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </section>



    <section class="section section-notebook">
        <h2>NoteBook（メイン投稿 post）</h2>

        <!-- トップページを固定ページとしている場合 メイン投稿もWP_Queryが必要 -->
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

            <p class="all-view"><a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>">All view →</a></p>

            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </section>


    <section class="section-contact">
        <h2>お問合せ</h2>

        <p><a href="<?php echo esc_url(home_url('/contact')) ?>">お問い合わせはこちら</a></p>
    </section>
</main>

<?php get_footer(); ?>
