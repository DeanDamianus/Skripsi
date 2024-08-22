<?php
// routes/web.php
namespace App\Http\Controllers;
use App\Http\Controllers\RekapController;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PetaniMiddleware;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

// Routes for login, logout, and error handling
Route::get('/', [SesiController::class, 'index']);
Route::post('/', [SesiController::class, 'login']);
Route::get('/logout', [SesiController::class, 'logout']);
Route::get('/error', function() {
    return view('error');
})->name('error');

// Register routes
Route::get('/register', [SesiController::class, 'register'])->name('register.form');
Route::post('/register', [SesiController::class, 'create'])->name('register.store');

// Routes for authenticated users based on roles
Route::middleware('auth')->group(function () {
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/owner', function() {
            return view('dashboard-admin');
        })->name('owner.dashboard');
        Route::get('/hutang-admin', function() {
            return view('hutang_admin');
        })->name('hutang-admin');
        Route::get('/datapetani', function() {
            return view('datapetani');
        })->name('datapetani');
        Route::get('/parameter', function (){
            return view ('parameter');
        })->name('parameter');
        Route::get('/hapuspetani', function (){
            return view ('hapus-petani');
        })->name('hapus-petani');
    });
    Route::post('/hapuspetani', [PetaniController::class, 'delete'])->name('hapus-petani');

    Route::middleware(PetaniMiddleware::class)->group(function () {
        Route::get('/petani', function() {
            return view('dashboard-petani');
        })->name('petani.dashboard');
    });

    Route::get('/rekap', [RekapController::class, 'index']);

});




