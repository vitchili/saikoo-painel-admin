<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificacaoGeralResource\Pages;
use App\Filament\Resources\NotificacaoGeralResource\RelationManagers;
use App\Models\Chamado\Chamado;
use App\Models\NotificacaoGeral;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotificacaoGeralResource extends Resource
{
    protected static ?string $model = NotificacaoGeral::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?string $navigationLabel = 'Notificações Agendadas';

    protected static ?string $slug = 'notificacoes-agendadas';

    protected static ?string $modelLabel = 'Notificações Agendadas';

    protected static ?string $navigationGroup = 'Gerais';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Notificação')
                    ->schema([
                        Forms\Components\Select::make('tecnico_id')
                            ->options(User::all()->pluck('name', 'id'))
                            ->label('Técnico')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('chamado_id')
                            ->options(Chamado::all()->pluck('id', 'id'))
                            ->label('Chamado')
                            ->searchable(),
                        Forms\Components\DateTimePicker::make('data_hora')
                            ->required()
                            ->seconds(false)
                            ->label('Data Hora'),
                        Forms\Components\TextInput::make('descricao')
                            ->required()
                            ->label('Descrição')
                            ->maxLength(255)
                            ->columnSpan(3),
                    ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tecnico.name')
                    ->size(TextColumnSize::ExtraSmall)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('chamado.id')
                    ->size(TextColumnSize::ExtraSmall)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_hora')
                    ->size(TextColumnSize::ExtraSmall)
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('descricao')
                    ->size(TextColumnSize::ExtraSmall)
                    ->searchable(),
                Tables\Columns\TextColumn::make('cadastrado_em')
                    ->size(TextColumnSize::ExtraSmall)
                    ->dateTime('d/m/Y h:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('atualizado_em')
                    ->size(TextColumnSize::ExtraSmall)
                    ->dateTime('d/m/Y h:i:s')
                    ->sortable(),
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
            'index' => Pages\ListNotificacaoGerals::route('/'),
            'create' => Pages\CreateNotificacaoGeral::route('/create'),
            'edit' => Pages\EditNotificacaoGeral::route('/{record}/edit'),
        ];
    }
}
