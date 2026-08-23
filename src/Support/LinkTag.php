<?php

declare(strict_types=1);

namespace Foodineers\SEO\Support;

use Override;

final class LinkTag extends Tag
{
    #[Override]
    public string $tag = 'link';

    public function __construct(
        string $rel,
        string $href,
    ) {
        $this->attributes['rel'] = $rel;
        $this->attributes['href'] = $href;
    }
}
