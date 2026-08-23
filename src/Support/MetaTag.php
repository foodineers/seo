<?php

declare(strict_types=1);

namespace Foodineers\SEO\Support;

use Illuminate\Support\HtmlString;
use Override;

final class MetaTag extends Tag
{
    #[Override]
    public string $tag = 'meta';

    public function __construct(
        string $name,
        string|HtmlString $content,
    ) {
        $this->attributes['name'] = $name;
        $this->attributes['content'] = $content;
    }
}
