<?php

namespace App\Http\Controllers;

use App\Models\Lembrete\Lembrete;
use App\Services\NotificacaoExceptionGeralService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LembreteController extends Controller
{
    public function atualizarLembrete(Request $request): mixed
    {
        try {
            if (! empty($request->event)) {
                $request = (object) $request->event;
            }

            $lembrete = Lembrete::findOrFail($request->id);
            $lembrete->data_hora_inicio = Carbon::parse($request->start, 'UTC')->subHours(3);
            $lembrete->data_hora_fim = Carbon::parse($request->end, 'UTC')->subHours(3);
            $lembrete->save();

            return response()->json(
                ['data' => 'Operação realizada com sucesso']
            , 200); 
        }
        catch(\Exception $e){
            new NotificacaoExceptionGeralService($e->getMessage(), 'Erro ao atualizar o lembrete');
            return response()->json(
                ['mensagem' => 'Ocorreu um erro inesperado no servidor.']
            , 500);
        }
    }
}
