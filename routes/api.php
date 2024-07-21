<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\App\HomeController;
use App\Http\Controllers\App\LoginController;
use App\Http\Controllers\App\LogoutController;
use App\Http\Controllers\App\SpeController;
use Illuminate\Http\Request;
use App\Http\Controllers\Login;
use App\Http\Controllers\Message;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Inscription;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableauController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\TraitementController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\Logout;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/patient/logout', [Logout::class, 'logout'])->middleware('auth.patient');
Route::post('/medecin/logout', [Logout::class, 'logout'])->middleware('auth.medecin');
Route::post('/checklogin', [Login::class, 'check_login']);
Route::post('/saveUser', [Inscription::class, 'saveUser']);
Route::get('/getTableauPrincipal', [TableauController::class, 'getTableauPrincipal']);
Route::post('/saveConsultation', [ConsultationController::class, 'saveConsultation'])->middleware('auth.patient');
Route::post('/saveRendezVous', [RendezVousController::class, 'saveRendezVous'])->middleware('auth.patient');
Route::post('/editPassword', [Login::class, 'editPassword'])->middleware('roles:patient,medecin');
Route::post('/editCred', [InfoController::class, 'editCred'])->middleware('roles:patient,medecin');
Route::post('/payments', [PaymentsController::class, 'getPayments'])->middleware('auth.patient');
Route::post('/consultations', [ConsultationController::class, 'getConsultations'])->middleware('auth.patient');
Route::post('/deleteConsultation', [ConsultationController::class, 'deleteConsultation'])->middleware('auth.patient');
Route::post('/rendezvous', [RendezVousController::class, 'getRendezVous'])->middleware('auth.patient');
Route::post('/deleteRendezVous', [RendezVousController::class, 'deleteRendezVous'])->middleware('auth.patient');
Route::get('/getUser', [Controller::class, 'getUser'])->middleware('roles:patient,medecin');
Route::get('/getConsultations', [ConsultationController::class, 'getConsultation'])->middleware('auth.medecin');
Route::post('/getPatientTb', [TableauController::class, 'getPatientTb'])->middleware('auth.patient');
Route::post('/getFullConsultations', [ConsultationController::class, 'getFullConsultations'])->middleware('auth.medecin');
Route::post('/saveTraitement', [TraitementController::class, 'saveTraitement'])->middleware('auth.medecin');
Route::post('/getMedecinTraiterConsultationsFull', [ConsultationController::class, 'getMedecinTraiterConsultationsFull'])->middleware('auth.medecin');
Route::post('/getPatientTraiterConsultationsFull', [ConsultationController::class, 'getPatientTraiterConsultationsFull'])->middleware('auth.patient');
Route::post('/saveMessage', [Message::class, 'addMessage'])->middleware('roles:patient,medecin');
Route::post('/fetchMessages', [Message::class, 'fetchMessages'])->middleware('roles:patient,medecin');
Route::post('/getMessages', [Message::class, 'getMessages'])->middleware('roles:patient,medecin');
Route::post('/getPatientInfo', [InfoController::class, 'getPatientInfo'])->middleware('auth.medecin');
Route::post('/getMedecinInfo', [InfoController::class, 'getMedecinInfo'])->middleware('auth.patient');
Route::post('/cibe', [Message::class, 'checkIfBoiteExists'])->middleware('roles:patient,medecin');
Route::post('/dBD', [Message::class, 'deleteBoiteDialogue'])->middleware('auth.medecin');
Route::get('/getmedagenda', [AgendaController::class, 'getAgendas']);
Route::post('/saveagenda', [AgendaController::class, 'saveAgenda']);
Route::put('/editagenda/jour/{jour}', [AgendaController::class, 'editAgenda'])->whereAlpha('jour');
Route::delete('/deleteagenda/jour/{jour}', [AgendaController::class, 'deleteAgenda'])->whereAlpha('jour');
Route::get('/getspe', [MedecinController::class, 'getSpe']);
Route::get('/getType', [PatientController::class, 'getTypeConsultationList']);
Route::get('/getStats', [PatientController::class, 'getStats']);
Route::get('/getMedStats', [MedecinController::class, 'getMedStats']);
Route::get('/getMedMeeting', [MedecinController::class, 'getRendezVous']);
Route::post('/getAllMeeting', [PatientController::class, 'getMeetingHours']);

// api mobile

Route::post('/mobile/login', [LoginController::class, 'login']);
Route::post('/mobile/logout', [LogoutController::class, 'logout']);
Route::get('/mobile/home', [HomeController::class, 'home']);
Route::post('/mobile/home/add', [HomeController::class, 'addMedecin']);
Route::put('/mobile/home/edit/{id}', [HomeController::class, 'editMedecin'])->whereNumber('id');
Route::delete('/mobile/home/delete/{id}', [HomeController::class, 'deleteMedecin'])->whereNumber('id');
Route::get('/mobile/home/patients', [HomeController::class, 'getPatients']);
Route::delete('/mobile/home/patient/delete/{id}', [HomeController::class, 'deletePatient'])->whereNumber('id');
Route::get('/mobile/home/spes/setup', [SpeController::class, 'setup']);
Route::get('/mobile/home/spes', [SpeController::class, 'getSpes']);
Route::post('/mobile/home/spe/add', [SpeController::class, 'saveSpe']);
Route::put('/mobile/home/spe/edit/{id}', [SpeController::class, 'editSpe']);
Route::delete('/mobile/home/spe/delete/{id}', [SpeController::class, 'deleteSpe'])->whereNumber('id');
Route::put('/mobile/home/spe/editMed/spe/{id}', [SpeController::class, 'editMedSpe'])->whereNumber('id');
