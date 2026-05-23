import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import i18n from './i18n';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { createApp, h } from 'vue';

import PublicLayout from './components/layout/PublicLayout.vue';

// Initialize AOS (Animate On Scroll)
AOS.init({
  duration: 800,
  once: true,
  easing: 'ease-out-cubic',
});

createInertiaApp({
    resolve: async (name) => {
        const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
        if (!name.startsWith('admin/')) {
            page.default.layout = page.default.layout || PublicLayout;
        }
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(createPinia())
            .use(i18n);

        // Global RouterLink compatibility component mapping to Inertia Link
        app.component('RouterLink', {
            props: ['to'],
            setup(props, { slots }) {
                return () => h(Link, { href: props.to }, slots);
            }
        });

        app.mount(el);
    },
});
