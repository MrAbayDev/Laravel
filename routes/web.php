<?php

use App\Http\Controllers\UserController;
use App\Actions\GetAds;
use App\Http\Controllers\AdController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('/', [AdController::class, "index"])->name("home");

Route::middleware('auth')->group(function () {
    Route::resource('ads', AdController::class);
    Route::get('/search',[AdController::class ,'find']);
    Route::get('branches',[BranchController::class,'index' ]);
    Route::get('/contact',[AdController::class,'contact']);
    Route::get('/branch/{id}',[BranchController::class,'branch' ]);
    Route::post("/ads/{id}/bookmark",[UserController::class ,  "toggleBookmark"]);
    Route::get('/my/profile',[UserController::class, 'profile']);
    Route::get('/ads/{id}' ,[AdController::class,'show']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
