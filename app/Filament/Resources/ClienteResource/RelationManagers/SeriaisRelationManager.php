<?php

namespace App\Filament\Resources\ClienteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
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
