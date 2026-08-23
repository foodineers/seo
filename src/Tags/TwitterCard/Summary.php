<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags\TwitterCard;

use Foodineers\SEO\Support\RenderableCollection;
use Foodineers\SEO\Support\SEOData;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
final class Summary extends Collection implements Renderable
{
    use BuildsTwitterCard;
    use RenderableCollection;

    public static function initialize(SEOData $SEOData): static
    {
        return self::buildCard($SEOData, 'summary', 144, 144);
    }
}
