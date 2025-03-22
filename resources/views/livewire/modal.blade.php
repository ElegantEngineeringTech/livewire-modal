<div x-data="{
    open: $wire.entangle('open', false),
    components: $wire.entangle('components', false),
    stack: [],
    get active() {
        if (this.stack.length) {
            return this.stack[this.stack.length - 1];
        }

        return null;
    },
    get activeComponent() {
        return this.components.find((item) => item.id === this.active);
    },
    get lastComponent() {
        if (this.components.length) {
            return this.components[this.components.length - 1];
        }
        return null;
    },
    generateRandomId() {
        return Math.random().toString(36).substring(2, 7);
    },
    sync() {
        this.$wire.$refresh();
    },
    removeComponentById(id) {
        this.stack = this.stack.filter((item) => item !== id);
        this.components = this.components.filter((item) => item.id !== id);
    },
    makeComponentFromEvent(event) {
        const component = event.detail?.component ?? null;
        const props = event.detail?.props ?? [];
        const params = event.detail?.params ?? [];

        if (component) {
            return {
                component: component,
                props: props,
                params: params,
            };
        }

        return null;
    },
    addComponentFromEvent(event) {
        const component = this.makeComponentFromEvent(event);

        if (component) {
            component.id = this.generateRandomId();

            this.components.push(component);

            return component;
        }

        return null;
    },
    getPreloadedComponent(component) {
        if (this.lastComponent.component === component.component) {
            return this.lastComponent;
        }

        return null;
    },
    onPreload(event) {
        this.addComponentFromEvent(event);

        this.sync();
    },
    onOpen(event) {
        const eventComponent = this.makeComponentFromEvent(event);

        if (!eventComponent) {
            return null;
        }

        const preloaded = this.getPreloadedComponent(eventComponent);

        if (preloaded) {

            this.stack.push(preloaded.id);
            this.open = true;

        } else {
            const component = this.addComponentFromEvent(event);

            if (component) {
                this.stack.push(component.id);
                this.open = true;
                this.sync();
            }
        }

    },
    removeComponent(component) {
        this.components
            .filter((item) => item.component === component)
            .forEach((item) => this.removeComponentById(item.id));
    },
    removeActiveComponent() {
        if (this.active) {
            this.removeComponentById(this.active);
        }
    },
    onClose(event) {
        const component = this.makeComponentFromEvent(event);

        if (component) {
            this.removeComponent(component);
        } else {
            this.removeActiveComponent();
        }

        if (this.components.length < 1) {
            this.open = false;
        }

        this.sync();
    },
    onCloseAll() {
        this.stack = [];
        this.components = [];
        this.open = false;
        this.sync();
    },
    init() {
        this.$watch('open', (value) => {
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
}" style="display: none;" x-show="open" x-trap="open" x-on:modal-open.window="onOpen"
    x-on:modal-preload.window="onPreload" x-on:modal-close.window="onClose" x-on:modal-close-all.window="onCloseAll"
    x-on:mousedown.self="onClose" x-on:keyup.escape.prevent.stop="onClose" x-transition.opacity.duration.250ms
    class="fixed left-0 top-0 z-40 flex h-dvh w-full flex-col overflow-hidden bg-black/50" tabindex="0">

    @foreach ($components as ['id' => $id, 'component' => $component, 'props' => $props])
        <div wire:key="{{ $this->getId() }}.components.{{ $id }}" class="contents"
            x-show="active === '{{ $id }}'">
            @livewire($component, $props, key("{$this->getId()}.components.{$id}.component"))
        </div>
    @endforeach

</div>
