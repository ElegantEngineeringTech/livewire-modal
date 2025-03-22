@props([
    'position' => 'center-right',
])

<x-livewire-modal::modal :attributes="$attributes->class([
    'h-full',
    match ($position) {
        'center' => 'mx-6',
        'center-right' => 'mr-6',
        'center-left' => 'ml-6',
    },
])" :position="$position">
    {{ $slot }}
</x-livewire-modal::modal>
