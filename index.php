<?php

Kirby::plugin('getkirby/editor', [
    'snippets' => [
        'blocks/blockquote' => __DIR__ . '/snippets/blockquote.php',
        'blocks/code'       => __DIR__ . '/snippets/code.php',
        'blocks/h1'         => __DIR__ . '/snippets/h1.php',
        'blocks/h2'         => __DIR__ . '/snippets/h2.php',
        'blocks/h3'         => __DIR__ . '/snippets/h3.php',
        'blocks/hr'         => __DIR__ . '/snippets/hr.php',
        'blocks/image'      => __DIR__ . '/snippets/image.php',
        'blocks/ol'         => __DIR__ . '/snippets/ol.php',
        'blocks/paragraph'  => __DIR__ . '/snippets/paragraph.php',
        'blocks/ul'         => __DIR__ . '/snippets/ul.php',
        'blocks/video'      => __DIR__ . '/snippets/video.php',
    ],
    'fieldMethods' => [
        'blocks' => function ($field) {
            $html   = [];
            $blocks = $field->yaml();

            $blockToObj = function ($block) {

                if ($block === null) {
                    return null;
                }

                return new Obj([
                    'content' => $block['content'],
                    'attrs'   => new Obj($block['attrs']),
                    'type'    => $block['type'],
                    'prev'    => $block['prev'] ?? null,
                    'next'    => $block['next'] ?? null
                ]);
            };

            foreach ($blocks as $index => $block) {

                $block['prev'] = $blockToObj($blocks[$index - 1] ?? null);
                $block['next'] = $blockToObj($blocks[$index + 1] ?? null);

                $block = $blockToObj($block);

                $html[] = snippet('blocks/' . $block->type(), ['block' => $block], true);
            }

            return implode($html);
        }
    ],
    'fields' => [
        'editor' => [
            'mixins' => ['filepicker', 'upload'],
            'props' => [
                'value' => function ($value = null) {
                    return Yaml::decode($value);
                },
                /**
                 * Sets the options for the files picker
                 */
                'files' => function ($files = []) {
                    if (is_string($files) === true) {
                        return ['query' => $files];
                    }

                    if (is_array($files) === false) {
                        $files = [];
                    }

                    return $files;
                },
            ],
            'api' => function () {
                return [
                    [
                        'pattern' => 'files',
                        'action' => function () {
                            return $this->field()->filepicker($this->field()->files());
                        }
                    ],
                    [
                        'pattern' => 'upload',
                        'action' => function () {
                            return $this->field()->upload($this, $this->field()->uploads(), function ($file) {
                                return [
                                    'filename' => $file->filename(),
                                    'dragText' => $file->dragText(),
                                ];
                            });
                        }
                    ]
                ];
            },
        ]
    ]
]);
