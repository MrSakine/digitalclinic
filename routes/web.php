<?php

use App\Http\Controllers\MedecinController;
use App\Http\Controllers\PatientController;
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

Route::get('/', function () { return view('digitalclinic'); })->name('index');
Route::get('/faq', function () { return view('digitalclinic'); });
Route::get('/login', function() { return view('digitalclinic'); })->name('login');
Route::get('/inscription', function() { return view('digitalclinic'); });
Route::get('/accueil/patient', [PatientController::class, 'index'])->name('patient.index');
Route::get('/accueil/patient/mon-compte', [PatientController::class, 'index']);
Route::get('/accueil/patient/payments', [PatientController::class, 'index']);
Route::get('/accueil/patient/consultation', [PatientController::class, 'index']);
Route::get('/accueil/patient/rendezvous', [PatientController::class, 'index']);
Route::get('/accueil/patient/messages', [PatientController::class, 'index']);
Route::get('/accueil/patient/start-conversation/{id}', [PatientController::class, 'index'])->whereNumber('id');
Route::get('/accueil/patient/resultats', [PatientController::class, 'index']);
Route::get('/accueil/patient/solde', [PatientController::class, 'index']);
Route::get('/accueil/medecin', [MedecinController::class, 'index'])->name('medecin.index');
Route::get('/accueil/medecin/agenda', [MedecinController::class, 'index']);
Route::get('/accueil/medecin/mon-compte', [MedecinController::class, 'index']);
Route::get('/accueil/medecin/listes', [MedecinController::class, 'index']);
Route::get('/accueil/medecin/rdv', [MedecinController::class, 'index']);
Route::get('/accueil/medecin/specialites', [MedecinController::class, 'index']);
Route::get('/accueil/medecin/listes/traites', [MedecinController::class, 'index']);
Route::get('/accueil/medecin/traiter/{id}', [MedecinController::class, 'index'])->whereNumber('id');
Route::get('/accueil/medecin/messages', [MedecinController::class, 'index']);
Route::get('/accueil/medecin/start-conversation/{id}', [MedecinController::class, 'index'])->whereNumber('id');
