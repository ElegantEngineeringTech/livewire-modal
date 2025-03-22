<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Livewire\LivewireManager;
use Workbench\App\Livewire\Card;
use Workbench\App\Livewire\Slideover;

class WorkbenchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->callAfterResolving('livewire', function (LivewireManager $livewire, Application $app) {
            $livewire->component('card', Card::class);
            $livewire->component('slideover', Slideover::class);
        });
    }
}
