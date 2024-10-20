<?php

use App\Models\Cliente\Proposta\Enum\TipoDescontoProposta;
use App\Models\Cliente\Proposta\Enum\TipoRecorrenciaCobrancaProposta;
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
        Schema::create('valores_e_descontos_propostas_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->foreignIdFor(\App\Models\Cliente\Proposta\PropostaCliente::class, 'proposta_id');
            $table->integer('tipo_recorrencia_cobranca_id')->nullable()->default(TipoRecorrenciaCobrancaProposta::UNICA->value);
            $table->integer('qtd_profissionais');
            $table->decimal('valor', 8, 2);
            $table->integer('tipo_desconto_id')->nullable()->default(TipoDescontoProposta::NENHUM->value);
            $table->decimal('valor_desconto', 8, 2)->nullable();
            $table->softDeletes();
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valores_e_descontos_propostas_clientes');
    }
};
