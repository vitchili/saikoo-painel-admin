<x-filament-panels::page>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Data
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Valor %
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->indices as $indice)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$indice['data']}}
                    </th>
                    <td class="px-6 py-4 text-right">
                        {{$indice['valor']}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="flex justify-end">
            {{$this->indices->links()}}
        </div>
    </div>
</x-filament-panels::page>