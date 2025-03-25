<div x-data="{
    modalOpen: $wire.entangle('open', false),
    modalComponents: $wire.entangle('components', false), // Array of loaded modalComponents
    modalHistory: [], // Array or component Ids to display
    get modalActiveId() {
        return this.modalHistory.length ? this.modalHistory[this.modalHistory.length - 1] : null;
    },
    get modalActiveComponent() {
        return this.modalComponents.find((item) => item.id === this.modalActiveId);
    },
    get modalActiveStack() {
        return this.modalActiveComponent?.stack ?? null;
    },
    get modalLastComponent() {
        return this.modalComponents.length ? this.modalComponents[this.modalComponents.length - 1] : null;
    },
    areModalComponentsEqual(a, b) {
        return a.component === b.component && a.stack === b.stack &&
            JSON.stringify(a.props) === JSON.stringify(b.props) &&
            JSON.stringify(a.params) === JSON.stringify(b.params);
    },
    findModalHistoryIndex(id, reverse = false) {
        if (reverse) {
            return this.modalHistory.length - 1 - this.findModalHistoryIndex(id);
        }

        return this.modalHistory.findIndex((item) => id === item);
    },
    generateModalId() {
        return Math.random().toString(36).substring(2, 7);
    },
    makeModalComponent(event) {
        return {
            component: event.detail?.component ?? event.component ?? null,
            props: event.detail?.props ?? event.props ?? [],
            params: event.detail?.params ?? event.params ?? [],
            stack: event.detail?.stack ?? event.stack ?? this.$wire.stack,
        };
    },
    getPreloadedModalComponent(eventComponent) {
        if (
            eventComponent &&
            this.modalLastComponent &&
            this.modalLastComponent.preloaded &&
            this.areModalComponentsEqual(eventComponent, this.modalLastComponent)
        ) {
            return this.modalLastComponent;
        }

        return null;
    },
    onPreloadModal(event) {
        const eventComponent = this.makeModalComponent(event);

        const preloadedComponent = this.getPreloadedModalComponent(eventComponent);

        if (preloadedComponent) {
            return;
        }

        eventComponent.id = this.generateModalId();
        eventComponent.preloaded = true;

        this.modalComponents.push(eventComponent);

        this.$wire.$refresh();
    },
    openModal(eventComponent) {
        eventComponent.id = this.generateModalId();
        eventComponent.preloaded = false;

        this.modalComponents.push(eventComponent);
        this.modalHistory.push(eventComponent.id);

        this.modalOpen = true;
        this.$wire.$refresh();
    },
    openPreloadedModal(component) {
        component.preloaded = false;

        this.modalHistory.push(component.id);
        this.modalOpen = true;
    },
    onOpenModal(event) {
        const eventComponent = this.makeModalComponent(event);
        const preloadedComponent = this.getPreloadedModalComponent(eventComponent);

        if (preloadedComponent) {
            this.openPreloadedModal(preloadedComponent);
        } else {
            this.openModal(eventComponent);
        }
    },
    findModalById(id) {
        return this.modalComponents.find((item) => item.id === id);
    },
    removeModalById(id) {
        this.modalHistory = this.modalHistory.filter((item) => item !== id);
        this.modalComponents = this.modalComponents.filter((item) => item.id !== id);
    },
    removeModal(eventComponent) {
        this.modalComponents
            .filter((item) => item.component === eventComponent.component)
            .forEach((item) => this.removeModalById(item.id));
    },
    removeActiveModal() {
        this.modalActiveId && this.removeModalById(this.modalActiveId);
    },
    onCloseModal(event) {
        const eventComponent = this.makeModalComponent(event);

        if (eventComponent.component) {
            this.removeModal(eventComponent);
        } else {
            this.removeActiveModal();
        }

        this.modalOpen = this.modalHistory.length > 0;

        this.$wire.$refresh();
    },
    onCloseAllModal() {
        this.modalHistory = [];
        this.modalComponents = [];
        this.modalOpen = false;
        this.$wire.$refresh();
    },
    init() {
        this.$watch('modalOpen', (value) => {
            if (value) {
                window.document.body.style.top = `-${window.scrollY}px`;
                window.document.body.style.width = '100%';
                window.document.body.style.position = 'fixed';
            } else {
                const scrollY = document.body.style.top;

                window.document.body.style.position = '';
                window.document.body.style.width = '';
                window.document.body.style.top = '';
                window.scrollTo(0, parseInt(scrollY || '0') * -1);

            }
        });
    },
}" x-show="modalOpen" x-trap="modalOpen" x-on:modal-open.window="onOpenModal"
    x-on:modal-preload.window="onPreloadModal" x-on:modal-close.window="onCloseModal"
    x-on:modal-close-all.window="onCloseAllModal" x-on:mousedown.self="onCloseModal"
    x-on:keyup.escape.prevent.stop="onCloseModal" x-transition.opacity.duration.250ms
    class="fixed left-0 top-0 z-40 grid h-dvh w-full select-none overflow-hidden bg-black/30" tabindex="0"
    style="
        display: none;
        grid-template-areas: 'stack';
    ">

    @foreach ($components as $component)
        @php
            ['id' => $id, 'component' => $componentName, 'props' => $props, 'params' => $params] = $component;
        @endphp
        <div x-data="{
            modalPosition: [null, null],
            get modalId() {
                return '{{ $component['id'] }}';
            },
            get isModalActive() {
                return modalActiveId === this.modalId;
            },
            get modal() {
                return findModalById(this.modalId);
            },
            get modalStack() {
                return this.modal?.stack ?? null;
            },
            get isModalStacked() {
                return modalActiveStack && modalActiveStack === this.modalStack;
            },
            get modalIndexReversed() {
                return findModalHistoryIndex(this.modalId, true);
            },
            computeModalPosition() {
                const parent = this.$el.getBoundingClientRect();
                const rect = this.$el.firstElementChild.getBoundingClientRect();
        
                const dx = parent.width - rect.right;
                const dy = parent.height - rect.bottom;
        
                const px = dx === rect.left ? 'center' : dx < rect.left ? 'right' : 'left';
                const py = dy === rect.top ? 'center' : dy < rect.top ? 'bottom' : 'top';
        
                return [px, py];
            },
            get modalStackDirection() {
                const [px, py] = this.modalPosition;
        
                const directions = {
                    left: [1, 0],
                    right: [-1, 0],
                    top: [0, 1],
                    bottom: [0, -1],
                };
        
                return directions[px || py] || [0, -1];
            },
            init() {
                this.$nextTick(() => {
                    this.modalPosition = this.computeModalPosition();
                });
            },
            modalWrapper: {
                ['x-bind:inert']() {
                    return !this.isModalActive;
                },
                ['x-show']() {
                    if (this.isModalStacked) {
                        return modalHistory.includes(this.modalId);
                    }
                    return this.isModalActive;
                },
                ['x-bind:style']() {
                    let base = {
                        'grid-area': 'stack'
                    };
        
                    if (this.isModalStacked) {
                        const [dx, dy] = this.modalStackDirection;
        
                        return {
                            ...base,
                            '--dx': dx,
                            '--dy': dy,
                            '--i': this.modalIndexReversed,
                            transform: `scale(calc(1 - 0.05 * var(--i))) translate(calc(1rem * var(--dx) * var(--i)), calc(1rem * var(--dy) * var(--i)))`,
                            opacity: this.modalIndexReversed <= 2 ? 1 : 0,
                        };
                    }
        
                    return base;
                }
            },
        }" x-bind="modalWrapper"
            class="pointer-events-none isolate flex size-full min-w-0 select-text transition [&>*]:pointer-events-auto"
            wire:key="{{ $this->getId() }}.modalComponents.{{ $id }}">
            @livewire($componentName, $props, key("{$this->getId()}.modalComponents.{$id}.component"))
        </div>
    @endforeach

    @include('livewire-modal::directive')
</div>
