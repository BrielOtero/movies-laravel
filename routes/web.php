<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    }
    )->name('dashboard');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/genres', function () {
        return view('content.genres');
    }
    )->name('genres');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/movies', function () {
        return view('content.movies');
    }
    )->name('movies');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/all-movies', function () {
        return view('content.all-movies');
    })->name('all-movies');
    Route::get('/all-genres', function () {
        return view('content.all-genres');
    })->name('all-genres');
});

Route::get('/all-movies', function () {
    return view('content.all-movies');
})->name('all-movies');

Route::get('/all-genres', function () {
    return view('content.all-genres');
})->name('all-genres');
