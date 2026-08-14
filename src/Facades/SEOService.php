<?php

declare(strict_types=1);

namespace Foodieneers\SEO\Facades;

use Foodieneers\SEO\Support\SEOData;
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
        return \Foodieneers\SEO\SEOService::class;
    }
}
