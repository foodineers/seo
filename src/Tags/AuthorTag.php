<?php

declare(strict_types=1);

namespace Foodieneers\SEO\Tags;

use Foodieneers\SEO\Support\MetaTag;
use Foodieneers\SEO\Support\SEOData;

class AuthorTag extends MetaTag
{
    public static function initialize(?SEOData $SEOData): ?MetaTag
    {
        $author = $SEOData?->author;

        if (! $author) {
            return null;
        }

        return new MetaTag(
            name: 'author',
            content: $author
        );
    }
}
