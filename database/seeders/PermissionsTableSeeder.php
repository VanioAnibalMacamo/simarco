<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            // Usuários
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Roles
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Permissions
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',

            // Consultas
            'view consultas',
            'create consultas',
            'edit consultas',
            'delete consultas',

            // Pacientes
            'view pacientes',
            'create pacientes',
            'edit pacientes',
            'delete pacientes',

            // Médicos
            'view medicos',
            'create medicos',
            'edit medicos',
            'delete medicos',

            // Diagnósticos
            'view diagnosticos',
            'create diagnosticos',
            'edit diagnosticos',
            'delete diagnosticos',

            // Prescrições
            'view prescricoes',
            'create prescricoes',
            'edit prescricoes',
            'delete prescricoes',

            // Medicamentos
            'view medicamentos',
            'create medicamentos',
            'edit medicamentos',
            'delete medicamentos'
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
