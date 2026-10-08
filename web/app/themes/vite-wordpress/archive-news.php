<?php

/**
 * News archive template.
 *
 * @package ViteWordPressStarter
 */

get_header();

$news_counts = wp_count_posts('news');
$published_news_count = isset($news_counts->publish) ? (int) $news_counts->publish : 0;
?>

<main class="site-main news-archive">
    <section class="news-hero" aria-labelledby="news-title">
        <div class="news-hero__heading">
            <p class="news-eyebrow">News &amp; topics</p>
            <h1 id="news-title">News</h1>
        </div>

        <div class="news-hero__introduction">
            <p class="news-hero__lead">日々のこと、<br>新しいこと。</p>
            <p class="news-hero__description">
                私たちからの最新のお知らせや、日々の取り組みをお届けします。
            </p>
        </div>

        <div class="news-hero__decoration" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </section>

    <section class="news-index" aria-labelledby="news-list-title">
        <header class="news-index__header" data-news-reveal>
            <div>
                <p class="news-eyebrow">Latest updates</p>
                <h2 id="news-list-title">お知らせ一覧</h2>
            </div>

            <?php if ($published_news_count > 0): ?>
                <p class="news-index__count">
                    <span><?php echo esc_html(sprintf('%02d', $published_news_count)); ?></span>
                    articles
                </p>
            <?php endif; ?>
        </header>

        <?php if (have_posts()): ?>
            <div class="news-list">
                <?php while (have_posts()): ?>
                    <?php
                    the_post();
                    $news_excerpt = get_the_excerpt();
                    ?>
                    <article <?php post_class('news-card'); ?> data-news-reveal>
                        <a class="news-card__link" href="<?php the_permalink(); ?>">
                            <time class="news-card__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <span><?php echo esc_html(get_the_date('d')); ?></span>
                                <?php echo esc_html(get_the_date('Y.m')); ?>
                            </time>

                            <div class="news-card__body">
                                <p class="news-card__label">News</p>
                                <h3><?php the_title(); ?></h3>
                                <?php if ($news_excerpt !== ''): ?>
                                    <p class="news-card__excerpt"><?php echo esc_html(wp_trim_words($news_excerpt, 54, '…')); ?></p>
                                <?php endif; ?>
                            </div>

                            <span class="news-card__arrow" aria-hidden="true">
                                <svg viewBox="0 0 24 24" role="img">
                                    <path d="M5 12h13M13 6l6 6-6 6" />
                                </svg>
                            </span>
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
                <nav class="news-pagination" aria-label="お知らせ一覧のページ送り">
                    <?php echo wp_kses_post($pagination); ?>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="news-empty" data-news-reveal>
                <p class="news-empty__mark" aria-hidden="true">N</p>
                <h2>お知らせはまだありません</h2>
                <p>新しい情報はこちらでお知らせします。公開までしばらくお待ちください。</p>
                <a href="<?php echo esc_url(home_url('/')); ?>">トップページへ戻る</a>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
