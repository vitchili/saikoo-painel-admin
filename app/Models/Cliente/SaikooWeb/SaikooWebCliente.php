<?php

namespace App\Models\Cliente\SaikooWeb;

use App\Models\Cliente\Cliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaikooWebCliente extends Model
{
    use HasFactory;

    protected $table = 'conexoes_saikoo_web';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'cliente_id',
        'url_app',
        'url',
        'host',
        'usuario',
        'senha',
        'bd',
        'status',
        'atualizado_em',
        'cadastrado_em'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
