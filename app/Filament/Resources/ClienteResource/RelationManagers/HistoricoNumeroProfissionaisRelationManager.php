<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HistoricoNumeroProfissionaisRelationManager extends RelationManager
{
    protected static string $relationship = 'historicoNumeroProfissionais';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id_cliente')
            ->columns([
                Tables\Columns\TextColumn::make('qtd_profissionais')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Qtd Profissionais')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('dta_atualizacao')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Data atualização')
                    ->datetime(),
                Tables\Columns\TextColumn::make('cadastrado_em')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Data atualização')
                    ->datetime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([
                
            ]);
    }
}
