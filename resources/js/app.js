import './bootstrap';
import { createApp } from 'vue'
import CalendarIndex from './components/Index.vue'
import UserSummary from './components/user_summary/index.vue'
import ScheduleIndex from './components/schedules/Index.vue'
import PruebaIndex from './components/Prueba.vue'



window.app = createApp({
    components: {
        CalendarIndex,
        UserSummary,
        ScheduleIndex,
        PruebaIndex
    },
}).mount('#app');
