<?php

use App\Models\Chamado\Enum\SituacaoChamado;
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
        Schema::table('chamados', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Diversos\Veiculo::class, 'veiculo_id')->nullable()->change();
            $table->foreignIdFor(\App\Models\User::class, 'tecnico_condutor_ida_id')->nullable()->change();
            $table->foreignIdFor(\App\Models\User::class, 'tecnico_condutor_volta_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chamados', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Diversos\Veiculo::class, 'veiculo_id')->change();
            $table->foreignIdFor(\App\Models\User::class, 'tecnico_condutor_ida_id')->change();
            $table->foreignIdFor(\App\Models\User::class, 'tecnico_condutor_volta_id')->change();
        });
    }
};
