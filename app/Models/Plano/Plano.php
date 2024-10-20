<?php

namespace App\Models\Plano;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plano extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tipo_id',
        'nome',
        'descricao',
        'qtd_profissionais',
        'qtd_horas',
        'qtd_dias_valido',
        'qtd_limites_ligacoes',
        'valor_geral',
        'valor_mensal',
        'valor_semestral',
        'valor_anual',
        'desconto_mensal',
        'desconto_semestral',
        'desconto_anual',
        'tipo_desconto',
    ];
}
