<?php

declare(strict_types=1);

namespace Elegantly\LivewireModal\Tests\Fixtures;

use Livewire\Component;

class ForbiddenComponent extends Component
{
    public function render(): string
    {
        return '<div>forbidden-component</div>';
    }
}
