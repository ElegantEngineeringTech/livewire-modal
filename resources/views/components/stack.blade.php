@props([
    'fullscreen' => false,
])

<div {!! $attributes->class([
    'pt-20 sm:p-5' => !$fullscreen,
    'size-full min-w-0 flex pointer-events-none [&>*]:pointer-events-auto',
]) !!} x-data="{
    modalPosition: [null, null],
    get modalIndexReversed() { return findModalHistoryIndex(modalId, true); },
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
    computeModalPosition() {
        const parent = this.$el.getBoundingClientRect();
        const rect = this.$el.firstElementChild.getBoundingClientRect();

        const dx = parent.width - rect.right;
        const dy = parent.height - rect.bottom;

        const px = dx === rect.left ? 'center' : dx < rect.left ? 'right' : 'left';
        const py = dy === rect.top ? 'center' : dy < rect.top ? 'bottom' : 'top';

        return [px, py];
    },
    init() {
        this.$nextTick(() => {
            this.modalPosition = this.computeModalPosition();
        });
    },
    modalAttributes: {
        ['x-show']() { return isModalStacked ? modalHistory.includes(modalId) : isModalActive; },
        ['x-bind:inert']() { return !isModalActive },
        ['x-bind:style']() {
            if (isModalStacked) {
                const [dx, dy] = this.modalStackDirection;

                return {
                    '--dx': dx,
                    '--dy': dy,
                    '--i': this.modalIndexReversed,
                    transform: `scale(calc(1 - 0.05 * var(--i))) translate(calc(2rem * var(--dx) * var(--i)), calc(2rem * var(--dy) * var(--i)))`,
                    opacity: this.modalIndexReversed <= 2 ? 1 : 0,
                };
            }

            return {};
        },
    },
}">
    {{ $slot }}
</div>
