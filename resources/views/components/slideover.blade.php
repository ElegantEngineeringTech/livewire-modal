@props([
    'position' => 'right',
])

<x-livewire-modal::modal :attributes="$attributes->class([
    'h-full',
    match ($position) {
        'center' => 'mx-6',
        'right' => 'mr-6',
        'left' => 'ml-6',
        default => '',
    },
])" :position="$position">
    {{ $slot }}
</x-livewire-modal::modal>
