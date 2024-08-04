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
        Schema::create('versoes_sistemas', function (Blueprint $table) {
            $table->id();
            $table->string('versao');
            $table->boolean('em_desenvolvimento')->default(0)->nullable();
            $table->boolean('disponivel_para_atualizacao')->default(0)->nullable();
            $table->date('data_disponivel')->nullable();
            $table->text('obs')->nullable();
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versoes_sistemas');
    }
};
