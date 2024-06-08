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
        Schema::create('contatos_pessoas_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Cliente\Cliente::class, 'cliente_id');
            $table->foreignIdFor(\App\Models\Cliente\TipoContatoPessoaCliente::class, 'tipo_contato_pessoa_cliente_id');
            $table->string('nome');
            $table->string('telefone');
            $table->string('email')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'responsavel_id');
            $table->foreignIdFor(\App\Models\User::class, 'cadastrado_por');
            $table->timestamp('cadastrado_em')->useCurrent();
            $table->timestamp('atualizado_em')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatos_pessoas_clientes');
    }
};
