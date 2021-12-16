<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

// new auth routes with email verification
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

// Login
Route::get('/user/home', [App\Http\Controllers\HomeController::class, 'menuUser'])->name('home-user')->middleware('user');
Route::get('/volunteer/home', [App\Http\Controllers\HomeController::class, 'menuVolunteer'])->name('home-volunteer')->middleware('volunteer');
Route::get('/pet-shelter/home', [App\Http\Controllers\HomeController::class, 'menuPetShelter'])->name('home-pet-shelter')->middleware('petShelter');

// Pet Controller
Route::resource('pets', PetController::class);
//Route::get('/pets/{id}/edit', [App\Http\Controllers\PetController::class, 'edit'])->name('pet-edit');

