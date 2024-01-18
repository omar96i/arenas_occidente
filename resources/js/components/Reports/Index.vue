<template>
    <div>
        <label>Consultar Informes de:</label>
        <div class="w-full">
            <label for="filter1" class="block text-sm font-medium text-gray-700"></label>
            <select id="filter1" v-model="selected_report" @change="setReport()" name="filter1" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="" disabled selected>Selecciona un informe</option>
                <option v-for="(report, index) in reports" :value="report.value">{{ report.name }}</option>
            </select>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 mt-4" v-if="loading">
        <div v-if="selected_report == 'resumen_salarios'">
            <user-salary :entities="entities" :segments="segments"></user-salary>
        </div>
        <div v-if="selected_report == 'combustible_equipos'">
            <equipment-fuel></equipment-fuel>
        </div>
        <div v-if="selected_report == 'redimiento_equipos'">
            <equipment-performance></equipment-performance>
        </div>
        <div v-if="selected_report == 'detalle_contratos'">
            <h5>Detalles por Contrato (Combustible)</h5>
        </div>
    </div>
</template>
<script>
import UserSalary from '../UserSalary/Index.vue';
import EquipmentFuel from '../EquipmentFuel/Index.vue';
import EquipmentPerformance from '../EquipmentPerformance/Index.vue';
export default {
    props: ['entities', 'segments'],
    components: {
        UserSalary,
        EquipmentFuel,
        EquipmentPerformance,
    },
    data(){
        return{
            reports: [
                {value: 'resumen_salarios', name: 'Resumen de Salarios'},
                {value: 'combustible_equipos', name: 'Combustible por Equipos'},
                {value: 'redimiento_equipos', name: 'Redimiento por Equipos'},
                {value: 'detalle_contratos', name: 'Detalle por Contratos'},
            ],
            selected_report: '',
            equipments : [],
            loading : true,
            selected_equipment : 0,
        }
    },
    created(){
        this.getEquipment()
    },
    methods:{
        setReport(){
            console.log(this.selected_report);
        },
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
