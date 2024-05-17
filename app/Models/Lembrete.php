<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lembrete extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'descricao',
        'data_hora_inicio',
        'data_hora_fim',
        'observacoes',
        'periodicidade_id',
        'criado_por',
    ];

    public function tecnicos(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lembretes_tecnicos', 'lembrete_id', 'tecnico_id');
    }

    public function periodicidade(): BelongsTo
    {
        return $this->belongsTo(Periodicidade::class);
    }

    public function criador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'criado_por');
    }
}
