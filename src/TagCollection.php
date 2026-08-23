<?php

declare(strict_types=1);

namespace Foodineers\SEO;

use Foodineers\SEO\Support\SchemaTagCollection;
use Foodineers\SEO\Support\SEOData;
use Foodineers\SEO\Tags\AlternateTags;
use Foodineers\SEO\Tags\AuthorTag;
use Foodineers\SEO\Tags\CanonicalTag;
use Foodineers\SEO\Tags\DescriptionTag;
use Foodineers\SEO\Tags\FaviconTag;
use Foodineers\SEO\Tags\ImageTag;
use Foodineers\SEO\Tags\OpenGraphTags;
use Foodineers\SEO\Tags\RobotsTag;
use Foodineers\SEO\Tags\SitemapTag;
use Foodineers\SEO\Tags\TitleTag;
use Foodineers\SEO\Tags\TwitterCardTags;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
final class TagCollection extends Collection
{
    public static function initialize(?SEOData $SEOData = null): static
    {
        return new self([
            RobotsTag::initialize($SEOData),
            CanonicalTag::initialize($SEOData),
            SitemapTag::initialize($SEOData),
            DescriptionTag::initialize($SEOData),
            AuthorTag::initialize($SEOData),
            TitleTag::initialize($SEOData),
            ImageTag::initialize($SEOData),
            FaviconTag::initialize($SEOData),
            OpenGraphTags::initialize($SEOData),
            TwitterCardTags::initialize($SEOData),
            AlternateTags::initialize($SEOData),
            SchemaTagCollection::initialize($SEOData),
        ])->filter(fn (?Renderable $item): bool => $item instanceof Renderable);
    }
}
