<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use App\Models\Cliente\HistoricoObservacoesCliente;
use Illuminate\Database\Eloquent\Model;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCliente extends EditRecord
{
    protected static string $resource = ClienteResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if (empty($record->data_torna_cliente) && ! empty($data['tornar_cliente'])) {
            $data['data_torna_cliente'] = now();
        }

        if (empty($record->certificado) && ! empty($data['certificado'])) {
            $data['data_certificado'] = now();
        }

        if (! empty($data['telefone'])) {
            $data['ddd'] = substr($data['telefone'], 1, 2);
        }

        $historicosAnteriores = $record->historicoObservacoes ?? [];
        
        foreach($historicosAnteriores as $historicoAnterior) {
            if (
                $historicoAnterior->observacao != $data['obs'] ||
                $historicoAnterior->observacao_atendimento != $data['obs_tendimento'] ||
                $historicoAnterior->servicos != $data['servicos_c']
            ) {
                HistoricoObservacoesCliente::create([
                    'cliente_id' => $record->id,
                    'observacao' => $data['obs'],
                    'observacao_atendimento' => $data['obs_tendimento'],
                    'servicos' => $data['servicos_c'],
                    'cadastrado_por' => auth()->user()->id
                ]);
            }
        }

        if (empty($historicosAnteriores->toArray())) {
            HistoricoObservacoesCliente::create([
                'cliente_id' => $record->id,
                'observacao' => $data['obs'],
                'observacao_atendimento' => $data['obs_tendimento'],
                'servicos' => $data['servicos_c'],
                'cadastrado_por' => auth()->user()->id
            ]);
        }

        $record->update($data);
    
        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

}
