<div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Opciones
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Por que no?
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Observaciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if ($getState()[0]['checkbox'][0] == "CUMPLE")
                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $getState()[0]['checkbox'][0] }}</span>
                        @endif
                        @if ($getState()[0]['checkbox'][0] == "NO CUMPLE")
                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">{{ $getState()[0]['checkbox'][0] }}</span>
                        @endif
                        @if ($getState()[0]['checkbox'][0] == "N/A")
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">{{ $getState()[0]['checkbox'][0] }}</span>
                        @endif
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ ($getState()[0]['why_not']) ? $getState()[0]['why_not'] : 'No asignado' }}
                    </th>

                    <td class="px-6 py-4">
                        {{ ($getState()[0]['observations']) ? $getState()[0]['observations'] : 'No asignado' }}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
