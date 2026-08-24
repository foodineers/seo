<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags;

use Foodineers\SEO\Support\GenericLinkTag;
use Foodineers\SEO\Support\LinkTag;
use Foodineers\SEO\Support\SEOData;

final class CanonicalTag extends LinkTag
{
    public static function initialize(?SEOData $SEOData = null): ?LinkTag
    {
        if (! config('seo.canonical_link')) {
            return null;
        }

        return new GenericLinkTag('canonical', $SEOData?->canonicalUrl ?? $SEOData?->url ?? '');
    }
}
