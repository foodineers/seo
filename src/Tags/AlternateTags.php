<?php

namespace Foodieneers\SEO\Tags;

use Foodieneers\SEO\Support\AlternateTag;
use Foodieneers\SEO\Support\RenderableCollection;
use Foodieneers\SEO\Support\SEOData;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class AlternateTags extends Collection implements Renderable
{
    use RenderableCollection;

    public static function initialize(SEOData $SEOData): ?static
    {
        if ($SEOData->lang === []) {
            return null;
        }

        $alternates = collect($SEOData->lang)
            ->map(fn (string $href, string $hreflang): AlternateTag => new AlternateTag($hreflang, $href))
            ->values()
            ->all();

        return new static($alternates);
    }
}
