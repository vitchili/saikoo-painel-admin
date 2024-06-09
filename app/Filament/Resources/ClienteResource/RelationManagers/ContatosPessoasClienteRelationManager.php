<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Concerns\HasSubNavigation;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContatosPessoasClienteRelationManager extends RelationManager
{
    protected static string $relationship = 'contatosPessoasCliente';

    protected static ?string $title = 'Contatos com o Cliente';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nome')
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Novo Contato'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

}
