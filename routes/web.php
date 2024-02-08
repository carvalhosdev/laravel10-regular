<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VerificationController;

//homepage
Route::get("/", [WebController::class, 'index']);

//admin
Route::get("/dashboard", [AdminController::class, 'index'])->middleware('auth', 'verified');


//users
Route::get("/register", [UserController::class, 'create'])->middleware('guest');
Route::post("/users", [UserController::class, 'store']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
Route::get('/forgot', [UserController::class, 'forgot'])->middleware('guest')->name('password.request');
Route::post("/forgot", [UserController::class, 'recover'])->middleware('guest')->name('password.email');
Route::post("/reset-password", [UserController::class, 'updatePasword'])->middleware('guest')->name('password.update');
Route::get("/reset-password/{token}", [UserController::class, 'reset'])->middleware('guest')->name('password.reset');


Route::controller(VerificationController::class)->group(function(){
    Route::get('/email/verify', 'notice')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'verify')->name('verification.verify');
    Route::post('/email/resend', 'resend')->name('verification.resend');
});