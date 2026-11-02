<script wire:ignore>
    document.addEventListener('alpine:init', () => {
        Alpine.directive('modal', (el, {
            value,
            modifiers,
            expression
        }, {
            Alpine,
            effect,
            evaluateLater,
            cleanup
        }) => {
            let prevent = modifiers && modifiers.includes('prevent');
            let stop = modifiers && modifiers.includes('stop');
            let params;

            if (expression) {
                let getParams = evaluateLater(expression);

                effect(() => {
                    getParams(result => {
                        params = result;
                    });
                });
            }

            if (value === 'open') {
                let preload = modifiers && modifiers.includes('preload');

                let onClick = e => {
                    prevent && e.preventDefault();
                    stop && e.stopImmediatePropagation();

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
                    el.removeEventListener('click', onClick, {
                        capture: true
                    });
                    if (preload) {
                        el.removeEventListener('mouseenter', onMouseenter, {
                            capture: true
                        });
                    }
                });

            } else if (value === 'close') {
                let onClick = e => {
                    prevent && e.preventDefault();
                    stop && e.stopImmediatePropagation();

                    Livewire.dispatch('modal-close', params);
                };

                el.addEventListener('click', onClick, {
                    capture: true
                });

                cleanup(() => {
                    el.removeEventListener('click', onClick, {
                        capture: true
                    });
                });
            } else if (value === 'close-all') {
                let onClick = e => {
                    prevent && e.preventDefault();
                    stop && e.stopImmediatePropagation();

                    Livewire.dispatch('modal-close-all', params);
                };

                el.addEventListener('click', onClick, {
                    capture: true
                });

                cleanup(() => {
                    el.removeEventListener('click', onClick, {
                        capture: true
                    });
                });
            }

        });
    });
</script>
