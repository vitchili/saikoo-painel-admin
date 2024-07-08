<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HistoricoObservacoesRelationManager extends RelationManager
{
    protected static string $relationship = 'historicoObservacoes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('observacao')
            ->columns([
                Tables\Columns\TextColumn::make('observacao')
                ->formatStateUsing(function ($state) {
                    return \Illuminate\Support\Str::limit(strip_tags($state), 200);
                })
                ->wrap(),
                Tables\Columns\TextColumn::make('observacao_atendimento')
                ->formatStateUsing(function ($state) {
                    return \Illuminate\Support\Str::limit(strip_tags($state), 200);
                })
                ->wrap(),
                Tables\Columns\TextColumn::make('servicos')
                ->formatStateUsing(function ($state) {
                    return \Illuminate\Support\Str::limit(strip_tags($state), 200);
                })
                ->wrap(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
            ])
            ->bulkActions([
            ]);
    }
}
