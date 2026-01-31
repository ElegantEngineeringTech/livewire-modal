<x-livewire-modal::stack>
    <x-livewire-modal::slideover :position="$position" class="w-full overflow-auto rounded-md border bg-white sm:w-96">
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
                x-modal:open="{ modal: 'card', stack: 'card' }">
                Open Stacked Modal
            </button>

            <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                x-modal:open="{ modal: 'slideover', stack: 'slideover' }">
                Open Stacked Slideover
            </button>

            <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                x-modal:open="{ modal: 'slideover', props:{ position: 'left' }, stack: 'slideover-left' }">
                Open Stacked Slideover Left
            </button>
        </div>
    </x-livewire-modal::slideover>
</x-livewire-modal::stack>
