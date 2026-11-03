# Changelog

All notable changes to `livewire-modal` will be documented in this file.

## Unreleased

### Changed

- The `x-modal` directive now follows Alpine's `x-on:click`. Its params are evaluated on each click instead of once on load, so values such as `$wire.currency` are always current, and `$event` is available.
- **Breaking:** `x-modal` no longer listens during the capture phase, so `@click` handlers on the element and its children now run first.
- **Breaking:** `.stop` now calls `stopPropagation()` instead of `stopImmediatePropagation()`, like `x-on`.

### Added

- `.self` and `.throttle` (`.throttle.500ms`) modifiers on the `x-modal` directive.
- Hover delay for `.preload` (`x-modal:open.preload.150ms`). The preload is cancelled if the pointer leaves first.

### Fixed

- `x-modal` click listeners are now removed when the element is destroyed.
- `x-modal` is skipped while Alpine clones elements during a Livewire morph.

## v3.0.0 - 2026-11-02

Security release. All users should upgrade.

### Security

- **Breaking:** the modal manager is now deny-by-default. Components that are not explicitly allowed are refused with a 403. Previously, any registered Livewire component (including vendor components such as Filament pages) could be rendered from the browser with arbitrary props, bypassing the middleware of its own route.
- **Breaking:** positional props (`props: [1]`) are refused. They were bound to `mount()` arguments by position, bypassing public property types. Pass props by name (`props: { userId: 1 }`).
- Modal ids sent by the browser are validated and escaped with `Js::from()` before being rendered in an Alpine expression.

### Added

- `Elegantly\LivewireModal\Contracts\ModalComponent` contract to allow a component to be opened in a modal.
- `livewire-modal` config file with a `components` allowlist, for components you can't modify (by name or class). Publish it with `php artisan vendor:publish --tag="livewire-modal-config"`.

### Upgrading from v2

1. Implement `ModalComponent` on every component opened as a modal, or list it in the `components` config key.
2. Replace positional props with named props.
3. If you published the views, republish them or replace `'{{ $id }}'` with `{{ Js::from($id) }}` in `livewire/modal.blade.php`.
4. Props are untrusted input, even on `#[Locked]` properties: authorize in `mount()` and in every action.
