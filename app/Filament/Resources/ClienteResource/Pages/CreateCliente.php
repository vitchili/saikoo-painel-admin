<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use App\Models\Cliente\ContatoPessoaCliente;
use App\Models\Cliente\HistoricoObservacoesCliente;
use App\Models\Cliente\RedeSocialCliente;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCliente extends CreateRecord
{
    protected static string $resource = ClienteResource::class;

    public array $historicoObservacoesCliente;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['data_torna_cliente'] = ! empty($data['tornar_cliente']) ? now() : null;

        $data['data_certificado'] = ! empty($data['certificado']) ? now() : null;

        $this->historicoObservacoesCliente = [
            'observacao' => $data['obs'] ?? '',
            'observacao_atendimento' => $data['obs_tendimento'] ?? '',
            'servicos' => $data['servicos_c'] ?? ''
        ];

        $data['id_usuario_cadastro'] = auth()->user()->id;

        return $data;
    }

    protected function afterSave(): void
    {
        parent::afterSave();

        $clienteId = $this->record->id;

        HistoricoObservacoesCliente::create([
            'cliente_id' => $clienteId,
            'observacao' => $this->historicoObservacoesCliente['observacao'],
            'observacao_atendimento' => $this->historicoObservacoesCliente['observacao_atendimento'],
            'servicos' => $this->historicoObservacoesCliente['servicos'],
            'cadastrado_por' => auth()->user()->id
        ]);
    }
}
