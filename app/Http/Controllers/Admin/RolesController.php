<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /*
	* return the dashboard
	*/
	public function index()
	{
		$roles = Role::when(request()->search, function($query) {
					$query->where('name', 'LIKE', '%' . request()->search . '%' );
				})
			->orderBy('name')
			->withCount('permissions')
			->withCount('users')
			->paginate(25)
			->withQueryString();

		return inertia('Admin/Roles/Index', [
			'roles' => $roles,
			'search' => request()->search
		]);
	}

	/*
	* show form to add or edit role
	*/
	public function form(Role $role)
	{
		$role->load('permissions');
		$permissions = Permission::orderBy('name')->get(['id', 'name']);

		return inertia('Admin/Roles/Form', [
			'role' => $role,
			'permissions' => $permissions
		]);
	}

	/*
	* save role
	*/
	public function save(Role $role)
	{
		request()->validate([
			'name' => [ 'required', 'string', 'max:191', Rule::unique('roles', 'name')->ignore($role->id)]
		]);

		$role->name = request()->name;
		$role->save();

		$permissions = request()->perms;
		foreach(request()->newperms as $permission)
		{
			$p = new Permission;
			$p->name = $permission['name'];
			$p->save();

			$permissions[] = $p->id;
		}

		$role->syncPermissions($permissions);

		flash('Role has been saved')->success();
		return redirect( route( 'admin.roles' ) );
	}

	/*
	* delete the role
	*/
	public function destroy(Role $role)
	{
		$role->delete();

		flash('Role has been deleted')->success();
		return redirect( route( 'admin.roles' ) );
	}
}
