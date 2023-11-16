import './bootstrap';
import { createApp } from 'vue'
import HelloWorld from './components/Index.vue'


window.app = createApp({
    components: {
        HelloWorld,
    },
}).mount('#app');
