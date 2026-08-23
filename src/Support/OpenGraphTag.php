<?php

declare(strict_types=1);

namespace Foodineers\SEO\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Override;

final class OpenGraphTag extends Tag
{
    #[Override]
    public string $tag = 'meta';

    public function __construct(
        string $property,
        string|HtmlString $content,
    ) {
        $this->attributes['property'] = $property;
        $this->attributes['content'] = $content;

        $this->attributesPipeline[] = (fn (Collection $collection) => $collection->mapWithKeys(function (mixed $value, string $key): array {
            if ($key === 'property') {
                $value = 'og:'.$value;
            }

            return [$key => $value];
        }));
    }
}
