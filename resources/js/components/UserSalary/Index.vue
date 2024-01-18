<template lang="">
    <section>
        <div class="flex flex-row">
            <div class="basis-2/5 mx-2">
                <label for="select_entity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Contrato:</label>
                <select id="select_entity" v-model="select_entity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected disabled value=''>Seleccion un contrato</option>
                    <option v-for="(item, index) in entities" :value="item">{{item.name}}</option>
                </select>
            </div>
            <div class="basis-2/5 mx-2">
                <label for="select_segment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Area:</label>
                <select id="select_segment" v-model="select_segment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected disabled value=''>Selecciona un area</option>
                    <template v-for="(item, index) in segments">
                        <option v-if="item.entity_id === select_entity.id" :value="item">{{item.name}}</option>
                    </template>
                </select>
            </div>
            <div class="mx-2">
                <div class="fi-ac gap-3 flex flex-wrap items-center justify-start shrink-0 sm:mt-7">
                    <button type="button" class="primary inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto" @click="getUsersSalary()">Buscar</button>
                </div>
            </div>
        </div>
    </section>
    <section class="mt-8">
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md my-5">
            <table class="w-full border-collapse bg-gray-50 text-left text-sm text-gray-500">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Contrato</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Area</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Usuario</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Salario</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Salario x Area</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    <tr class="hover:bg-gray-50 border borde" v-for="(item, index) in users_salary" :key="index">
                        <td class="px-6 py-4">{{select_entity.name}}</td>
                        <td class="px-6 py-4">{{select_segment.name}} </td>
                        <td class="px-6 py-4">{{item.name}}</td>
                        <td class="px-6 py-4">{{formatMoney(item.contract_active.salary)}} </td>
                        <td class="px-6 py-4">{{formatMoney(item.total_salary)}} </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-4">
                                <button @click="openModal(item)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal -->
    <div class="relative z-10" style="z-index: 99999;" v-if="isModalOpen">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="mt-3 text-center ">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Tabla de valores por hora</h3>
                            <div class="mt-2">
                                <button
                                    @click="activeTab = 'base'"
                                    :class="{ 'fi-btn-active': activeTab === 'base' }"
                                    class="fi-btn fi-btn-segmento"
                                    >
                                    <span class="fi-btn-label">Base</span>
                                </button>

                                <button
                                    @click="activeTab = 'segmento'"
                                    :class="{ 'fi-btn-active': activeTab === 'segmento' }"
                                    class="fi-btn fi-btn-segmento"
                                    >
                                    <span class="fi-btn-label">Area</span>
                                </button>

                                <div v-if="activeTab === 'base'">
                                    <div class="flex flex-col space-y-4">
                                        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-5">
                                            <table class="w-full border-collapse bg-gray-50 text-left text-sm text-gray-500">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Recargo</th>
                                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Porcentaje sobre el cual se paga</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Hora Ordinaria</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.valor_hora)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Nocturno</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.valor_hora * 1.35)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Extra Diurno</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.valor_hora * 1.25)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Extra Nocturno</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.valor_hora * 1.75)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Dominical y Festivo</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.valor_hora * 1.75)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Extra Diurno en dominical y festivo</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.valor_hora * 2)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Extra Nocturno en dominical y festivo</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.valor_hora * 2.5)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Nocturno en dominical y festivo</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.valor_hora * 2.1)}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div v-else-if="activeTab === 'segmento'">
                                    <div class="flex flex-col space-y-4">
                                        <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md my-5">
                                            <table class="w-full border-collapse bg-gray-50 text-left text-sm text-gray-500">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Recargo</th>
                                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Porcentaje sobre el cual se paga</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Hora Ordinaria</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.value_day)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Nocturno</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.value_night)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Extra Diurno</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.value_extra_day)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Extra Nocturno</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.value_extra_night)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Dominical y Festivo</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.value_day_weekend)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Extra Diurno en dominical y festivo</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.value_extra_day_weekend)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Extra Nocturno en dominical y festivo</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.value_extra_night_weekend)}}</td>
                                                    </tr>
                                                    <tr class="hover:bg-gray-50 border borde">
                                                        <td class="px-6 py-4">Trabajo Nocturno en dominical y festivo</td>
                                                        <td class="px-6 py-4">{{formatMoney(data_user_modal.value_night_weekend)}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" class="mt-3  inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="closeModal()">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['entities', 'segments'],
    data() {
        return {
            select_entity: '',
            select_segment: '',
            users_salary: [],
            isModalOpen: false,
            data_user_modal: {},
            activeTab: 'base',
        }
    },
    methods: {
        getUsersSalary() {
            axios.get(`/getUsersSalary/${this.select_segment.id}`).then(res => {
                console.log(res);
                this.users_salary = res.data.users_salary
                this.calculateSalary()
            }).catch(error => {
                console.log(error);
            })
        },
        openModal(data_user) {
            this.data_user_modal = data_user
            this.data_user_modal['valor_hora'] = this.data_user_modal.contract_active.salary / 235.66
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        calculateSalary() {
            this.users_salary.forEach(user => {
                const hourValue = user.contract_active.salary / 235.66;
                let totalSalary = 0;
                let timeDay = 0,
                    timeExtraDay = 0,
                    timeNight = 0,
                    timeExtraNight = 0,
                    timeDayWeekend = 0,
                    timeExtraDayWeekend = 0,
                    timeNightWeekend = 0,
                    timeExtraNightWeekend = 0;

                user.shifts.forEach(shift => {
                    switch (shift.measure.description) {
                        case 'Primer turno: de 6am-2pm':
                            timeDay += 7.83;
                            timeExtraDay += 0.17;
                            break;
                        case 'Segundo turno: de 2pm-10pm':
                            timeDay += 7;
                            timeNight += 0.83;
                            timeExtraNight += 0.17;
                            break;
                        case 'Tercer turno: de 10pm-6am':
                            timeNight += 7.83;
                            timeExtraNight += 0.17;
                            break;
                        case 'Turno día fin de semana: de 6am-6pm':
                            timeDayWeekend += 7.83;
                            timeExtraDayWeekend += 4.17;
                            break;
                        case 'Turno noche fin de semana: de 6pm-6am':
                            timeDayWeekend += 3;
                            timeNightWeekend += 4.83;
                            timeExtraNightWeekend += 4.17;
                            break;
                    }
                });

                user['value_day'] = (timeDay * hourValue);
                user['value_extra_day'] = (timeExtraDay * (hourValue * 1.25));
                user['value_night'] = (timeNight * (hourValue * 1.35));
                user['value_extra_night'] = (timeExtraNight * (hourValue * 1.75));
                user['value_day_weekend'] = (timeDayWeekend * (hourValue * 1.75));
                user['value_extra_day_weekend'] = (timeExtraDayWeekend * (hourValue * 2));
                user['value_night_weekend'] = (timeNightWeekend * (hourValue * 2.1));
                user['value_extra_night_weekend'] = (timeExtraNightWeekend * (hourValue * 2.5));

                user['total_salary'] = (user['value_day'] + user['value_extra_day'] + user['value_night'] +
                    user['value_extra_night'] + user['value_day_weekend'] + user['value_extra_day_weekend'] +
                    user['value_night_weekend'] + user['value_extra_night_weekend']).toFixed(2);
            });
        },
        formatMoney(value){
            if (isNaN(value)) {
                return "¡Error! Valor no numérico.";
            }

            // Redondear a dos decimales y formatear con puntos de mil y coma
            var valorRedondeado = Math.round(value * 100) / 100;  // Redondear a dos decimales
            var partes = valorRedondeado.toString().split(".");
            partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            return partes.join(",");
        }

    },

}
</script>

<style scoped>
.fi-btn {
  font-weight: bold;
  outline: none;
  transition: background-color 0.3s, box-shadow 0.3s;
  border-radius: 0.375rem;
  padding: 0.5rem 1rem;
  margin-right: 0.5rem;
  cursor: pointer;
  border: 1px solid transparent;
}

.fi-btn:hover {
  background-color: #ffae42;
}

.fi-btn-label {
  color: #333;
}

.fi-btn-active {
  background-color: #f58120;
  color: white;
  border-color: #f58120;
}

.fi-btn-search {
  background-color: #ffae42;
  color: white;
  border-color: #ffae42;
}
</style>
