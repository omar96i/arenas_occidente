import './bootstrap';
import { createApp } from 'vue'
import HelloWorld from './components/Index.vue'

window.app = createApp({
    setup() {
        return {
            message: 'Welcome to Your Vue.js App',
        };
    },
    components: {
        HelloWorld
    },
}).mount('#app');