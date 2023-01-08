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


Route::get('requests/{request}/accept_request', [\App\Http\Controllers\RepairRequestController::class, 'accept_request'])->name('requests.accept_request');
Route::get('requests/{request}/accept', [\App\Http\Controllers\RepairRequestController::class, 'accept'])->name('requests.accept');
Route::get('requests/{request}/respond', [\App\Http\Controllers\RepairRequestController::class, 'respond'])->name('requests.respond');
Route::get('requests/send_respond', [\App\Http\Controllers\RepairRequestController::class, 'send_respond'])->name('requests.send_respond');
Route::get('requests/{request}/reject', [\App\Http\Controllers\RepairRequestController::class, 'reject'])->name('requests.reject');
Route::get('requests/{request}/finish', [\App\Http\Controllers\RepairRequestController::class, 'finish'])->name('requests.finish');
Route::resource('/requests', \App\Http\Controllers\RepairRequestController::class)->middleware(['auth']);

Route::resource('/orders', \App\Http\Controllers\OrderController::class)->middleware(['auth']);
