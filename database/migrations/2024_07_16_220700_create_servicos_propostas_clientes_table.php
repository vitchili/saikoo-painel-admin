<?php

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
        Schema::create('servicos_propostas_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cliente\Proposta\PropostaCliente::class, 'proposta_id');
            $table->foreignIdFor(\App\Models\Cliente\Servico\TipoServicoCliente::class, 'servico_id');
            $table->integer('qtd');
            $table->decimal('valor', 8, 2);
            $table->boolean('calc_por_qtd');
            $table->boolean('cobrar_instalacao');
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos_propostas_clientes');
    }
};
