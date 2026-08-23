<?php

declare(strict_types=1);

namespace Foodineers\SEO\Tags\TwitterCard;

use Foodineers\SEO\Support\ImageMeta;
use Foodineers\SEO\Support\SEOData;
use Foodineers\SEO\Support\TwitterCardTag;
use Illuminate\Support\HtmlString;

trait BuildsTwitterCard
{
    protected static function buildCard(
        SEOData $SEOData,
        string $card,
        int $minWidth,
        int $minHeight,
    ): static {
        $collection = new static;

        if ($SEOData->imageMeta instanceof ImageMeta) {
            $width = $SEOData->imageMeta->width;
            $height = $SEOData->imageMeta->height;

            if ($width < $minWidth || $height < $minHeight || $width > 4096 || $height > 4096) {
                return $collection;
            }
        }

        $collection->push(new TwitterCardTag('card', $card));

        if ($SEOData->image) {
            $collection->push(new TwitterCardTag('image', new HtmlString($SEOData->image)));

            if ($SEOData->imageMeta instanceof ImageMeta) {
                $collection->push(new TwitterCardTag('image:width', (string) $SEOData->imageMeta->width));
                $collection->push(new TwitterCardTag('image:height', (string) $SEOData->imageMeta->height));
            }
        }

        return $collection;
    }
}
