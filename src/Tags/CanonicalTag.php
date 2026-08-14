<?php

declare(strict_types=1);

namespace Foodieneers\SEO\Tags;

use Foodieneers\SEO\Support\LinkTag;
use Foodieneers\SEO\Support\SEOData;

class CanonicalTag extends LinkTag
{
    public static function initialize(?SEOData $SEOData = null): ?LinkTag
    {
        if (! config('seo.canonical_link')) {
            return null;
        }

        return new LinkTag('canonical', $SEOData?->canonicalUrl ?? $SEOData?->url ?? '');
    }
}
