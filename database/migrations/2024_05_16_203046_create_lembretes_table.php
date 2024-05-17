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
        Schema::create('lembretes', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->datetime('data_hora_inicio');
            $table->datetime('data_hora_fim');
            $table->text('observacoes')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'periodicidade_id');
            $table->foreignIdFor(\App\Models\User::class, 'criado_por');
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembretes');
    }
};
