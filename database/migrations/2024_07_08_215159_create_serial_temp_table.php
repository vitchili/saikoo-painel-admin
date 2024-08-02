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
        Schema::create('serial_temp', function (Blueprint $table) {
            $table->id();
            $table->string('serial');
            $table->date('vencimento_serial');
            $table->string('usuario_gerado');
            $table->integer('id_cliente');
            $table->string('cnpj_serial')->nullable();
            $table->string('obs')->nullable();
            $table->string('tipo')->nullable()->comment('Cliente/Representante')->default('C');
            $table->timestamp('data_gerado')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_temp');
    }
};
