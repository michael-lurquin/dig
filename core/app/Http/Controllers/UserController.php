<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Contracts\Auth\Guard;

use App\User;
use App\Behaviour\ListRoles;

class UserController extends Controller
{
    use ListRoles;

    public function __construct(Guard $auth)
    {
        $this->middleware('permission:manage_users', ['except' => ['edit', 'update']]);
        $this->auth = $auth;
    }

    public function index(Request $request)
    {
        $users = User::with('role')->get();

        return view('users.index')->withUsers($users);
    }

    public function create()
    {
        $roles = $this->getListRoles();

        return view('users.create')->withRoles($roles);
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
          'name'      => $request->name,
          'email'     => $request->email,
          'poste'     => $request->poste,
          'role_id'   => $request->role_id,
          'password'  => bcrypt($request->password),
        ]);

        return redirect()->route('user.index')->withSuccess("L'utilisateur : <strong>$request->name</strong> a été créé avec succès");
    }

    public function edit(User $user)
    {
        $roles = $this->getListRoles();
        $hasPermission = $this->auth->user()->can("manage_users");

        return view('users.edit')->withUser($user)->withRoles($roles)->with(['hasPermission' => $hasPermission]);
    }

    public function update(UserRequest $request, User $user)
    {
        $hasPermission = $this->auth->user()->can("manage_users");
        $redirect = $redirect = redirect()->route('profile', $user)->withSuccess("Votre profil a été modifié avec succès");

        $user->name = $request->name;

        if ( $hasPermission )
        {
          $user->email = $request->email;
          $user->poste = $request->poste;
          $user->role_id = $request->role_id;

          $redirect = redirect()->route('user.index')->withSuccess("L'utilisateur : <strong>$request->name</strong> a été modifié avec succès");
        }

        if ( !empty($request->password) && $hasPermission )
        {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return $redirect;
    }

    public function destroy(Request $request, User $user)
    {
        $user->active = FALSE;
        $user->save();

        return redirect()->route('user.index')->withSuccess("L'utilisateur : <strong>$user->name</strong> a été supprimé avec succès");
    }

    public function restore(Request $request, User $user)
    {
        $user->active = TRUE;
        $user->save();

        return redirect()->route('user.index')->withSuccess("L'utilisateur : <strong>$user->name</strong> a été restauré avec succès");
    }
}