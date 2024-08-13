<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $empresas = [
            [
                'nome' => 'Vodacom Moçambique',
                'sigla' => 'VM',
                'nuit' => '600000000',
                'email' => 'info@vodacom.co.mz',
                'contacto1' => '822000000',
                'contacto2' => '842000000',
                'localizacao' => 'Maputo, Moçambique',
            ],
            [
                'nome' => 'Emose (Empresa Moçambicana de Seguros)',
                'sigla' => 'EMOSE',
                'nuit' => '600000001',
                'email' => 'info@emose.co.mz',
                'contacto1' => '825000000',
                'contacto2' => '843000000',
                'localizacao' => 'Maputo, Moçambique',
            ],
            [
                'nome' => 'Caminhos de Ferro de Moçambique',
                'sigla' => 'CFM',
                'nuit' => '600000002',
                'email' => 'info@cfm.co.mz',
                'contacto1' => '824000000',
                'contacto2' => '844000000',
                'localizacao' => 'Beira, Moçambique',
            ],
            [
                'nome' => 'Aeroportos de Moçambique',
                'sigla' => 'AdM',
                'nuit' => '600000003',
                'email' => 'info@aeroportos.co.mz',
                'contacto1' => '823000000',
                'contacto2' => '845000000',
                'localizacao' => 'Maputo, Moçambique',
            ],
            [
                'nome' => 'HCB (Hidráulica de Cahora Bassa)',
                'sigla' => 'HCB',
                'nuit' => '600000004',
                'email' => 'info@hcb.co.mz',
                'contacto1' => '821500000',
                'contacto2' => '842500000',
                'localizacao' => 'Tete, Moçambique',
            ],
        ];

        foreach ($empresas as $empresa) {
            // Verificar se a empresa já existe com base no 'nuit'
            if (!DB::table('empresas')->where('nuit', $empresa['nuit'])->exists()) {
                DB::table('empresas')->insert($empresa);
            }
        }
    }
}
