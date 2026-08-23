<?php

declare(strict_types=1);

namespace Foodineers\SEO;

use const FILTER_VALIDATE_URL;

use Foodineers\SEO\Support\SEOData;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Stringable;

final class TagManager implements Renderable, Stringable
{
    public ?SEOData $SEOData = null;

    public TagCollection $tags;

    public function __construct()
    {
        $this->tags = new TagCollection;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function for(SEOData $source): static
    {
        $this->SEOData = $this->normalize($source);
        $this->tags = TagCollection::initialize($this->SEOData);

        return $this;
    }

    public function render(): string
    {
        if (! $this->SEOData instanceof SEOData) {
            $this->for(new SEOData);
        }

        return $this->tags
            ->reduce(fn (string $carry, Renderable $item): string => $carry .= Str::of($item->render())->trim().PHP_EOL, '');
    }

    private function normalize(SEOData $source): SEOData
    {
        $url = $source->url ?: request()->path();
        $SEOData = clone $source;

        $SEOData->title = $this->resolveTitle($SEOData->title, $url);
        $this->applyConfigDefaults($SEOData);
        $SEOData->url = url($url);
        $SEOData->robots = $SEOData->noindex ? 'noindex, nofollow' : $SEOData->robots;
        $this->absolutizeAssets($SEOData);

        return $SEOData;
    }

    private function resolveTitle(?string $title, string $url): ?string
    {
        if ($title !== null || ! config('seo.title.infer_title_from_url')) {
            return $title;
        }

        return $this->inferTitleFromUrl($url);
    }

    private function applyConfigDefaults(SEOData $SEOData): void
    {
        $SEOData->description ??= config('seo.description.fallback');
        $SEOData->author ??= config('seo.author.fallback');
        $SEOData->twitterUsername ??= Str::of(config('seo.twitter.@username'))->start('@')->toString();
        $SEOData->siteName ??= config('seo.site_name');
        $SEOData->favicon ??= config('seo.favicon');
        $SEOData->locale ??= app()->getLocale();
        $SEOData->image ??= config('seo.image.fallback');
    }

    private function absolutizeAssets(SEOData $SEOData): void
    {
        if ($SEOData->image && ! $this->isAbsoluteUrl($SEOData->image)) {
            $SEOData->imageMeta();
            $SEOData->image = secure_url($SEOData->image);
        }

        if ($SEOData->favicon !== null && ! $this->isAbsoluteUrl($SEOData->favicon)) {
            $SEOData->favicon = secure_url($SEOData->favicon);
        }
    }

    private function isAbsoluteUrl(string $value): bool
    {
        return filter_var(str_replace(' ', '%20', $value), FILTER_VALIDATE_URL) !== false;
    }

    private function inferTitleFromUrl(string $url): string
    {
        $langCodes = ['en', 'fr', 'de', 'it', 'es'];
        $lastSegment = Str::of($url)->afterLast('/');
        if (in_array($lastSegment->toString(), $langCodes, true)) {
            return 'Home';
        }

        return $lastSegment
            ->headline()
            ->whenEmpty(fn (Stringable $str): string => 'Home');
    }
}
