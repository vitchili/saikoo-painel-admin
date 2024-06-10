<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Models\Chamado\Enum\SituacaoChamado;
use App\Models\Chamado\Enum\SituacaoContato;
use App\Models\Cliente\TipoContatoPessoaCliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Concerns\HasSubNavigation;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComentariosRelationManager extends RelationManager
{
    protected static string $relationship = 'comentarios';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Defina o schema do formulário de Comentarios aqui
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                // Defina as colunas da tabela de Comentarios aqui
            ]);
    }
}