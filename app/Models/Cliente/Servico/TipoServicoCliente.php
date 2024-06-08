<?php

namespace App\Models\Cliente\Servico;

use App\Models\Chamado\Chamado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoServicoCliente extends Model
{
    use HasFactory;

    protected $table = 'tipos_servicos_clientes';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillble = [
        'nome',
    ];

    public function chamados()
    {
        return $this->hasMany(Chamado::class);
    }
}
