<x-livewire-modal::modal class="m-auto flex size-96 flex-col rounded-md bg-white">
    {{ now() }}
    <button type="button" class="m-auto rounded-md border px-3.5 py-1.5 shadow-sm active:shadow-none"
        x-on:click="Livewire.dispatch('modal-open', { component: 'slideover' })">
        Open Slideover
    </button>
</x-livewire-modal::modal>
