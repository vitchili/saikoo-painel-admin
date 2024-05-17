<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Periodicidade extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    public function lembretes(): BelongsToMany
    {
        return $this->belongsToMany(Lembrete::class, 'lembretes');
    }
}
