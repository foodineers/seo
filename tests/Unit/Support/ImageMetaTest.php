<?php

declare(strict_types=1);

use Foodineers\SEO\Support\ImageMeta;
use Foodineers\SEO\Support\SchemaTagCollection;
use Foodineers\SEO\Support\SEOData;
use Illuminate\Support\Facades\File;

it('reads width and height from a local public image', function (): void {
    $relativePath = '/images/test-image.jpg';
    $destination = public_path($relativePath);

    File::ensureDirectoryExists(dirname($destination));
    File::copy(dirname(__DIR__, 2).'/Fixtures/images/test-image.jpg', $destination);

    $meta = new ImageMeta($relativePath);

    expect($meta->width)->toBeInt()->toBeGreaterThan(0)
        ->and($meta->height)->toBeInt()->toBeGreaterThan(0);
});

it('returns null imageMeta when SEOData has no image', function (): void {
    expect((new SEOData)->imageMeta())->toBeNull();
});

it('returns null schema collection when SEOData is missing', function (): void {
    expect(SchemaTagCollection::initialize())->toBeNull();
});
