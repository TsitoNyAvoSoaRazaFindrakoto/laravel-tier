<?php
use Illuminate\Support\Facades\Route;

/*Route::prefix('/')->name('client.')->group(function(){
    Route::get('/',[ClientController::class,'index'])->name('index');
    Route::post('/login',[ClientController::class,'login'])->name('login');
    Route::get('/logout',[ClientController::class,'logout'])->name('logout');
    Route::middleware(ClientMiddleware::class)->group(function(){
        Route::get('/accueil',[ClientController::class,'accueil'])->name('accueil');
        Route::get('/devis',[DevisController::class,'findByIdClient'])->name('devis');
    });
});

Route::prefix('/devis')->name('devis.')->group(function(){
    Route::get('/form',[DevisController::class,'formInsertion'])->name('devis.insertion');
    Route::middleware(ClientMiddleware::class)->group(function(){
        Route::get('/details/{idDevis}',[DevisController::class,'findDetails'])->name('details');
    });
    Route::get("/mail/{idDevis}",[DevisController::class,'sendEmail'])->name('mail');
});

Route::prefix('/admin')->name('admin.')->group(function(){
    Route::get('/',[AdminController::class,'index'])->name('index');
    Route::post('/login',[AdminController::class,'login'])->name('login');
    Route::get('/logout',[AdminController::class,'logout'])->name('logout');
    Route::middleware(AdminMiddleware::class)->group(function(){
        Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    });
});*/

Route::prefix('/depot')->name('depot.')->group(function () {
    Route::get('',[\App\Http\Controllers\FondController::class,'formDepot'])->name('form');
    Route::post('',[\App\Http\Controllers\FondController::class,'insertDepot'])->name('insert');
});

Route::prefix('/retrait')->name('retrait.')->group(function () {
    Route::get('',[\App\Http\Controllers\FondController::class,'formRetrait'])->name('form');
    Route::post('',[\App\Http\Controllers\FondController::class,'insertRetrait'])->name('insert');
});

Route::prefix('/achat')->name('achat.')->group(function () {
    Route::get('',[\App\Http\Controllers\CryptoController::class,'formAchat'])->name('form');
    Route::post('',[\App\Http\Controllers\CryptoController::class,'insertAchat'])->name('insert');
    Route::get('/liste',[\App\Http\Controllers\CryptoController::class,'findListeAchat'])->name('liste');
});

Route::prefix('')->name('utilisateur.')->group(function () {
    Route::get('',[\App\Http\Controllers\UtilisateurController::class,'login'])->name('login');
});
