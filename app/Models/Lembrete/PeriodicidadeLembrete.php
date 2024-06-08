<?php

namespace App\Models\Lembrete;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PeriodicidadeLembrete extends Model
{
    use HasFactory;

    protected $table = 'periodicidades';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    public function lembretes(): BelongsToMany
    {
        return $this->belongsToMany(Lembrete::class, 'lembretes');
    }
}
