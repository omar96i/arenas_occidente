<template>
    <section>
        <label>Selecciona la fecha de registro</label>
        <div class="flex flex-row">
            <div class="w-full mx-1">
                <label for="filter1" class="block text-sm font-medium text-gray-700">Mes:</label>
                <select id="filter1" v-model="select_month" @change="getData()" name="filter1" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option v-for="(month, index) in months" :value="month.month">{{ month.name }}</option>
                </select>
            </div>
            <div class="w-full">
                <label for="filter2" class="block text-sm font-medium text-gray-700">Año:</label>
                <select id="filter2" v-model="select_year" @change="getData()" name="filter2" class="input-filament mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option v-for="(year, index) in years" :value="year">{{ year }}</option>
                </select>
            </div>
        </div>
    </section>
    <div>

    </div>
    <div class="grid grid-cols-1 gap-4 mt-4" v-if="loading">
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md my-5">
            <table class="w-full border-collapse bg-gray-50 text-left text-sm text-gray-500">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Equipo/Maquinaria</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Recibio</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Dio</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Total</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Ubicación</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    <tr class="hover:bg-gray-50 border borde" v-for="(item, index) in equipments_fuels" :key="index">
                        <td class="px-6 py-4">{{item.name}}</td>
                        <td class="px-6 py-4">{{item.fuel_data[0]?.fuel_total || '--'}}</td>
                        <td class="px-6 py-4">{{item.fuel_data[0]?.gave || '--' }}</td>
                        <td class="px-6 py-4">{{(item.fuel_data[0]?.fuel_total || 0) - (item.fuel_data[0]?.gave || 0)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    components: {

    },
    data(){
        return{
            equipments_fuels : [],
            select_month: 1,
            select_year: new Date().getFullYear(),
            loading: true,
            months: [
                { month: 1, name: 'Enero' },
                { month: 2, name: 'Febrero' },
                { month: 3, name: 'Marzo' },
                { month: 4, name: 'Abril' },
                { month: 5, name: 'Mayo' },
                { month: 6, name: 'Junio' },
                { month: 7, name: 'Julio' },
                { month: 8, name: 'Agosto' },
                { month: 9, name: 'Septiembre' },
                { month: 10, name: 'Octubre' },
                { month: 11, name: 'Noviembre' },
                { month: 12, name: 'Diciembre' }
            ],
            years: Array.from({ length: 8 }, (_, i) => (new Date().getFullYear() - 4) + i),
        }
    },
    created(){
        this.getData()
    },
    methods:{
        getData(){
            axios.get(`/equipmentMachinary/fuels/get/${this.select_month}/${this.select_year}`).then(res=>{
                this.equipments_fuels = res.data.equipments_fuels
                
            }).catch(error=>{
                console.log(error.response)
            })
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
