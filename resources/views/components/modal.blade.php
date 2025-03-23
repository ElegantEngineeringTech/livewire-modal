@props([
    'position' => 'center',
    'fullscreen' => false,
])

<div {!! $attributes->class([
    'max-w-full transition',
    'max-h-[calc(100%-3rem)]' => !$fullscreen,
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
]) !!}
    x-bind:style="{
        '--index': modalIndexReversed,
        '--direction': {{ match ($position) {
            'center' => -1,
            'left' => 1,
            'right' => -1,
            default => 1,
        } }},
        transform: '{{ match ($position) {
            'center' => 'scale(calc(1 - 0.05 * var(--index))) translateY(calc(var(--direction) * 1.5rem * var(--index)))',
            'left',
            'right'
                => 'scale(calc(1 - 0.05 * var(--index))) translateX(calc(var(--direction) * 1.5rem * var(--index)))',
            default => '',
        } }}',
        opacity: modalIndexReversed <= 2 ? 1 : 0,
    }">
    {{ $slot }}
</div>
