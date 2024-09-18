<x-filament-panels::page>
    <div style="width: 100%; text-align: right; ">
        <label style="color: #585858; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 10pt;" for="tipo">Tipo de chamado</label>
        <select wire:model="tipo_chamado_id" id="tipo" style="border-radius: 5px; border-color: #ccc; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif" name="interno-externo" id="interno-externo">
            <option value="1" selected>Interno</option>
            <option value="3">Externo</option>
        </select>
        &nbsp;
        <label style="color: #585858; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 10pt;" for="tipo" for="data-inicio">Data início</label>
        <input wire:model="dataInicio" type="date" name="data-inicio" id="data-inicio" style="border-radius: 5px; border-color: #ccc; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif" />
        &nbsp;
        <label style="color: #585858; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; font-size: 10pt;" for="tipo" for="data-inicio">Data fim</label>
        <input wire:model="dataFim" type="date" name="data-fim" id="data-fim" style="border-radius: 5px; border-color: #ccc; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif" />
        <button wire:click="pesquisar" style="padding: 10px 10px; top: 4px; --c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);" class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md gap-1.5 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50 dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action">
            <span class="fi-btn-label">
                <svg style="width: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>

            </span>
        </button>
    </div>
    <div class="flex gap-6 space-x-4 p-4 bg-gray-100 rounded-lg shadow-md">
        <div class="flex flex-col">
            <span class="font-semibold">Próxima Versão</span>
            <span style="color: #34bfa3; font-size: 18pt;">{{$this->versao['versao'] ?? ''}}</span>
        </div>
        <div class="flex flex-col">
            <span class="font-semibold">Previsão Lançamento</span>
            <span style="color: #34bfa3; font-size: 18pt;">{{$this->versao['data_disponivel'] ?? ''}}</span>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Ticket Desenvolvimento
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Data
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Solicitação
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Detalhes
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        #{{$this->versao['tickets'][0]['id'] ?? ''}}
                    </th>
                    <td class="px-6 py-4">
                        {{$this->versao['tickets'][0]['cadastrado_em'] ?? ''}}
                    </td>
                    <td class="px-6 py-4">
                        {{strip_tags($this->versao['tickets'][0]['comentario'] ?? '')}}
                    </td>
                    @if( ! empty($this->versao) && ! empty($this->versao['tickets']) ) 
                    <td class="px-6 py-4 text-right">
                        <a href="http://localhost:8000/admin/ticket-desenvolvimentos/{{$this->versao['tickets'][0]['id']}}/edit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detalhes</a>
                    </td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <span style="color: #333333; margin-left: 15px; font-weight: 600; font-size: .9rem; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif">Quantidade de chamados por dia da semana</span>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Horário
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Segunda-feira
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Terça-feira
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Quarta-feira
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Quinta-feira
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Sexta-feira
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Sábado
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Até às 13:00
                    </th>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[2]['antes_13']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[3]['antes_13']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[4]['antes_13']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[5]['antes_13']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[6]['antes_13']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[7]['antes_13']}}
                    </td>
                    <td class="px-6 py-4 text-right">
                        {{$this->chamadosDiasSemana[2]['total_antes_13'] + $this->chamadosDiasSemana[3]['total_antes_13'] + $this->chamadosDiasSemana[4]['total_antes_13'] + $this->chamadosDiasSemana[5]['total_antes_13'] + $this->chamadosDiasSemana[6]['total_antes_13'] + $this->chamadosDiasSemana[7]['total_antes_13']}}
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Após às 13:00
                    </th>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[2]['depois_13']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[3]['depois_13']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[4]['depois_13']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[5]['depois_13']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[6]['depois_13']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[7]['depois_13']}}
                    </td>
                    <td class="px-6 py-4 text-right">
                        {{$this->chamadosDiasSemana[2]['total_depois_13'] + $this->chamadosDiasSemana[3]['total_depois_13'] + $this->chamadosDiasSemana[4]['total_depois_13'] + $this->chamadosDiasSemana[5]['total_depois_13'] + $this->chamadosDiasSemana[6]['total_depois_13'] + $this->chamadosDiasSemana[7]['total_depois_13']}}
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Quantidade Total
                    </th>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[2]['total']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[3]['total']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[4]['total']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[5]['total']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[6]['total']}}
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[7]['total']}}
                    </td>
                    <td class="px-6 py-4 text-right">
                        {{$this->chamadosDiasSemana[2]['total'] + $this->chamadosDiasSemana[3]['total'] + $this->chamadosDiasSemana[4]['total'] + $this->chamadosDiasSemana[5]['total'] + $this->chamadosDiasSemana[6]['total'] + $this->chamadosDiasSemana[7]['total']}}
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Percentual
                    </th>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[2]['percentual']}}%
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[3]['percentual']}}%
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[4]['percentual']}}%
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[5]['percentual']}}%
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[6]['percentual']}}%
                    </td>
                    <td class="px-6 py-4">
                        {{$this->chamadosDiasSemana[7]['percentual']}}% 
                    </td>
                    <td class="px-6 py-4 text-right">
                        100%
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-filament-panels::page>