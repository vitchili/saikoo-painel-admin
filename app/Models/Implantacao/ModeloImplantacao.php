<?php

namespace App\Models\Implantacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloImplantacao extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'modelos_implantacoes';

    protected $fillble = [
        'nome',
    ];
}
