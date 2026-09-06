<?php

declare(strict_types=1);

namespace Foodineers\SEO\Support;

use const FILTER_VALIDATE_URL;

use Exception;

final class ImageMeta
{
    public ?int $width = null;

    public ?int $height = null;

    public function __construct(string $path)
    {
        if (self::isAbsoluteUrl($path)) {
            return;
        }

        $publicPath = public_path($path);

        if (! is_file($publicPath)) {
            report(new Exception("Path {$publicPath} is not a file."));

            return;
        }

        $size = getimagesize($publicPath);

        if ($size === false) {
            return;
        }

        $this->width = $size[0];
        $this->height = $size[1];
    }

    public static function isAbsoluteUrl(string $value): bool
    {
        return filter_var(str_replace(' ', '%20', $value), FILTER_VALIDATE_URL) !== false;
    }
}
