<?php

declare(strict_types=1);

namespace Foodineers\SEO\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Override;

final class TwitterCardTag extends Tag
{
    #[Override]
    public string $tag = 'meta';

    public function __construct(
        string $name,
        string|HtmlString $content,
    ) {
        $this->attributes['name'] = $name;
        $this->attributes['content'] = $content;

        $this->attributesPipeline[] = (fn (Collection $collection) => $collection->mapWithKeys(function (mixed $value, string $key): array {
            if ($key === 'name') {
                $value = 'twitter:'.$value;
            }

            return [$key => $value];
        }));
    }
}
