<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

//Common Resource Routes/Naming
//index - Show all data -> listings || Route::get();
//show - Show single data -> listing || Route::get();
//create - Show form to create new -> listing  || Route::get();
//store - Store data -> new listing || Route::post()
//edit - show form to edit data 
//update - Update data -> listing || Route::put(); Route::patch();
//destroy - Delete a data -> listing     Route::delete();

//All listings
Route::get('/', [ListingController::class, 'index']);

Route::middleware('auth')->group(function () {
  Route::get('/listings/create', [ListingController::class, 'create']);
  Route::post('/listings', [ListingController::class, 'store']);
  Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']);
  Route::put('/listings/{listing}', [ListingController::class, 'update']);
  Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);
  // Manage Listings route (only for HR)
  Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('check.role:HR');
   // Manage Users route (only for Admins)
  //  Route::get('/manage/users', [UserManagementController::class, 'index'])
  //  ->middleware('check.role:admin')
  //  ->name('manage.users');
  Route::get('/manage/users', 'App\Http\Controllers\UserManagementController@index')
     ->middleware('check.role:admin')
     ->name('manage.users');
  // Update user role (only for Admins)  
  Route::patch('/users/{user}/role', 'App\Http\Controllers\UserManagementController@updateRole')
  ->middleware('check.role:admin')
  ->name('users.update.role');
  //Route for the modal
  Route::post('/manage/users/create', 'App\Http\Controllers\UserManagementController@createUser')
     ->middleware('check.role:admin')
     ->name('manage.users.create');
  Route::post('/logout', [UserController::class, 'logout']);
});

Route::get('/listings/{listing}', [ListingController::class, 'show']);

Route::middleware('guest')->group(function(){
  Route::get('/register', [UserController::class, 'create']);
  Route::post('/users', [UserController::class, 'store']);
  Route::get('/login', [UserController::class, 'login'])->name('login');
  Route::post('/users/authenticate', [UserController::class, 'authenticate']);

});

