require('./bootstrap');

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { createPinia } from 'pinia';
import Neat from '@/Mixins/Neat.vue';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const pinia = createPinia();

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .use(VueSweetalert2);
    
    // Make Swal available globally
    window.Swal = app.config.globalProperties.$swal;
    
    // Make route helper available globally if Ziggy is present
    if (window.route) {
      app.config.globalProperties.route = window.route;
    }
    
    app.mount(el);
  },
});

InertiaProgress.init({ color: '#ffab40' });

