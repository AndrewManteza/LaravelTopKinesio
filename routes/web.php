<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
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



Route::get('/',[HomeController::class,'index']);

Route::get('/home',[HomeController::class,'redirect'])->middleware('auth','verified');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



Route::get('/viewpatient',[AdminController::class,'viewpatient']);

Route::get('/add_therapist_view',[AdminController::class,'addview']);

Route::get('/add_patient_view',[AdminController::class,'addviewpatient']);

Route::post('/upload_therapist',[AdminController::class,'upload']);

Route::post('/upload_patient',[AdminController::class,'uploadPatient']);

Route::post('/appointment',[HomeController::class,'appointment']);

Route::get('/myappointment',[HomeController::class,'myappointment']);

Route::get('/cancel_appoint/{id}',[HomeController::class,'cancel_appoint']);

Route::get('/showappointment',[AdminController::class,'showappointment']);

Route::get('/approved/{id}',[AdminController::class,'approved']);

Route::get('/cancelled/{id}',[AdminController::class,'cancelled']);

Route::get('/showtherapist',[AdminController::class,'showtherapist']);

Route::get('/deletetherapist/{id}',[AdminController::class,'deletetherapist']);

Route::get('/updatetherapist/{id}',[AdminController::class,'updatetherapist']);

Route::post('/editpatient/{id}',[AdminController::class,'editpatient']);

Route::get('/deletepatient/{id}',[AdminController::class,'deletepatient']);

Route::get('/updatepatient/{id}',[AdminController::class,'updatepatient']);

Route::post('/editpatient/{id}',[AdminController::class,'editpatient']);

Route::get('/emailview/{id}',[AdminController::class,'emailview']);

Route::post('/sendemail/{id}',[AdminController::class,'sendemail']);

Route::get('/contact',[HomeController::class,'contact']);

Route::get('../config/chatify',[HomeController::class,'']);


