<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serv_cliente', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cliente\Servico\TipoServicoCliente::class, 'id_servico');
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'id_cliente');
            $table->integer('id_pedido')->nullable();
            $table->integer('qtd_sms_disp_mes')->nullable();
            $table->string('usuario_sms', 255)->nullable();
            $table->string('senha_sms', 255)->nullable();
            $table->char('servico_sms', 1)->default('N');
            $table->string('bd_btech', 20)->nullable();
            $table->integer('qtd')->default(1);
            $table->integer('qtd_profissionais')->nullable();
            $table->string('validar_prof', 20)->default('N');
            $table->char('tipo_qtd', 1)->default('P');
            $table->integer('id_representante')->nullable();
            $table->string('dta_contratada', 40)->nullable();
            $table->string('dta_instalacao', 40)->nullable();
            $table->decimal('valor', 18, 2)->nullable();
            $table->string('pagamento', 255)->nullable();
            $table->text('obs')->nullable();
            $table->string('url_agenda_online', 255)->nullable();
            $table->string('versao', 40)->nullable();
            $table->string('obs_versao', 1000)->nullable();
            $table->string('parametro_comissao', 255)->nullable();
            $table->timestamp('versao_data_atualizado')->nullable();
            $table->string('versao_por_atualizado', 40)->nullable();
            $table->string('tipo', 40)->nullable();
            $table->string('periodicidade', 40)->nullable();
            $table->string('serial_servico', 255)->nullable();
            $table->char('status', 1)->default('S');
            $table->string('motivo_status', 255)->nullable();
            $table->char('em_implatacao', 1)->default('N');
            $table->dateTime('dta_inicio_implatacao')->nullable();
            $table->dateTime('dta_fim_implatacao')->nullable();
            $table->string('link_painel_host', 255)->nullable();
            $table->string('login_host', 255)->nullable();
            $table->string('senha_host', 255)->nullable();
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serv_cliente');
    }
}