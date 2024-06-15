<?php

namespace App\Filament\Resources\ChamadoResource\Pages;

use App\Filament\Resources\ChamadoResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditChamado extends EditRecord
{
    protected static string $resource = ChamadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $data['data_hora_inicial'] = $data['data_visita'] . ' ' . $data['data_hora_inicial'] . ':00';
        $data['data_hora_final'] = $data['data_visita'] . ' ' . $data['data_hora_final'] . ':00';

        $data['data_hora_inicial'] = Carbon::parse($data['data_hora_inicial'])->format('Y-m-d H:i:s');
        $data['data_hora_final'] = Carbon::parse($data['data_hora_final'])->format('Y-m-d H:i:s');

        $data['cadastrado_por'] = auth()->user()->id;

        $record->update($data);
    
        return $record;
    }

    
}
