import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import CKEditor from '@ckeditor/ckeditor5-vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';


/* // vuetify UI */
import 'vuetify/dist/vuetify.min.css';
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import "@fortawesome/fontawesome-free/css/all.css";
import "@mdi/font/css/materialdesignicons.css";
import * as directives from 'vuetify/directives'
const vuetify = createVuetify({
    components,
    directives,
})

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use( CKEditor )
            .use(vuetify)  // vuetify UI
            .use(Vue3Toasity, {
                autoClose: 3000,
                position: "bottom-right",
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
