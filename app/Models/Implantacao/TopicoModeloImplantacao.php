<?php

namespace App\Models\Implantacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicoModeloImplantacao extends Model
{
    use HasFactory;
    
    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'topicos_modelos_implantacoes';

    protected $fillble = [
        'modelo_id',
        'nome',
        'descricao',
    ];

    public function modelo()
    {
        return $this->belongsTo(ModeloImplantacao::class, 'modelo_id');
    }
}
