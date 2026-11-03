<script wire:ignore>
    document.addEventListener('alpine:init', () => {
        const events = {
            'open': 'modal-open',
            'close': 'modal-close',
            'close-all': 'modal-close-all',
        };

        // x-on modifiers forwarded to the click listener, the others don't make sense on a modal
        const clickModifiers = ['prevent', 'stop', 'self', 'throttle'];

        const isWait = modifier => /^\d+(ms)?$/.test(modifier);

        Alpine.directive('modal', Alpine.skipDuringClone((el, {
            value,
            modifiers,
            expression
        }, {
            evaluateLater,
            cleanup
        }) => {
            if (!events[value]) {
                return;
            }

            // Like x-on, the params are evaluated when the event fires, so they are always current
            let getParams = expression ? evaluateLater(expression) : callback => callback();

            let dispatch = (name, e) => getParams(params => {
                Livewire.dispatch(name, params);
            }, {
                scope: {
                    '$event': e
                },
                params: [e]
            });

            // x-on would take unknown modifiers such as `preload` for keys, and never fire on a click
            let forwarded = modifiers.filter((modifier, index) => {
                return clickModifiers.includes(modifier) || (modifiers[index - 1] === 'throttle' && isWait(modifier));
            });

            cleanup(Alpine.bind(el, {
                [[Alpine.prefixed('on:click'), ...forwarded].join('.')]: e => dispatch(events[value], e),
            }));

            if (value === 'open' && modifiers.includes('preload')) {
                let wait = modifiers[modifiers.indexOf('preload') + 1];
                let delay = isWait(wait) ? parseInt(wait) : 0;
                let timeout;

                let onMouseenter = e => {
                    timeout = setTimeout(() => dispatch('modal-preload', e), delay);
                };

                let onMouseleave = () => clearTimeout(timeout);

                el.addEventListener('mouseenter', onMouseenter);
                el.addEventListener('mouseleave', onMouseleave);

                cleanup(() => {
                    clearTimeout(timeout);
                    el.removeEventListener('mouseenter', onMouseenter);
                    el.removeEventListener('mouseleave', onMouseleave);
                });
            }
        }));
    });
</script>
