<?php

use App\Models\Cliente\TicketDesenvolvimento\Enum\PrioridadeTicketDesenvolvimentoEnum;
use App\Models\Cliente\TicketDesenvolvimento\Enum\SituacaoTicketDesenvolvimentoEnum;
use App\Models\Cliente\TicketDesenvolvimento\Enum\TipoTicketDesenvolvimentoEnum;
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
        Schema::create('tickets_desenvolvimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'cliente_id');
            $table->integer('tipo_id')->nullable()->default(TipoTicketDesenvolvimentoEnum::NOVO_REQUISITO->value);
            $table->foreignIdFor(\App\Models\Cliente\TicketDesenvolvimento\TipoProjetoTicketDesenvolvimento::class, 'tipo_projeto_id');
            $table->foreignIdFor(\App\Models\User::class, 'responsavel_id')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'desenvolvedor_id')->nullable();
            $table->integer('prioridade_id')->nullable()->default(PrioridadeTicketDesenvolvimentoEnum::MINIMA->value);
            $table->integer('versao_id')->nullable();
            $table->integer('situacao_id')->nullable()->default(SituacaoTicketDesenvolvimentoEnum::AGUARDANDO_ANALISE->value);
            $table->foreignIdFor(\App\Models\Diversos\Sistema::class, 'sistema_id')->nullable();
            $table->foreignIdFor(\App\Models\Diversos\Modulo::class, 'modulo_id')->nullable();
            $table->foreignIdFor(\App\Models\Diversos\Tela::class, 'tela_id')->nullable();
            $table->foreignIdFor(\App\Models\Diversos\Subtela::class, 'subtela_id')->nullable();
            $table->date('prazo')->nullable();
            $table->date('previsao')->nullable();
            $table->string('comentario')->nullable();
            $table->string('anexo')->nullable();
            $table->string('titulo')->nullable();
            $table->string('objetivo')->nullable();
            $table->string('versao_atual')->nullable();
            $table->text('situacao_atual')->nullable();
            $table->text('situacao_proposta')->nullable();
            $table->text('imagens')->nullable();
            $table->text('testes_em_caso_de_erro')->nullable();
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_desenvolvimentos');
    }
};
