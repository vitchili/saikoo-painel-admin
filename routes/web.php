<?php

use App\Http\Controllers\LembreteController;
use Illuminate\Support\Facades\Route;

Route::put('/lembretes/{id}', [LembreteController::class, 'atualizarLembrete']);