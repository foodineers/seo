<?php

namespace Foodieneers\SEO\Tags;

use Foodieneers\SEO\Support\SEOData;
use Foodieneers\SEO\Support\SitemapTag as SupportSitemapTag;

class SitemapTag extends SupportSitemapTag
{
    public static function initialize(?SEOData $SEOData = null): ?static
    {
        $sitemap = config('seo.sitemap');

        if (! $sitemap) {
            return null;
        }

        return new static($sitemap);
    }
}
