<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfiguracaoReajusteMassa extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'configuracao_reajustes_massa';

    protected $fillable = [
        'nome',
        'indice_correcao_generica_id',
        'igpm_id',
        'data_inicio',
    ];

    public function igpm(): BelongsTo
    {
        return $this->belongsTo(Igpm::class, 'igpm_id');
    }

    public function indiceCorrecaoGenerica(): BelongsTo
    {
        return $this->belongsTo(IndiceCorrecaoGenerico::class, 'indice_correcao_generica_id');
    }
}
