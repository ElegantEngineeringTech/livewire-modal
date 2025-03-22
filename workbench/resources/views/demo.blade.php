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

<body class="flex h-dvh">

    <div class="m-auto flex gap-2" x-data>
        <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm active:shadow-none"
            x-modal:open.preload="{ component: 'card', props: { title: 'Hello' } }" x-on:mouseenter="console.log('on')">
            Open Modal Preloaded
        </button>
        <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm active:shadow-none"
            x-on:click="Livewire.dispatch('modal-open', { component: 'card', props: { title: 'Hello' } })">
            Open Modal
        </button>
        <button type="button" class="rounded-md border px-3.5 py-1.5 shadow-sm active:shadow-none"
            x-on:click="Livewire.dispatch('modal-open', { component: 'slideover' })">
            Open Slideover
        </button>
    </div>

    <livewire:modal />


    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.directive('modal', (el, {
                value,
                modifiers,
                expression
            }, {
                Alpine,
                effect,
                evaluate,
                cleanup
            }) => {
                console.log(value, modifiers, expression);

                if (value === 'open') {
                    let preload = modifiers && modifiers.includes('preload');

                    let params = evaluate(expression);

                    let onClick = e => {
                        e.preventDefault();

                        Livewire.dispatch('modal-open', params);
                    };

                    let onMouseenter = e => {
                        Livewire.dispatch('modal-preload', params);
                    };

                    el.addEventListener('click', onClick, {
                        capture: true
                    });

                    if (preload) {
                        el.addEventListener('mouseenter', onMouseenter, {
                            capture: true
                        });
                    }

                    cleanup(() => {
                        el.removeEventListener('click', onClick);
                        el.removeEventListener('mouseenter', onMouseenter);
                    });

                } else if (value === 'close') {
                    // 
                }

            });
        });
    </script>
</body>

</html>
