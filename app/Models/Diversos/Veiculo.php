<?php

namespace App\Models\Diversos;

use App\Models\Chamado\Chamado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Veiculo extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillble = [
        'tipo',
        'nome',
        'placa',
    ];

    public function chamados(): BelongsToMany
    {
        return $this->belongsToMany(Chamado::class);
    }
}
