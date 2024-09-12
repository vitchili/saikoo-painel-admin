<?php

use App\Models\Cliente\Proposta\Enum\CidadeProposta;
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
        Schema::create('propostas_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'cliente_id');
            $table->foreignIdFor(\App\Models\User::class, 'responsavel_id');
            $table->integer('cidade_id')->nullable()->default(CidadeProposta::CUIABA_VARZEA_GRANDE->value);
            $table->boolean('apresentacao_info_opcionais')->nullable()->default(1);
            $table->boolean('apresentacao_split_pagamento')->nullable()->default(1);
            $table->boolean('apresentacao_sms_mensal')->nullable()->default(1);
            $table->boolean('apresentacao_saikoo_mobile')->nullable()->default(1);
            $table->boolean('apresentacao_modulos_fiscais')->nullable()->default(1);
            $table->boolean('apresentacao_agenda_online')->nullable()->default(1);
            $table->boolean('apresentacao_cartao_comanda')->nullable()->default(1);
            $table->boolean('apresentacao_microterminal_comanda')->nullable()->default(1);
            $table->boolean('apresentacao_terminal_comanda_touch_screen')->nullable()->default(1);
            $table->boolean('apresentacao_terminal_comanda_tablet')->nullable()->default(1);
            $table->boolean('apresentacao_requisitos_minimos_instalacao')->nullable()->default(1);
            $table->text('info')->nullable();
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propostas_clientes');
    }
};
