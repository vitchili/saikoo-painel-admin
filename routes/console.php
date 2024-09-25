<?php

use App\Console\Commands\GerarNotificacoesGerais;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('app:gerar-notificacoes-gerais', function () {
    $not = new GerarNotificacoesGerais();
    $not->handle();
})->purpose('Gera notificacao geral')->everyMinute();