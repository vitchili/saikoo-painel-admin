<?php

namespace App\Models\Cliente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoContatoPessoaCliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_contatos_pessoas_clientes';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'nome',
    ];
}
