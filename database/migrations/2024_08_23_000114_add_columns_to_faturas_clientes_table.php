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
        Schema::table('faturas_clientes', function (Blueprint $table) {
            $table->integer('incremento_parcela')->default(1);
            $table->string('cobranca_bitpag_id')->nullable();
            $table->boolean('gerar_serial')->default(0);
            $table->string('status_pagamento_bitpag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faturas_clientes', function (Blueprint $table) {
            $table->dropColumn('incremento_parcela');
            $table->dropColumn('cobranca_bitpag_id');
            $table->dropColumn('gerar_serial');
            $table->dropColumn('status_pagamento_bitpag');
        });
    }
};
