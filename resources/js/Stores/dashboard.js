import { defineStore } from 'pinia'

export const useDashboardStore = defineStore('dashboard', {
    state: () => ({
        loading: false,
        dark: localStorage.getItem('dark') === 'true',
        notifications: [],
        activities: [],
    }),

    actions: {
        toggleDark() {
            this.dark = !this.dark
            localStorage.setItem('dark', this.dark)

            document.documentElement.classList.toggle(
                'dark',
                this.dark
            )
        },
    },
})
