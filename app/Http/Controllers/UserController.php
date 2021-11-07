<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index',compact('users'));
    }
    public function show($id)
    {
        $user = User::find($id);

        return view('user.show', compact('user'));
    }
    public function create()
    {
        $user = new User();
        return view('user.create',compact('user'));
    }
    public function store(Request $request)
    {
        $request['password'] = Hash::make($request->password);
        if($request->tipo_usuario == 'ADMINISTRADOR'){
            $user = User::create($request->all())->assignRole('ADMINISTRADOR');
        }else{
            $user = User::create($request->all())->assignRole('VENDEDOR');
        }
        return redirect()->route('user.index')
             ->with('success', 'Usuario Creado correctamente.');
    }
    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {

        $user->update($request->all());

        return redirect()->route('user.index')
            ->with('success', 'Usuario Actualizado correctamente');
    }
    public function destroy($id)
    {
        $users = User::find($id)->delete();

        return redirect()->route('user.index')
            ->with('success', 'Usuario Eliminado correctamente');
    }
}
