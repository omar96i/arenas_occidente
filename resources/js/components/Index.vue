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
<script>
    import FullCalendar from '@fullcalendar/vue3'
    import interactionPlugin from '@fullcalendar/interaction'; // for selectable
    import dayGridPlugin from '@fullcalendar/daygrid'; // for dayGridMonth view
    import esLocale from "@fullcalendar/core/locales/es";

    export default {
        components: {
            FullCalendar
        },
        data() {
            return {
                calendarOptions: {
                    plugins: [ dayGridPlugin, interactionPlugin ],
                    initialView: 'dayGridMonth',
                    dateClick: this.handleDateClick,
                    locale: esLocale,
                    selectable: true,
                    events: [
                        // Quiero obtener el valor de cuando se le de click a uno de los eventos de aqui
                    ],
                    eventClick: (info) => {
                        this.clickEventAction(info.event.id)
                    },
                    select: function(info) {
                        alert('selected ' + info.startStr + ' to ' + info.endStr);
                    }
                },
                loading: false,
                selected_entity : 0,
                entities : [],
                find_entity : {},
                selected_segment : 0,
                employees : [],
                selected_employee : 0,
                selected_date : '',
                openModal : false,
                general_employees : [],
                measures : [],
                data : {
                    segment : 0,
                    measure : 0,
                    user : 0
                },
                error : '',
                action : 'insert',
                actualShift : {},
                dataSegment : {
                    entity_id : '',
                    name : '',
                    sub_title : '',
                    time_limit : '',
                },
                modalType : 'shift'
            }
        },
        created(){
            this.getEntity()
        },
        methods: {

            clickEventAction(id){
                axios.get(`/entity/getShift/${id}`).then(res=>{
                    this.actualShift = res.data.shift
                    this.data = {
                        segment : res.data.shift.entity_segment_id,
                        measure : res.data.shift.entity_measure_id,
                        user : res.data.shift.user_id
                    }
                    this.selected_date = res.data.shift.date
                    this.modalType = 'shift'
                    this.action = 'edit'
                    this.openModal = true
                }).catch(error=>{
                    console.log(error.response)
                })
            },

            handleDateClick: function(arg) {
                this.selected_date = arg.dateStr
                this.modalType = 'shift'
                this.openModal = true
                this.action = 'insert'
                if(this.selected_segment != 0){
                    this.data.segment = this.selected_segment
                }else{
                    this.data.segment = 0
                }
            },

            closeModal(){
                this.openModal = false
                this.error = ''
                this.modalType = ''

            },

            getEntity(aux = false){
                axios.get('/entity/get').then(res=>{
                    this.entities = res.data.entities
                    this.general_employees = res.data.employees
                    if(aux){
                        this.setEntity(true)
                    }
                }).catch(error=>{
                    console.log(error.response)
                })
            },

            setEntity(aux = false){
                if(!aux){
                    this.selected_segment = 0
                }
                if(this.selected_entity != 0){
                    let index = this.entities.findIndex(objeto => objeto.id === this.selected_entity)
                    this.find_entity = this.entities[index]
                    this.measures = this.entities[index].measures
                    this.employees = []
                    this.calendarOptions.events = []
                    this.selected_employee = 0
                    this.loading = true
                }else{
                    this.loading = false
                }
                if(aux){
                    this.getEmployees()
                }
            },

            getEmployees(){
                axios.get(`/entity/getEmployee/${this.selected_segment}`).then(res=>{
                    let index = this.find_entity.segments.findIndex(objeto => objeto.id === this.selected_segment)
                    let segment = this.find_entity.segments[index]
                    this.calendarOptions.events = segment.shifts.map(shift => ({
                        title: shift.user.full_name + " - "+ shift.measure.name,
                        date: shift.date,
                        id: shift.id
                    }))
                    this.employees = res.data.employees
                }).catch(error=>{
                    console.log(error.response)
                })
            },

            setEmployee(){
                let index = this.find_entity.segments.findIndex(objeto => objeto.id === this.selected_segment)
                let segment = this.find_entity.segments[index]
                this.calendarOptions.events = segment.shifts
                .filter(shift => shift.user.id === this.selected_employee)
                .map(shift => ({
                    title: shift.user.full_name + " - " + shift.measure.name,
                    date: shift.date,
                    id: shift.id,
                }));
            },

            deleteShift(){
                axios.get(`/entity/shift/delete/${this.actualShift.id}`).then(res=>{
                    if(res.data.status){
                        this.actualShift = {}
                        this.getEntity(true)
                        this.resetData()
                    }
                }).catch(error=>{
                    console.log(error.response)
                })
            },

            storeSegment(){
                this.dataSegment.entity_id = this.selected_entity
                if(this.dataSegment.name != '' && this.dataSegment.sub_title != '' && this.dataSegment.time_limit != ''){
                    axios.post('/entity/segment/store', this.dataSegment).then(res=>{
                        this.error = ''
                        if(res.data.status){
                            this.getEntity(true)
                            this.resetData()
                        }else{
                            this.error = res.data.msg
                        }
                        console.log(res.data)
                    }).catch(error=>{
                        this.error = "Error en el servidor"
                        console.log(error.response)
                    })
                }else{
                    this.error = "Todos los campos son requeridos"
                }
            },

            openModalAux(text){
                this.modalType = text
                this.openModal = true
            },

            store(){
                let request = {
                    date : this.selected_date,
                    segment : this.data.segment,
                    measure : this.data.measure,
                    user : this.data.user
                }
                if(request.date != '' && request.segment != '' && request.measure != '' && request.user != ''){
                    let route = (this.action == 'insert') ? '/entity/shift/store' : `/entity/shift/edit/${this.actualShift.id}`
                    axios.post(route, request).then(res=>{
                        this.error = ''
                        if(res.data.status){
                            this.getEntity(true)
                            this.resetData()
                        }else{
                            this.error = res.data.msg
                        }
                        console.log(res.data)
                    }).catch(error=>{
                        this.error = "Error en el servidor"
                        console.log(error.response)
                    })
                }else{
                    this.error = "Todos los campos son requeridos"
                }

            },

            resetData(){
                //Store action
                this.data = {
                    segment : 0,
                    measure : 0,
                    user : 0
                }
                this.selected_date = ''
                this.dataSegment = {
                    entity_id : '',
                    name : '',
                    sub_title : '',
                    time_limit : '',
                }
                this.modalType = 'shift'
                this.closeModal()
            }
        },
    }
