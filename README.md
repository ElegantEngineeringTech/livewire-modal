# Livewire Modals. Done Right.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elegantly/livewire-modal.svg?style=flat-square)](https://packagist.org/packages/elegantly/livewire-modal)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/ElegantEngineeringTech/livewire-modal/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ElegantEngineeringTech/livewire-modal/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/ElegantEngineeringTech/livewire-modal/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ElegantEngineeringTech/livewire-modal/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/elegantly/livewire-modal.svg?style=flat-square)](https://packagist.org/packages/elegantly/livewire-modal)

This package allows you to seamlessly open Livewire components inside modals or slideovers with powerful features:

-   Support for modals, slideovers, or any similar UI pattern.
-   Nested and stacked modals.
-   Custom styling and animations, with optional presets.
-   Preloading components for faster interactions.

## Requirements

-   `livewire/livewire`: v3
-   `tailwindcss`: v3 (not yet tested with v4)

## How It Works

This package provides a single Livewire `Modal` component that you should place at the end of your `body` tag. This component dynamically renders and manages all modal instances, maintaining a modal history.

You can open and close modals by dispatching `modal-open` and `modal-close` events.

Any Livewire component can be used as a modal without requiring special interfaces or base components. Simply use your existing components as they are.

## Installation

Install the package via Composer:

```bash
composer require elegantly/livewire-modal
```

To customize modal behavior, publish the views with:

```bash
php artisan vendor:publish --tag="livewire-modal-views"
```

## Usage

### Configuring Tailwind CSS

Since the modal component is styled using Tailwind CSS, you must include its views in your Tailwind configuration file:

```js
export default {
    content: [
        "./vendor/elegantly/livewire-modal/resources/views/**/*.blade.php",
    ],
};
```

### Setting Up Your Application

Add the modal manager component `<livewire:modal />` at the end of your `body` tag. This is typically done in your layout views:

```html
<body>
    ...
    <livewire:modal />
</body>
```

### Preparing Your Modals

Any Livewire component can be displayed as a modal. However, certain features like stacking require additional customization.

#### Creating a Simple Modal Component

This package provides two Blade components to simplify stacking and positioning:

-   `x-livewire-modal::stack`: Provides a basic layout with stacking capabilities.
-   `x-livewire-modal::modal`: Handles positioning and stacking.

Wrap your content within these components:

```html
<x-livewire-modal::stack>
    <x-livewire-modal::modal
        position="center"
        class="w-full max-w-md overflow-auto rounded-lg bg-white p-5"
    >
        <div class="prose">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
                rhoncus, augue eget vulputate vehicula, justo dui auctor est, at
                iaculis urna orci ut nunc.
            </p>
        </div>
    </x-livewire-modal::modal>
</x-livewire-modal::stack>
```

#### Controlling the Modal Position

By default, modals are centered, but you can adjust their position using the `position` prop:

```html
<x-livewire-modal::stack>
    <x-livewire-modal::modal position="left"> ... </x-livewire-modal::modal>
</x-livewire-modal::stack>
```

```html
<x-livewire-modal::stack>
    <x-livewire-modal::modal position="bottom"> ... </x-livewire-modal::modal>
</x-livewire-modal::stack>
```

#### Fullscreen Modal

To make a modal fullscreen, use the `fullscreen` prop:

```html
<x-livewire-modal::stack fullscreen> ... </x-livewire-modal::stack>
```

#### Creating a Slideover Component

```html
<x-livewire-modal::stack>
    <x-livewire-modal::slideover
        class="w-full max-w-md overflow-auto rounded-lg bg-white p-5"
    >
        <div class="prose">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam
                rhoncus, augue eget vulputate vehicula, justo dui auctor est, at
                iaculis urna orci ut nunc.
            </p>
        </div>
    </x-livewire-modal::slideover>
</x-livewire-modal::stack>
```

### Opening a Modal

To open a modal, dispatch a `modal-open` event:

```js
Livewire.dispatch("modal-open", {
    component: "users.show",
    props: { userId: 1 },
});
```

### Closing the Current Modal

To close the currently active modal, dispatch a `modal-close` event:

```js
Livewire.dispatch("modal-close");
```

### Closing All Modals

To close all modals at once:

```html
<button x-on:click="$dispatch('modal-close-all')">Close All</button>
```

## Testing

Run the test suite with:

```bash
composer test
```

## Changelog

For recent changes, see [CHANGELOG](CHANGELOG.md).

## Contributing

See [CONTRIBUTING](CONTRIBUTING.md) for contribution guidelines.

## Security Vulnerabilities

For information on reporting security vulnerabilities, please review [our security policy](../../security/policy).

## Credits

-   [Quentin Gabriele](https://github.com/QuentinGab)
-   [All Contributors](../../contributors)

## License

This package is licensed under the MIT License. See [License File](LICENSE.md) for details.
