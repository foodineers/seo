<?php

declare(strict_types=1);

namespace Foodineers\SEO\Support;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;

trait RenderableCollection
{
    public function render(): string
    {
        return $this->reduce(fn (string $carry, Renderable $item): string => $carry .= Str::of(
            $item->render()
        )->trim().PHP_EOL, '');
    }
}
