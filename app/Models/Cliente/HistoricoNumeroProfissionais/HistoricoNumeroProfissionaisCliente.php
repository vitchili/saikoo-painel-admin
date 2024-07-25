<?php

namespace App\Models\Cliente\HistoricoNumeroProfissionais;

use App\Models\Cliente\Cliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoNumeroProfissionaisCliente extends Model
{
    use HasFactory;

    protected $table = 'numero_profissionais_sistema';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'dta_atualizacao';

    protected $fillable = [
        'id_cliente',
        'qtd_profissionais',
        'dta_atualizacao',
        'cadastrado_em'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
