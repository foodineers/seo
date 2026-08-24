<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags;

use Foodineers\SEO\Support\MetaTag;
use Foodineers\SEO\Support\SEOData;
use Illuminate\Support\HtmlString;

final class ImageTag extends MetaTag
{
    public static function initialize(?SEOData $SEOData): ?MetaTag
    {
        $image = $SEOData?->image;

        if (! $image) {
            return null;
        }

        return new self(
            name: 'image',
            content: new HtmlString($image),
        );
    }
}
