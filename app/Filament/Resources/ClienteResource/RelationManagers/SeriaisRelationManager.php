<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeriaisRelationManager extends RelationManager
{
    protected static string $relationship = 'seriais';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Gerar Serial')
                    ->schema([
                        DatePicker::make('vencimento_serial')
                            ->label('Vencimento Serial')
                            ->required()
                            ->after('today'),
                        RichEditor::make('obs')
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
                            ->columnSpanFull()
                            ->label('Observação'),
                    ])->columns(1),
                
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('serial')
            ->columns([
                Tables\Columns\TextColumn::make('serial')
                    ->label('Serial'),
                Tables\Columns\TextColumn::make('vencimento_serial')
                    ->label('Vencimento serial')
                    ->datetime('d/m/Y'),
                Tables\Columns\TextColumn::make('obs')
                    ->label('Motivo'),
                Tables\Columns\TextColumn::make('data_gerado')
                    ->label('Gerado em'),
                Tables\Columns\TextColumn::make('usuario_gerado')
                    ->label('Gerado em'),
                    
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
