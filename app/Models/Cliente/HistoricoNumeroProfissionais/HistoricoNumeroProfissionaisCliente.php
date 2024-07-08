<?php

namespace App\Models\Cliente\HistoricoNumeroProfissionais;

use App\Models\Cliente\Cliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoNumeroProfissionaisCliente extends Model
{
    use HasFactory;

    protected $table = 'historico_numero_profissionais_clientes';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'cliente_id',
        'quantidade',
        'atualizado_em',
        'cadastrado_em'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
