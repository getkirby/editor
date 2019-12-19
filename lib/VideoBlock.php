<?php

namespace Kirby\Editor;

use Throwable;

class VideoBlock extends Block
{
    public function controller(): array
    {
        $data = parent::controller();
        $data['iframe'] = $this->iframe();
        $data['videoSourceType'] = $this->videoSourceType();
        return $data;
    }

    public function iframe()
    {
        try {
            return video($this->attrs()->src());
        } catch (Throwable $e) {
            return false;
        }
    }

    public function videoSourceType(): ?string
    {
        $src = $this->attrs()->src();
        if (preg_match('!youtu!i', $src) === 1) {
            return 'youtube';
        }
        elseif (preg_match('!vimeo!i', $src) === 1) {
            return 'vimeo';
        }
        return null;
    }

    public function isEmpty(): bool
    {
        return empty($this->iframe()) === true;
    }

    public function ampCustomElementScripts(): array
    {
        $scripts = parent::ampCustomElementScripts();
        switch ($this->videoSourceType()) {
            case 'youtube':
                $scripts['amp-youtube'] = 'https://cdn.ampproject.org/v0/amp-youtube-0.1.js';
                break;
            case 'vimeo':
                $scripts['amp-vimeo'] = 'https://cdn.ampproject.org/v0/amp-vimeo-0.1.js';
                break;
        }
        return $scripts;
    }
    
    public function markdown(): string
    {
        $attrs = [
            'video'   => $this->attrs()->src(),
            'caption' => $this->attrs()->caption(),
            'class'   => $this->attrs()->class(),
        ];

        return kirbyTagMaker($attrs) . PHP_EOL . PHP_EOL;
    }
}
