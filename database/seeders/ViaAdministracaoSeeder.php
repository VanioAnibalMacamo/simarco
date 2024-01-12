<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ViaAdministracao;

class ViaAdministracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        ViaAdministracao::create(['descricao' => 'Oral']);
        ViaAdministracao::create(['descricao' => 'Injectavel']);
        ViaAdministracao::create(['descricao' => 'Topica']);
    }
}
