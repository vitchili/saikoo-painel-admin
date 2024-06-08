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
        Schema::create('comentarios_chamados', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Chamado\Chamado::class, 'chamado_id');
            $table->string('descricao');
            $table->foreignIdFor(\App\Models\User::class, 'cadastrado_por');
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios_chamados');
    }
};
