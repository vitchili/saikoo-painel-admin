<?php

namespace App\Models\Cliente\TicketDesenvolvimento;

use App\Models\Cliente\Cliente;
use App\Models\Diversos\Modulo;
use App\Models\Diversos\Subtela;
use App\Models\Diversos\Tela;
use App\Models\Diversos\Sistema;
use App\Models\User;
use App\Models\VersaoSistema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class TicketDesenvolvimento extends Model
{
    use HasFactory, SoftDeletes;

    use HasFilamentComments;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'tickets_desenvolvimentos';

    protected $casts = [
        'imagens' => 'array',
    ];

    protected $fillable = [
        'cliente_id',
        'tipo_id',
        'tipo_projeto_id',
        'responsavel_id',
        'desenvolvedor_id',
        'prioridade_id',
        'versao_id',
        'sistema_id',
        'modulo_id',
        'tela_id',
        'subtela_id',
        'prazo',
        'previsao',
        'comentario',
        'anexo',
        'titulo',
        'objetivo',
        'versao_atual',
        'situacao_atual',
        'situacao_proposta',
        'imagens',
        'testes_em_caso_de_erro',
        'situacao_id',
    ];

    public function tipoProjto(): BelongsTo
    {
        return $this->belongsTo(TipoProjetoTicketDesenvolvimento::class, 'tipo_projeto_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function sistema(): BelongsTo
    {
        return $this->belongsTo(Sistema::class, 'sistema_id');
    }

    public function modulo(): BelongsTo
    {
        return $this->belongsTo(Modulo::class, 'modulo_id');
    }

    public function tela(): BelongsTo
    {
        return $this->belongsTo(Tela::class, 'tela_id');
    }

    public function subtela(): BelongsTo
    {
        return $this->belongsTo(Subtela::class, 'subtela_id');
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function desenvolvedor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'desenvolvedor_id');
    }

    public function versao(): BelongsTo
    {
        return $this->belongsTo(VersaoSistema::class, 'versao_id');
    }
}
