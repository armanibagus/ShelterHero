<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
    Artisan::call('storage:link');
    return view('welcome');
});

// new auth routes with email verification
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

// Login
Route::get('/user/home', [App\Http\Controllers\HomeController::class, 'menuUser'])->name('home-user')->middleware('user');
Route::get('/volunteer/home', [App\Http\Controllers\HomeController::class, 'menuVolunteer'])->name('home-volunteer')->middleware('volunteer');
Route::get('/pet-shelter/home', [App\Http\Controllers\HomeController::class, 'menuPetShelter'])->name('home-pet-shelter')->middleware('petShelter');

// Pet Controller
Route::get('/pets/lost-pets', [\App\Http\Controllers\PetController::class, 'lostPets'])->name('pets.lostPets')->middleware('user');;
Route::get('/pets/pet-registration', [\App\Http\Controllers\PetController::class, 'viewPetRegis'])->name('pets.viewPetRegis')->middleware('petShelter');
Route::get('/pets/my-pets', [\App\Http\Controllers\PetController::class, 'myPets'])->name('pets.myPets')->middleware('petShelter');

Route::resource('pets', \App\Http\Controllers\PetController::class);

// Adoption Controller
Route::resource('adoptions', \App\Http\Controllers\AdoptionController::class);

// Lost Pet Claim Controller
Route::resource('lost-pet-claims', \App\Http\Controllers\LostPetClaimsController::class);

// Donation Controller
Route::resource('donations', \App\Http\Controllers\DonationController::class);

// Donate Controller
Route::resource('donates', \App\Http\Controllers\DonateController::class);

// User Controller
Route::resource('users', \App\Http\Controllers\UserController::class);

// HealthCheck Controller
Route::resource('health-checks', \App\Http\Controllers\HealthCheckController::class);
