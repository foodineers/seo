<?php

namespace Foodieneers\SEO;

use Foodieneers\SEO\Support\SchemaTagCollection;
use Foodieneers\SEO\Support\SEOData;
use Foodieneers\SEO\Tags\AlternateTags;
use Foodieneers\SEO\Tags\AuthorTag;
use Foodieneers\SEO\Tags\CanonicalTag;
use Foodieneers\SEO\Tags\DescriptionTag;
use Foodieneers\SEO\Tags\FaviconTag;
use Foodieneers\SEO\Tags\ImageTag;
use Foodieneers\SEO\Tags\OpenGraphTags;
use Foodieneers\SEO\Tags\RobotsTag;
use Foodieneers\SEO\Tags\SitemapTag;
use Foodieneers\SEO\Tags\TitleTag;
use Foodieneers\SEO\Tags\TwitterCardTags;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class TagCollection extends Collection
{
    public static function initialize(?SEOData $SEOData = null): static
    {
        return (new static([
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
        ]))->filter(fn (?Renderable $item): bool => $item instanceof Renderable);
    }
}
