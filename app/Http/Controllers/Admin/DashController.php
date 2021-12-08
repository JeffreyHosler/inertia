<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashController extends Controller
{
    /*
	* return the dashboard
	*/
	public function index()
	{
		return inertia('Admin/Dashboard');
	}
}
