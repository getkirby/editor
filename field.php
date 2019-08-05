<?php

return [
    'mixins' => ['filepicker', 'upload'],
    'props' => [
        'value' => function ($value = null) {
            return Kirby\Editor\Blocks::factory($value, $this->model())->toArray();
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
    'save' => function ($value) {
        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    },
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
                'method'  => 'POST',
                'action'  => function () {
                    return $this->field()->upload($this, $this->field()->uploads(), function ($file) {
                        return [
                            'filename' => $file->filename(),
                            'link'     => $file->panelUrl(true),
                            'url'      => $file->url(),
                        ];
                    });
                }
            ]
        ];
    },
];
