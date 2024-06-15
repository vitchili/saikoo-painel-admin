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
        Schema::create('chamados_servicos', function (Blueprint $table) {
            $table->foreignId('chamado_id')->constrained('chamadosServicos')->onDelete('cascade');
            $table->foreignId('tipo_servico_id')->constrained('tipoServicoChamado')->onDelete('cascade');
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamados_servicos');
    }
};
