<?php

namespace Kirby\Editor;

use Kirby\Cms\Collection;
use Kirby\Data\Json;
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
     * @param string $json
     * @param Page|File|User|Site $parent
     * @return Kirby\Editor\Blocks
     */
    public static function factory(string $json, $parent)
    {
        try {
            $blocks = Json::decode($json);
        } catch (Throwable $e) {
            $blocks = [];
        }

        $collection = new static;

        foreach ($blocks as $params) {
            $params['parent'] = $parent;
            $block = new Block($params, $collection);
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

}
