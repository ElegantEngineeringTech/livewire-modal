<?php

declare(strict_types=1);

namespace Elegantly\LivewireModal\Tests\Fixtures;

use Elegantly\LivewireModal\Contracts\ModalComponent;
use Livewire\Component;

class AllowedModal extends Component implements ModalComponent
{
    public ?int $userId = null;

    public function render(): string
    {
        return '<div>allowed-modal:{{ $userId }}</div>';
    }
}
