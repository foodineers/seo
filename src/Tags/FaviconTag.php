<?php

namespace Foodieneers\SEO\Tags;

use Foodieneers\SEO\Support\LinkTag;
use Foodieneers\SEO\Support\SEOData;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class FaviconTag extends LinkTag
{
    public static function initialize(?SEOData $SEOData): ?static
    {
        $favicon = $SEOData?->favicon;

        if (! $favicon) {
            return null;
        }

        return new static(
            rel: 'shortcut icon',
            href: $favicon,
        );
    }

    public function collectAttributes(): Collection
    {
        return parent::collectAttributes()
            ->sortKeys();
    }
}
