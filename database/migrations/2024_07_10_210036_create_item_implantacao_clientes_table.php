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
        Schema::create('itens_implantacao_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Implantacao\TelaTopicoModeloImplantacao::class, 'tela_id');
            $table->foreignIdFor(\App\Models\Cliente\Implantacao\ImplantacaoCliente::class, 'implantacao_cliente_id');
            $table->boolean('faz_parte_do_treinamento')->nullable();
            $table->date('data_treinamento')->nullable();
            $table->string('treinado')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'treinado_por')->nullable();
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
        Schema::dropIfExists('itens_implantacao_clientes');
    }
};
