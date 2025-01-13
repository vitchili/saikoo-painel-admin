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
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
            $table->string('qr_code_pix')->nullable();
            $table->string('data_expiracao_pix')->nullable();
            $table->string('digitavel_pix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faturas_clientes', function (Blueprint $table) {
            $table->dropColumn('atualizado_em');
            $table->dropColumn('qr_code_pix');
            $table->dropColumn('data_expiracao_pix');
            $table->dropColumn('digitavel_pix');
        });
    }
};
