<?php
// routes/web.php
namespace App\Http\Controllers;
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
Route::post('/parameter', [SesiController::class, 'parameter']);
Route::post('/parameter2025', [SesiController::class, 'parameter2025']);
Route::post('/inputPetani', [SesiController::class, 'input'])->name('inputPetani.store');
Route::post('/hapuspetani', [PetaniController::class, 'delete'])->name('hapus-petani');
Route::post('/editInput', [SesiController::class, 'update'])->name('editInput.update');
Route::post('/hutang', [SesiController::class, 'hutang'])->name('hutang.store');
Route::post('/pelunasan', [SesiController::class, 'pelunasan'])->name('pelunasan');

// rout menghapus data hutang
Route::delete('/deletehutang/{id}', [SesiController::class, 'destroy'])->name('hutang.delete');





// Routes for authenticated users based on roles
Route::middleware('auth')->group(function () {
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/owner', function() {
            return view('dashboard-admin');
        })->name('owner.dashboard');
        Route::get('/owner2025', function() {
            return view('dashboard-admin-2');
        })->name('owner.dashboard2');
        Route::get('/hutang-admin', function() {
            return view('hutang_admin');
        })->name('hutang-admin');
        Route::get('/datapetani', function() {
            return view('datapetani');
        })->name('datapetani');
        Route::get('/parameter', function (){
            return view ('parameter');
        })->name('parameter');
        Route::get('/parameter2025', function (){
            return view ('parameter-2025');
        })->name('parameter_2');
        Route::get('/hapuspetani', function (){
            return view ('hapus-petani');
        })->name('hapus-petani');
        Route::get('/register', function (){
            return view ('register');
        })->name('register');
        Route::get('/input', function (){
            return view ('input');
        })->name('input');
        Route::get('/inputPetani', function (){
            return view ('input_petani');
        })->name('input_petani');
        Route::get('/dataInput', function (){
            return view ('input_data');
        })->name('input_data');
        Route::get('/editInput', function (){
            return view ('edit_petani');
        })->name('edit_petani');
    });


    Route::middleware(PetaniMiddleware::class)->group(function () {
        Route::get('/petani', function() {
            return view('dashboard-Petani');
        })->name('dashboard-Petani');
    });

});




