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
Route::post('/register', [SesiController::class, 'create'])->name('register.store');
Route::post('/parameter', [SesiController::class, 'updateParameter'])->name('updateParameter');
Route::post('/inputPetani', [SesiController::class, 'inputpetani'])->name('inputPetani.store'); //input post rekap
Route::post('/inputdistribusi', [SesiController::class, 'inputdistribusi'])->name('inputdistribusi.store');  //input post distribusi
Route::post('/hapuspetani', [PetaniController::class, 'delete'])->name('hapus-petani');
Route::post('/editInput', [SesiController::class, 'update'])->name('editInput.update');
Route::post('/hutang', [SesiController::class, 'hutang'])->name('hutang.store');
Route::post('/pelunasan', [SesiController::class, 'pelunasan'])->name('pelunasan');
Route::post('/postfoto', [SesiController::class, 'postfoto'])->name('post.foto');

// rout menghapus data hutang
Route::delete('/deletehutang/{id}', [SesiController::class, 'destroy'])->name('hutang.delete');
Route::delete('/inputPetani/{id}', [SesiController::class, 'destroyrekap'])->name('inputPetani.destroy');



Route::middleware('auth')->group(function () {
    Route::middleware(AdminMiddleware::class)->group(function () {

        Route::get('/owner', [SesiController::class, 'dashboard']);//dashboard utama

        Route::get('/hutang-admin', [SesiController::class, 'hutangdashboard']); //halman hutang 

        Route::get('/datapetani', [SesiController::class, 'datapetani']);
        
        Route::get('/datapetani/search', [SesiController::class, 'search']);//halaman list data petani
        
        Route::get('/parameter', [SesiController::class, 'parameter'])->name('parameter'); //halaman menambah parameter

        Route::get('/hapuspetani', function (){
            return view ('hapus-petani');
        })->name('hapus-petani');

        Route::get('/register', function (){
            return view ('register');
        })->name('register');

        Route::get('/register', [SesiController::class, 'register']);//halaman penambah user

        Route::get('/input', [SesiController::class, 'input']);//halam utama dari innput rekap
   
        Route::get('/dataInput', [SesiController::class, 'rekap']);//halaman kedua data input ini untuk melihat data rekap dari tiap petani

        Route::get('/inputform', [SesiController::class, 'inputform']);//halaman input form untuk rekap

        Route::get('/distribusi', [SesiController::class, 'distribusidashboard']);//dashboard distribusi

        Route::get('/formdistribusi', [SesiController::class, 'formdistribusi']);//formdistribusi
        
        Route::get('/uploadfoto', [SesiController::class, 'uploadfoto']);//halaman upload foto

        Route::get('/editInput', function (){
            return view ('edit_petani');
        })->name('edit_petani');

        Route::get('/inputdistribusi', function (){
            return view ('input_distribusi');
        })->name('inputdistribusi');

       
    });

    Route::get('/error', [SesiController::class, 'error']);


    Route::middleware(PetaniMiddleware::class)->group(function () {
        Route::get('/petani', function() {
            return view('dashboard-Petani');
        })->name('dashboard-Petani');
    });

});




