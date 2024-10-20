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
        Schema::create('parceiros_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'cliente_id');
            $table->string('url')->nullable();
            $table->string('codigo')->nullable();
            $table->string('login')->nullable();
            $table->string('senha')->nullable();
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
        Schema::dropIfExists('parceiros_clientes');
    }
};
