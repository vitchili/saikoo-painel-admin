<?php

namespace App\Filament\Pages;

use App\Models\Chamado\Chamado;
use App\Models\Cliente\Cliente;
use App\Models\Lembrete\Lembrete;
use App\Models\User;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Page ;
use Illuminate\Support\Facades\Redirect;

class Atendimento extends Page
{
    public static function canAccess(): bool
    {
        return ! auth()->user()->hasRole('Cliente');
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Principal';

    protected static string $view = 'filament.pages.atendimento';

    public array $lembretes;
    public array $chamados;
    public array $clientes; 
    public int $selectedCliente;

    

    public function mount()
    {
        $this->lembretes = Lembrete::with('criador')->with('tecnicos')->get()->toArray();
        $this->chamados = Chamado::with('criador')->with('tecnicos')->whereNotNull('data_visita')->get()->toArray();
        $this->clientes = Cliente::all()->pluck('nome', 'id')->toArray();
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('selectedCliente')
                ->label('Selecione um cliente')
                ->options(Cliente::whereNotNull('codigo')->get()->mapWithKeys(function ($cliente) {
                    return [
                        $cliente->id => $cliente->nome  . ' - ' . $cliente->cpf_cnpj
                    ];
                }))
                ->searchable()
                ->suffixAction(
                    fn($state, $livewire, $set) => Action::make('search-action')
                    ->icon('heroicon-o-magnifying-glass')
                    ->action(function () use ($state, $livewire, $set) {
                        Redirect::to("https://hml-paineladmin.taskimob.com.br/admin/clientes/{$this->selectedCliente}");
                    })
                ),
        ];
    }
}
