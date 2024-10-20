<?php

namespace App\Models\Implantacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TelaTopicoModeloImplantacao extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'telas_topicos_modelos_implantacoes';

    protected $fillble = [
        'topico_id',
        'nome',
    ];

    public function topico()
    {
        return $this->belongsTo(TopicoModeloImplantacao::class, 'topico_id');
    }
}
