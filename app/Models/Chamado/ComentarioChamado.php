<?php

namespace App\Models\Chamado;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioChamado extends Model
{
    use HasFactory;

    protected $table = 'comentarios_chamados';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'chamado_id',
        'descricao',
        'cadastrado_por',
    ];

    public function chamado()
    {
        return $this->belongsTo(Chamado::class);
    }
}
