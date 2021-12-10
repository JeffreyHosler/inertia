<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Models\User;

use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /*
	* return the dashboard
	*/
	public function index()
	{
		$users = User::when(request()->search, function($query) {
				$query->where('first_name', 'LIKE', '%' . request()->search . '%' )
					->orWhere('last_name', 'LIKE', '%' . request()->search . '%' )
					->orWhere('name', 'LIKE', '%' . request()->search . '%' )
					->orWhere('email', 'LIKE', '%' . request()->search . '%' );
				})
			->orderBy('last_name')
			->orderBy('first_name')
			->paginate(10)
			->withQueryString();

		return inertia('Admin/Users/Index', [
			'users' => $users,
			'search' => request()->search
		]);
	}

	/*
	* show form to add or edit user
	*/
	public function form(User $user)
	{
		$user->load('roles');
		$roles = Role::orderBy('name')->get(['id', 'name']);

		return inertia('Admin/Users/Form', [
			'user' => $user,
			'roles' => $roles
		]);
	}

	/*
	* show form to add or edit user
	*/
	public function save(User $user)
	{
		request()->validate([
			'first_name' => [ 'required', 'string', 'max:191' ],
			'last_name' => [ 'required', 'string', 'max:191' ],
			'username' => [ 'required', 'string', 'max:191', Rule::unique('users', 'name')->ignore($user->id)],
			'email' => [ 'required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user->id) ],
			'password' => [ Rule::requiredIf(! $user->id), 'confirmed' ],
		]);

		$user->first_name = request()->first_name;
		$user->last_name = request()->last_name;
		$user->name = request()->username;
		$user->email = request()->email;

		if(request()->password)
		{
			$user->password = request()->password;
		}
		$user->save();

		$user->syncRoles(request()->roles);

		flash('User has been saved')->success();
		return redirect( route( 'admin.users' ) );
	}

	/*
	* show form to add or edit user
	*/
	public function destroy(User $user)
	{
		$user->delete();

		flash('User has been deleted')->success();
		return redirect( route( 'admin.users' ) );
	}
}
