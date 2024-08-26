<?php

use App\Models\Cliente\Fatura\FaturaCliente;
use App\Models\Cliente\Servico\ServicoCliente;
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
        Schema::create('servicos_faturas', function (Blueprint $table) {
            //$table->foreignId('fatura_id')->constrained('faturas_clientes')->onDelete('cascade');
            //$table->foreignId('servico_id')->constrained('serv_cliente')->onDelete('cascade');
            $table->integer('fatura_id');
            $table->integer('servico_id');
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos_faturas');
    }
};
