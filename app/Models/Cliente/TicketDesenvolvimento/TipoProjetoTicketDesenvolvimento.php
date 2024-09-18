<?php

namespace App\Models\Cliente\TicketDesenvolvimento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TipoProjetoTicketDesenvolvimento extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'tipos_projetos_tickets_desenvolvimentos';

    protected $fillable = [
        'nome',
    ];

    public function ticket(): HasOne
    {
        return $this->hasOne(TicketDesenvolvimento::class, 'tipo_projeto_id');
    }
}
