<?php

namespace App\Models\Cliente\Contato;

use App\Models\Cliente\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class ContatoComCliente extends Model
{
    use HasFactory;

    use HasFilamentComments;

    protected $table = 'contatos_com_clientes';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'cliente_id',
        'tipo_contato_com_cliente_id',
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
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class);
    }

    public function tipoContato()
    {
        return $this->belongsTo(TipoContatoComCliente::class, 'tipo_contato_com_cliente_id');
    }

}
