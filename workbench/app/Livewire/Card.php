<?php

declare(strict_types=1);

namespace Workbench\App\Livewire;

use Elegantly\LivewireModal\Contracts\ModalComponent;
use Livewire\Component;

class Card extends Component implements ModalComponent
{
    public string $position = 'center';

    public function render()
    {
        usleep(250_000);

        return view('livewire.card');
    }
}
