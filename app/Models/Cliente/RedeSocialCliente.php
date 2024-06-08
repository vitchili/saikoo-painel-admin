<?php

namespace App\Models\Cliente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedeSocialCliente extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'redes_sociais_clientes';

    protected $fillable = ['cliente_id', 'tipo_rede_social_id', 'url'];

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(TipoRedeSocialCliente::class, 'tipo_rede_social_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
