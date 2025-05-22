<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return redirect()->route('index');
})->name('/');

Auth::routes();
Route::group(['middleware'=>"auth"],function (){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('dashboard')->group(function () {
        Route::view('index', 'dashboard.index')->name('index');
        Route::view('dashboard-02', 'dashboard.dashboard-02')->name('dashboard-02');
        Route::view('dashboard-03', 'dashboard.dashboard-03')->name('dashboard-03');
        Route::view('dashboard-04', 'dashboard.dashboard-04')->name('dashboard-04');
        Route::view('dashboard-05', 'dashboard.dashboard-05')->name('dashboard-05');
    });

    Route::resource('users', App\Http\Controllers\Blade\UserController::class);
    Route::resource('roles', App\Http\Controllers\Blade\RoleController::class);
    Route::get('permissions', [App\Http\Controllers\Blade\PermissionController::class,'index'])->name('permissions.index');

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
