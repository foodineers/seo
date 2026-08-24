<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags;

use Foodineers\SEO\Support\GenericSitemapTag;
use Foodineers\SEO\Support\SEOData;
use Foodineers\SEO\Support\SitemapTag as SupportSitemapTag;

final class SitemapTag extends SupportSitemapTag
{
    public static function initialize(?SEOData $SEOData = null): ?SupportSitemapTag
    {
        $sitemap = config('seo.sitemap');

        if (! $sitemap) {
            return null;
        }

        return new GenericSitemapTag($sitemap);
    }
}
