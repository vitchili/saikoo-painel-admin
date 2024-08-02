<?php

use App\Http\Controllers\LembreteController;
use App\Http\Controllers\ChamadoController;
use Illuminate\Support\Facades\Route;

Route::put('/lembretes/{id}', [LembreteController::class, 'atualizarLembrete']);
Route::put('/chamados/{id}', [ChamadoController::class, 'atualizarChamado']);