<?php

declare(strict_types=1);

namespace Foodieneers\SEO\Support;

class AlternateTag extends LinkTag
{
    public function __construct(
        string $hreflang,
        string $href,
    ) {
        parent::__construct('alternate', $href);

        $this->attributes['hreflang'] = $hreflang;
    }
}
