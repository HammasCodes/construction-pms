import Alpine from 'alpinejs';

/**
 * Animated number counter. Usage:
 *   <span x-data="counter(1234, 0)" x-text="display"></span>
 */
Alpine.data('counter', (target = 0, decimals = 0, duration = 1200) => ({
    value: 0,
    init() {
        const to = Number(target) || 0;
        const start = performance.now();
        const ease = (t) => 1 - Math.pow(1 - t, 3);
        const tick = (now) => {
            const p = Math.min((now - start) / duration, 1);
            this.value = to * ease(p);
            if (p < 1) {
                requestAnimationFrame(tick);
            } else {
                this.value = to;
            }
        };
        requestAnimationFrame(tick);
    },
    get display() {
        return this.value.toLocaleString('en-IN', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals,
        });
    },
}));

window.Alpine = Alpine;

Alpine.start();
