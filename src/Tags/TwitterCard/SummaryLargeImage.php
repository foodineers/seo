<?php

declare(strict_types=1);

namespace Foodieneers\Laravel\SEO\Tags\TwitterCard;

use Foodieneers\Laravel\SEO\Support\RenderableCollection;
use Foodieneers\Laravel\SEO\Support\SEOData;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class SummaryLargeImage extends Collection implements Renderable
{
    use BuildsTwitterCard;
    use RenderableCollection;

    public static function initialize(SEOData $SEOData): static
    {
        return static::buildCard($SEOData, 'summary_large_image', 300, 157);
    }
}
