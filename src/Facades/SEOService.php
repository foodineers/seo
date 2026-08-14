<?php

declare(strict_types=1);

namespace Foodieneers\Laravel\SEO\Facades;

use Foodieneers\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void setData(SEOData $data)
 * @method static bool hasData()
 * @method static string render()
 */
class SEOService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Foodieneers\Laravel\SEO\SEOService::class;
    }
}
