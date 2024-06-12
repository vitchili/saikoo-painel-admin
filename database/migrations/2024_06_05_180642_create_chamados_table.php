<?php

use App\Models\Chamado\Enum\SituacaoChamado;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Chamado\DepartamentoChamado::class, 'departamento_id');
            $table->foreignIdFor(\App\Models\Chamado\MeioAberturaChamado::class, 'meio_abertura_id');
            $table->foreignIdFor(\App\Models\User::class, 'gerente_id');
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'cliente_id');
            $table->foreignIdFor(\App\Models\Chamado\TipoChamado::class, 'tipo_chamado_id');
            $table->date('data_visita')->nullable();
            $table->datetime('data_hora_inicial')->nullable();
            $table->datetime('data_hora_final')->nullable();
            $table->integer('situacao_id')->nullable()->default(SituacaoChamado::ABERTO->value);
            $table->text('descricao')->nullable();
            $table->foreignIdFor(\App\Models\Diversos\Veiculo::class, 'veiculo_id');
            $table->foreignIdFor(\App\Models\User::class, 'tecnico_condutor_ida_id');
            $table->foreignIdFor(\App\Models\User::class, 'tecnico_condutor_volta_id');
            $table->boolean('sera_cobrado')->nullable();
            $table->boolean('fatura_foi_alterada')->nullable();
            $table->date('vencimento_fatura')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'cadastrado_por');
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamados');
    }
};
