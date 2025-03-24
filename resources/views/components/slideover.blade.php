@props([
    'position' => 'right',
])

<x-livewire-modal::modal :attributes="$attributes->class([
    'h-full',
    match ($position) {
        'center' => 'sm:mx-6',
        'right' => 'sm:mr-6',
        'left' => 'sm:ml-6',
        default => '',
    },
])" :position="$position">
    {{ $slot }}
</x-livewire-modal::modal>
