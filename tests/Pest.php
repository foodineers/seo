<?php

declare(strict_types=1);

use Foodineers\SEO\Support\SEOData;
use Foodineers\SEO\TagManager;
use Foodineers\SEO\Tests\TestCase;

pest()->extend(TestCase::class)->in(__DIR__);

function renderSeo(SEOData $input): string
{
    return resolve(TagManager::class)
        ->for($input)
        ->render();
}
