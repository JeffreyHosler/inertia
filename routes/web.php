<?php

use App\Http\Controllers\Admin\DashController;
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
Route::post('/logout', [AuthController::class, 'logout']);

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
		});

	});
});

// Route::middleware('auth')->prefix('admin')->group(function() {
// 	Route::get('/', function () {
// 		return inertia('Admin.Dashboard');
// 	});
// });