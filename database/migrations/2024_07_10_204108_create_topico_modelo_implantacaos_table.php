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
        Schema::create('topicos_modelos_implantacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Implantacao\ModeloImplantacao::class, 'modelo_id');
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topicos_modelos_implantacoes');
    }
};
