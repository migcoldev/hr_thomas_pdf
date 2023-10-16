<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;

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

Route::get('/iniciar-sesion', UserController::class .'@login')->name('user.login');
Route::get('/logout', UserController::class .'@logout')->name('user.logout');
Route::post('/user/authenticate', UserController::class .'@authenticate')->name('user.authenticate');

#Personal
Route::get('/', PDFController::class .'@index')->name('pdf.index');
Route::get('/personal/importar-excel', PDFController::class .'@importar')->name('pdf.importar');
Route::post('/personal/convertir-excel', PDFController::class .'@convertir')->name('pdf.convertir');
Route::get('/personal/usil-template', PDFController::class .'@usiltemplate')->name('pdf.usiltemplate');

#Grupal
Route::get('/grupal/lista', PDFController::class .'@indexgrupal')->name('pdf.index_grupal');
Route::get('/grupal/importar-excel', PDFController::class .'@importar_grupal')->name('pdf.importar_grupal');
Route::post('/grupal/convertir-excel', PDFController::class .'@convertir_grupal')->name('pdf.convertir_grupal');
Route::get('/grupal/generar-pdf', PDFController::class .'@generar_grupal')->name('pdf.generar_grupal');
Route::post('/grupal/usil-template', PDFController::class .'@usiltemplate_grupal')->name('pdf.usiltemplate_grupal');

Route::post('/pdf/upload-blob', PDFController::class .'@uploadblob')->name('pdf.uploadblob');