<?php

namespace App\Providers;

use App\Models\Cliente\Contato\ContatoPessoaCliente;
use App\Models\Lembrete\Lembrete;
use App\Observers\ContatoPessoaClienteObserver;
use App\Observers\LembreteObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Lembrete::observe(LembreteObserver::class);
        ContatoPessoaCliente::observe(ContatoPessoaClienteObserver::class);
    }
}
