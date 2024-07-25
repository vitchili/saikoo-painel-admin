<?php

namespace App\Models\Cliente\Implantacao;

use App\Models\Implantacao\TelaTopicoModeloImplantacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemImplantacaoCliente extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'itens_implantacao_clientes';

    protected $fillble = [
        'tela_id',
        'implantacao_cliente_id',
        'faz_parte_do_treinamento',
        'data_treinamento',
        'treinado',
        'treinado_por',
    ];

    public function tela()
    {
        return $this->belongsTo(TelaTopicoModeloImplantacao::class, 'tela_id');
    }

    public function implantacaoCliente()
    {
        return $this->belongsTo(ImplantacaoCliente::class, 'implantacao_cliente_id');
    }
}
