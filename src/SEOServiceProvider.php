<?php

declare(strict_types=1);

namespace Foodineers\SEO;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class SEOServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/seo.php', 'seo');
        $this->app->singleton(SEOService::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/seo.php' => config_path('seo.php'),
        ], 'seo-config');

        Blade::directive('seo', fn (?string $expression): string => "<?php app(\Foodineers\SEO\SEOService::class)->setData(new \Foodineers\SEO\Support\SEOData({$expression})); ?>");
        Blade::directive('seoData', fn (): string => "<?php echo app(\Foodineers\SEO\SEOService::class)->render(); ?>");
    }
}
