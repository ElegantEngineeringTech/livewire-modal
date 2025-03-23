<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/iconify-icon@2.3.0/dist/iconify-icon.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="" x-data>
    <div class="grid grid-cols-1 divide-x md:grid-cols-3 [&>*]:h-60">

        <div class="isolate flex flex-col">
            <div class="p-3">
                <h1 class="font-semibold">Simple Modal</h1>
            </div>
            <div class="flex grow flex-wrap items-center justify-center gap-2 border-b">

                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'card' }">
                    Open Modal
                </button>
                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'card', props: { position: 'left' } }">
                    Open Left
                </button>
                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'card', props: { position: 'right' } }">
                    Open Right
                </button>

                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'card', props: { position: 'bottom' } }">
                    Open Bottom
                </button>

                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'card', props: { position: 'top' } }">
                    Open Top
                </button>

            </div>
        </div>

        <div class="isolate flex flex-col">
            <div class="p-3">
                <h1 class="font-semibold">Preloaded Modal</h1>
            </div>
            <div class="flex grow items-center justify-center border-b">

                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open.preload="{ component: 'card' }">
                    Open Preloaded Modal
                </button>

            </div>
        </div>

        <div class="isolate flex flex-col">
            <div class="p-3">
                <h1 class="font-semibold">Stacked Modal</h1>
            </div>
            <div class="flex grow items-center justify-center border-b">

                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'card', params:{ mode: 'stack' } }">
                    Open Stacked Modal
                </button>

            </div>
        </div>

        <div class="isolate flex flex-col">
            <div class="p-3">
                <h1 class="font-semibold">Simple Slideover</h1>
            </div>
            <div class="flex grow flex-wrap items-center justify-center gap-2 border-b">

                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'slideover' }">
                    Open Slideover
                </button>
                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'slideover', props: { position: 'left' } }">
                    Open Left
                </button>
                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'slideover', props: { position: 'right' } }">
                    Open Right
                </button>

            </div>
        </div>

        <div class="isolate flex flex-col">
            <div class="p-3">
                <h1 class="font-semibold">Stacked Slideover</h1>
            </div>
            <div class="flex grow flex-wrap items-center justify-center gap-2 border-b">

                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'slideover', params:{ mode: 'stack' } }">
                    Open Stacked Slideover
                </button>

                <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm focus:ring active:shadow-none"
                    x-modal:open="{ component: 'slideover', props:{ position: 'left' }, params:{ mode: 'stack' } }">
                    Open Left
                </button>

            </div>
        </div>

    </div>

    <livewire:modal />
</body>

</html>
