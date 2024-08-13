<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(8);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        // Valida os dados do formulário
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Cria uma nova role
        $role = Role::create([
            'name' => $validated['name'],
        ]);

        // Associa as permissões selecionadas à nova role
        if (isset($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        // Redireciona para a lista de roles com uma mensagem de sucesso
        return redirect()->route('roles.index')->with('success', 'Role criada com sucesso');
    }


    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados recebidos
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array', // A permissão é um array de IDs
            'permissions.*' => 'exists:permissions,id' // Cada ID de permissão deve existir na tabela de permissões
        ]);

        // Encontrar a role pelo ID
        $role = Role::findOrFail($id);

        // Atualizar o nome da role
        $role->name = $request->input('name');
        $role->save();

        // Atualizar as permissões associadas
        // Sync garante que somente as permissões fornecidas sejam associadas à role
        $role->permissions()->sync($request->input('permissions', []));

        // Redirecionar com mensagem de sucesso
        return redirect()->route('roles.index')->with('success', 'Role atualizada com sucesso');
    }


    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role excluída com sucesso!');
    }
}
