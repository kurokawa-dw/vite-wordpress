<?php
/**
 * Main template.
 *
 * @package ViteWordPressStarter
 */

get_header();
?>

<main class="site-main">
    <section class="hero">
        <p class="hero__eyebrow">WordPress + Vite</p>
        <h1>固定ページ</h1>
        <p class="hero__lead">
            このカードの色や余白を <code>src/scss/main.scss</code> で変更すると、開発サーバーが即座に反映します。
        </p>
        <button class="demo-button" type="button" data-demo-button>
            JavaScriptを試す
        </button>
        <p class="demo-message" data-demo-message aria-live="polite"></p>
    </section>


</main>

<?php
get_footer();
