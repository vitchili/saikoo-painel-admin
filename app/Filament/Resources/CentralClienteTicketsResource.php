<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CentralClienteTicketsResource\Pages;
use App\Filament\Resources\CentralClienteTicketsResource\RelationManagers;
use App\Models\CentralClienteTickets;
use App\Models\Cliente\TicketDesenvolvimento\Enum\PrioridadeTicketDesenvolvimentoEnum;
use App\Models\Cliente\TicketDesenvolvimento\TicketDesenvolvimento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CentralClienteTicketsResource extends Resource
{
    protected static ?string $model = TicketDesenvolvimento::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $slug = 'central-tickets';

    protected static ?string $navigationLabel = 'Meus Tickets';

    protected static ?string $title = 'Meus Tickets';

    protected static ?string $modelLabel = 'Meus Tickets';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('Cliente');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('cliente_id', auth()->user()->cliente_id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Código')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cadastrado_em')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Data')
                    ->datetime('d/m/Y H:s')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('prioridade_id')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Prioridade')
                    ->formatStateUsing(fn($state) => PrioridadeTicketDesenvolvimentoEnum::from($state)->label())
                    ->sortable()
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('sistema.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Sistema')
                    ->limit(30)
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('modulo.nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Módulo')
                    ->limit(30)
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('responsavel.name')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Responsável')
                    ->limit(30)
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('desenvolvedor.name')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Desenvolvedor')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('situacao_id')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Situação')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCentralClienteTickets::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
