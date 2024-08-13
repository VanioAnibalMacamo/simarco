<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(15);
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        Permission::create(['name' => $request->input('name')]);

        return redirect()->route('permissions.index')->with('success', 'Permissão criada com sucesso!');
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();

        return redirect()->route('permissions.index')->with('success', 'Permissão atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permissão excluída com sucesso!');
    }
}

