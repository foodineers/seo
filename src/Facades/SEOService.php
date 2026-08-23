<?php

declare(strict_types=1);

namespace Foodineers\SEO\Facades;

use Foodineers\SEO\Support\SEOData;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void setData(SEOData $data)
 * @method static bool hasData()
 * @method static string render()
 */
final class SEOService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Foodineers\SEO\SEOService::class;
    }
}
