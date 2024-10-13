<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CentralClienteTicketsResource\Pages;
use App\Filament\Resources\CentralClienteTicketsResource\RelationManagers;
use App\Models\CentralClienteTickets;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CentralClienteTicketsResource extends Resource
{
    protected static ?string $model = CentralClienteTickets::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'create' => Pages\CreateCentralClienteTickets::route('/create'),
            'edit' => Pages\EditCentralClienteTickets::route('/{record}/edit'),
        ];
    }
}
