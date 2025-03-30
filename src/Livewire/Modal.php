<?php

declare(strict_types=1);

namespace Elegantly\LivewireModal\Livewire;

use Livewire\Attributes\Locked;
use Livewire\Component;

class Modal extends Component
{
    #[Locked]
    public ?string $stack = null;

    public bool $open = false;

    /**
     * @var array<array-key, array{ id: string, component: string, props: array<string, mixed>, params: array<string, mixed> }>
     */
    public array $components = [];

    public function mount(null|string|bool $stack = null): void
    {
        if (is_bool($stack)) {
            $this->stack = $stack ? 'default' : null;
        } else {
            $this->stack = $stack;
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire-modal::livewire.modal');
    }
}
