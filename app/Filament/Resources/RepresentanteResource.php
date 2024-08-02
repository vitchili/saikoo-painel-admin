<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepresentanteResource\Pages;
use App\Filament\Resources\RepresentanteResource\RelationManagers;
use App\Models\Cliente\Contato\Enum\Estado;
use App\Models\Representante;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class RepresentanteResource extends Resource
{
    protected static ?string $model = Representante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Gerais';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Fieldset::make('Status e visibilidade')
                            ->schema([
                                Forms\Components\Toggle::make('status')
                                    ->required()
                                    ->default(true),
                                Forms\Components\Toggle::make('mostrarNoSite'),
                            ])->columns(2),
                        Fieldset::make('Dados')
                            ->schema([
                                Forms\Components\TextInput::make('nome')
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('cpf')
                                    ->label('CPF')
                                    ->placeholder('CPF do responsável')
                                    ->mask('999.999.999-99')
                                    ->rule('cpf'),
                                Forms\Components\TextInput::make('cep')
                                    ->label('CEP')
                                    ->maxLength(9)
                                    ->required()
                                    ->mask('99999-999')
                                    ->suffixAction(
                                        fn ($state, $livewire, $set) => Action::make('search-action')
                                            ->icon('heroicon-o-rectangle-stack')
                                            ->action(function () use ($state, $livewire, $set) {
                                                $livewire->validateOnly('data.cep');

                                                $cepData = Http::get(
                                                    "https://viacep.com.br/ws/{$state}/json"
                                                )->throw()->json();

                                                if (in_array('erro', $cepData)) {
                                                    throw ValidationException::withMessages([
                                                        'data.cep' => 'Erro ao buscar CEP'
                                                    ]);
                                                }

                                                $set('logradouro', $cepData['logradouro'] ?? null);
                                                $set('cidade', $cepData['localidade'] ?? null);
                                                $set('estado', $cepData['uf'] ?? null);
                                                $set('bairro', $cepData['bairro'] ?? null);
                                            })
                                    ),
                                Forms\Components\TextInput::make('logradouro')
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('numero')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('complemento')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('bairro')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('cidade')
                                    ->maxLength(255),
                                Select::make('estado')
                                    ->label('UF')
                                    ->options(collect(Estado::cases())->mapWithKeys(fn ($estado) => [$estado->value => $estado->label()]))
                                    ->searchable(),
                            ])->columns(3),
                        Fieldset::make('Contato')
                            ->schema([
                                Forms\Components\TextInput::make('telefone')
                                    ->label('Telefone')
                                    ->mask(RawJs::make(<<<'JS'
                                    $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                                JS)),
                                Forms\Components\TextInput::make('telefoneSecundario')
                                    ->label('Telefone Secundário')
                                    ->mask(RawJs::make(<<<'JS'
                                $input.length >= 14 ? '(99)99999-9999' : '(99)9999-9999'
                            JS)),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->maxLength(255),
                            ])->columns(3)
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status'),
                Tables\Columns\ToggleColumn::make('mostrarNoSite')
                    ->label('Mostrar no Site')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable()
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('cpf')
                    ->searchable()
                    ->label('CPF'),
                Tables\Columns\TextColumn::make('cep')
                    ->searchable()
                    ->label('CEP'),
                Tables\Columns\TextColumn::make('logradouro')
                    ->searchable()
                    ->label('Logradouro')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('complemento')
                    ->searchable()
                    ->label('Complemento')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('numero')
                    ->searchable()
                    ->label('Número')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bairro')
                    ->searchable()
                    ->label('Bairro')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('cidade')
                    ->searchable()
                    ->label('Belo Horizonte')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('estado')
                    ->searchable()
                    ->label('UF'),
                Tables\Columns\TextColumn::make('telefone')
                    ->searchable()
                    ->label('Telefone'),
                Tables\Columns\TextColumn::make('telefoneSecundario')
                    ->searchable()
                    ->label('Tel. Secundário')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('E-mail'),
                Tables\Columns\TextColumn::make('cadastrado_em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('atualizado_em')
                    ->dateTime('d/m/Y')
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
            'index' => Pages\ListRepresentantes::route('/'),
            'create' => Pages\CreateRepresentante::route('/create'),
            'edit' => Pages\EditRepresentante::route('/{record}/edit'),
        ];
    }
}
