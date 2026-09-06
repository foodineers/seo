<?php

declare(strict_types=1);

namespace Foodineers\SEO;

use Foodineers\SEO\Support\SEOData;
use Stringable;

final class SEOService implements Stringable
{
    private ?SEOData $data = null;

    public function __toString(): string
    {
        return $this->render();
    }

    public function setData(SEOData $data): void
    {
        $this->data = $data;
    }

    public function hasData(): bool
    {
        return $this->data instanceof SEOData;
    }

    public function render(): string
    {
        if ($this->data instanceof SEOData) {
            return (new TagManager)->for($this->data)->render();
        }

        $title = config('seo.site_name');

        return sprintf(
            '<title>%s</title><meta name="robots" content="noindex, nofollow, noarchive">',
            e(is_string($title) ? $title : null)
        );
    }
}
