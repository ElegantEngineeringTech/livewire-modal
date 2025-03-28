@props([
    'position' => 'center',
])

<div x-data="{
    position: @js($position),
}"
    x-bind:class="{
        'm-auto': position === 'center',
        'mr-auto my-auto': position === 'left',
        'ml-auto my-auto': position === 'right',
        'mb-auto mx-auto': position === 'top',
        'mt-auto mx-auto': position === 'bottom',
        'mb-auto mr-auto': position === 'top-left',
        'mb-auto ml-auto': position === 'top-right',
        'mt-auto mr-auto': position === 'bottom-left',
        'mt-auto ml-auto': position === 'bottom-right',
    }"
    x-bind="modalAttributes" {!! $attributes->class(['max-w-full min-w-0 transition']) !!}>
    {{ $slot }}
</div>
