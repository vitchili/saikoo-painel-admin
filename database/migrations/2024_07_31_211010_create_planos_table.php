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
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_id');
            $table->decimal('nome');
            $table->decimal('descricao')->nullable();
            $table->integer('qtd_profissionais')->nullable();
            $table->integer('qtd_horas')->nullable();
            $table->integer('qtd_dias_valido')->nullable();
            $table->integer('qtd_limites_ligacoes')->nullable();
            $table->decimal('valor_geral')->nullable();
            $table->decimal('valor_mensal')->nullable();
            $table->decimal('valor_semestral')->nullable();
            $table->decimal('valor_anual')->nullable();
            $table->decimal('desconto_mensal')->nullable();
            $table->decimal('desconto_semestral')->nullable();
            $table->decimal('desconto_anual')->nullable();
            $table->string('tipo_desconto')->nullable();
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
        Schema::dropIfExists('planos');
    }
};
