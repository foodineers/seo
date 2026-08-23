<?php

declare(strict_types=1);

namespace Foodineers\SEO\Support;

use Override;

final class MetaContentTag extends Tag
{
    #[Override]
    public string $tag = 'meta';

    public function __construct(
        string $property,
        string $content,
    ) {
        $this->attributes['property'] = $property;
        $this->attributes['content'] = $content;
    }
}
