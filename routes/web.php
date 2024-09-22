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
Route::post('/parameter', [SesiController::class, 'updateParameter'])->name('updateParameter');
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

        Route::get('/owner', [SesiController::class, 'dashboard']);

        Route::get('/hutang-admin', function() {
            return view('hutang_admin');
        })->name('hutang-admin');

        Route::get('/hutang-admin', [SesiController::class, 'hutangdashboard']);

        Route::get('/datapetani', function() {
            return view('datapetani');
        })->name('datapetani');


        Route::get('/parameter', [SesiController::class, 'parameter'])->name('parameter');

        Route::get('/hapuspetani', function (){
            return view ('hapus-petani');
        })->name('hapus-petani');

        Route::get('/register', function (){
            return view ('register');
        })->name('register');

        Route::get('/input', [SesiController::class, 'input']);


        Route::get('/inputPetani', function (){
            return view ('input_petani');
        })->name('input_petani'); // input petani merupakan halaman form input untuk rekap

        
        Route::get('/dataInput', [SesiController::class, 'rekap']);//data input ini untuk melihat data rekap dari tiap petani

        
        Route::get('/dataInput2025', function (){
            return view ('input_data2025');
        })->name('input_data2025');

        Route::get('/distribusi', function (){
            return view ('distribusi');
        })->name('distribusi');

        Route::get('/editInput', function (){
            return view ('edit_petani');
        })->name('edit_petani');

        Route::get('/inputdistribusi', function (){
            return view ('input_distribusi');
        })->name('inputdistribusi');

       
    });


    Route::middleware(PetaniMiddleware::class)->group(function () {
        Route::get('/petani', function() {
            return view('dashboard-Petani');
        })->name('dashboard-Petani');
    });

});




