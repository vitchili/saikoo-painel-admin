<?php

namespace App\Http\Controllers;

use App\Models\Lembrete;
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
            $lembrete->data_hora_inicio = Carbon::parse($request->start, 'UTC');
            $lembrete->data_hora_fim = Carbon::parse($request->end, 'UTC');
            $lembrete->save();

            return response()->json(
                ['data' => 'Operação realizada com sucesso']
            , 200); 
        }
        catch(\Exception $e){
            Log::error('Erro ao executar atualização do lembrete: ' . $e->getMessage());
            return response()->json(
                ['mensagem' => 'Ocorreu um erro inesperado no servidor.']
            , 500);
        }
    }
}
