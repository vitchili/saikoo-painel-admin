<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CentralClienteSerialResource\Pages;
use App\Models\Cliente\Serial\SerialCliente;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CentralClienteSerialResource extends Resource
{
    protected static ?string $model = SerialCliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static ?string $slug = 'central-seriais';

    protected static ?string $navigationLabel = 'Meus Seriais';

    protected static ?string $title = 'Meus Seriais';

    protected static ?string $modelLabel = 'Meus Seriais';

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
        $query = SerialCliente::with('fatura')->where('id_cliente', auth()->user()->cliente_id)
            ->whereHas('fatura', function($query) {
                $query->whereNotNull('valor_pago');
            })
            ->orderBy('vencimento_serial')
            ->limit(1);
            
        $registro = $query->get()->first();

        return $table
            ->modifyQueryUsing(function (Builder $query) use ($registro) {
                if ($registro) {
                    return $query->where('id', $registro->id);
                }
                return $query->whereNull('id');
            })
            ->columns([
                Tables\Columns\TextColumn::make('serial')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Serial'),
                Tables\Columns\TextColumn::make('vencimento_serial')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Vencimento')
                    ->datetime('d/m/Y'),
                Tables\Columns\TextColumn::make('obs')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Motivo')
                    ->formatStateUsing(function ($state) {
                        return \Illuminate\Support\Str::limit(strip_tags($state), 200);
                    })
                    ->wrap(),
                Tables\Columns\TextColumn::make('data_gerado')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Gerado em')
                    ->datetime('d/m/Y'),
                Tables\Columns\TextColumn::make('usuario_gerado')
                    ->size(TextColumnSize::ExtraSmall)
                    ->label('Gerado por'),

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
            'index' => Pages\ListCentralClienteSerials::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
