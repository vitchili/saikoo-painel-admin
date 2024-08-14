<?php

namespace App\Models\Cliente;

use App\Models\Cliente\Contato\ContatoComCliente;
use App\Models\Cliente\ContatoPessoaCliente;
use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\HistoricoNumeroProfissionais\HistoricoNumeroProfissionaisCliente;
use App\Models\Cliente\Implantacao\ImplantacaoCliente;
use App\Models\Cliente\Parceiro\ParceiroCliente;
use App\Models\Cliente\SaikooWeb\SaikooWebCliente;
use App\Models\Cliente\Serial\SerialCliente;
use App\Models\Cliente\Servico\ServicoCliente;
use App\Models\Cliente\TicketDesenvolvimento\TicketDesenvolvimento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    const CREATED_AT = 'data_cadastro';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'id_representante',
        'id_indicacao',
        'tipo',
        'token',
        'data_inst',
        'codico',
        'codigo',
        'nome',
        'nomefantasia',
        'cpf_cnpj',
        'ie',
        'inscricao_municipal',
        'residente_domiciliada',
        'responsavel',
        'cpf_resp',
        'email_resp',
        'senha_resp',
        'aut_envio_email_resp',
        'rg',
        'fone_resp1',
        'fone_resp2',
        'orgao_expedidor',
        'data_nasc_resp',
        'responsavel2',
        'cpf_resp2',
        'email_resp2',
        'aut_envio_email_resp2',
        'nao_faz_parte_contrato2',
        'rg2',
        'orgao_expedidor2',
        'data_nasc_resp2',
        'email',
        'senha',
        'status_senha',
        'site',
        'end',
        'numero',
        'cep',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'ddd',
        'skype',
        'telefone',
        'telefone2',
        'banco',
        'operacaocaixa',
        'tipo_conta',
        'agencia',
        'agenciadv',
        'conta',
        'contadv',
        'cod_pago',
        'senha_pago',
        'obs',
        'obs_tendimento',
        'servicos_c',
        'nivel',
        'data',
        'data_cadastro',
        'id_usuario_cadastro',
        'id_usuario_auto_repre',
        'versao',
        'data_atu_ver',
        'usuario_atu',
        'usuario_atu_validador',
        'horario_atu_validador',
        'validador',
        'status',
        'contato_ativo_cliente',
        'em_implantacao',
        'dta_em_implantacao',
        'dta_concluido_implantacao',
        'contrato',
        'logo',
        'id_remoto',
        'senha_remoto',
        'data_remoto',
        'tornar_cliente',
        'data_torna_cliente',
        'certificado',
        'data_certificado',
        'usuario_certificado',
        'senha_certificado',
        'cadastro_site',
        'vinculado',
        'termos_concordo',
        'termos_texto',
        'termos_dta_concordo',
        'solicita_dados',
        'cliente_parceiro',
        'url_api',
    ];

    public function contatosComCliente()
    {
        return $this->hasMany(ContatoComCliente::class);
    }

    public function contatosPessoasCliente()
    {
        return $this->hasMany(ContatoPessoaCliente::class);
    }

    public function redesSociais()
    {
        return $this->hasMany(RedeSocialCliente::class);
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'id_usuario_cadastro');
    }

    public function historicoObservacoes()
    {
        return $this->hasMany(HistoricoObservacoesCliente::class, 'cliente_id');
    }

    public function faturas()
    {
        return $this->hasMany(FaturaCliente::class, 'id_cliente');
    }

    public function servicosCliente()
    {
        return $this->hasMany(ServicoCliente::class, 'id_cliente');
    }

    public function historicoNumeroProfissionais()
    {
        return $this->hasMany(HistoricoNumeroProfissionaisCliente::class, 'id_cliente');
    }

    public function parceiros()
    {
        return $this->hasMany(ParceiroCliente::class, 'cliente_id');
    }

    public function seriais()
    {
        return $this->hasMany(SerialCliente::class, 'id_cliente');
    }

    public function implantacaoCliente()
    {
        return $this->hasOne(ImplantacaoCliente::class, 'cliente_id');
    }

    public function ticketsDesenvolvimento()
    {
        return $this->hasMany(TicketDesenvolvimento::class, 'cliente_id');
    }
}
