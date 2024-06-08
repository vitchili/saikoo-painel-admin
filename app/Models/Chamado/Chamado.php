<?php

namespace App\Models\Chamado;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Models\Diversos\Veiculo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
    use HasFactory;

    const CREATED_AT = 'cadastrado_em';

    const UPDATED_AT = 'atualizado_em';

    protected $fillable = [
        'departamento_id',
        'meio_abertura_id',
        'gerente_id',
        'cliente_id',
        'tipo_chamado_id',
        'data_visita',
        'data_hora_inicial',
        'data_hora_final',
        'situacao_id',
        'descricao',
        'veiculo_id',
        'tecnico_condutor_ida_id',
        'tecnico_condutor_volta_id',
        'tipo_servico_cliente_id',
        'sera_cobrado',
        'fatura_foi_alterada',
        'vencimento_fatura',
        'cadastrado_por'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function meioAbertura()
    {
        return $this->belongsTo(MeioAberturaChamado::class);
    }
    
    public function departamento()
    {
        return $this->belongsTo(DepartamentoChamado::class);
    }

    public function gerente()
    {
        return $this->belongsTo(User::class, 'gerente_id');
    }

    public function tipoChamado()
    {
        return $this->belongsTo(TipoChamado::class, 'tipo_chamado_id');
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function tecnicoCondutorIda()
    {
        return $this->belongsTo(User::class, 'tecnico_condutor_ida_id');
    }

    public function tecnicoCondutorVolta()
    {
        return $this->belongsTo(User::class, 'tecnico_condutor_volta_id');
    }

    public function tipoServicoCliente()
    {
        return $this->belongsTo(TipoServicoCliente::class, 'tipo_servico_cliente_id');
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioChamado::class);
    }

}
