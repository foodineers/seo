<?php

declare(strict_types=1);

namespace Foodineers\SEO;

use Foodineers\SEO\Support\ImageMeta;
use Foodineers\SEO\Support\SEOData;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\Graph;
use Stringable;

final class TagManager implements Stringable
{
    public ?SEOData $SEOData = null;

    public function __toString(): string
    {
        return $this->render();
    }

    public function for(SEOData $source): static
    {
        $this->SEOData = $this->normalize($source);

        return $this;
    }

    public function render(): string
    {
        $this->SEOData ??= $this->normalize(new SEOData);

        return implode(PHP_EOL, $this->tags($this->SEOData)).PHP_EOL;
    }

    private function normalize(SEOData $source): SEOData
    {
        $url = $source->url ?: request()->path();
        $SEOData = clone $source;

        $SEOData->description ??= $this->stringConfig('seo.description.fallback');
        $SEOData->author ??= $this->stringConfig('seo.author.fallback');
        $SEOData->twitterUsername ??= Str::of($this->stringConfig('seo.twitter.@username') ?? '')->start('@')->toString();
        $SEOData->siteName ??= $this->stringConfig('seo.site_name');
        $SEOData->image ??= $this->stringConfig('seo.image.fallback');
        $SEOData->url = url($url);
        $SEOData->robots = $SEOData->noindex ? 'noindex, nofollow' : $SEOData->robots;

        if ($SEOData->image && ! ImageMeta::isAbsoluteUrl($SEOData->image)) {
            $SEOData->imageMeta();
            $SEOData->image = secure_url($SEOData->image);
        }

        return $SEOData;
    }

    /** @return list<string> */
    private function tags(SEOData $data): array
    {
        $robots = config('seo.robots.force_default') === true
            ? $this->stringConfig('seo.robots.default')
            : ($data->robots ?? $this->stringConfig('seo.robots.default'));

        $tags = [
            $this->el('meta', ['name' => 'robots', 'content' => $robots ?? '']),
        ];

        if (config('seo.canonical_link')) {
            $tags[] = $this->el('link', ['rel' => 'canonical', 'href' => $data->canonicalUrl ?? $data->url ?? '']);
        }

        if ($sitemap = $this->stringConfig('seo.sitemap')) {
            $tags[] = $this->el('link', [
                'rel' => 'sitemap',
                'title' => 'Sitemap',
                'href' => $sitemap,
                'type' => 'application/xml',
            ]);
        }

        if ($data->description) {
            $tags[] = $this->el('meta', ['name' => 'description', 'content' => $data->description]);
        }

        if ($data->author) {
            $tags[] = $this->el('meta', ['name' => 'author', 'content' => $data->author]);
        }

        if ($data->title) {
            $tags[] = $this->el('title', inner: mb_trim($data->title));
        }

        if ($data->image) {
            $tags[] = $this->el('meta', ['name' => 'image', 'content' => $data->image]);
        }

        array_push($tags, ...$this->openGraph($data), ...$this->twitter($data));

        foreach ($data->lang as $hreflang => $href) {
            $tags[] = $this->el('link', ['rel' => 'alternate', 'hreflang' => $hreflang, 'href' => $href]);
        }

        array_push($tags, ...$this->schema($data));

        return $tags;
    }

    /** @return list<string> */
    private function openGraph(SEOData $data): array
    {
        $tags = [];

        if ($data->openGraphTitle) {
            $tags[] = $this->el('meta', ['property' => 'og:title', 'content' => $data->openGraphTitle]);
        } elseif ($data->title) {
            $tags[] = $this->el('meta', ['property' => 'og:title', 'content' => $data->title]);
        }

        if ($data->description) {
            $tags[] = $this->el('meta', ['property' => 'og:description', 'content' => $data->description]);
        }

        if ($data->locale) {
            $tags[] = $this->el('meta', ['property' => 'og:locale', 'content' => $data->locale]);
        }

        if ($data->image) {
            $tags[] = $this->el('meta', ['property' => 'og:image', 'content' => $data->image]);

            if ($data->imageMeta?->width !== null) {
                $tags[] = $this->el('meta', ['property' => 'og:image:width', 'content' => (string) $data->imageMeta->width]);
            }

            if ($data->imageMeta?->height !== null) {
                $tags[] = $this->el('meta', ['property' => 'og:image:height', 'content' => (string) $data->imageMeta->height]);
            }
        }

        $tags[] = $this->el('meta', ['property' => 'og:url', 'content' => $data->url ?? '']);

        if ($data->siteName) {
            $tags[] = $this->el('meta', ['property' => 'og:site_name', 'content' => $data->siteName]);
        }

        if ($data->type) {
            $tags[] = $this->el('meta', ['property' => 'og:type', 'content' => $data->type]);
        }

        if ($data->type !== 'article') {
            return $tags;
        }

        if ($data->publishedAt) {
            $tags[] = $this->el('meta', ['property' => 'article:published_at', 'content' => $data->publishedAt->toIso8601String()]);
        }

        if ($data->modifiedAt) {
            $tags[] = $this->el('meta', ['property' => 'article:modified_at', 'content' => $data->modifiedAt->toIso8601String()]);
        }

        if ($data->section) {
            $tags[] = $this->el('meta', ['property' => 'article:section', 'content' => $data->section]);
        }

        foreach ($data->tags ?? [] as $tag) {
            $tags[] = $this->el('meta', ['property' => 'article:tag', 'content' => $tag]);
        }

        return $tags;
    }

