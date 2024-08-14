<?php

namespace App\Models\Cliente\Serial;

use App\Models\Cliente\Cliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialCliente extends Model
{
    use HasFactory;

    const CREATED_AT = 'data_gerado';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'serial_temp';

    protected $fillable = [
        'serial',
        'vencimento_serial',
        'usuario_gerado',
        'id_cliente',
        'cnpj_serial',
        'obs',
        'tipo',
        'data_gerado',
        'atualizado_em',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

}
