<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome');
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

Route::resource('comments', \App\Http\Controllers\CommentController::class);
Route::resource('/books', \App\Http\Controllers\BookController::class)->middleware(['auth']);
/*
Route::get('requests/accept', '\App\Http\Controllers\RepairRequestController@accept');
Route::get('requests/respond', '\App\Http\Controllers\RepairRequestController@respond');
Route::get('requests/reject', '\App\Http\Controllers\RepairRequestController@reject');
*/
Route::get('requests/accept', [\App\Http\Controllers\RepairRequestController::class, 'accept'])->name('requests.accept');
Route::get('requests/respond', [\App\Http\Controllers\RepairRequestController::class, 'respond'])->name('requests.respond');
Route::get('requests/reject', [\App\Http\Controllers\RepairRequestController::class, 'reject'])->name('requests.reject');
Route::resource('/requests', \App\Http\Controllers\RepairRequestController::class)->middleware(['auth']);

Route::get('orders/accept', [\App\Http\Controllers\RepairRequestController::class, 'accept'])->name('orders.accept');
Route::resource('/orders', \App\Http\Controllers\RepairRequestController::class)->middleware(['auth']);
