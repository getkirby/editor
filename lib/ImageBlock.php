<?php

namespace Kirby\Editor;

use Throwable;

class ImageBlock extends Block
{

    public function controller(): array
    {
        $data = parent::controller();
        $data['image'] = $this->image();

        return $data;
    }

    public function image()
    {
        try {
            return $this->kirby()->api()->parent($this->attrs()->guid()->value());
        } catch (Throwable $e) {
            return null;
        }
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if ($image = $this->image()) {
            $data['attrs'] = array_merge($data['attrs'] ?? [], [
                'guid'  => $image->panelUrl(true),
                'ratio' => $image->ratio(),
                'src'   => $image->url(),
            ]);
        } else {
            $data['attrs'] = [];
        }

        return $data;
    }

}
