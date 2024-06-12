<?php

namespace App\Models\Chamado;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoChamado extends Model
{
    use HasFactory;

    protected $table = 'tipos_chamados';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillble = [
        'nome',
    ];

    public function chamados()
    {
        return $this->hasMany(Chamado::class);
    }

}
