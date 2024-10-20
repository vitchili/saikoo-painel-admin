<?php

namespace App\Models\Cliente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoRedeSocialCliente extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'tipos_redes_sociais_clientes';

    public function redesSociais(): HasMany
    {
        return $this->hasMany(RedeSocialCliente::class, 'tipo_rede_social_id');
    }
}
