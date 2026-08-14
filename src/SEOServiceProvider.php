<?php

namespace Foodieneers\SEO;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SEOServiceProvider extends PackageServiceProvider
{
    public function register(): void
    {
        parent::register();

        $this->app->singleton(SEOService::class, fn (): SEOService => new SEOService);
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('seo')
            ->hasConfigFile();
    }

    public function bootingPackage(): void
    {
        Blade::directive('seo', fn (?string $expression): string => "<?php app(\Foodieneers\SEO\SEOService::class)->setData(new \Foodieneers\SEO\Support\SEOData({$expression})); ?>");
        Blade::directive('seoData', fn (): string => "<?php echo app(\Foodieneers\SEO\SEOService::class)->render(); ?>");
    }
}
