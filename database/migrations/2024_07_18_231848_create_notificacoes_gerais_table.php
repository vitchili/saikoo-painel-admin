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
        Schema::create('notificacoes_gerais', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'tecnico_id');
            $table->foreignIdFor(\App\Models\Chamado\Chamado::class, 'chamado_id');
            $table->datetime('data_hora');
            $table->string('descricao');
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacoes_gerais');
    }
};
