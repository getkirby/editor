<?php

namespace Kirby\Editor;

use Throwable;

class VideoBlock extends Block
{

    public function controller(): array
    {
        $data = parent::controller();
        $data['iframe'] = $this->iframe();
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

    public function isEmpty(): bool
    {
        return empty($this->iframe()) === true;
    }

}
