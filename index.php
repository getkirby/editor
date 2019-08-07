<?php

load([
    // base classes
    'kirby\\editor\\block'  => __DIR__ . '/lib/Block.php',
    'kirby\\editor\\blocks' => __DIR__ . '/lib/Blocks.php',

    // block extensions
    'kirby\\editor\\h1block'    => __DIR__ . '/lib/H1Block.php',
    'kirby\\editor\\h2block'    => __DIR__ . '/lib/H2Block.php',
    'kirby\\editor\\h3block'    => __DIR__ . '/lib/H3Block.php',
    'kirby\\editor\\imageblock' => __DIR__ . '/lib/ImageBlock.php',
]);

Kirby::plugin('getkirby/editor', [
    'fieldMethods' => [
        'blocks' => require __DIR__ . '/method.php'
    ],
    'fields' => [
        'editor' => require __DIR__ . '/field.php'
    ],
    'snippets' => [
        'editor/blockquote' => __DIR__ . '/snippets/blockquote.php',
        'editor/code'       => __DIR__ . '/snippets/code.php',
        'editor/h1'         => __DIR__ . '/snippets/h1.php',
        'editor/h2'         => __DIR__ . '/snippets/h2.php',
        'editor/h3'         => __DIR__ . '/snippets/h3.php',
        'editor/hr'         => __DIR__ . '/snippets/hr.php',
        'editor/image'      => __DIR__ . '/snippets/image.php',
        'editor/kirbytext'  => __DIR__ . '/snippets/kirbytext.php',
        'editor/ol'         => __DIR__ . '/snippets/ol.php',
        'editor/paragraph'  => __DIR__ . '/snippets/paragraph.php',
        'editor/ul'         => __DIR__ . '/snippets/ul.php',
        'editor/video'      => __DIR__ . '/snippets/video.php',
    ],
    'translations' => [
        'de' => require __DIR__ . '/i18n/de.php',
        'en' => require __DIR__ . '/i18n/en.php',
    ]
]);
