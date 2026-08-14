<?php

declare(strict_types=1);

namespace Foodieneers\SEO\Tags;

use Foodieneers\SEO\Support\MetaTag;
use Foodieneers\SEO\Support\SEOData;

class DescriptionTag extends MetaTag
{
    public static function initialize(?SEOData $SEOData): ?MetaTag
    {
        $description = $SEOData?->description;

        if (! $description) {
            return null;
        }

        return new MetaTag(
            name: 'description',
            content: $description
        );
    }
}
