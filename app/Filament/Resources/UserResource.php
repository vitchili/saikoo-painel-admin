<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Hash;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Usuários';

    protected static ?string $slug = 'usuarios';

    protected static ?string $modelLabel = 'Usuário';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome completo')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefone')
                            ->mask(RawJs::make(<<<'JS'
                        $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                    JS)),
                        Forms\Components\Select::make('roles')
                            ->label('Tipo de Perfil')
                            ->relationship(
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) =>
                                auth()->user()->hasRole('Diretor(a)') ? null : $query->where('name', '!=', 'Diretor(a)')
                            )
                            ->required()
                            ->preload(),
                        Forms\Components\ColorPicker::make('color_hash')
                            ->label('Cor (Para diferenciação na Agenda, Dashboard, entre outros)')
                            ->default('#CCCCCC'),
                        Forms\Components\FileUpload::make('avatar_url')
                            ->label('Foto de Perfil')
                            ->image()
                            ->directory('fotos_perfis'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->circular()
                    ->height(50),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome completo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Tipo de Perfil')
                    ->sortable(),
                Tables\Columns\ColorColumn::make('color_hash')
                    ->label('Cor'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastrado em')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return auth()->user()->hasRole('Diretor(a)')
            ?  parent::getEloquentQuery()
            : parent::getEloquentQuery()->whereHas(
                'roles',
                fn (Builder $query) => $query->where('name', '!=', 'Diretor(a)')
            );
    }
}
