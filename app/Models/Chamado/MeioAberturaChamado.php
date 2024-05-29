<?php

namespace App\Models\Chamado;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeioAberturaChamado extends Model
{
    use HasFactory;

    protected $table = 'meios_aberturas_chamados';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'nome',
    ];
}
