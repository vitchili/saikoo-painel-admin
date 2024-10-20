<?php

namespace App\Models;

use App\Models\Cliente\TicketDesenvolvimento\TicketDesenvolvimento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VersaoSistema extends Model
{
    use HasFactory, SoftDeletes;

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

    public function tickets(): HasMany
    {
        return $this->hasMany(TicketDesenvolvimento::class, 'versao_id');
    }
}
