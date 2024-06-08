<?php

namespace App\Models\Cliente\Contato;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoContatoPessoaCliente extends Model
{
    use HasFactory;

    protected $table = 'historico_contatos_pessoas_clientes';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'contato_pessoa_cliente_id',
        'descricao',
        'cadastrado_por',
    ];
    
    public function contato()
    {
        return $this->belongsTo(ContatoPessoaCliente::class);
    }
}
