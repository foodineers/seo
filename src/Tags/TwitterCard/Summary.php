<?php

declare(strict_types=1);

namespace Foodieneers\SEO\Tags\TwitterCard;

use Foodieneers\SEO\Support\RenderableCollection;
use Foodieneers\SEO\Support\SEOData;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class Summary extends Collection implements Renderable
{
    use BuildsTwitterCard;
    use RenderableCollection;

    public static function initialize(SEOData $SEOData): static
    {
        return static::buildCard($SEOData, 'summary', 144, 144);
    }
}
