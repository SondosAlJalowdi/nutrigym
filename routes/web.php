<?php

use App\Http\Controllers\UserPagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\CategoryViewController;
use App\Http\Controllers\GymsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserPagesController::class, 'showLandingPage'])->name('user.home');

Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

Route::get('auth/redirect/{provider}', [SocialAuthController::class, 'redirect'])->name('auth.redirect');
Route::get('auth/callback/{provider}', [SocialAuthController::class, 'callback'])->name('auth.callback');

Route::get('/categories/{name}', [CategoryViewController::class, 'showByCategory'])->name('categories');


Route::get('/gyms', [GymsController::class, 'index'])->name('gyms.index');
Route::get('/gyms/{id}', [GymsController::class, 'show'])->name('gyms.show');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/profile/complete', [UserPagesController::class, 'showCompleteProfileForm'])->name('user.completeProfile');
    Route::post('/profile/complete', [UserPagesController::class, 'completeProfile'])->name('profile.complete.post');
    Route::get('/profile', [UserPagesController::class, 'showProfile'])->name('user.profile');
    Route::post('/subscriptions', [GymsController::class, 'addSubscription'])->name('subscriptions.store');
    Route::get('/subscriptions', [GymsController::class, 'mySubscriptions'])->name('subscriptions.show');
    Route::post('/appointments', [CategoryViewController::class, 'addAppointment'])->name('appointments.store');
    Route::get('/my-appointments', [CategoryViewController::class, 'myAppointments'])->name('appointments.show');



});


Route::middleware(['auth', 'role:admin'])->group(function () {

});

Route::middleware(['auth', 'role:service_provider'])->group(function () {

});
