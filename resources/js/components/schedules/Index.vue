<template>
    <div>
        <div class="w-full">
            <label for="filter1" class="block text-sm font-medium text-gray-700">Selecciona un contrato con el cual desea interactuar</label>
            <select id="filter1" v-model="selected_equipment" @change="setEquipment()" name="filter1" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="0">Selecciona un equipo o maquinaria</option>
                <option v-for="(equipment, index) in equipments" :value="equipment.id">{{ equipment.name }}</option>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 mt-4" v-if="loading">
        <div>
            <FullCalendar :options="calendarOptions">
            </FullCalendar>
        </div>
    </div>

    <div class="relative z-10" style="z-index: 99999;" v-if="openModal">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="text-center">
                            <strong><h4>{{ selected_date }}</h4></strong>
                        </div>

                        <div class="mt-3 text-center" >
                            <div class="mt-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <input id="name" v-model="data.description" type="text" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="w-full" v-if="error != ''">
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                    <strong class="font-bold">Hubo un error! </strong>
                                    <span class="block sm:inline">  {{error}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6" v-if="modalType == 'insert'">
                        <button type="button" class="primary inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto" @click="store()">Agregar nuevo registro</button>
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="resetData()">Cerrar</button>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6" v-if="modalType == 'edit'">
                        <button type="button" class="primary inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto" @click="store()">Editar</button>
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-red-500 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="deleteScheduling()">Eliminar registro</button>
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="resetData()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import esLocale from "@fullcalendar/core/locales/es";
export default {
    components: {
        FullCalendar
    },
    data(){
        return{
            calendarOptions: {
                plugins: [ dayGridPlugin, interactionPlugin ],
                initialView: 'dayGridMonth',
                dateClick: this.handleDateClick,
                locale: esLocale,
                events: [

                ],
                eventClick: (info) => {
                    this.clickEventAction(info.event.id)
                },
                validRange: {
                    start: new Date(),
                },
            },
            equipments : [],
            loading : false,
            selected_equipment : 0,
            selected_equipment_data : {},
            selected_date : '',
            openModal : false,
            data : {
                description : '',
                date : ''
            },
            error : '',
            modalType : 'insert'
        }
    },
    created(){
        this.getEquipment()
    },
    methods:{
        getEquipment(aux = false){
            axios.get('/equipmentMachinary/get').then(res=>{
                this.equipments = res.data.equipments
                if(aux){
                    this.loading = false
                    this.setEquipment()
                }
            }).catch(error=>{
                console.log(error.response)
            })
        },



        setEquipment(){
            if(this.selected_equipment != 0){
                let index = this.equipments.findIndex(equipment => equipment.id === this.selected_equipment)
                this.calendarOptions.events = this.equipments[index].schedules.map(schedule => ({
                    title: schedule.date,
                    date: schedule.date,
                    id: schedule.id
                }))
                this.loading = true
            }else{
                this.loading = false
                this.calendarOptions.events = []
            }
        },

        clickEventAction(id){
            axios.get(`/maintenance/scheduling/get/${id}`).then(res=>{
                this.data = res.data.scheduling
                this.selected_date = res.data.scheduling.date
                this.modalType = 'edit'
                this.openModal = true
            }).catch(error=>{
                console.log(error.response)
            })
        },

        handleDateClick: function(arg) {
            this.selected_date = arg.dateStr
            this.openModal = true
        },

        store(){
            let request = (this.modalType == 'edit') ?

                this.data

                :

                {
                    description : this.data.description,
                    date : this.selected_date,
                    equipment_machinery_id : this.selected_equipment
                }

            let route = (this.modalType == 'edit') ? `/maintenance/scheduling/update/${this.data.id}` : `/maintenance/scheduling/store`

            axios.post(route, request).then(res=>{
                if(res.data.status){
                    this.getEquipment(true)
                }
            }).catch(error=>{
                console.log(error.response)
            }).finally(()=>{
                this.resetData()
            })
        },

        deleteScheduling(){
            axios.get(`/maintenance/scheduling/delete/${this.data.id}`).then(res=>{
                if(res.data.status){
                    this.getEquipment(true)
                }
            }).finally(()=>{
                this.resetData()
            })
        },

        resetData(){
            this.data.description = ''
            this.selected_date = ''
            this.modalType = 'insert'
            this.openModal = false
        }
    }
}
</script>

<style>
    .fc-button { /* Personaliza los botones */
        background-color: #f29d11 !important; /* Color de fondo del botón */
        color: white !important; /* Color del texto del botón */
        border: none !important; /* Elimina el borde */
        cursor: pointer !important; /* Cambia el cursor al pasar el ratón por encima */
        padding: 10px 20px !important; /* Espaciado interno del botón */
        text-align: center !important; /* Alineación del texto */
        text-decoration: none !important; /* Elimina el subrayado del texto */
        display: inline-block !important;
        font-size: 16px !important;
        margin: 4px 2px !important;
        transition-duration: 0.4s !important; /* Duración de la transición */
        border-radius: 12px !important; /* Bordes redondeados del botón */
    }

    .fc-col-header-cell{
        background: #f29d11;
        color: white;
    }

    .primary{
        background-color: #f29d11 !important;
    }

    .primary:hover{
        background-color: #f7bf64 !important;
    }

    .fc-button:hover { /* Efecto hover del botón */
        background-color: white; /* Color de fondo al pasar el ratón por encima */
        color: black; /* Color del texto al pasar el ratón por encima */
    }
    .fc-daygrid-day:hover {
        background-color: #f5f5f5; /* Cambia este color al que prefieras */
    }
    @media (max-width: 600px) { /* Ajusta este valor al tamaño de pantalla que prefieras */
        .fc-toolbar-chunk {
            flex-wrap: wrap !important; /* Permite que los elementos dentro del contenedor se ajusten automáticamente a nuevas líneas según sea necesario */
        }
        .fc-toolbar-chunk {
            flex-basis: 100% !important; /* Hace que cada elemento ocupe el 100% del ancho del contenedor, forzándolos a ocupar su propia línea */
        }
        .fc-header-toolbar{
            flex-wrap: wrap !important;
        }
    }
    .fc-daygrid-event-harness{
        background: #f29d11;
    }
    .fc-event{
        background: #f29d11;
        border-color: #f29d11;
        cursor: pointer;
    }
    .input-filament{
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
    }
    .input-filament:focus {
        border-color: #f29d11 !important; /* Color del borde al enfocar el input */
        box-shadow: 0 0 0 3px rgba(242, 157, 17, 0.5) !important; /* Sombra al enfocar el input */
    }
</style>
