<?php

declare(strict_types=1);

namespace Foodineers\SEO\Support;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

abstract class Tag implements Renderable
{
    /**
     * The HTML tag
     */
    public string $tag;

    /**
     * The HTML attributes of the tag
     */
    public array $attributes = [];

    /**
     * The content of the tag
     */
    public null|string|HtmlString $inner = null;

    public array $attributesPipeline = [];

    /** @var list<string> */
    protected static array $attributesOrder = ['rel', 'hreflang', 'title', 'name', 'href', 'property', 'description', 'content'];

    final public function render(): string
    {
        return new TagRender(
            tag: $this->tag,
            attributes: $this->collectAttributes(),
            inner: $this->getInner(),
        )->render();
    }

    final public function collectAttributes(): Collection
    {
        return collect($this->attributes)
            ->map(fn (string|bool|HtmlString $attribute): string|bool|HtmlString => is_string($attribute) ? mb_trim($attribute) : $attribute)
            ->sortKeysUsing(function (string|int $a, string|int $b): int {
                $indexA = array_search($a, static::$attributesOrder);
                $indexB = array_search($b, static::$attributesOrder);

                return match (true) {
                    $indexB === $indexA => 0,
                    $indexA === false => 1,
                    $indexB === false => -1,
                    default => $indexA - $indexB
                };
            })
            ->pipeThrough($this->attributesPipeline);
    }

    final public function getInner(): null|string|HtmlString
    {
        return $this->inner;
    }
}
