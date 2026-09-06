<?php

declare(strict_types=1);

use Foodineers\SEO\Support\ImageMeta;
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

it('skips remote urls and missing local files', function (): void {
    $remote = new ImageMeta('https://cdn.example.com/cover.jpg');
    $missing = new ImageMeta('/images/missing.jpg');

    expect($remote->width)->toBeNull()
        ->and($missing->width)->toBeNull()
        ->and(ImageMeta::isAbsoluteUrl('https://example.com/a.jpg'))->toBeTrue()
        ->and(ImageMeta::isAbsoluteUrl('/images/a.jpg'))->toBeFalse();
});

it('skips local files that are not images', function (): void {
    $relativePath = '/images/not-an-image.txt';
    $destination = public_path($relativePath);

    File::ensureDirectoryExists(dirname($destination));
    File::put($destination, 'not an image');

    expect((new ImageMeta($relativePath))->width)->toBeNull();
});
