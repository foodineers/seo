<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags;

use Foodineers\SEO\Support\SEOData;
use Foodineers\SEO\Support\Tag;
use Override;

/** @phpstan-consistent-constructor */
final class TitleTag extends Tag
{
    #[Override]
    public string $tag = 'title';

    public function __construct(
        string $inner,
    ) {
        $this->inner = mb_trim($inner);
    }

    public static function initialize(?SEOData $SEOData): ?Tag
    {
        $title = $SEOData?->title;

        if (! $title) {
            return null;
        }

        return new self(
            inner: $title,
        );
    }
}
