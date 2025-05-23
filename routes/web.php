<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Blade\ProfileController;

Route::get('/', function () {
    return redirect()->route('home');
})->name('/');

Auth::routes();
Route::group(['middleware'=>"auth"],function (){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('users', App\Http\Controllers\Blade\UserController::class);
    Route::resource('roles', App\Http\Controllers\Blade\RoleController::class);
    Route::get('permissions', [App\Http\Controllers\Blade\PermissionController::class,'index'])->name('permissions.index');

    Route::get('profile', [ProfileController::class,'index'])->name('profile');
    Route::put('profile/{user}', [ProfileController::class,'update'])->name('profile.update');
});

//Language Change
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'de', 'es', 'fr', 'pt', 'cn', 'ae'])) {
        abort(400);
    }
    Session()->put('locale', $locale);
    Session::get('locale');
    return redirect()->back();
})->name('lang');
