<?php

namespace App\Providers;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Contato\ContatoComCliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Serial\SerialCliente;
use App\Models\Cliente\Servico\ServicoCliente;
use App\Models\Lembrete\Lembrete;
use App\Observers\ClienteObserver;
use App\Observers\ContatoComClienteObserver;
use App\Observers\FaturaClienteObserver;
use App\Observers\LembreteObserver;
use App\Observers\SerialClienteObserver;
use App\Observers\ServicoClienteObserver;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        FilamentView::registerRenderHook(
            'panels::auth.login.form.after',
            fn (): View => view('filament.login')
        );

        Lembrete::observe(LembreteObserver::class);
        ContatoComCliente::observe(ContatoComClienteObserver::class);
        FaturaCliente::observe(FaturaClienteObserver::class);
        ServicoCliente::observe(ServicoClienteObserver::class);
        SerialCliente::observe(SerialClienteObserver::class);
        Cliente::observe(ClienteObserver::class);
    }
}
