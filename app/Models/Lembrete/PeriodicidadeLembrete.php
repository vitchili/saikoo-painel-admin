<?php

namespace App\Models\Lembrete;

use App\Models\Cliente\Servico\ServicoCliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodicidadeLembrete extends Model
{
    public const PERIODICIDADE_ATIPICO = 1;
    public const PERIODICIDADE_DIARIO = 2;
    public const PERIODICIDADE_SEMANAL = 3;
    public const PERIODICIDADE_QUINZENAL = 4;
    public const PERIODICIDADE_MENSAL = 5;
    public const PERIODICIDADE_ANUAL = 6;

    use HasFactory;

    protected $table = 'periodicidades';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    public function lembretes(): BelongsToMany
    {
        return $this->belongsToMany(Lembrete::class, 'lembretes');
    }

    public function servicos(): HasMany
    {
        return $this->hasMany(ServicoCliente::class, 'periodicidade');
    }
}
