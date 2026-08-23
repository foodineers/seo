<?php

declare(strict_types=1);

namespace Foodineers\SEO;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class SEOServiceProvider extends PackageServiceProvider
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
        Blade::directive('seo', fn (?string $expression): string => "<?php app(\Foodineers\SEO\SEOService::class)->setData(new \Foodineers\SEO\Support\SEOData({$expression})); ?>");
        Blade::directive('seoData', fn (): string => "<?php echo app(\Foodineers\SEO\SEOService::class)->render(); ?>");
    }
}
