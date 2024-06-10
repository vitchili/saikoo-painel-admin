<?php

namespace App\Models\Cliente\Contato;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioContatoPessoaCliente extends Model
{
    use HasFactory;

    protected $fillable = ['contato_pessoa_cliente_id', 'descricao', 'cadastrado_por'];
}
