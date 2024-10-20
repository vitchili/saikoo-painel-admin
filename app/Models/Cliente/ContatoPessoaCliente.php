<?php

namespace App\Models\Cliente;

use App\Models\Cliente\Cliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContatoPessoaCliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contatos_pessoas_clientes';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'cliente_id',
        'tipo_contato_pessoa_cliente_id',
        'nome',
        'telefone',
        'email',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
