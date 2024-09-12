<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use App\Models\Cliente\Cliente;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParceirosRelationManager extends RelationManager
{
    protected static string $relationship = 'parceiros';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('')
                    ->schema([
                        Forms\Components\Select::make('cliente_id')
                            ->label('Cliente Parceiro')
                            ->searchable()
                            ->preload()
                            ->options(Cliente::all()->pluck('nome', 'id')),
                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->maxLength(255),
                    ])->columns(1),
                Fieldset::make('Acesso')
                    ->schema([
                        Forms\Components\TextInput::make('codigo')
                            ->label('Código')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('login')
                            ->label('Login')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('senha')
                            ->label('Senha')
                            ->password()
                            ->maxLength(255),
                    ])->columns(3)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('clienteId')
            ->columns([
                Tables\Columns\TextColumn::make('url')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('URL'),
                Tables\Columns\TextColumn::make('codigo')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('URL'),
                Tables\Columns\TextColumn::make('login')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Login'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->slideOver(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                
            ]);
    }
}
