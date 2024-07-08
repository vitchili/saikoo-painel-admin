<?php

namespace App\Models\Cliente\Parceiro;

use App\Models\Cliente\Cliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParceiroCliente extends Model
{
    use HasFactory;

    protected $table = 'parceiros_clientes';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'cliente_id',
        'url',
        'codigo',
        'login',
        'senha',
        'atualizado_em',
        'cadastrado_em'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
