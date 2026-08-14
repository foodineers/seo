<?php

declare(strict_types=1);

namespace Foodieneers\SEO\Tags;

use Foodieneers\SEO\Support\MetaTag;
use Foodieneers\SEO\Support\SEOData;
use Illuminate\Support\HtmlString;

class ImageTag extends MetaTag
{
    public static function initialize(?SEOData $SEOData): ?MetaTag
    {
        $image = $SEOData?->image;

        if (! $image) {
            return null;
        }

        return new MetaTag(
            name: 'image',
            content: new HtmlString($image),
        );
    }
}
