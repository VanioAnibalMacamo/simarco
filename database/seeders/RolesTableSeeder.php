<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            'admin' => [
                // Usuários
                'view users', 'create users', 'edit users', 'delete users',

                // Roles
                'view roles', 'create roles', 'edit roles', 'delete roles',

                // Permissions
                'view permissions', 'create permissions', 'edit permissions', 'delete permissions',

                // Consultas
                'view consultas', 'create consultas', 'edit consultas', 'delete consultas',

                // Pacientes
                'view pacientes', 'create pacientes', 'edit pacientes', 'delete pacientes',

                // Médicos
                'view medicos', 'create medicos', 'edit medicos', 'delete medicos',

                // Diagnósticos
                'view diagnosticos', 'create diagnosticos', 'edit diagnosticos', 'delete diagnosticos',

                // Prescrições
                'view prescricoes', 'create prescricoes', 'edit prescricoes', 'delete prescricoes',

                // Medicamentos
                'view medicamentos', 'create medicamentos', 'edit medicamentos', 'delete medicamentos',

                //Parametrizacao e Gestao
                'view Parametrizacao', 'View gestao',

                //Dashborad
                'view dashboard',
            ],
            'manager' => [
                // Usuários
                'view users', 'edit users',

                // Roles
                'view roles', 'edit roles',

                // Permissions
                'view permissions',

                // Consultas
                'view consultas', 'edit consultas',

                // Pacientes
                'view pacientes', 'edit pacientes',

                // Médicos
                'view medicos', 'edit medicos',

                // Diagnósticos
                'view diagnosticos', 'edit diagnosticos',

                // Prescrições
                'view prescricoes', 'edit prescricoes',

                // Medicamentos
                'view medicamentos', 'edit medicamentos',

                //Parametrizacao e Gestao
                'view Parametrizacao', 'View gestao',

                //Dashborad
                'view dashboard',
            ],
            'user' => [
                // Consultas
                'view consultas',

                // Pacientes
                'view pacientes',

                // Médicos
                'view medicos',

                // Diagnósticos
                'view diagnosticos',

                // Prescrições
                'view prescricoes',

                // Medicamentos
                'view medicamentos'
            ]
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            foreach ($permissions as $permission) {
                $perm = Permission::where('name', $permission)->first();
                if ($perm) {
                    $role->givePermissionTo($perm);
                }
            }
        }
    }
}
