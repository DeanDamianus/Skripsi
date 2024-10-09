<?php
// routes/web.php
namespace App\Http\Controllers;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PetaniMiddleware;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

// Routes for login, logout, and error handling
Route::get('/', [SesiController::class, 'index']);
Route::post('/', [SesiController::class, 'login']);
Route::get('/logout', [SesiController::class, 'logout']);
Route::get('/error', function() {
    return view('error');
})->name('error');


// Register routes

Route::post('/parameter', [SesiController::class, 'updateParameter'])->name('updateParameter');
 //input post rekap
Route::post('/inputdistribusi', [SesiController::class, 'inputdistribusi'])->name('inputdistribusi.store');  //input post distribusi
// Route::post('/hapuspetani', [PetaniController::class, 'delete'])->name('hapus-petani');
Route::post('/editInput', [SesiController::class, 'update'])->name('editInput.update');

Route::post('/pelunasan', [SesiController::class, 'pelunasan'])->name('pelunasan');


// rout menghapus data hutang
Route::delete('/deletehutang/{id}', [SesiController::class, 'destroy'])->name('hutang.delete');
Route::delete('/inputPetani/{id}', [SesiController::class, 'destroyrekap'])->name('inputPetani.destroy');



Route::middleware('auth')->group(function () {
    Route::middleware(AdminMiddleware::class)->group(function () {

        Route::get('/owner', [SesiController::class, 'dashboard']);//dashboard utama

        Route::get('/hutang-admin', [SesiController::class, 'hutangdashboard']); //halman hutang 

        Route::get('/datapetani', [SesiController::class, 'datapetani']); //route datta petani

        Route::get('/dashboardindividual', [SesiController::class, 'dashboardindividual']); //dashbaord pemilihan petani

        Route::get('/dashboardpetani', [SesiController::class, 'dashboardpetani']); // dashboard seteleah petani di klik
        
        Route::get('/datapetani/search', [SesiController::class, 'search']);//halaman list data petani
        
        Route::get('/parameter', [SesiController::class, 'parameter'])->name('parameter'); //halaman menambah parameter
        
        Route::get('/historyhutang/{id_hutang}', [SesiController::class, 'history_hutang'])->name('historyhutang');
        Route::post('/hutang', [SesiController::class, 'hutang'])->name('hutang.store');

        Route::get('/register', [SesiController::class, 'register']);//halaman penambah user
        Route::post('/register', [SesiController::class, 'create'])->name('register.store');

        Route::get('/input', [SesiController::class, 'input']);//halam utama dari innput rekap
   
        Route::get('/dataInput', [SesiController::class, 'rekap']);//halaman kedua data input ini untuk melihat data rekap dari tiap petani

        Route::get('/inputform', [SesiController::class, 'inputform']);
        Route::post('/inputPetani', [SesiController::class, 'inputpetani'])->name('inputPetani.store');//halaman input form untuk rekap

        Route::get('/distribusi', [SesiController::class, 'distribusidashboard']);//dashboard distribusi

        Route::get('/formdistribusi', [SesiController::class, 'formdistribusi']);
        
        Route::get('/distribusitolak', [SesiController::class, 'distribusitolak']);
        Route::post('/distribusiulang', [SesiController::class, 'distribusiulang'])->name('distribusiulang');//formdistribusi
        
        Route::get('/uploadfoto', [SesiController::class, 'uploadfoto']);//halaman upload foto
        Route::post('/postfoto', [SesiController::class, 'postfoto'])->name('post.foto');

       
    });

    Route::get('/error', [SesiController::class, 'error']);


    Route::middleware(PetaniMiddleware::class)->group(function () {
        Route::get('/petani', function() {
            return view('dashboard-Petani');
        })->name('dashboard-Petani');
    });

});




