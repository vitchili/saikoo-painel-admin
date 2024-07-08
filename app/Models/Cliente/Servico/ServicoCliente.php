<?php

namespace App\Models\Cliente\Servico;

use App\Models\Cliente\Cliente;
use App\Models\Lembrete\PeriodicidadeLembrete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicoCliente extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $table = 'serv_cliente';

    protected $fillable = [
        'id_servico',
        'id_cliente',
        'id_pedido',
        'qtd_sms_disp_mes',
        'usuario_sms',
        'senha_sms',
        'servico_sms',
        'bd_btech',
        'qtd',
        'qtd_profissionais',
        'validar_prof',
        'tipo_qtd',
        'id_representante',
        'dta_contratada',
        'dta_instalacao',
        'valor',
        'pagamento',
        'obs',
        'url_agenda_online',
        'versao',
        'obs_versao',
        'parametro_comissao',
        'versao_data_atualizado',
        'versao_por_atualizado',
        'tipo',
        'periodicidade',
        'serial_servico',
        'status',
        'motivo_status',
        'em_implatacao',
        'dta_inicio_implatacao',
        'dta_fim_implatacao',
        'link_painel_host',
        'login_host',
        'senha_host'
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function servicoCliente(): BelongsTo
    {
        return $this->belongsTo(TipoServicoCliente::class, 'id_servico');
    }

}
