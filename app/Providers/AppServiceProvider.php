<?php

namespace App\Providers;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Contato\ContatoComCliente;
use App\Models\Cliente\ContatoPessoaCliente;
use App\Models\Cliente\Fatura\FaturaCliente;

use App\Models\Cliente\RedeSocialCliente;
use App\Models\Cliente\Serial\SerialCliente;
use App\Models\Cliente\Servico\ServicoCliente;

use App\Models\Lembrete\Lembrete;
use App\Observers\ClienteObserver;
use App\Observers\ContatoComClienteObserver;
use App\Observers\ContatoPessoaClienteObserver;
use App\Observers\FaturaClienteObserver;
use App\Observers\FilamentCommentObserver;
use App\Observers\LembreteObserver;
use App\Observers\RedeSocialClienteObserver;
use App\Observers\SerialClienteObserver;
use App\Observers\ServicoClienteObserver;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Parallax\FilamentComments\Models\FilamentComment;

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
            fn(): View => view('filament.login')
        );

        Lembrete::observe(LembreteObserver::class);
        ContatoComCliente::observe(ContatoComClienteObserver::class);
        FaturaCliente::observe(FaturaClienteObserver::class);
        ServicoCliente::observe(ServicoClienteObserver::class);
        SerialCliente::observe(SerialClienteObserver::class);
        Cliente::observe(ClienteObserver::class);
        ContatoPessoaCliente::observe(ContatoPessoaClienteObserver::class);
        RedeSocialCliente::observe(RedeSocialClienteObserver::class);
        FilamentComment::observe(FilamentCommentObserver::class);

        
    }
}
