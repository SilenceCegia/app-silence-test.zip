<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActionController;
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
    return view('/auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/mentions-legales', function () {
    return view('mentions-legales');
});

Route::get('/politiques-confidentialites', function () {
    return view('politiques-confidentialites');
});

Route::post("/save-action-teacher", [App\Http\Controllers\ActionController::class, 'saveActionTeacher']);
Route::post("/save-action", [App\Http\Controllers\ActionController::class, 'saveAction']);

Route::post("/save-actionDecoupage", [App\Http\Controllers\ActionController::class, 'saveActionDecoupage']);
Route::post("/AddDecoupage", [App\Http\Controllers\ActionController::class, 'AddDecoupage']);
Route::post("/DeleteDec", [App\Http\Controllers\ActionController::class, 'DeleteDec']);

Route::post("/DeletePersonnage", [App\Http\Controllers\ActionController::class, 'DeletePersonnage']);
Route::post("/DeleteDescription", [App\Http\Controllers\ActionController::class, 'DeleteDescription']);

Route::post("/AddDescription", [App\Http\Controllers\ActionController::class, 'AddDescription']);
Route::post("/AddPersonnage", [App\Http\Controllers\ActionController::class, 'AddPersonnage']);

Route::post("/UpdtadePAT", [App\Http\Controllers\ActionController::class, 'UpdtadePAT']);
Route::post("/UpdtadeOrdre", [App\Http\Controllers\ActionController::class, 'UpdtadeOrdre']);

Route::get('/GetSubCatAgainstMainCatEdit/{action_id}/{id}', [\App\Http\Controllers\ActionController::class, 'GetSubCatAgainstMainCatEdit']);


// Projet Action Routes
Route::prefix('student')->middleware(['auth'])->name("student.")->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('action-dls', [App\Http\Controllers\ActionController::class, 'downloadScenarioPdf']);
    Route::get('action', [App\Http\Controllers\ActionController::class, 'index']);
    Route::get('action-dashboard', [App\Http\Controllers\ActionController::class, 'dashboard']);
    Route::post('action-join-project', [App\Http\Controllers\ProjetActionController::class, 'joinProject'])->name("action-join-project");
    Route::post('/DeleteProjet/{id}', [App\Http\Controllers\ProjetActionController::class, 'delete']);

        // Créer
        Route::post("/creer", [App\Http\Controllers\ProjetActionController::class, 'creer']);
        Route::post("/student-create", [App\Http\Controllers\ProjetActionController::class, 'studentCreateProject']);

    Route::get('{page}', function () {
        return view('student.pages.en-construction');
    })->where('name', ('informations|actions|support|videos'));

    Route::get('{page}', function ($page) {
        return view('student.pages.' . $page);
    });

});

Route::prefix('pdf')->middleware(['auth'])->name("pdf.")->group(function () {
    Route::get('{page}', function ($page) {
        return view('pdf.' . $page);
    });
});

Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('silence', [App\Http\Controllers\ReportController::class, 'silencePdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('La thématique', [App\Http\Controllers\ReportController::class, 'thématiquePdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Le pitch', [App\Http\Controllers\ReportController::class, 'pitchPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Le schéma narratif', [App\Http\Controllers\ReportController::class, 'shémaPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Le synopsis', [App\Http\Controllers\ReportController::class, 'synopsisPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Le traitement', [App\Http\Controllers\ReportController::class, 'traitementPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Scénario', [App\Http\Controllers\ReportController::class, 'scénarioPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Découpage technique', [App\Http\Controllers\ReportController::class, 'découpagePdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Lieux de tournage', [App\Http\Controllers\ReportController::class, 'lieux_tPdf']);
});

Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Liste des acteurs/actrices', [App\Http\Controllers\ReportController::class, 'liste_acteurPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Dépouillement personnage', [App\Http\Controllers\ReportController::class, 'dépouillementPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Planning de tournage', [App\Http\Controllers\ReportController::class, 'planningPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Feuille de script', [App\Http\Controllers\ReportController::class, 'feuille_scriptPdf']);
});

require __DIR__.'/auth.php';



