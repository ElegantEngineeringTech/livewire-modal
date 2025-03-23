<?php

declare(strict_types=1);

namespace Elegantly\LivewireModal\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public string $mode = 'sequence';

    public bool $open = false;

    /**
     * @var array<array-key, array{ id: string, component: string, props: array<string, mixed>, params: array<string, mixed> }>
     */
    public array $components = [];

    /**
     * @param  array{ id: string, component: string, props: array<string, mixed>, params: array<string, mixed> }  $component
     */
    public function getModeComponent(array $component): string
    {
        /** @var string $componentMode */
        $componentMode = $component['params']['mode'] ?? $this->mode;

        /** @var array<string, string> $modes */
        $modes = config()->array('livewire-modal.modes');

        return $modes[$componentMode] ?? $componentMode;
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire-modal::livewire.modal');
    }
}
