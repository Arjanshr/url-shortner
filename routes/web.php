<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortUrlsController;
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
require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/short-url',[ShortUrlsController::class, 'index'])->name('shortUrl.index');
    Route::delete('/short-url/{short_url}', [ShortUrlsController::class, 'destroy'])->name('shortUrl.destroy');
});

Route::post('makeShortUrl',[ShortUrlsController::class, 'create'])->name('shortUrl.create');
Route::get('{code}',[ShortUrlsController::class, 'reroute'])->name('shortUrl.reroute');