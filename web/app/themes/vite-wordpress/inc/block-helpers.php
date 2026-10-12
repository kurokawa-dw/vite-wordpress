<?php

/**
 * 現在の投稿から指定したアンカーを持つグループブロックを取得する。
 *
 * 投稿本文のトップレベルにあるグループブロックを検索し、最初に一致した
 * ブロックをレンダリングして返す。一致するブロックがない場合は空文字列を返す。
 *
 * @param string $anchor 取得するグループブロックのHTMLアンカー。
 * @return string レンダリング済みのブロックHTML。一致しない場合は空文字列。
 */
function mytheme_get_company_group(string $anchor): string
{
    $content = get_post_field(
        'post_content',
        get_queried_object_id()
    );

    // error_log('$content コンテンツ:' . print_r($content, true));

    $blocks = parse_blocks((string) $content);

    foreach ($blocks as $block) {
        if (
            ($block['blockName'] ?? '') === 'core/group' &&
            ($block['attrs']['anchor'] ?? '') === $anchor
        ) {
            return render_block($block);
        }
    }

    return '';
}
