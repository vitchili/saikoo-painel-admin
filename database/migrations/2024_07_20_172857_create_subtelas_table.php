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
        Schema::create('subtelas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Diversos\Tela::class, 'tela_id');
            $table->string('nome');
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
        Schema::dropIfExists('subtelas');
    }
};