    /** @return list<string> */
    private function twitter(SEOData $data): array
    {
        $tags = [];
        $fallback = $this->stringConfig('seo.image.fallback');

        if ($data->image
            && (! $fallback || $data->image !== secure_url($fallback))
            && $data->imageMeta?->height !== null
            && $data->imageMeta->height > 0) {
            array_push($tags, ...($data->imageMeta->width / $data->imageMeta->height < 1.5
                ? $this->twitterImageCard($data, 'summary', 144, 144)
                : $this->twitterImageCard($data, 'summary_large_image', 300, 157)));
        } elseif ($data->image && ! $data->imageMeta) {
            array_push($tags, ...$this->twitterImageCard($data, 'summary_large_image', 300, 157));
        } else {
            $tags[] = $this->el('meta', ['name' => 'twitter:card', 'content' => 'summary']);
        }

        if ($data->openGraphTitle) {
            $tags[] = $this->el('meta', ['name' => 'twitter:title', 'content' => $data->openGraphTitle]);
        } elseif ($data->title) {
            $tags[] = $this->el('meta', ['name' => 'twitter:title', 'content' => $data->title]);
        }

        if ($data->description) {
            $tags[] = $this->el('meta', ['name' => 'twitter:description', 'content' => $data->description]);
        }

        if ($data->twitterUsername && $data->twitterUsername !== '@') {
            $tags[] = $this->el('meta', ['name' => 'twitter:site', 'content' => $data->twitterUsername]);
        }

        return $tags;
    }

    /** @return list<string> */
    private function twitterImageCard(SEOData $data, string $card, int $minWidth, int $minHeight): array
    {
        if ($data->imageMeta instanceof ImageMeta) {
            $width = $data->imageMeta->width;
            $height = $data->imageMeta->height;

            if ($width < $minWidth || $height < $minHeight || $width > 4096 || $height > 4096) {
                return [];
            }
        }

        $tags = [
            $this->el('meta', ['name' => 'twitter:card', 'content' => $card]),
            $this->el('meta', ['name' => 'twitter:image', 'content' => $data->image ?? '']),
        ];

        if ($data->imageMeta instanceof ImageMeta) {
            $tags[] = $this->el('meta', ['name' => 'twitter:image:width', 'content' => (string) $data->imageMeta->width]);
            $tags[] = $this->el('meta', ['name' => 'twitter:image:height', 'content' => (string) $data->imageMeta->height]);
        }

        return $tags;
    }

    /** @return list<string> */
    private function schema(SEOData $data): array
    {
        if ($data->schema === []) {
            return [];
        }

        $payloads = [];
        $types = [];

        foreach ($data->schema as $item) {
            if ($item instanceof Graph) {
                $payloads[] = $item->toArray();

                continue;
            }

            $types[] = $item;
        }

        if (count($types) === 1) {
            $payloads[] = $types[0]->toArray();
        } elseif (count($types) > 1) {
            $graph = new Graph;

            foreach ($types as $type) {
                $graph->add($type);
            }

            $payloads[] = $graph->toArray();
        }

        return array_map(function (array $payload): string {
            $json = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

            return '<script type="application/ld+json">'.str_replace('</script', '<\/script', $json).'</script>';
        }, $payloads);
    }

    /** @param  array<string, string>  $attributes */
    private function el(string $tag, array $attributes = [], ?string $inner = null): string
    {
        $html = '<'.$tag;

        foreach ($attributes as $name => $value) {
            $html .= ' '.$name.'="'.e($value).'"';
        }

        $html .= '>';

        if ($inner !== null) {
            $html .= e($inner).'</'.$tag.'>';
        }

        return $html;
    }

    private function stringConfig(string $key): ?string
    {
        $value = config($key);

        return is_string($value) ? $value : null;
    }
}
