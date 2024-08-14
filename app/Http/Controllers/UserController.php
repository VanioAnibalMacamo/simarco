<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Medico;
use App\Models\Paciente;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(8);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $medicos = Medico::all();
        $pacientes = Paciente::all();

        return view('users.create', compact('roles', 'medicos', 'pacientes'));
    }

    public function store(Request $request)
    {
        // Cria o hash da senha 'admin'
        $hashedPassword = Hash::make('admin');

        // Adiciona a senha ao request
        $request->merge(['password' => $hashedPassword]);

        // Cria o usuário com os dados do request, incluindo a senha hash
        $user = User::create($request->all());
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $medicos = Medico::all();
        $pacientes = Paciente::all();

        return view('users.edit', compact('user', 'roles', 'medicos', 'pacientes'));
    }


    public function update(Request $request, User $user)
    {
        // Valide os dados recebidos
        $request->validate([
            'medico_id' => 'nullable|exists:medicos,id',
            'paciente_id' => 'nullable|exists:pacientes,id',
            'role' => 'required|exists:roles,name',
            'type' => 'required|in:nenhum,medico,paciente',
        ]);

        // Atualize os dados do usuário, exceto as relações
        $user->update($request->except('role', 'medico_id', 'paciente_id'));

        // Sincronize os papéis (roles)
        $user->syncRoles($request->role);

        if ($request->type === 'medico') {
            $user->medico_id = $request->medico_id;
            $user->paciente_id = null;
        } elseif ($request->type === 'paciente') {
            $user->paciente_id = $request->paciente_id;
            $user->medico_id = null;
        } else {
            $user->medico_id = null;
            $user->paciente_id = null;
        }

        // Salve as mudanças no User, incluindo as relações
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }



}
