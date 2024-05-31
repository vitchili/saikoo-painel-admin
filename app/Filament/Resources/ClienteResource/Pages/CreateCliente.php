<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use App\Models\Cliente\ContatoPessoaCliente;
use App\Models\Cliente\RedeSocialCliente;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCliente extends CreateRecord
{
    protected static string $resource = ClienteResource::class;

    public array $contatosPessoasCliente;

    public array $redesSociaisClientes;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->contatosPessoasCliente = $data['contatosPessoasCliente'] ?? [];
        unset($data['contatosPessoasCliente']);

        $this->redesSociaisClientes = $data['redesSociaisClientes'] ?? [];
        unset($data['redesSociaisCliente']);

        $data['id_usuario_cadastro'] = auth()->user()->id;

        return $data;
    }

    protected function afterSave(): void
    {
        parent::afterSave();

        $clienteId = $this->record->id;

        foreach ($this->contatosPessoasCliente as $contato) {
            ContatoPessoaCliente::create([
                'cliente_id' => $clienteId,
                'tipo_contato_pessoa_cliente_id' => $contato['tipo_contato_pessoa_cliente_id'],
                'nome' => $contato['nome'],
                'telefone' => $contato['telefone'],
                'email' => $contato['email'],
                'cadastrado_por' => auth()->user()->id
            ]);
        }

        foreach ($this->redesSociaisCliente as $rede) {
            RedeSocialCliente::create([
                'cliente_id' => $clienteId,
                'tipo_rede_social_id' => $rede['tipo_rede_social_id'],
                'url' => $rede['url']
            ]);
        }
    }
}
