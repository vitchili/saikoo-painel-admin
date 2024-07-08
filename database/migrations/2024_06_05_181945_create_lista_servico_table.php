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
        Schema::create('lista_servico', function (Blueprint $table) { //tipos_servicos_clientes. O nome da tabela atual é restrição da migração do sistema antigo.
            $table->id();
            $table->string('nome');
            $table->string('sigla')->nullable();
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_servico');
    }
};
