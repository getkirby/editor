<?php

namespace Kirby\Editor;

use Throwable;

class ImageBlock extends Block
{
    public function controller(): array
    {
        $data          = parent::controller();
        $data['image'] = $image = $this->image();

        $width  = $this->attrs()->width()->toInt() ?? null;
        $height = $this->attrs()->height()->toInt() ?? null;
        $resize = $this->attrs()->resize()->value() ?? 'resize';

        if (empty($width) === false || empty($height) === false) {
            $data['src'] = $image ? $image->{$resize}($width, $height)->url() : $this->attrs()->src();
        } else {
            $data['src'] = $image ? $image->url() : $this->attrs()->src();
        }

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

    public function isEmpty(): bool
    {
        return empty($this->image()) === true && $this->attrs()->src()->isEmpty();
    }

    public function markdown(): string
    {
        $image = $this->image();

        $attrs = [
            'image'   => $image ? $image->id() : $this->attrs()->src(),
            'alt'     => $this->attrs()->alt(),
            'link'    => $this->attrs()->link(),
            'class'   => $this->attrs()->css(),
            'caption' => $this->attrs()->caption()
        ];

        return kirbyTagMaker($attrs) . PHP_EOL . PHP_EOL;
    }

    public function toArray(bool $toStorage = false): array
    {
        $data = parent::toArray();

        if ($image = $this->image()) {
            $data['attrs'] = array_merge($data['attrs'] ?? [], [
                'guid'  => $image->panelUrl(true),
                'ratio' => $image->ratio(),
                'src'   => $image->resize(800)->url()
            ]);

            if ($toStorage === true) {
                unset($data['attrs']['src']);
            }
        } else {
            unset($data['attrs']['guid']);
        }

        return $data;
    }

    public function toStorage(): array
    {
        return $this->toArray(true);
    }
}
