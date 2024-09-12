<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndiceCorrecaoGenerico extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'indices_correcao_genericos';

    protected $fillable = [
        'nome',
        'data_referencia',
        'valor',
    ];
}
