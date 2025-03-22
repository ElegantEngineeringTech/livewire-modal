<?php

declare(strict_types=1);

namespace Workbench\App\Livewire;

use Livewire\Component;

class Slideover extends Component
{
    public function render()
    {
        sleep(1);

        return view('livewire.slideover');
    }
}
