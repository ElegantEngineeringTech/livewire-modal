<?php

declare(strict_types=1);

namespace Workbench\App\Livewire;

use Livewire\Component;

class Slideover extends Component
{
    public string $position = 'right';

    public function render()
    {
        usleep(250_000);

        return view('livewire.slideover');
    }
}
