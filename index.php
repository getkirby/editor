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
        'en' => [
            'editor.blocks.blockquote.label'          => 'Quote',
            'editor.blocks.code.label'                => 'Code',
            'editor.blocks.h1.label'                  => 'Heading 1',
            'editor.blocks.h2.label'                  => 'Heading 2',
            'editor.blocks.h3.label'                  => 'Heading 3',
            'editor.blocks.hr.label'                  => 'Line',
            'editor.blocks.image.alt.label'           => 'Alternative text',
            'editor.blocks.image.caption.placeholder' => 'Add a caption',
            'editor.blocks.image.css.label'           => 'CSS class',
            'editor.blocks.image.label'               => 'Image',
            'editor.blocks.image.link.label'          => 'Link',
            'editor.blocks.image.link.placeholder'    => 'http://',
            'editor.blocks.image.open.browser'        => 'Open in the browser',
            'editor.blocks.image.open.panel'          => 'Open in the panel',
            'editor.blocks.image.or'                  => 'or',
            'editor.blocks.image.select'              => 'Select an image',
            'editor.blocks.image.settings'            => 'Image settings',
            'editor.blocks.image.upload'              => 'Upload an image',
            'editor.blocks.kirbytext.label'           => 'KirbyText',
            'editor.blocks.ol.label'                  => 'Numbered list',
            'editor.blocks.paragraph.label'           => 'Text',
            'editor.blocks.ul.label'                  => 'Bulleted list',
            'editor.blocks.video.label'               => 'Video',
            'editor.options.insert.below'             => 'Insert below',
            'editor.options.convert'                  => 'Turn into',
            'editor.options.duplicate'                => 'Duplicate',
            'editor.options.delete'                   => 'Delete',
        ]
    ]
]);
