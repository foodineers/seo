<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags;

use Foodineers\SEO\Support\AlternateTag;
use Foodineers\SEO\Support\RenderableCollection;
use Foodineers\SEO\Support\SEOData;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
final class AlternateTags extends Collection implements Renderable
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

        return new self($alternates);
    }
}
