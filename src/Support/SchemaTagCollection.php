<?php

declare(strict_types=1);

namespace Foodineers\SEO\Support;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
final class SchemaTagCollection extends Collection implements Renderable
{
    public static function initialize(?SEOData $SEOData = null): ?static
    {
        if (! $SEOData instanceof SEOData) {
            return null;
        }

        $schemas = SchemaResolver::resolve($SEOData);

        if ($schemas === null || $schemas === []) {
            return null;
        }

        return new self($schemas);
    }

    public function render(): string
    {
        return $this
            ->map(function (array $schema): string {
                $json = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
                $json = str_replace('</script', '<\/script', $json);

                return sprintf('<script type="application/ld+json">%s</script>', $json);
            })
            ->implode(PHP_EOL);
    }
}
