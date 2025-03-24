<div x-data="{
    modalOpen: $wire.entangle('open', false),
    components: $wire.entangle('components', false), // Array of loaded components
    modalHistory: [], // Array or component Ids to display
    get modalActiveId() {
        return this.modalHistory.length ? this.modalHistory[this.modalHistory.length - 1] : null;
    },
    get activeComponent() {
        return this.components.find((item) => item.id === this.modalActiveId);
    },
    get activeStack() {
        return this.activeComponent?.stack ?? null;
    },
    get lastComponent() {
        return this.components.length ? this.components[this.components.length - 1] : null;
    },
    areComponentsEqual({ component: component1, props: props1, params: params1 }, { component: component2, props: props2, params: params2 }) {
        return component1 === component2 &&
            JSON.stringify(props1) === JSON.stringify(props2) &&
            JSON.stringify(params1) === JSON.stringify(params2);
    },
    findHistoryIndex(id, reverse = false) {
        if (reverse) {
            return this.modalHistory.length - 1 - this.findHistoryIndex(id);
        }

        return this.modalHistory.findIndex((item) => id === item);
    },
    sync() {
        this.$wire.$refresh();
    },
    generateRandomId() {
        return Math.random().toString(36).substring(2, 7);
    },
    makeComponentFromEvent(event) {
        return {
            component: event.detail?.component ?? null,
            props: event.detail?.props ?? [],
            params: event.detail?.params ?? [],
            stack: event.detail?.stack ?? this.$wire.stack,
        };
    },
    getPreloadedComponent(eventComponent) {
        if (
            eventComponent &&
            this.lastComponent &&
            this.lastComponent.preloaded &&
            this.areComponentsEqual(eventComponent, this.lastComponent)
        ) {
            return this.lastComponent;
        }

        return null;
    },
    onPreload(event) {
        const eventComponent = this.makeComponentFromEvent(event);

        const preloadedComponent = this.getPreloadedComponent(eventComponent);

        if (preloadedComponent) {
            return;
        }

        eventComponent.id = this.generateRandomId();
        eventComponent.preloaded = true;

        this.components.push(eventComponent);

        this.sync();
    },
    openNewComponent(eventComponent) {
        eventComponent.id = this.generateRandomId();

        this.components.push(eventComponent);
        this.modalHistory.push(eventComponent.id);

        this.modalOpen = true;
        this.sync();
    },
    openPreloadedComponent(component) {
        component.preloaded = false;

        this.modalHistory.push(component.id);
        this.modalOpen = true;
    },
    onOpen(event) {
        const eventComponent = this.makeComponentFromEvent(event);
        const preloadedComponent = this.getPreloadedComponent(eventComponent);

        if (preloadedComponent) {
            this.openPreloadedComponent(preloadedComponent);
        } else {
            this.openNewComponent(eventComponent);
        }
    },
    findComponentById(id) {
        return this.components.find((item) => item.id === id);
    },
    removeComponentById(id) {
        this.modalHistory = this.modalHistory.filter((item) => item !== id);
        this.components = this.components.filter((item) => item.id !== id);
    },
    removeComponent(eventComponent) {
        this.components
            .filter((item) => item.component === eventComponent.component)
            .forEach((item) => this.removeComponentById(item.id));
    },
    removeActiveComponent() {
        this.modalActiveId && this.removeComponentById(this.modalActiveId);
    },
    onClose(event) {
        const eventComponent = this.makeComponentFromEvent(event);

        if (eventComponent.component) {
            this.removeComponent(eventComponent);
        } else {
            this.removeActiveComponent();
        }

        this.modalOpen = this.modalHistory.length > 0;

        this.sync();
    },
    onCloseAll() {
        this.modalHistory = [];
        this.components = [];
        this.modalOpen = false;
        this.sync();
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
}" x-show="modalOpen" x-trap="modalOpen" x-on:modal-open.window="onOpen"
    x-on:modal-preload.window="onPreload" x-on:modal-close.window="onClose" x-on:modal-close-all.window="onCloseAll"
    x-on:mousedown.self="onClose" x-on:keyup.escape.prevent.stop="onClose" x-transition.opacity.duration.250ms
    class="fixed left-0 top-0 z-40 grid h-dvh w-full select-none overflow-hidden bg-black/30" tabindex="0"
    style="
        display: none;
        grid-template-areas: 'stack';
    ">

    @foreach ($components as $item)
        @php
            ['id' => $id, 'component' => $componentName, 'props' => $props, 'params' => $params] = $item;
        @endphp
        <div x-data="{
            get modalId() {
                return '{{ $id }}';
            },
            get isModalActive() {
                return modalActiveId === this.modalId;
            },
            get isModalStacked() {
                const component = findComponentById(this.modalId);
                const componentStack = component?.stack ?? null;
        
                return activeStack && activeStack === componentStack;
            },
            get modalIndexReversed() {
                return findHistoryIndex(this.modalId, true);
            },
            modalWrapper: {
                ['x-bind:class']() {
                    if (this.isModalStacked) {
                        return 'relative flex size-full pointer-events-none [&>*]:pointer-events-auto';
                    }
                    return 'contents';
                },
                ['x-bind:style']() {
                    return `grid-area: stack;`;
                },
                ['x-bind:inert']() {
                    return !this.isModalActive;
                },
                ['x-show']() {
                    if (this.isModalStacked) {
                        return modalHistory.includes(this.modalId);
                    }
                    return this.isModalActive;
                },
            },
        }" x-bind="modalWrapper" class="select-text"
            wire:key="{{ $this->getId() }}.components.{{ $id }}">
            @livewire($componentName, $props, key("{$this->getId()}.components.{$id}.component"))
        </div>
    @endforeach

    @include('livewire-modal::directive')

</div>
