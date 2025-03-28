@props([
    'position' => 'right',
])

<x-livewire-modal::modal :attributes="$attributes->class(['h-full'])" :position="$position">
    {{ $slot }}
</x-livewire-modal::modal>
