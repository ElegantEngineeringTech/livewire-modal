<?php

declare(strict_types=1);

namespace Elegantly\LivewireModal\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Elegantly\LivewireModal\LivewireModal
 */
class LivewireModal extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Elegantly\LivewireModal\LivewireModal::class;
    }
}
