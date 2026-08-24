<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags;

use Foodineers\SEO\Support\GenericMetaTag;
use Foodineers\SEO\Support\MetaTag;
use Foodineers\SEO\Support\SEOData;

final class DescriptionTag extends MetaTag
{
    public static function initialize(?SEOData $SEOData): ?MetaTag
    {
        $description = $SEOData?->description;

        if (! $description) {
            return null;
        }

        return new GenericMetaTag(
            name: 'description',
            content: $description
        );
    }
}
