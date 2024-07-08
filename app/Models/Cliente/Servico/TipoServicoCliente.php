<?php

namespace App\Models\Cliente\Servico;

use App\Models\Chamado\Chamado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TipoServicoCliente extends Model
{
    use HasFactory;

    protected $table = 'lista_servico';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillble = [
        'nome',
    ];

    public function chamados(): BelongsToMany
    {
        return $this->belongsToMany(Chamado::class, 'chamados_servicos', 'tipo_servico_id', 'chamado_id');
    }
}
