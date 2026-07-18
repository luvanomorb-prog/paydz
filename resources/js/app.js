import '../css/app.css'
import './bootstrap'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

import { createPinia } from 'pinia'
import ApexChartsPlugin from './Plugins/apexcharts'

const appName = import.meta.env.VITE_APP_NAME || 'PayDZ'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,

    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),

    setup({ el, App, props, plugin }) {

        const app = createApp({
            render: () => h(App, props),
        })

        app.use(plugin)
        app.use(ZiggyVue)
        app.use(createPinia())
        app.use(ApexChartsPlugin)

        app.mount(el)
    },

    progress: {
        color: '#10b981',
    },
})
