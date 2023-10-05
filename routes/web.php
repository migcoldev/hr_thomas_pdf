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


Route::get('/', PDFController::class .'@index')->name('pdf.index');
Route::get('/importar-excel', PDFController::class .'@importar')->name('pdf.importar');
//Route::get('/convertir-excel', PDFController::class .'@convertir')->name('pdf.convertir');
Route::post('/convertir-excel', PDFController::class .'@convertir')->name('pdf.convertir');
Route::get('/pdf/usil-template', PDFController::class .'@usiltemplate')->name('pdf.usiltemplate');
Route::post('/pdf/upload-blob', PDFController::class .'@uploadblob')->name('pdf.uploadblob');