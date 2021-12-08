<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
			->paginate(25)
			->withQueryString();

		return inertia('Admin/Users/Index', [
			'users' => $users,
			'search' => request()->search
		]);
	}
}
