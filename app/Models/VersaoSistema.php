<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersaoSistema extends Model
{
    use HasFactory;

    protected $table = 'versoes_sistemas';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'versao',
        'em_desenvolvimento',
        'disponivel_para_atualizacao',
        'data_disponivel',
        'obs',
    ];
}
