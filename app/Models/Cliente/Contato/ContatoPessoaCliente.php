<?php

namespace App\Models\Cliente\Contato;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Contato\Enum\SituacaoContato;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContatoPessoaCliente extends Model
{
    use HasFactory;

    protected $table = 'contatos_pessoas_clientes';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'cliente_id',
        'tipo_contato_pessoa_cliente_id',
        'nome',
        'telefone',
        'email',
        'data_contato',
        'data_retorno',
        'situacao_id',
        'responsavel_id',
        'cadastrado_por',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class);
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioContatoPessoaCliente::class);
    }

}
