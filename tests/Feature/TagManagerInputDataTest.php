<?php

declare(strict_types=1);

use Foodineers\SEO\Support\SEOData;
use Foodineers\SEO\TagManager;

it('normalizes SEOData with config defaults and inferred title', function (): void {
    config()->set('seo.title.infer_title_from_url', true);
    config()->set('seo.description.fallback', 'Fallback description');
    config()->set('seo.author.fallback', 'Fallback author');
    config()->set('seo.site_name', 'Fallback site');
    config()->set('seo.favicon', '/favicon.ico');
    config()->set('seo.twitter.@username', 'foodineers');

    $manager = resolve(TagManager::class)->for(new SEOData(
        url: 'https://example.com/blog/my-article',
    ));

    expect($manager->SEOData?->title)->toBe('My Article')
        ->and($manager->SEOData?->description)->toBe('Fallback description')
        ->and($manager->SEOData?->author)->toBe('Fallback author')
        ->and($manager->SEOData?->siteName)->toBe('Fallback site')
        ->and($manager->SEOData?->favicon)->toBe(secure_url('/favicon.ico'))
        ->and($manager->SEOData?->twitterUsername)->toBe('@foodineers');
});

it('uses noindex robots when SEOData is marked as noindex', function (): void {
    $manager = resolve(TagManager::class)->for(new SEOData(
        noindex: true,
    ));

    expect($manager->SEOData?->robots)->toBe('noindex, nofollow');
});
