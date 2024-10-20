<?php

namespace App\Models\Lembrete;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lembrete extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->belongsTo(PeriodicidadeLembrete::class);
    }

    public function criador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'criado_por');
    }
}
