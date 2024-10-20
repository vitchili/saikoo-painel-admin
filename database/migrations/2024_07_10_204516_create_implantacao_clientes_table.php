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
        Schema::create('implantacoes_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'cliente_id');
            $table->foreignIdFor(\App\Models\Implantacao\ModeloImplantacao::class, 'modelo_id');
            $table->string('observacao')->nullable();
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
        Schema::dropIfExists('implantacoes_clientes');
    }
};
