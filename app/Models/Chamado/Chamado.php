<?php

namespace App\Models\Chamado;

use App\Models\Cliente\Cliente;
use App\Models\Cliente\Servico\TipoServicoCliente;
use App\Models\Diversos\Veiculo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Chamado extends Model
{
    use HasFactory, SoftDeletes;

    use HasFilamentComments;

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

    public function tecnicos()
    {
        return $this->belongsToMany(User::class, 'chamados_tecnicos', 'chamado_id', 'tecnico_id');
    }

    public function servicos(): BelongsToMany
    {
        return $this->belongsToMany(TipoServicoCliente::class, 'chamados_servicos', 'chamado_id', 'tipo_servico_id');
    }

    public function criador()
    {
        return $this->belongsTo(User::class, 'cadastrado_por');
    }
}
