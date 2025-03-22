<?php

declare(strict_types=1);

namespace Elegantly\LivewireModal\Commands;

use Illuminate\Console\Command;

class LivewireModalCommand extends Command
{
    public $signature = 'livewire-modal';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
