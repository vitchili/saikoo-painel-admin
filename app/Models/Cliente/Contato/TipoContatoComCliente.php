<?php

namespace App\Models\Cliente\Contato;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoContatoComCliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_contatos_com_clientes';

    protected $fillable = ['nome'];

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    public function contatoComCliente()
    {
        return $this->hasMany(ContatoComCliente::class, 'tipo_contato_com_cliente_id');
    }
}
