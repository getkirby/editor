<?php

return [
    'mixins' => ['filepicker', 'upload'],
    'props' => [
        'autofocus' => function (bool $autofocus = false) {
            return $autofocus;
        },
        'default' => function ($default = null) {
            return $default;
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
        'spellcheck' => function (bool $spellcheck = true) {
            return $spellcheck;
        },
        'value' => function ($value = null) {
            return $this->toValue($value);
        },
    ],
    'computed' => [
        'default' => function () {
            return $this->toValue($this->default);
        }
    ],
    'methods' => [
        'toBlocks' => function($value) {
            return Kirby\Editor\Blocks::factory($value, $this->model());
        },
        'toValue' => function ($value) {
            if ($this->inline) {
                if (is_array($value) === false) {
                    try {
                        $value = Json::decode((string)$value);
                    } catch (Throwable $e) {
                        return $value;
                    }
                }

                return $this->toBlocks($value)->toHtml();
            } else {
                return $this->toBlocks($value)->toArray();
            }
        }
    ],
    'save' => function ($value) {
        if (empty($value)) {
            return '';
        }

        if ($this->inline) {
            return $value;
        }

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
            ],
            [
                'pattern' => 'paste',
                'method' => 'POST',
                'action' => function () {
                    return Kirby\Editor\Blocks::factory(get('html'), $this->field()->model())->toArray();
                }
            ],
        ];
    },
];
