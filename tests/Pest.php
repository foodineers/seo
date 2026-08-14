<?php

use Foodieneers\SEO\Support\SEOData;
use Foodieneers\SEO\TagManager;
use Foodieneers\SEO\Tests\TestCase;

uses(TestCase::class)
    ->in(__DIR__);

function renderSeo(SEOData $input): string
{
    return resolve(TagManager::class)
        ->for($input)
        ->render();
}
