<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags;

use Foodineers\SEO\Support\LinkTag;
use Foodineers\SEO\Support\SEOData;

/** @phpstan-consistent-constructor */
final class FaviconTag extends LinkTag
{
    public static function initialize(?SEOData $SEOData): ?static
    {
        $favicon = $SEOData?->favicon;

        if (! $favicon) {
            return null;
        }

        return new self(
            rel: 'shortcut icon',
            href: $favicon,
        );
    }

    /** @return list<string> */
    protected function attributesOrder(): array
    {
        return ['href', 'rel'];
    }
}
