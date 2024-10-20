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
        Schema::create('numero_profissionais_sistema', function (Blueprint $table) {
            $table->id('id_numero_profissionais_sistema');
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'id_cliente');
            $table->integer('qtd_profissionais');
            $table->softDeletes();
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('dta_atualizacao')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numero_profissionais_sistema');
    }
};
