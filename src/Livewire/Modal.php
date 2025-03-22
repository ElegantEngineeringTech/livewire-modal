<?php

declare(strict_types=1);

namespace Elegantly\LivewireModal\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public bool $open = false;

    /**
     * @var array<array-key, array{ id: string, component: string, props: array<string, mixed> }>
     */
    public array $components = [];

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire-modal::livewire.modal');
    }
}
