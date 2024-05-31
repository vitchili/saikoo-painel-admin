<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LembreteResource\Pages;
use App\Filament\Resources\LembreteResource\RelationManagers;
use App\Models\Lembrete;
use App\Models\PeriodicidadeLembrete;
use App\Models\User;
use App\Rules\DataInicioMenorQueDataFim;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LembreteResource extends Resource
{
    protected static ?string $model = Lembrete::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Agenda';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('descricao')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('data_hora_inicio')
                    ->required()
                    ->seconds(false)
                    ->afterOrEqual('today'),
                Forms\Components\DateTimePicker::make('data_hora_fim')
                    ->required()
                    ->seconds(false)
                    ->afterOrEqual('data_hora_inicio'),
                Forms\Components\RichEditor::make('observacoes')
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                ->columnSpanFull(),
                Forms\Components\Select::make('periodicidade_id')
                    ->label('Periodicidade')
                    ->options(PeriodicidadeLembrete::all()->pluck('nome', 'id'))
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('tecnicos')
                    ->label('Técnicos')
                    ->options(User::all()->pluck('name', 'id'))
                    ->multiple()
                    ->relationship('tecnicos', 'name')
                    ->required()
                    ->preload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('descricao'),
                Tables\Columns\TextColumn::make('data_hora_inicio')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_hora_fim')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('periodicidade.nome')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('criador.name')
                    ->numeric()
                    ->sortable()
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
            'index' => Pages\ListLembretes::route('/'),
            'create' => Pages\CreateLembrete::route('/create'),
            'edit' => Pages\EditLembrete::route('/{record}/edit'),
        ];
    }
}
