<?php

namespace App\Providers;

use App\Models\Cliente\Contato\ContatoComCliente;
use App\Models\Lembrete\Lembrete;
use App\Observers\ContatoComClienteObserver;
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
        ContatoComCliente::observe(ContatoComClienteObserver::class);
    }
}
