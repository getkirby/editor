<?php

namespace Kirby\Editor;

use Closure;
use Kirby\Cms\Collection;
use Kirby\Data\Json;
use Kirby\Toolkit\Str;
use Throwable;

class Blocks extends Collection
{

    /**
     * Return HTML when the collection is
     * converted to a string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->html();
    }

    /**
     * Creates a new block collection from a
     * JSON string
     *
     * @param string|array $value
     * @param Page|File|User|Site $parent
     * @return Kirby\Editor\Blocks
     */
    public static function factory($blocks, $parent)
    {
        if (is_array($blocks) === false) {
            try {
                $blocks = Json::decode((string)$blocks);
            } catch (Throwable $e) {
                $blocks = [
                    [
                        'type'    => 'auto',
                        'content' => $parent->text()->value($blocks ?? '')->kt()->value(),
                        'id'      => '_' . Str::random(9)
                    ]
                ];
            }
        }

        if (!is_array($blocks) === true) {
            $blocks = [];
        }

        $collection = new static;

        foreach ($blocks as $params) {
            $params['parent'] = $parent;
            $block = Block::factory($params, $collection);
            $collection->append($block->id(), $block);
        }

        return $collection;
    }

    /**
     * Convert all blocks to HTML
     *
     * @return string
     */
    public function html(): string
    {
        $html = [];

        foreach ($this->data as $block) {
            $html[] = $block->html();
        }

        return implode($html);
    }

    /**
     * Convert the blocks to an array
     *
     * @return array
     */
    public function toArray(Closure $map = null): array
    {
        return array_values(parent::toArray($map));
    }

}
