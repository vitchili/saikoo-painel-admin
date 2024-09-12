<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndiceCorrecaoGenericoResource\Pages;
use App\Models\IndiceCorrecaoGenerico;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;

class IndiceCorrecaoGenericoResource extends Resource
{
    protected static ?string $model = IndiceCorrecaoGenerico::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Outros Índices de Correção';

    protected static ?string $slug = 'consulta-indice-generico';

    protected static ?string $title = 'Outros Índices de Correção';

    protected static ?string $modelLabel = 'Outros Índices de Correção';

    protected static ?string $navigationGroup = 'Financeiro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('data_referencia')
                    ->label('Data Referência')
                    ->required(),
                TextInput::make('valor')
                    ->label('Valor')
                    ->numeric()
                    ->reactive()
                    ->suffix('%')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('data_referencia')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Data Referência')
                    ->date('d/m/Y')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('valor')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Valor')
                    ->suffix('%')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
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
            'index' => Pages\ListIndiceCorrecaoGenericos::route('/'),
            'create' => Pages\CreateIndiceCorrecaoGenerico::route('/create'),
            'edit' => Pages\EditIndiceCorrecaoGenerico::route('/{record}/edit'),
        ];
    }
}
