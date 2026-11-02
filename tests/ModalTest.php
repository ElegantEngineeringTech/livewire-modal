<?php

declare(strict_types=1);

use Elegantly\LivewireModal\Livewire\Modal;
use Elegantly\LivewireModal\Tests\Fixtures\AllowedModal;
use Elegantly\LivewireModal\Tests\Fixtures\ConfigAllowedModal;
use Elegantly\LivewireModal\Tests\Fixtures\ForbiddenComponent;
use Livewire\Livewire;

beforeEach(function () {
    Livewire::component('allowed-modal', AllowedModal::class);
    Livewire::component('config-allowed-modal', ConfigAllowedModal::class);
    Livewire::component('forbidden-component', ForbiddenComponent::class);
});

function modalEntry(array $overrides = []): array
{
    return [
        'id' => 'abc12',
        'component' => 'allowed-modal',
        'props' => [],
        'params' => [],
        'stack' => null,
        'preloaded' => false,
        ...$overrides,
    ];
}

it('resolves the modal name to the package component', function () {
    expect(app('livewire.factory')->resolveComponentClass('modal'))->toBe(Modal::class);
});

it('renders components implementing the ModalComponent contract', function () {
    Livewire::test(Modal::class)
        ->set('components', [modalEntry(['props' => ['userId' => 42]])])
        ->assertOk()
        ->assertSee('allowed-modal:42');
});

it('renders components allowed in the config', function (string $allowed) {
    config()->set('livewire-modal.components', [$allowed]);

    Livewire::test(Modal::class)
        ->set('components', [modalEntry(['component' => 'config-allowed-modal'])])
        ->assertOk()
        ->assertSee('config-allowed-modal');
})->with([
    'by name' => 'config-allowed-modal',
    'by class' => ConfigAllowedModal::class,
]);

it('refuses components that are not allowed', function (string $component) {
    Livewire::test(Modal::class)
        ->set('components', [modalEntry(['component' => $component])])
        ->assertForbidden();
})->with([
    'registered component' => 'forbidden-component',
    'class name' => ForbiddenComponent::class,
    'modal itself' => 'modal',
    'unknown component' => 'does-not-exist',
]);

it('refuses a disallowed component set through a nested path', function () {
    Livewire::test(Modal::class)
        ->set('components', [modalEntry()])
        ->assertOk()
        ->set('components.0.component', 'forbidden-component')
        ->assertForbidden();
});

it('refuses positional props', function (array $props) {
    Livewire::test(Modal::class)
        ->set('components', [modalEntry(['props' => $props])])
        ->assertForbidden();
})->with([
    'list' => [[42]],
    'mixed' => [['userId' => 42, 0 => 1]],
    'numeric string key' => [['0' => 42]],
]);

it('refuses malformed entries', function (array $entry) {
    Livewire::test(Modal::class)
        ->set('components', [$entry])
        ->assertForbidden();
})->with([
    'xss in id' => [modalEntry(['id' => "a'); alert(1); ('"])],
    'missing id' => [modalEntry(['id' => null])],
    'missing component' => [modalEntry(['component' => null])],
    'non array props' => [modalEntry(['props' => 'userId'])],
    'non array params' => [modalEntry(['params' => 'x'])],
    'non string stack' => [modalEntry(['stack' => ['x']])],
]);

it('refuses non array entries', function () {
    Livewire::test(Modal::class)
        ->set('components', ['allowed-modal'])
        ->assertForbidden();
});
