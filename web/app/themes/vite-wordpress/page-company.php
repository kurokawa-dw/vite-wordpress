<?php

/**
 * Company page template.
 *
 * @package ViteWordPressStarter
 */

get_header(); ?>

<?php while (have_posts()): ?>
    <?php the_post(); ?>

    <main class="site-main company-page">
        <section class="company-hero" aria-labelledby="company-title">
            <div class="company-hero__content">
                <p class="company-section-label">Company</p>
                <h1 id="company-title"><?php the_title(); ?></h1>
                <p class="company-hero__lead">
                    アイデアとテクノロジーで、<br>
                    暮らしの「あたりまえ」を心地よく。
                </p>
                <p class="company-hero__description">
                    私たちは、デジタルの力で人と社会の課題に向き合い、
                    使う人の毎日に自然となじむサービスをつくる会社です。
                </p>
            </div>
            <div class="company-hero__decoration" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </section>

        <nav class="company-local-nav" aria-label="会社紹介ページ内メニュー">
            <a href="#philosophy">企業理念</a>
            <a href="#business">事業内容</a>
            <a href="#profile">会社概要</a>
            <a href="#history">沿革</a>
            <a href="#access">アクセス</a>
        </nav>

        <section id="philosophy" class="company-section company-philosophy" data-company-reveal>
            <div class="company-section__heading">
                <p class="company-section-label">Philosophy</p>
                <h2>企業理念</h2>
            </div>
            <div class="company-philosophy__body">
                <p class="company-philosophy__statement">小さな気づきから、<br>大きな変化をつくる。</p>
                <p>
                    一人ひとりの声に耳を傾け、まだ言葉になっていない課題を見つけること。
                    私たちは、誠実な対話と柔軟な発想を大切にしながら、
                    長く愛される価値を社会へ届けていきます。
                </p>
            </div>
        </section>

        <section id="business" class="company-section" data-company-reveal>
            <div class="company-section__heading">
                <p class="company-section-label">Business</p>
                <h2>事業内容</h2>
            </div>
            <div class="company-business-grid">
                <article class="company-business-card">
                    <p class="company-business-card__number">01</p>
                    <h3>デジタルプロダクト開発</h3>
                    <p>Webサイトや業務システム、アプリケーションの企画・設計・開発を一貫して支援します。</p>
                </article>
                <article class="company-business-card">
                    <p class="company-business-card__number">02</p>
                    <h3>ブランドデザイン</h3>
                    <p>企業やサービスの想いを整理し、ロゴ、グラフィック、Webを通じて一貫した体験を設計します。</p>
                </article>
                <article class="company-business-card">
                    <p class="company-business-card__number">03</p>
                    <h3>事業成長サポート</h3>
                    <p>データ分析と伴走型の改善提案により、サービスの継続的な成長をサポートします。</p>
                </article>
            </div>
        </section>

        <section class="company-numbers" aria-labelledby="company-numbers-title" data-company-reveal>
            <div class="company-section__heading">
                <p class="company-section-label">Numbers</p>
                <h2 id="company-numbers-title">数字で見る私たち</h2>
            </div>
            <dl class="company-numbers__list">
                <div>
                    <dt>創業</dt>
                    <dd><span data-company-count="2014">2014</span><small>年</small></dd>
                </div>
                <div>
                    <dt>プロジェクト実績</dt>
                    <dd><span data-company-count="320">320</span><small>件以上</small></dd>
                </div>
                <div>
                    <dt>メンバー</dt>
                    <dd><span data-company-count="48">48</span><small>名</small></dd>
                </div>
                <div>
                    <dt>継続取引率</dt>
                    <dd><span data-company-count="92">92</span><small>%</small></dd>
                </div>
            </dl>
            <p class="company-numbers__note">※ 数値はサンプルです。</p>
        </section>

        <section id="profile" class="company-section" data-company-reveal>
            <div class="company-section__heading">
                <p class="company-section-label">Profile</p>
                <h2>会社概要</h2>
            </div>
            <div class="company-profile">
                <dl>
                    <div>
                        <dt>会社名</dt>
                        <dd>株式会社サンプルクリエイティブ</dd>
                    </div>
                    <div>
                        <dt>英文社名</dt>
                        <dd>Sample Creative Inc.</dd>
                    </div>
                    <div>
                        <dt>設立</dt>
                        <dd>2014年4月1日</dd>
                    </div>
                    <div>
                        <dt>代表者</dt>
                        <dd>代表取締役　山田 太郎</dd>
                    </div>
                    <div>
                        <dt>資本金</dt>
                        <dd>1,000万円</dd>
                    </div>
                    <div>
                        <dt>従業員数</dt>
                        <dd>48名（2026年4月現在）</dd>
                    </div>
                    <div>
                        <dt>事業内容</dt>
                        <dd>デジタルプロダクト開発、ブランドデザイン、事業成長支援</dd>
                    </div>
                    <div>
                        <dt>所在地</dt>
                        <dd>〒100-0005 東京都千代田区丸の内1-1-1 サンプルビル8F</dd>
                    </div>
                </dl>
            </div>
        </section>

        <section id="history" class="company-section" data-company-reveal>
            <div class="company-section__heading">
                <p class="company-section-label">History</p>
                <h2>沿革</h2>
            </div>
            <ol class="company-history">
                <li>
                    <time datetime="2014-04">2014.04</time>
                    <p>東京都渋谷区に株式会社サンプルクリエイティブを設立</p>
                </li>
                <li>
                    <time datetime="2017-09">2017.09</time>
                    <p>デジタルプロダクト開発事業を開始</p>
                </li>
                <li>
                    <time datetime="2020-06">2020.06</time>
                    <p>事業拡大に伴い、本社を東京都千代田区へ移転</p>
                </li>
                <li>
                    <time datetime="2023-11">2023.11</time>
                    <p>プロジェクト実績300件を達成</p>
                </li>
                <li>
                    <time datetime="2026-04">2026.04</time>
                    <p>ブランドメッセージを刷新し、新たな事業方針を発表</p>
                </li>
            </ol>
        </section>

        <section id="access" class="company-section company-access" data-company-reveal>
            <div class="company-section__heading">
                <p class="company-section-label">Access</p>
                <h2>アクセス</h2>
            </div>
            <div class="company-access__body">
                <div class="company-access__map" aria-hidden="true">
                    <span>Sample Creative Inc.</span>
                </div>
                <div class="company-access__information">
                    <h3>東京本社</h3>
                    <p>〒100-0005<br>東京都千代田区丸の内1-1-1<br>サンプルビル8F</p>
                    <ul>
                        <li>JR「東京駅」丸の内北口より徒歩5分</li>
                        <li>東京メトロ「大手町駅」D2出口より徒歩2分</li>
                    </ul>
                </div>
            </div>
        </section>

        <?php if (trim((string) get_the_content()) !== ''): ?>
            <section class="company-section company-editor-content" data-company-reveal>
                <div class="company-section__heading">
                    <p class="company-section-label">More</p>
                    <h2>会社について</h2>
                </div>
                <div class="company-editor-content__body">
                    <?php the_content(); ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="company-contact" data-company-reveal>
            <p class="company-section-label">Contact</p>
            <h2>ともに、新しい価値をつくりませんか。</h2>
            <p>プロジェクトのご相談や採用について、お気軽にお問い合わせください。</p>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせはこちら</a>
        </section>
    </main>
<?php endwhile; ?>

<?php get_footer();
