<?php

use App\Http\Controllers\Admin\DashController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function() {

	Route::get('/', function () {
		return Inertia::render('Home');
	})->name('home');

	/* admin panel */
	Route::prefix('admin')->middleware('permission:admin')->group(function() {
		/* dash */
		Route::get('/', [DashController::class, 'index'])->name('admin.dashboard');

		/* users */
		Route::prefix('users')->middleware('can:users,viewAny')->group(function() {
			Route::get('/', [UsersController::class, 'index'])->name('admin.users');
			Route::get('/form/{user?}', [UsersController::class, 'form'])->name('admin.users.form');
			Route::match(['POST', 'PATCH'], '/{user?}', [UsersController::class, 'save'])->name('admin.users.save');
			Route::delete('/{user}', [UsersController::class, 'destroy'])->name('admin.users.delete');
		});

		/* roles */
		Route::prefix('roles')->middleware('can:roles,viewAny')->group(function() {
			Route::get('/', [RolesController::class, 'index'])->name('admin.roles');
			Route::get('/form/{role?}', [RolesController::class, 'form'])->name('admin.roles.form');
			Route::match(['POST', 'PATCH'], '/{role?}', [RolesController::class, 'save'])->name('admin.roles.save');
			Route::delete('/{role}', [RolesController::class, 'destroy'])->name('admin.roles.delete');
		});

	});
});

// Route::middleware('auth')->prefix('admin')->group(function() {
// 	Route::get('/', function () {
// 		return inertia('Admin.Dashboard');
// 	});
// });