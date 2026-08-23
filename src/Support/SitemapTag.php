<?php

declare(strict_types=1);

namespace Foodineers\SEO\Support;

use Override;

final class SitemapTag extends LinkTag
{
    #[Override]
    public array $attributes = [
        'type' => 'application/xml',
        'rel' => 'sitemap',
        'title' => 'Sitemap',
    ];

    public function __construct(
        string $href
    ) {
        $this->attributes['href'] = $href;
    }
}
