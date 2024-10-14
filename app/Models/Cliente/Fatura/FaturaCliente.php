<?php

namespace App\Models\Cliente\Fatura;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Servico\ServicoCliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Models\Igpm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class FaturaCliente extends Model
{
    use HasFactory;
    
    use HasFilamentComments;

    const CREATED_AT = 'data';

    const UPDATED_AT = 'data_alt_status';

    protected $table = 'faturas_clientes';

    protected $fillable = [
        'id_cliente',
        'codigo_cliente',
        'id_pedido',
        'id_checkout',
        'tipo',
        'temp',
        'vencimento',
        'vencimento_boleto',
        'status',
        'valor',
        'juros_atraso',
        'multa_atraso',
        'valor_atualizado',
        'valor_pago',
        'qtd',
        'serial',
        'validade_final',
        'cpf_cnpj',
        'formapagamento',
        'referencia',
        'info_add',
        'obs',
        'url_checkout',
        'data',
        'data_alt_status',
        'hora_alt_status',
        'user_alt_status',
        'ip_alt_status',
        'comprovante',
        'chave_fortunus',
        'pedido',
        'utilizado',
        'nec_host',
        'datahost',
        'renovahost',
        'sms_qtd',
        'sms_creditado',
        'sms_creditar_automaticamente',
        'pedido_visualizado',
        'igpm_id',
        'reajuste_automatico',
        'reajuste_aplica_ultimo_igpm',
        'servicos',
        'incremento_parcela',
        'cobranca_bitpag_id',
        'gerar_serial',
        'final_cartao',
    ];

    protected $with = ['cliente', 'servicos'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function servicos()
    {
        return $this->belongsToMany(ServicoCliente::class, 'servicos_faturas', 'fatura_id', 'servico_id');
    }

    public function igpm()
    {
        return $this->belongsTo(Igpm::class, 'igpm_id');
    }
}
