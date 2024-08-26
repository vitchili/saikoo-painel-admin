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
            $table->integer('igpm_id')->nullable();
            $table->boolean('reajuste_automatico')->default(0);
            $table->boolean('reajuste_aplica_ultimo_igpm')->default(0);
            $table->integer('incremento_parcela')->default(1);
            $table->string('cobranca_bitpag_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faturas_clientes', function (Blueprint $table) {
            $table->dropColumn('igpm_id');
            $table->dropColumn('reajuste_automatico');
            $table->dropColumn('reajuste_aplica_ultimo_igpm');
            $table->dropColumn('incremento_parcela');
            $table->dropColumn('cobranca_bitpag_id');
        });
    }
};
