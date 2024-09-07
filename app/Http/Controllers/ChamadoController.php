<?php

namespace App\Http\Controllers;

use App\Models\Chamado\Chamado;
use App\Services\NotificacaoExceptionGeralService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    public function atualizarChamado(Request $request): mixed
    {
        try {
            if (! empty($request->event)) {
                $request = (object) $request->event;
            }

            $chamado = Chamado::findOrFail($request->id);
            $chamado->data_hora_inicial = Carbon::parse($request->start, 'UTC')->subHours(3);
            $chamado->data_hora_final = Carbon::parse($request->end, 'UTC')->subHours(3);
            $chamado->save();

            return response()->json(
                ['data' => 'Operação realizada com sucesso']
            , 200); 
        }
        catch(\Exception $e){
            new NotificacaoExceptionGeralService($e->getMessage(), 'Erro ao atualizar chamado');

            return response()->json(
                ['mensagem' => 'Ocorreu um erro inesperado no servidor.']
            , 500);
        }
    }
}
