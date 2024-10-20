<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndiceCorrecaoGenerico extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'indices_correcao_genericos';

    protected $fillable = [
        'nome',
        'data_referencia',
        'valor',
    ];
}
