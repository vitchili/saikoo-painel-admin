<?php

namespace App\Filament\Resources\ContatoComClienteResource\Pages;

use App\Filament\Resources\ContatoComClienteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ClienteResource;
use App\Models\Cliente\Contato\HistoricoContatoComCliente;

class CreateContatoComCliente extends CreateRecord
{
    protected static string $resource = ContatoComClienteResource::class;

    public array $historicoContatoComCliente;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->historicoContatoComCliente = [
            'descricao' => $data['descricao'] ?? '',
        ];

        $data['cadastrado_por'] = auth()->user()->id;

        return $data;
    }

    protected function afterSave(): void
    {
        parent::afterSave();

        $clienteId = $this->record->id;

        HistoricoContatoComCliente::create([
            'cliente_id' => $clienteId,
            'descricao' => $this->historicoContatoComCliente['descricao'],
            'cadastrado_por' => auth()->user()->id
        ]);
    }
}
