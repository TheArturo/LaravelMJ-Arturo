<?php

namespace Src\Usuarios\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UsuarioController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $term = $request->input('term');
        $users = User::query()
            ->when(trim($term) !== '', function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        $roles = Role::orderBy('id')->get();
        return view('modulos.usuarios.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:usuarios,email'],
            'password' => ['nullable', 'string', 'min:6'],
            'role_id' => ['nullable', 'exists:roles,id'],
        ]);

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->role_id = $data['role_id'] ?? 2;
        $user->save();

        return redirect()->route('usuarios.index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('id')->get();
        return view('modulos.usuarios.editar', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:usuarios,email,{$id}"] ,
            'password' => ['nullable', 'string', 'min:6'],
            'role_id' => ['nullable', 'exists:roles,id'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->role_id = $data['role_id'] ?? $user->role_id;
        $user->save();

        return redirect()->route('usuarios.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('usuarios.index');
    }
}
