<x-livewire-modal::slideover class="flex w-96 flex-col rounded-md border bg-white" :position="$position">

    <div class="p-5">
        <p>
            Modal ID: <span x-text="modalId"></span>
        </p>
        <p>
            Rendered At: <span>{{ now() }}</span>
        </p>
    </div>

    <div class="flex flex-col gap-2 p-5">
        <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
            x-modal:open="{ component: 'card' }">
            Open Modal
        </button>

        <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
            x-modal:open="{ component: 'slideover' }">
            Open Slideover
        </button>

        <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
            x-modal:open="{ component: 'card', stack: 'card' }">
            Open Stacked Modal
        </button>

        <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
            x-modal:open="{ component: 'slideover', stack: 'slideover' }">
            Open Stacked Slideover
        </button>

        <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
            x-modal:open="{ component: 'slideover', props:{ position: 'left' }, stack: 'slideover-left' }">
            Open Stacked Slideover Left
        </button>
    </div>
</x-livewire-modal::slideover>
