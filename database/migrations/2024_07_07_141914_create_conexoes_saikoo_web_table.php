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
        Schema::create('conexoes_saikoo_web', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'cliente_id');
            $table->string('url_app')->nullable();
            $table->string('url')->nullable();
            $table->string('host')->nullable();
            $table->string('usuario')->nullable();
            $table->string('senha')->nullable();
            $table->string('bd')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conexoes_saikoo_web');
    }
};
