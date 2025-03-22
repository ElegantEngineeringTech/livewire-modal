<x-livewire-modal::slideover class="flex w-96 flex-col rounded-md bg-white">
    {{ now() }}
    <div class="m-auto">
        <button type="button" class="m-auto rounded-md border px-3.5 py-1.5 shadow-sm active:shadow-none"
            x-on:click="Livewire.dispatch('modal-open', { component: 'card' })">
            Open modal
        </button>
    </div>
</x-livewire-modal::slideover>