</script>

<template>
    <div v-if="!loading">
        <div class="w-full">
            <label for="filter1" class="block text-sm font-medium text-gray-700">Selecciona un contrato con el cual desea interactuar</label>
            <select id="filter1" v-model="selected_entity" @change="setEntity()" name="filter1" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="0">Selecciona un contrato</option>
                <option v-for="(entity, index) in entities" :value="entity.id">{{ entity.name }}</option>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" v-if="loading">
        <div class="col-span-2">
            <FullCalendar :options="calendarOptions">
                <template v-slot:eventContent='arg'>
                    <b>{{ arg.event.title }}</b>
                </template>
            </FullCalendar>
        </div>
        <div>
            <div class="grid grid-cols-1">
                <button type="button" class="primary inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto" @click="openModalAux('form_segment')">Agregar una nueva area</button>
                <div class="p-3">
                    <h4>Buscar por:</h4><br>
                    <div class="flex flex-col space-y-4">
                        <div class="w-full">
                            <label for="filter1" class="block text-sm font-medium text-gray-700">Contrato</label>
                            <select id="filter1" v-model="selected_entity" @change="setEntity()" name="filter1" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="0">Selecciona un contrato</option>
                                <option v-for="(entity, index) in entities" :value="entity.id">{{ entity.name }}</option>
                            </select>
                        </div>
                        <div class="w-full">
                            <label for="filter2" class="block text-sm font-medium text-gray-700">Area</label>
                            <select id="filter2" v-model="selected_segment" @change="getEmployees()" name="filter2" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="0">Selecciona un Area</option>
                                <option v-for="(segment, index) in find_entity.segments" :value="segment.id">{{ segment.name+" - "+segment.sub_title }}</option>
                            </select>
                        </div>
                        <div class="w-full">
                            <label for="filter3" class="block text-sm font-medium text-gray-700">Empleado</label>
                            <select id="filter3" v-model="selected_employee" @change="setEmployee()" name="filter3" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="0">Selecciona un empleado</option>
                                <option v-for="(employee, index) in employees" :value="employee.id">{{ employee.full_name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="relative z-10" style="z-index: 99999;" v-if="openModal">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <!-- Formulario de registro de los turnos -->
                        <div class="mt-3 text-center" v-if="modalType == 'shift'">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Fecha seleccionada: {{selected_date}}</h3>
                            <div class="mt-2">
                                <div class="flex flex-col space-y-4">
                                    <div class="w-full">
                                        <label for="filter1" class="block text-sm font-medium text-gray-700">Selecciona un segmento</label>
                                        <select id="filter1" v-model="data.segment" name="filter2" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="0">Selecciona un segmento</option>
                                            <option v-for="(segment, index) in find_entity.segments" :value="segment.id">{{ segment.name+" - "+segment.sub_title }}</option>
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <label for="filter2" class="block text-sm font-medium text-gray-700">Selecciona el turno</label>
                                        <select id="filter2" v-model="data.measure"  name="filter3" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="0">Selecciona un turno</option>
                                            <option v-for="(measure, index) in measures" :value="measure.id">{{ measure.name }}</option>
                                        </select>
                                    </div>
                                    <div class="w-full">
                                        <label for="filter3" class="block text-sm font-medium text-gray-700">Selecciona el empleado</label>
                                        <select id="filter3" v-model="data.user"  name="filter3" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="0">Selecciona un empleado</option>
                                            <option v-for="(employee, index) in general_employees" :value="employee.id">{{ employee.full_name }}</option>
                                        </select>
                                    </div>
                                    <div class="w-full" v-if="error != ''">
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                            <strong class="font-bold">Hubo un error!</strong>
                                            <span class="block sm:inline">  {{error}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-center" v-if="modalType == 'form_segment'">
                            <div class="mt-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Area:</label>
                                <input id="name" v-model="dataSegment.name" type="text" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="mt-3">
                                <label for="sub_title" class="block text-sm font-medium text-gray-700">Mes:</label>
                                <select id="sub_title" v-model="dataSegment.sub_title" name="filter2" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="0">Selecciona un mes</option>
                                    <option value="enero">Enero</option>
                                    <option value="febrero">Febrero</option>
                                    <option value="marzo">Marzo</option>
                                    <option value="abril">Abril</option>
                                    <option value="mayo">Mayo</option>
                                    <option value="junio">Junio</option>
                                    <option value="julio">Julio</option>
                                    <option value="agosto">Agosto</option>
                                    <option value="septiembre">Septiembre</option>
                                    <option value="octubre">Octubre</option>
                                    <option value="noviembre">Noviembre</option>
                                    <option value="diciembre">Diciembre</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="time_limit" class="block text-sm font-medium text-gray-700">Tiempo limite:</label>
                                <input id="time_limit" v-model="dataSegment.time_limit" type="number" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="w-full" v-if="error != ''">
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                    <strong class="font-bold">Hubo un error! </strong>
                                    <span class="block sm:inline">  {{error}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6" v-if="modalType == 'shift'">
                        <button type="button" class="primary inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto" @click="store()">{{ (action == 'edit') ? 'Editar registro' : 'Agregar nuevo registro' }}</button>
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-red-500 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="deleteShift()" v-if="action == 'edit'">Eliminar registro</button>
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="resetData()">Cerrar</button>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6" v-if="modalType == 'form_segment'">
                        <button type="button" class="primary inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto" @click="storeSegment()">Agregar nuevo registro</button>
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="resetData()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
