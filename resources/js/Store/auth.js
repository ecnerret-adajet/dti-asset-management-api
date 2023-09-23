import { defineStore } from 'pinia';
import { router } from '@inertiajs/vue3'

export const useAuthStore = defineStore('auth', {

    state: () => ({
        authUser: null,
        api_token: null,
        error: null,
    }),

    getters: {
        user: (state) => state.authUser,
        has_error: (state) => state.error
    },

    actions: {

        async getToken() {
            await axios.get(`/sanctum/csrf-cookie`);
        },

        async getUser() {
            await this.getToken();
            await axios.get(`/api/user`)
            .then(res => {
                this.authUser = res.data.user;
            });
        },

        async onLogin(data) {
            await this.getToken();
            await axios.post(`/api/login`, {
                email: data.email,
                password: data.password
            })
            .then(res => {
                console.log(res.data)
            })
            router.get('/');
            // window.location.href = '/';
        }

    },

});
