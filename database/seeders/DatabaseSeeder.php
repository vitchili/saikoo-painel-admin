<?php

namespace Database\Seeders;

use App\Models\Periodicidade;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Periodicidade::create([
            'nome' => 'Atípico',
        ]);

        Periodicidade::create([
            'nome' => 'Diário',
        ]);

        Periodicidade::create([
            'nome' => 'Semanal',
        ]);

        Periodicidade::create([
            'nome' => 'Quinzenal',
        ]);

        Periodicidade::create([
            'nome' => 'Mensal',
        ]);

        Periodicidade::create([
            'nome' => 'Anual',
        ]);
    }
}
