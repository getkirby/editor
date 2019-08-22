<?php

namespace Kirby\Editor;

use PHPHtmlParser\Dom;

class Parser
{

    public static $parsers = [];

    public static function __callStatic(string $name, array $args = [])
    {
        $parser = static::$parsers[$name] ?? static::$parsers['unknown'];
        return $parser(...$args);
    }

    public static function parse($dom)
    {
        if (is_string($dom) === true) {
            $html = $dom;
            $dom  = new Dom;
            $dom->load($html, [
                'whitespaceTextNode' => false,
                'preserveLineBreaks' => true
            ]);
        }

        if (empty($dom) === true) {
            return [];
        }

        $result = [];
        $skip   = ['meta', 'style', 'script', 'noscript', 'title'];
        $inline = [];

        foreach ($dom->getChildren() as $element) {

            $tag  = $element->tag;
            $name = $tag->name();

            // kill all style attributes
            $element->removeAttribute('style');

            if (in_array($name, $skip)) {
                continue;
            }

            if (static::isInline($name)) {
                $inline[] = $element->outerHtml;
            } else {

                // convert all previous inline elements
                // to a new block
                if (empty($inline) === false) {
                    $result[] = static::inlineToParagraph($inline);
                    $inline = [];
                };

                $blocks = static::$name($element);

                if (empty($blocks) === false && is_array($blocks)) {
                    $result = array_merge($result, $blocks);
                }
            }
        }

        if (empty($inline) === false) {
            $result[] = static::inlineToParagraph($inline);
        }

        return $result;

    }

    public static function sanitize(string $html, string $tags = '<a><b><em><i><strong><code>')
    {
        return trim(strip_tags($html, $tags));
    }

    public static function isInline($tag): bool
    {
        $inline = [
            'a',
            'abbr',
            'acronym',
            'b',
            'bdo',
            'br',
            'button',
            'cite',
            'code',
            'dfn',
            'em',
            'font',
            'i',
            'img',
            'input',
            'kbd',
            'label',
            'map',
            'object',
            'q',
            'samp',
            'script',
            'select',
            'small',
            'span',
            'strong',
            'sub',
            'sup',
            'text',
            'textarea',
            'tt',
            'var',
        ];

        return in_array($tag, $inline) === true;
    }

    public static function inlineToParagraph(array $inline): array
    {
        return [
            'type'    => 'paragraph',
            'content' => static::sanitize(implode($inline)),
        ];
    }

}
