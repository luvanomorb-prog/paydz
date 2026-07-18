import VueApexCharts from 'vue3-apexcharts'

export default {
    install(app) {
        app.use(VueApexCharts)
        app.component('apexchart', VueApexCharts)
    },
}
