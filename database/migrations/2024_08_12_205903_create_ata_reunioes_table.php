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
        Schema::create('ata_reunioes', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(0);
            $table->string('titulo');
            $table->text('texto');
            $table->string('anexo');
            $table->foreignIdFor(\App\Models\User::class, 'criado_por');
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
        Schema::dropIfExists('ata_reunioes');
    }
};
