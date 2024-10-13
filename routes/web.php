<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JointController;
use App\Http\Controllers\AppointmentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
#routes patients **************************

Route::get('/dashboard', [PatientController::class, 'dash'])->name('dashboard');
Route::get('patients', [PatientController::class, 'index'])->name('patients');
Route::get('patients/create', [PatientController::class, 'create']);
Route::post('patients', [PatientController::class, 'store']);
Route::get('patients/{id}/edit', [PatientController::class, 'edit']);
Route::get('patients/{id}/details', [PatientController::class, 'details']);

Route::put('patients/{id}', [PatientController::class, 'update']);

Route::delete('patients/{id}', [PatientController::class, 'destroy']);

Route::post('/storeStatus', [PatientController::class, 'storeStatus']);
Route::post('/delet', [PatientController::class, 'destroyS']);
#************
Route::get('/dash', [PatientController::class, 'dashAjax'])->name('dash.ajax');
Route::get('/dashe', [PatientController::class, 'dashliste'])->name('dash.list');

Route::post('/attenteS', [PatientController::class, 'attenteP']);
});
#***************



Route::middleware('auth')->group(function () {
    #routes Consultation**************************
    
   
    Route::get('consultations', [ConsultationController::class, 'index'])->name('consultations');
    Route::get('consultations/create', [ConsultationController::class, 'create']);
    Route::get('consultations/{name}/createC', [ConsultationController::class, 'createC']);
    Route::post('consultations', [ConsultationController::class, 'store']);
    Route::get('consultations/{id}/edit', [ConsultationController::class, 'edit']);
    Route::get('consultations/{id}/details', [ConsultationController::class, 'details']);
    
    Route::put('consultations/{id}', [ConsultationController::class, 'update']);
    
    Route::post('consultations/delet', [ConsultationController::class, 'destroyS']);
    
    
   
    Route::get('/counts', [ConsultationController::class, 'getCounts']);
    /***
     * route to get name for auto consultation
     */
   // web.php or api.php
    Route::get('/patients/names', [PatientController::class, 'getPatientNames']);

    });
    #***************

    Route::middleware('auth')->group(function () {
    Route::get('/joints', [JointController::class, 'index'])->name('joints.index');
    Route::get('/joints/create', [JointController::class, 'create'])->name('joints.create');
    Route::post('/joints', [JointController::class, 'store'])->name('joints.store');
    Route::get('/joints/{id}', [JointController::class, 'show'])->name('joints.show');
    Route::get('/joints/{id}/edit', [JointController::class, 'edit'])->name('joints.edit');
    Route::put('/joints/{id}', [JointController::class, 'update'])->name('joints.update');
    Route::delete('/joints/{id}', [JointController::class, 'destroy'])->name('joints.destroy');

});


/***route table rendezvous */

Route::middleware('auth')->group(function () {
    
Route::get('/calendar', [AppointmentController::class, 'calendar'])->name('calendar');

Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::put('appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
Route::delete('appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
});
require __DIR__.'/auth.php';
