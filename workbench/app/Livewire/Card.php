<?php

declare(strict_types=1);

namespace Workbench\App\Livewire;

use Livewire\Component;

class Card extends Component
{
    public ?string $title = null;

    public function render()
    {
        sleep(1);

        return view('livewire.card');
    }
}
