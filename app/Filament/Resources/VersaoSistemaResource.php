<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VersaoSistemaResource\Pages;
use App\Filament\Resources\VersaoSistemaResource\RelationManagers;
use App\Models\VersaoSistema;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VersaoSistemaResource extends Resource
{
    protected static ?string $model = VersaoSistema::class;

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?string $navigationLabel = 'Versões';

    protected static ?string $slug = 'versoes';

    protected static ?string $modelLabel = 'Versões';

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Fieldset::make('Dados')
                            ->schema([
                                Forms\Components\TextInput::make('versao')
                                    ->label('Versão')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('em_desenvolvimento')
                                    ->label('Em desenvolvimento')
                                    ->inline(false),
                                Forms\Components\Toggle::make('disponivel_para_atualizacao')
                                    ->label('Disponível para atualização')
                                    ->inline(false),
                                Forms\Components\DatePicker::make('data_disponivel')
                                    ->label('Data Disponível'),
                            ])->columns(4),
                        RichEditor::make('obs')
                            ->label('Observação')
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
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('versao')
                    ->size(TextColumnSize::ExtraSmall)
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('em_desenvolvimento')
                    ->label('Em desenvolvimento'),
                Tables\Columns\ToggleColumn::make('disponivel_para_atualizacao')
                    ->label('Disp. para atualização'),
                Tables\Columns\TextColumn::make('data_disponivel')
                    ->size(TextColumnSize::ExtraSmall)
                    ->date('d/m/Y')
                    ->label('Data disponível')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cadastrado_em')
                    ->size(TextColumnSize::ExtraSmall)
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('atualizado_em')
                    ->size(TextColumnSize::ExtraSmall)
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListVersaoSistemas::route('/'),
            'create' => Pages\CreateVersaoSistema::route('/create'),
            'edit' => Pages\EditVersaoSistema::route('/{record}/edit'),
        ];
    }
}
