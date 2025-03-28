@props([
    'position' => 'center',
])

<div {!! $attributes->class([
    'max-w-full min-w-0 transition',
    match ($position) {
        'center' => 'm-auto origin-top',
        'left' => 'mr-auto my-auto',
        'right' => 'ml-auto my-auto',
        'top' => 'mb-auto mx-auto',
        'bottom' => 'mt-auto mx-auto',
        'top-left' => 'mb-auto mr-auto',
        'top-right' => 'mb-auto ml-auto',
        'bottom-left' => 'mt-auto mr-auto',
        'bottom-right' => 'mt-auto ml-auto',
        default => '',
    },
]) !!} x-bind="modalAttributes">
    {{ $slot }}
</div>
