import './bootstrap';
import { createApp } from 'vue'
import CalendarIndex from './components/Index.vue'
import ScheduleIndex from './components/schedules/Index.vue'

import Reports from './components/Reports/Index.vue'



window.app = createApp({
    components: {
        CalendarIndex,
        ScheduleIndex,
        Reports
    },
}).mount('#app');
