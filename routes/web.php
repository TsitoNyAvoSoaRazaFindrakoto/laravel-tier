<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ClientMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(ClientMiddleware::class)->group(function () {
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
        Route::get('/insertion_achat',[\App\Http\Controllers\CryptoController::class,'insertAchat'])->name('insert');
        Route::post('/validated',[\App\Http\Controllers\CryptoController::class,'insertAchatValidated'])->name('insert');
        Route::get('/liste_achat',[\App\Http\Controllers\CryptoController::class,'findListeAchat'])->name('liste');
    });
    Route::prefix('/vente')->name('vente.')->group(function () {
        Route::get('',[\App\Http\Controllers\CryptoController::class,'formVente'])->name('form');
        Route::post('/insertion_vente',[\App\Http\Controllers\CryptoController::class,'insertVente'])->name('insert');
        Route::get('/liste_vente',[\App\Http\Controllers\CryptoController::class,'findListVente'])->name('liste');
    });
    Route::prefix('/portefeuille')->name('portefeuille.')->group(function () {
        Route::get('/liste_portefeuille',[\App\Http\Controllers\CryptoController::class,'fintPorfeuilleUtilisateur'])->name('liste');
    });
});

Route::middleware(AdminMiddleware::class)->group(function () {
    Route::get("/transaction/request",[\App\Http\Controllers\FondController::class,'findTransactionRequest'])->name('transaction.request');
    Route::get('/transaction/historique',[\App\Http\Controllers\UtilisateurController::class,'findTransactionHistorique'])->name('liste.transaction.historique');
    Route::get('/transaction/details/{idUtilisateur}-utilisateur',[\App\Http\Controllers\UtilisateurController::class,'findTransactionsUser'])->name('liste.transaction.historique');
    Route::post('/transaction/accept/{idTransaction}',[\App\Http\Controllers\FondController::class,'acceptTransaction'])->name('insert');
    Route::post('/transaction/decline/{idTransaction}',[\App\Http\Controllers\FondController::class,'declineTransaction'])->name('decline');
});

Route::prefix('')->name('utilisateur.')->group(function () {
    Route::get('',[\App\Http\Controllers\UtilisateurController::class,'index'])->name('index');
    Route::get('/connection',[\App\Http\Controllers\UtilisateurController::class,'login'])->name('login');
    Route::get('/inscription',[\App\Http\Controllers\UtilisateurController::class,'inscription'])->name('inscription');
    Route::get('/pin',[\App\Http\Controllers\UtilisateurController::class,'loginPin'])->name('pin');
    Route::get('/session',[\App\Http\Controllers\UtilisateurController::class,'setSession'])->name('session');
    Route::get('/logout',[\App\Http\Controllers\UtilisateurController::class,'logOut'])->name('logout');
    Route::get('/login',[\App\Http\Controllers\UtilisateurController::class,'loginFafana'])->name('session');
});

Route::prefix('api')->name('api.')->group(function () {
    Route::middleware(ClientMiddleware::class)->group(function () {
        Route::get('/cours/crypto',[\App\Http\Controllers\DashboardController::class,'cours'])->name('cours');
    });
});

Route::get('/test',[\App\Http\Controllers\FondController::class,'test'])->name('test');

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::middleware(ClientMiddleware::class)->group(function () {
        Route::get('',[\App\Http\Controllers\DashboardController::class,'index'])->name('index');
        Route::get('/cours/crypto',[\App\Http\Controllers\DashboardController::class,'coursView'])->name('cours');
        Route::get('/crypto/{idCrypto}',[\App\Http\Controllers\DashboardController::class,'cryptoPrix'])->name('crypto');
    });
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/parametre',[\App\Http\Controllers\DashboardController::class,'parametre'])->name('parametre');
        Route::post('/parametre',[\App\Http\Controllers\DashboardController::class,'parametreUpdate'])->name('parametre.update');
        Route::get('/analyse/crypto',[\App\Http\Controllers\DashboardController::class,'analyseCrypto'])->name('analyse.crypto');
        Route::post('/analyse/crypto',[\App\Http\Controllers\DashboardController::class,'analyseCryptoListe'])->name('analyse.crypto');
        Route::get('/analyse/commission',[\App\Http\Controllers\DashboardController::class,'analyseCommission'])->name('analyse.comission');
        Route::post('/analyse/commission',[\App\Http\Controllers\DashboardController::class,'analyseCommissionListe'])->name('analyse.comission.liste');
        Route::get('/porte-feuille',[\App\Http\Controllers\CryptoController::class,'statistique'])->name('portefeuille');
        Route::get('/transaction',[\App\Http\Controllers\CryptoController::class,'findAllTransaction'])->name('vente');
    });
});
