<?php

declare(strict_types=1);

namespace Foodieneers\SEO\Tags;

use Foodieneers\SEO\Support\SEOData;
use Foodieneers\SEO\Support\Tag;

/** @phpstan-consistent-constructor */
class TitleTag extends Tag
{
    public string $tag = 'title';

    public function __construct(
        string $inner,
    ) {
        $this->inner = trim($inner);
    }

    public static function initialize(?SEOData $SEOData): ?Tag
    {
        $title = $SEOData?->title;

        if (! $title) {
            return null;
        }

        return new static(
            inner: $title,
        );
    }
}
