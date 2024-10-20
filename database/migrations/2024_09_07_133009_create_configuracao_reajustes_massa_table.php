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
        Schema::create('configuracao_reajustes_massa', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('indice_correcao_generica_id')->nullable()->constrained('indices_correcao_genericos')->onDelete('cascade');
            $table->foreignId('igpm_id')->nullable()->constrained('indices_igpm')->onDelete('cascade');
            $table->date('data_inicio');
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
        Schema::dropIfExists('configuracao_reajustes_massa');
    }
};
