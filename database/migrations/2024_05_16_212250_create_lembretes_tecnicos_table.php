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
        Schema::create('lembretes_tecnicos', function (Blueprint $table) {
            $table->foreignId('lembrete_id')->constrained('lembretes')->onDelete('cascade');
            $table->foreignId('tecnico_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembretes_tecnicos');
    }
};
