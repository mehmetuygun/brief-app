<?php

use App\Actions\Library\BorrowBook;
use App\Actions\Library\RegisterAssociate;
use App\Http\Controllers\BookController;
use Illuminate\Foundation\Application;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('associates', RegisterAssociate::class)->name(
        'associates.store'
    );

    Route::post('borrow/book', BorrowBook::class)->name('books.borrow');

    Route::get('books', [BookController::class, 'index'])->name('books.index');

    Route::get('books/{book}', [BookController::class, 'show'])->name(
        'books.show'
    );
});
