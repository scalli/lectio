require('./bootstrap');

import { createApp, h } from 'vue';
// import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { createInertiaApp } from '@inertiajs/vue3'
// import { InertiaProgress } from '@inertiajs/progress';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    progress: {
        color: '#4B5563',
      },
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

// InertiaProgress.init({ color: '#4B5563' });
