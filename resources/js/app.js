import './bootstrap';
import { createApp } from 'vue'
import HelloWorld from './components/Index.vue'
import UserSummary from './components/user_summary/index.vue'


window.app = createApp({
    components: {
        HelloWorld,
        UserSummary
    },
}).mount('#app');
