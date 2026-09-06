<?php

declare(strict_types=1);

use Foodineers\SEO\Support\SEOData;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;

it('renders nothing if no schema is provided', function (): void {
    $output = renderSeo(new SEOData);

    expect($output)
        ->not->toContain('schema.org');

    $output = renderSeo(new SEOData(schema: []));

    expect($output)
        ->not->toContain('schema.org');
});

it('renders a Spatie BaseType schema', function (): void {
    $product = Schema::product()->name('Custom Product');

    $output = renderSeo(new SEOData(schema: [$product]));

    expect($output)
        ->toContain('<script type="application/ld+json">')
        ->toContain('"@type":"Product"')
        ->toContain('"name":"Custom Product"');
});

it('merges multiple BaseTypes into one graph', function (): void {
    $organization = Schema::organization()->name('Example Site')->url('https://example.com');
    $product = Schema::product()->name('Addon');

    $output = renderSeo(new SEOData(schema: [$organization, $product]));

    expect($output)
        ->toContain('"@graph"')
        ->toContain('"@type":"Organization"')
        ->toContain('"@type":"Product"');
});

it('renders a Graph schema directly', function (): void {
    $graph = new Graph;
    $graph->add(Schema::product()->name('Graph Product'));

    $output = renderSeo(new SEOData(schema: [$graph]));

    expect($output)
        ->toContain('"@graph"')
        ->toContain('"@type":"Product"')
        ->toContain('"name":"Graph Product"');
});

it('renders FAQPage schema from Spatie BaseType', function (): void {
    $faqPage = Schema::fAQPage()
        ->mainEntity(
            Schema::question()
                ->name('Example question?')
                ->acceptedAnswer(
                    Schema::answer()->text('Example answer.'),
                ),
        );

    $output = renderSeo(new SEOData(schema: [$faqPage]));

    expect($output)
        ->toContain('"@type":"FAQPage"')
        ->toContain('"name":"Example question?"');
});

it('keeps Graph instances separate from merged BaseTypes', function (): void {
    $graph = new Graph;
    $graph->add(Schema::product()->name('In graph'));
    $organization = Schema::organization()->name('Example Site');

    $output = renderSeo(new SEOData(schema: [$graph, $organization]));

    expect(mb_substr_count($output, '<script type="application/ld+json">'))->toBe(2)
        ->and($output)->toContain('"name":"In graph"')
        ->and($output)->toContain('"@type":"Organization"');
});

it('throws for raw array schema items', function (): void {
    new SEOData(schema: [[
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
    ]]);
})->throws(InvalidArgumentException::class, 'Schema must be a BaseType or Graph.');

it('throws for string schema items', function (): void {
    new SEOData(schema: ['Website']);
})->throws(InvalidArgumentException::class, 'Schema must be a BaseType or Graph.');
