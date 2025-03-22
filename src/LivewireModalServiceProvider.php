<?php

declare(strict_types=1);

namespace Elegantly\LivewireModal;

use Elegantly\LivewireModal\Commands\LivewireModalCommand;
use Elegantly\LivewireModal\Livewire\Modal;
use Illuminate\Contracts\Foundation\Application;
use Livewire\LivewireManager;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireModalServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('livewire-modal')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(LivewireModalCommand::class);
    }

    public function bootingPackage(): void
    {
        $this->callAfterResolving('livewire', function (LivewireManager $livewire, Application $app) {
            $livewire->component('modal', Modal::class);
        });
    }
}
