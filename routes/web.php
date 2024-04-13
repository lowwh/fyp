<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\noticeController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Dashboard


//Subjects
//view addsubject
Route::view('addsubject', '/operations/addsubject');

//view managesubject
Route::view('managesubject', '/operations/managesubject');

//Students
//view addstudent
Route::view('addstudent', '/operations/addstudent');

//view managestudent
Route::view('managestudent', '/operations/managestudent');

//Result
//view addresult
Route::view('addresult', '/operations/addresult');

//view manageresult
Route::view('manageresult', '/operations/manageresult');

//Notice
//view addnotice
Route::view('addnotice', '/operations/addnotice');
Route::post('/addnotice',[noticeController::class,'addnotice']);

//view managenotice
Route::view('managenotice', '/operations/managenotice');
Route::get('managenotice',[noticeController::class,'shownotice']);
Route::delete('deletenotice/{id}',[noticeController::class,'deletenotice']);
Route::put('managenotice/{id}',[noticeController::class,'editnotice']);
Route::get('managenotice/{id}',[noticeController::class,'shownotice']);

//User Controls
