# Livewire Modals. Done Right.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elegantly/livewire-modal.svg?style=flat-square)](https://packagist.org/packages/elegantly/livewire-modal)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/ElegantEngineeringTech/livewire-modal/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ElegantEngineeringTech/livewire-modal/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/ElegantEngineeringTech/livewire-modal/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ElegantEngineeringTech/livewire-modal/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/elegantly/livewire-modal.svg?style=flat-square)](https://packagist.org/packages/elegantly/livewire-modal)

With this package, you can effortlessly open Livewire components inside modals or slideovers, featuring:

-   Support for modals, slideovers, or any similar UI pattern.
-   Nested modals (one at a time).
-   Stacked modals.
-   Custom styling and animations, with optional presets.
-   Preloading components for faster user interactions.

## Requirements

-   `livewire/livewire`: v3
-   `tailwindcss`: v3 (not yet tested with v4)

## How It Works

This package provides a single Livewire `Modal` component that you should place at the end of your `body` tag. This component dynamically renders and manages all modal instances, maintaining a modal history.

You can open and close modals by dispatching `modal-open` and `modal-close` events.

Any Livewire component can be used as a modal, no need for special interfaces or base components. Simply use your existing components as they are.

## Installation

Install the package via Composer:

```bash
composer require elegantly/livewire-modal
```

To customize modal behavior, you can publish the views with:

```bash
php artisan vendor:publish --tag="livewire-modal-views"
```

## Usage

### Configuring Tailwind CSS

Since the modal component is styled using Tailwind CSS, you need to include its views in your Tailwind configuration file:

```js
export default {
    // ...
    content: [
        "./vendor/elegantly/livewire-modal/resources/views/**/*.blade.php",
    ],
    // ...
};
```

### Preparing your App

Add the modal manager component `<livewire:modal />` at the end of your `body` tag. This is usually done in your layout views:

```html
<body>
    ...
    <livewire:modal />
</body>
```

### Preparing your Modals

Any Livewire component can be displayed as a modal, however, some features like stacking, requires you to customize your components.

### Opening a Modal

To open a modal, dispatch a `modal-open` event with the following parameters:

-   `component`: The name of the Livewire component (required)
-   `props`: An array of properties to pass to the component (optional)
-   `stack`: A string identifying a specific stack, like `left` or `center` (optional)
-   `params`: Additional parameters to store in the modal manager (optional)

You can disptach the events using three methods:

Using Alpine `$distach` from inside an Alpine or Livewire component:

```html
<button
    type="button"
    x-on:click="$dispatch('modal-open', { component: 'users.show', props: { userId: 1 } })"
>
    See User
</button>
```

Using the custom Alpine directive from inside an Alpine or Livewire component:

```html
<button
    type="button"
    x-modal:open="{ component: 'users.show', props: { userId: 1 } }"
>
    See User
</button>
```

Using the Livewire global variable from outside a component:

```js
Livewire.dispatch("modal-open", {
    component: "users.show",
    props: { userId: 1 },
});
```

### Closing the Current Modal

To close the currently active modal, dispatch a `modal-close` event. If there is a modal history, it will return to the previous modal; otherwise, all modals will close.

You can disptach the events using three methods:

Using Alpine `$distach` from inside an Alpine or Livewire component:

```html
<button type="button" x-on:click="$dispatch('modal-close')">Close</button>
```

Using the custom Alpine directive from inside an Alpine or Livewire component:

```html
<button type="button" x-modal:close>Close</button>
```

Using the Livewire global variable from outside a component:

```js
Livewire.dispatch("modal-close");
```

### Closing All Modals

To close all modals at once, dispatch a `modal-close-all` event:

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
