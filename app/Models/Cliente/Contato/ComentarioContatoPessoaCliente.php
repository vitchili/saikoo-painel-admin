<?php

namespace App\Models\Cliente\Contato;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioContatoPessoaCliente extends Model
{
    use HasFactory;

    protected $table = 'comentarios_contatos_pessoas_clientes';

    protected $fillable = ['contato_pessoa_cliente_id', 'descricao', 'cadastrado_por'];

    public function contatoPessoaCliente()
    {
        return $this->belongsTo(ContatoPessoaCliente::class, 'contato_pessoa_cliente_id');
    }
}
