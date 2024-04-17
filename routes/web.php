<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\UserController;

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
Route::get('managenotice',[NoticeController::class,'shownotice']);
Route::delete('deletenotice/{id}',[NoticeController::class,'deletenotice']);
Route::put('managenotice/{id}',[NoticeController::class,'editnotice']);
Route::get('managenotice/{id}',[NoticeController::class,'shownotice']);

//User Controls
Route::view('admins', '/operations/manageadminuser');
Route::get('admins', [UserController::class,'indexAdmins']);
Route::put('/admins/{id}', [UserController::class,'update']);
Route::delete('/deleteadmins/{id}', [UserController::class,'destroy']);
Route::get('/admins/{id}', [UserController::class, 'show']);

Route::view('lecturers', '/operations/managelectureruser');
Route::get('lecturers', [UserController::class,'indexLecturers']);
Route::put('/lecturers/{id}', [UserController::class,'update']);
Route::delete('/deletelecturers/{id}', [UserController::class,'destroy']);
Route::get('/lecturers//{id}', [UserController::class, 'show']);



