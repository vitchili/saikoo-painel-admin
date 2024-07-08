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
        Schema::create('faturas_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'id_cliente');
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'codigo_cliente')->nullable();
            $table->integer('id_pedido')->nullable();
            $table->integer('id_checkout')->nullable();
            $table->char('tipo', 3)->nullable();
            $table->char('temp', 3)->default('N');
            $table->string('vencimento', 255)->nullable();
            $table->date('vencimento_boleto')->nullable();
            $table->string('status', 255)->default('Em aberto');
            $table->decimal('valor', 18, 2)->nullable();
            $table->decimal('juros_atraso', 18, 2)->default(1.00);
            $table->decimal('multa_atraso', 18, 2)->default(2.00);
            $table->decimal('valor_atualizado', 18, 2)->nullable();
            $table->decimal('valor_pago', 18, 2)->nullable();
            $table->string('qtd', 2)->nullable();
            $table->string('serial', 255)->nullable();
            $table->string('validade_final', 255);
            $table->string('cpf_cnpj', 14);
            $table->string('formapagamento', 255)->nullable();
            $table->string('referencia', 1000);
            $table->string('info_add', 255)->nullable();
            $table->text('obs')->nullable();
            $table->string('url_checkout', 1000)->nullable();
            $table->datetime('data')->useCurrent();
            $table->string('data_alt_status', 40)->nullable();
            $table->string('hora_alt_status', 40)->nullable();
            $table->string('user_alt_status', 255)->nullable();
            $table->string('ip_alt_status', 255)->nullable();
            $table->string('comprovante', 255)->nullable();
            $table->string('chave_fortunus', 255)->nullable();
            $table->string('pedido', 255)->nullable();
            $table->char('utilizado', 1)->default('N')->comment('CAMPO QUE INFORMA SE O SERIAL FOI OU NAO UTILIZADO');
            $table->char('nec_host', 1)->default('N');
            $table->string('datahost', 10)->nullable();
            $table->char('renovahost', 1)->default('N');
            $table->integer('sms_qtd')->nullable();
            $table->char('sms_creditado', 1)->default('N');
            $table->char('sms_creditar_automaticamente', 1)->default('S');
            $table->char('pedido_visualizado', 1)->default('N');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faturas_clientes');
    }
};
