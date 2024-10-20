<?php

namespace App\Models\Cliente\Contato;

use App\Models\Cliente\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoricoContatoComCliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'historico_contatos_com_clientes';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'cliente_id',
        'descricao',
        'cadastrado_por',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'cadastrado_por');
    }

    public function contato()
    {
        return $this->belongsTo(ContatoComCliente::class, 'cliente_id', 'cliente_id');
    }

}
