<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags;

use Foodineers\SEO\Support\MetaTag;
use Foodineers\SEO\Support\SEOData;

final class RobotsTag extends MetaTag
{
    public static function initialize(?SEOData $SEOData = null): MetaTag
    {
        $robotsContent = config('seo.robots.default');

        if (! config('seo.robots.force_default')) {
            $robotsContent = $SEOData?->robots ?? $robotsContent;
        }

        return new self('robots', $robotsContent);
    }
}
