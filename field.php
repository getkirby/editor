<?php

return [
    'mixins' => ['filepicker', 'upload'],
    'props' => [
        'value' => function ($value = null) {

            if (is_array($value) === true) {
                return $value;
            }

            try {
                return Json::decode($value);
            } catch (Exception $e) {
                return [
                    [
                        'type'    => 'auto',
                        'content' => $this->model()->text()->value($value ?? '')->kt()->value()
                    ]
                ];
            }
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
