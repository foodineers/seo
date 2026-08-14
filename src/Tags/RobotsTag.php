<?php

namespace Foodieneers\SEO\Tags;

use Foodieneers\SEO\Support\MetaTag;
use Foodieneers\SEO\Support\SEOData;

class RobotsTag extends MetaTag
{
    public static function initialize(?SEOData $SEOData = null): MetaTag
    {
        $robotsContent = config('seo.robots.default');

        if (! config('seo.robots.force_default')) {
            $robotsContent = $SEOData?->robots ?? $robotsContent;
        }

        return new MetaTag('robots', $robotsContent);
    }
}
