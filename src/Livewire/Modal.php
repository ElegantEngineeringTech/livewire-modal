<?php

declare(strict_types=1);

namespace Elegantly\LivewireModal\Livewire;

use Elegantly\LivewireModal\Contracts\ModalComponent;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Exceptions\ComponentNotFoundException;

class Modal extends Component
{
    #[Locked]
    public ?string $stack = null;

    public bool $open = false;

    /**
     * Entangled with the browser: every entry is untrusted until validated.
     *
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

    public function render(): View
    {
        // Validated here rather than in an updating hook so that every way
        // of changing the state (nested paths, $set, entangle) is covered.
        foreach ($this->components as $item) {
            if (! $this->isValidModalComponent($item)) {
                abort(403, 'This component cannot be opened in a modal.');
            }
        }

        return view('livewire-modal::livewire.modal');
    }

    protected function isValidModalComponent(mixed $item): bool
    {
        if (! is_array($item)) {
            return false;
        }

        $id = $item['id'] ?? null;
        $component = $item['component'] ?? null;
        $props = $item['props'] ?? [];
        $params = $item['params'] ?? [];
        $stack = $item['stack'] ?? null;

        // The id is rendered inside an Alpine expression and a wire:key.
        if (! is_string($id) || ! preg_match('/^[a-z0-9]{1,16}$/', $id)) {
            return false;
        }

        if (! is_string($component) || $component === '') {
            return false;
        }

        if (! is_array($props) || ! is_array($params)) {
            return false;
        }

        // Positional props would be bound to mount() arguments by position,
        // bypassing the component's public property types.
        foreach (array_keys($props) as $key) {
            if (! is_string($key)) {
                return false;
            }
        }

        if ($stack !== null && ! is_string($stack)) {
            return false;
        }

        return $this->isAllowedComponent($component);
    }

    /**
     * Override to customize which components can be opened in the modal.
     */
    protected function isAllowedComponent(string $name): bool
    {
        $class = $this->resolveComponentClass($name);

        if ($class === null) {
            return false;
        }

        if (is_subclass_of($class, ModalComponent::class)) {
            return true;
        }

        /** @var array<int, string> $allowed */
        $allowed = config('livewire-modal.components', []);

        foreach ($allowed as $allowedComponent) {
            if ($this->resolveComponentClass($allowedComponent) === $class) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return null|class-string<Component>
     */
    protected function resolveComponentClass(string $name): ?string
    {
        try {
            /** @var class-string<Component> */
            return app('livewire.factory')->resolveComponentClass($name);
        } catch (ComponentNotFoundException) {
            return null;
        }
    }
}
