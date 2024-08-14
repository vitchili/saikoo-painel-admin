<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtaReuniaoResource\Pages;
use App\Filament\Resources\AtaReuniaoResource\RelationManagers;
use App\Models\AtaReuniao;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AtaReuniaoResource extends Resource
{
    protected static ?string $model = AtaReuniao::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $modelLabel = 'Atas Reuniões';
    
    protected static ?string $slug = 'atas-reunioes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo')
                    ->label('Título')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                RichEditor::make('texto')
                    ->required()
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
                    ->label('Texto'),
                FileUpload::make('anexo')
                    ->label('Anexo')
                    ->directory('atas_reunioes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Ativo'),
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('autor.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cadastrado_em')
                    ->dateTime('d/m/Y')
                    ->sortable(),
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
            'index' => Pages\ListAtaReuniaos::route('/'),
            'create' => Pages\CreateAtaReuniao::route('/create'),
            'edit' => Pages\EditAtaReuniao::route('/{record}/edit'),
        ];
    }
}
