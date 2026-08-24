<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags;

use Foodineers\SEO\Support\GenericMetaTag;
use Foodineers\SEO\Support\MetaTag;
use Foodineers\SEO\Support\SEOData;

final class AuthorTag extends MetaTag
{
    public static function initialize(?SEOData $SEOData): ?MetaTag
    {
        $author = $SEOData?->author;

        if (! $author) {
            return null;
        }

        return new GenericMetaTag(
            name: 'author',
            content: $author
        );
    }
}
