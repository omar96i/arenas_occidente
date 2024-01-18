<!-- Paginator.vue -->
<template>
    <nav aria-label="Navegación de paginación" role="navigation"
        class="fi-pagination grid grid-cols-3 items-center px-3 py-3 sm:px-6">
        <span class="hidden text-sm font-medium text-gray-700 dark:text-gray-200 md:inline">
            Se muestran {{ pageSize }} de {{ totalItems }} resultados
        </span>
        <button
            class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus:ring-2 rounded-lg fi-color-gray fi-btn-color-gray fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-white text-gray-950 hover:bg-gray-50 dark:bg-white/5 dark:text-white dark:hover:bg-white/10 ring-1 ring-gray-950/10 dark:ring-white/20 col-start-3 justify-self-end inline-grid md:hidden"
            type="button">
            <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                class="animate-spin fi-btn-icon h-5 w-5 text-gray-400 dark:text-gray-500">
                <path clip-rule="evenodd"
                    d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                    fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
            </svg>
            <span class="fi-btn-label">Siguiente</span>
        </button>

        <div class="col-start-2 justify-self-center">
            <label class="hidden sm:inline">
                <div
                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500">
                    <div class="items-center gap-x-3 ps-3 flex border-e border-gray-200 pe-3 ps-3 dark:border-white/10">
                        <span class="fi-input-wrp-label whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            por página
                        </span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <select @change="handlePageSizeChange" class="fi-select-input block w-full border-none bg-transparent py-1.5 pe-8 text-base text-gray-950 transition duration-75 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] dark:text-white dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] sm:text-sm sm:leading-6 [&amp;_optgroup]:bg-white [&amp;_optgroup]:dark:bg-gray-900 [&amp;_option]:bg-white [&amp;_option]:dark:bg-gray-900 ps-3">
                            <option v-for="size in pageSizes" :key="size" :value="size">{{ size }}</option>
                        </select>
                    </div>
                </div>
            </label>
        </div>

        <ol
            class="fi-pagination-items hidden justify-self-end rounded-lg bg-white shadow-sm ring-1 ring-gray-950/10 dark:bg-white/5 dark:ring-white/20 md:flex">
            <li class="fi-pagination-item group/item border-x-[0.5px] border-gray-200 first:border-s-0 last:border-e-0 dark:border-white/10"
                rel="prev">
                <button :disabled="currentPage === 1" @click="changePage(currentPage - 1)" aria-label="Anterior" type="button"
                    class="fi-pagination-item-button group/button relative flex overflow-hidden p-2 outline-none transition duration-75 group-first/item:rounded-s-lg group-last/item:rounded-e-lg hover:bg-gray-50 focus-visible:z-10 focus-visible:ring-2 focus-visible:ring-primary-600 dark:hover:bg-white/5 dark:focus-visible:ring-primary-500">
                    <svg class="fi-pagination-item-icon h-5 w-5 text-gray-400 transition duration-75 group-hover/button:text-gray-500 dark:text-gray-500 dark:group-hover/button:text-gray-400"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </li>
            <li
                class="fi-pagination-item group/item border-x-[0.5px] border-gray-200 first:border-s-0 last:border-e-0 dark:border-white/10 fi-active">
                <button aria-label="Ir a la página 1" type="button" class="fi-pagination-item-button group/button relative flex overflow-hidden p-2 outline-none transition duration-75 group-first/item:rounded-s-lg group-last/item:rounded-e-lg hover:bg-gray-50 focus-visible:z-10 focus-visible:ring-2 focus-visible:ring-primary-600 dark:hover:bg-white/5 dark:focus-visible:ring-primary-500 bg-gray-50 dark:bg-white/5">
                    <span class="fi-pagination-item-label px-1.5 text-sm font-semibold text-primary-600 dark:text-primary-400">
                        {{ currentPage }}
                    </span>
                </button>
            </li>
            <li class="fi-pagination-item group/item border-x-[0.5px] border-gray-200 first:border-s-0 last:border-e-0 dark:border-white/10"
                rel="next">
                <button :disabled="currentPage === totalPages" @click="changePage(currentPage + 1)" aria-label="Siguiente" type="button"
                    class="fi-pagination-item-button group/button relative flex overflow-hidden p-2 outline-none transition duration-75 group-first/item:rounded-s-lg group-last/item:rounded-e-lg hover:bg-gray-50 focus-visible:z-10 focus-visible:ring-2 focus-visible:ring-primary-600 dark:hover:bg-white/5 dark:focus-visible:ring-primary-500">
                    <svg class="fi-pagination-item-icon h-5 w-5 text-gray-400 transition duration-75 group-hover/button:text-gray-500 dark:text-gray-500 dark:group-hover/button:text-gray-400"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </li>
        </ol>
    </nav>
</template>
  
<script>
export default {
    props: {
        totalItems: {
            type: Number,
            required: true,
        },
        currentPage: {
            type: Number,
            required: true,
        },
        pageSize: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            pageSizes: [5, 10, 20],
            selectPage: '',
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.totalItems / this.pageSize);
        },
    },
    methods: {
        changePage(page) {
            this.$emit('page-change', page);
        },
        handlePageSizeChange(event) {
            this.$emit('page-size-change', parseInt(event.target.value, 10));
        },
    },
};
</script>
  
<style scoped>/* Estilos del paginador si es necesario */</style>
  