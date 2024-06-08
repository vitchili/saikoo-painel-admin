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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_representante')->nullable();
            $table->integer('id_indicacao')->nullable();
            $table->integer('tipo')->nullable();
            $table->string('token')->nullable();
            $table->date('data_inst')->nullable();
            $table->integer('codico')->nullable();
            $table->integer('codigo')->nullable();
            $table->string('nome');
            $table->string('nomefantasia')->nullable();
            $table->string('cpf_cnpj')->nullable();
            $table->string('ie')->nullable();
            $table->string('inscricao_municipal')->nullable();
            $table->string('residente_domiciliada')->nullable();
            $table->string('responsavel')->nullable();
            $table->string('cpf_resp')->nullable();
            $table->string('email_resp')->nullable();
            $table->string('senha_resp')->nullable();
            $table->string('aut_envio_email_resp', 1)->default('N');
            $table->string('rg')->nullable();
            $table->string('fone_resp1')->nullable();
            $table->string('fone_resp2')->nullable();
            $table->string('orgao_expedidor')->nullable();
            $table->date('data_nasc_resp')->nullable();
            $table->string('responsavel2')->nullable();
            $table->string('cpf_resp2')->nullable();
            $table->string('email_resp2')->nullable();
            $table->string('aut_envio_email_resp2', 1)->default('N');
            $table->string('nao_faz_parte_contrato2', 1)->default('N');
            $table->string('rg2')->nullable();
            $table->string('orgao_expedidor2')->nullable();
            $table->date('data_nasc_resp2')->nullable();
            $table->string('email')->nullable();
            $table->string('senha')->nullable();
            $table->string('status_senha', 1)->default('N');
            $table->string('site')->nullable();
            $table->string('end');
            $table->string('numero');
            $table->string('cep');
            $table->string('complemento')->nullable();
            $table->string('bairro', 50);
            $table->string('cidade', 50);
            $table->string('uf', 2);
            $table->string('ddd', 3)->nullable();
            $table->string('skype')->nullable();
            $table->string('telefone')->nullable();
            $table->string('telefone2')->nullable();
            $table->integer('banco')->nullable();
            $table->integer('operacaocaixa')->nullable();
            $table->string('tipo_conta')->nullable();
            $table->string('agencia', 40)->nullable();
            $table->string('agenciadv', 40)->nullable();
            $table->string('conta', 40)->nullable();
            $table->string('contadv', 40)->nullable();
            $table->integer('id_tipo_financeira')->nullable();
            $table->string('cod_pago')->nullable();
            $table->string('senha_pago')->nullable();
            $table->text('obs')->nullable();
            $table->text('obs_tendimento')->nullable();
            $table->text('servicos_c')->nullable();
            $table->integer('nivel')->default(1);
            $table->timestamp('data')->useCurrent()->useCurrentOnUpdate();
            $table->datetime('data_cadastro')->useCurrent();
            $table->integer('id_usuario_cadastro')->nullable();
            $table->integer('id_usuario_auto_repre')->default(0);
            $table->string('versao')->nullable();
            $table->datetime('data_atu_ver')->nullable();
            $table->string('usuario_atu')->nullable();
            $table->string('usuario_atu_validador')->nullable();
            $table->string('horario_atu_validador')->nullable();
            $table->string('validador', 40)->nullable();
            $table->string('status', 40)->default('A');
            $table->string('contato_ativo_cliente', 1)->default('S');
            $table->string('em_implantacao', 1)->default('N');
            $table->datetime('dta_em_implantacao')->nullable();
            $table->datetime('dta_concluido_implantacao')->nullable();
            $table->string('contrato')->nullable();
            $table->string('logo')->nullable();
            $table->string('id_remoto')->nullable();
            $table->string('senha_remoto')->nullable();
            $table->datetime('data_remoto')->nullable();
            $table->string('tornar_cliente', 1)->nullable()->default('N');
            $table->datetime('data_torna_cliente')->nullable();
            $table->string('certificado')->nullable();
            $table->datetime('data_certificado')->nullable();
            $table->string('usuario_certificado')->nullable();
            $table->string('senha_certificado')->nullable();
            $table->string('cadastro_site', 1)->nullable();
            $table->string('vinculado', 1)->default('N');
            $table->string('termos_concordo', 1)->nullable();
            $table->text('termos_texto')->nullable();
            $table->datetime('termos_dta_concordo')->nullable();
            $table->string('solicita_dados', 1)->default('N');
            $table->string('cliente_parceiro', 1)->default('N');
            $table->string('url_api')->nullable();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
