<?php

namespace App\Models\Diversos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subtela extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'subtelas';

    protected $fillble = [
        'nome',
        'tela_id'
    ];

    public function tela(): BelongsTo
    {
        return $this->belongsTo(Tela::class, 'tela_id');
    }
}
