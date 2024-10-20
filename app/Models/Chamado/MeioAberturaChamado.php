<?php

namespace App\Models\Chamado;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeioAberturaChamado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'meios_aberturas_chamados';

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'nome',
    ];

    public function chamados()
    {
        return $this->hasMany(Chamado::class);
    }
}
