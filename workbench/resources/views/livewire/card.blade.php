<x-livewire-modal::stack>
    <x-livewire-modal::modal :position="$position" class="size-96 overflow-auto rounded-md border bg-white">
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
                x-modal:open="{ modal: 'card' }">
                Open Modal
            </button>

            <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                x-modal:open="{ modal: 'slideover' }">
                Open Slideover
            </button>

            <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                x-modal:open="{ modal: 'slideover', stack: 'slideover' }">
                Open Stacked Slideover
            </button>
        </div>

        <div class="flex flex-col gap-2 p-5">
            <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                x-modal:open="{ modal: 'card', stack: 'card', }">
                Open Stacked
            </button>
            <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                x-modal:open="{ modal: 'card', stack: 'card', props: { position: 'left' } }">
                Open Stacked Left
            </button>
            <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                x-modal:open="{ modal: 'card', stack: 'card', props: { position: 'right' } }">
                Open Stacked Right
            </button>

            <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                x-modal:open="{ modal: 'card', stack: 'card', props: { position: 'bottom' } }">
                Open Stacked Bottom
            </button>

            <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                x-modal:open="{ modal: 'card', stack: 'card', props: { position: 'top' } }">
                Open Stacked Top
            </button>
        </div>
    </x-livewire-modal::modal>
</x-livewire-modal::stack>
