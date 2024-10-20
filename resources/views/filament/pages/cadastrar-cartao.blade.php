<x-filament-panels::page>
    <div class="flex gap-4">
        <div class="bg-white rounded-lg shadow-md" style="width: 100%; padding:30px; border-radius: 10px; ">
            <form wire:submit.prevent="submit">
                {{ $this->form }}
            </form><br>
            <form id="addCartaoForm" wire:submit="save">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="numeroCartao">Número do Cartão</label>
                    <input
                        type="text"
                        id="numeroCartao"
                        wire:model.lazy="numeroCartao"
                        placeholder="XXXX-XXXX-XXXX-XXXX"
                        class="mt-1 font-s block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" for="nomeCartao">Nome no Cartão</label>
                    <input
                        type="text"
                        id="nomeCartao"
                        wire:model.lazy="nomeCartao"
                        placeholder="NOME DO CARTÃO"
                        class="mt-1 font-s block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                </div>

                <div class="mb-4 flex space-x-2">
                    <div class="flex-1 mr-2">
                        <label class="block text-sm font-medium text-gray-700" for="mesAnoVencimento">Mês/Ano</label>
                        <input
                            type="text"
                            id="mesAnoVencimento"
                            wire:model.lazy="mesAnoVencimento"
                            placeholder="MM/YY"
                            class="mt-1 font-s block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>
                    <div class="flex-1 ml-2">
                        <label class="block text-sm font-medium text-gray-700" for="cvv">CVV</label>
                        <input
                            type="text"
                            id="cvv"
                            wire:model.lazy="cvv"
                            placeholder="XXX"
                            class="mt-1 font-s block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-200" />
                    </div>
                </div>

                <div style="display: flex; text-align: right;">
                    <img src="{{ asset('img/logos-bandeiras-card.png') }}" alt="Descrição da Imagem" style="margin: auto -10px auto auto; width: 500px; ">
                </div>
                @if($this->valorTotalAtual)
                <div id="cadastrarCartao" onclick="cadastrarCartao()" class="flex m-0" style="margin-top: 50px;">
                    <button type="button" style="background-color: #142171; color:#fff; padding:10px; border-radius:10px;" class="block w-full">
                        <span class="fi-btn-label">
                            Realizar pagamento (R$ {{$this->valorTotalAtual}})
                        </span>
                    </button>
                </div>
                <button id="triggerSend" style="display: none;" class="block w-full">
                    <span class="fi-btn-label">
                        Trigger Enviar Form
                    </span>
                </button>
                @endif
            </form>
        </div>
        <div class="bg-white rounded-lg shadow-md" style="width: 50%; padding:30px; border-radius: 10px;">
            <label class="flex" style="font-size: .9rem; color: #585858;">Cartões cadastrados:</label><br>
            @foreach ($this->cartoesCadastrados as $cartao)
            <div class="mb-4" style="background-color:#f6f6f6; border: 2px solid #142171; padding:10px 20px 10px 10px ; border-radius: 5px;">
                <div style="display: flex; text-align: right; padding: 2px;">
                    <label class="flex text-sm font-medium text-gray-700" style="font-weight: 500; font-size:.8rem; margin: auto auto auto 0px;">Serviços:</label>
                    <label class="flex text-sm font-medium text-gray-700" style="font-size:.8rem; margin: auto -10px auto auto;">{{ $cartao['servicos'] }}</label>
                </div>
                <div style="display: flex; text-align: right; padding: 2px;">
                    <label class="flex text-sm font-medium text-gray-700" style="font-size:.8rem; margin: auto auto auto 0px;">Periodicidade:</label>
                    <label class="flex text-sm font-medium text-gray-700" style="font-size:.8rem; margin: auto -10px auto auto;">{{ $cartao['periodicidade'] }}</label>
                </div>
                <div style="display: flex; text-align: right; padding: 2px;">
                    <label class="flex text-sm font-medium text-gray-700" style="font-size:.8rem; margin: auto auto auto 0px;">Valor:</label>
                    <label class="flex text-sm font-medium text-gray-700" style="font-size:.8rem; margin: auto -10px auto auto;">R$ {{ $cartao['valor'] }}</label>
                </div>
                <div style="display: flex; text-align: right; padding: 2px;">
                    <label class="flex text-sm font-medium text-gray-700" style="font-size:.8rem; margin: auto auto auto 0px;">Final &nbsp;
                        <svg style="width: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                        </svg>
                    </label>
                    <label class="flex text-sm font-medium text-gray-700" style="font-size:.8rem; margin: auto -10px auto auto;">
                        .... - .... - .... - {{ $cartao['final_cartao'] }}
                    </label>
                </div>

                <!-- <div style="display: flex; text-align: right;">
                        <span style="font-size: .7rem; color: green; margin: auto -5px auto auto;">Próxima cobrança agendada para 27/10/2025</span>
                    </div> -->
            </div>
            @endforeach
            <!-- <div class="flex" style="margin: auto">
                    <span style="font-size: .9rem; color: orange; margin: 20px auto">Nenhum cartão cadastrado</span>
            </div> -->
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function cadastrarCartao() {
            var numeroCartao = document.getElementById('numeroCartao').value;
            var nomeCartao = document.getElementById('nomeCartao').value;
            var mesAnoVencimento = document.getElementById('mesAnoVencimento').value;
            var cvv = document.getElementById('cvv').value;

            if (!numeroCartao || !nomeCartao || !mesAnoVencimento || !cvv) {
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Preencha todos os dados obrigatórios.",
                    confirmButtonColor: "#142171",
                });
            } else if (numeroCartao.length < 19) {
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Número do cartão inválido.",
                    confirmButtonColor: "#142171",
                });
            } else if (mesAnoVencimento.length < 5) {
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "Mês e Ano do vencimento inválido (MM/YY).",
                    confirmButtonColor: "#142171",
                });
            } else if (cvv.length < 3) {
                Swal.fire({
                    icon: "error",
                    title: "Erro",
                    text: "CVV inválido.",
                    confirmButtonColor: "#142171",
                });
            } else {
                Swal.fire({
                    title: "Cadastrar cobrança no cartão?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#142171",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Sucesso.",
                            text: "Cartão vinculado com sucesso.",
                            icon: "success"
                        });

                        document.getElementById('triggerSend').click();
                        window.location.reload();
                    }
                });
            }
        }
    </script>
    <style>
        .font-s {
            font-size: 11pt !important;
        }

        .ml-2 {
            margin-left: 5px !important;
        }

        .mr-2 {
            margin-right: 5px !important;
        }
    </style>
</x-filament-panels::page>