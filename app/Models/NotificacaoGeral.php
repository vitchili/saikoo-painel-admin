<?php

namespace App\Models;

use App\Models\Chamado\Chamado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificacaoGeral extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'notificacoes_gerais';

    protected $fillable = [
        'tecnico_id',
        'chamado_id',
        'data_hora',
        'descricao',
        'enviado',
    ];

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function chamado(): BelongsTo
    {
        return $this->belongsTo(Chamado::class, 'chamado_id');
    }
}
