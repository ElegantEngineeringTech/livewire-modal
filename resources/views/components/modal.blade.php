@props([
    'position' => 'center',
    'fullscreen' => false,
])

<div {!! $attributes->class([
    'max-w-full',
    'max-h-[calc(100%-3rem)]' => !$fullscreen,
    match ($position) {
        'center' => 'm-auto',
        'center-right' => 'my-auto ml-auto',
        'center-left' => 'my-auto mr-auto',
        'left' => 'mr-auto',
        'right' => 'ml-auto',
        'top' => 'mb-auto',
        'bottom' => 'mt-auto',
        'top-left' => 'mb-auto mr-auto',
        'top-right' => 'mb-auto ml-auto',
        'bottom-left' => 'mt-auto mr-auto',
        'bottom-right' => 'mt-auto ml-auto',
        default => '',
    },
]) !!}>
    {{ $slot }}
</div>
