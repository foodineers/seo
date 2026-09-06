<?php

declare(strict_types=1);

use Foodineers\SEO\Support\SEOData;
use Foodineers\SEO\TagManager;

it('builds and renders tags from SEOData', function (): void {
    $output = resolve(TagManager::class)
        ->for(new SEOData(
            title: 'Awesome News - My Project',
            description: 'Custom description',
            url: 'https://example.com/news',
        ))
        ->render();

    expect($output)
        ->toContain('<title>Awesome News - My Project</title>')
        ->toContain('<meta name="description" content="Custom description">');
});

it('marks robots as noindex when requested', function (): void {
    $manager = resolve(TagManager::class)->for(new SEOData(
        url: 'https://example.com/private',
        noindex: true,
    ));

    expect($manager->SEOData?->robots)->toBe('noindex, nofollow');
});

it('renders via string cast and without prior for()', function (): void {
    $manager = resolve(TagManager::class);

    expect((string) $manager)->toContain('name="robots"')
        ->and($manager->render())->toContain('name="robots"');
});
