<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;


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
Route::view('/addstudent','operations.addstudent');
Route::post('/add', [StudentController::class, 'store']);
Route::get('/managestudent', [StudentController::class,'index']);
Route::get('/showupdate/{id}',[StudentController::class,'show']);
Route::post('/update/{id}',[StudentController::class,'update']);
Route::get('/delete/{id}',[StudentController::class,'destroy']);

//Result
//Check result
Route::post('searchresult', [ResultController::class, 'search'])->name('search.result');
Route::view('searchresult', '/operations/showresult');

//view addresults
Route::view('addresult', '/operations/addresult');
Route::get('/addresult', [ResultController::class, 'showAddResultForm']);

//Manage result
Route::post('/addResult', [ResultController::class, 'store']);
Route::get('/manageresult', [ResultController::class,'index']);
Route::post('/update/{id}', [ResultController::class, 'update'])->name('result.update');
Route::get('/delete/{id}',[ResultController::class,'destroy'])->name('result.delete');

//Attendence
Route::view('addattendance', '/operations/addattendance');
Route::get('/addattendance', [AttendanceController::class, 'showAddAttendanceForm']);
Route::post('/addAttendance', [AttendanceController::class, 'store']);
Route::view('manageattendance', '/operations/manageattendance');
Route::get('/manageattendance', [AttendanceController::class,'index']);
Route::put('/attendance/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
Route::post('/delete/{id}',[AttendanceController::class,'destroy']);

//Notice
//Notice Board
Route::get('/notices', [NoticeController::class, 'shownotice'])->name('all.notices');
Route::get('/notice/{id}', [NoticeController::class, 'showonenotice'])->name('show.one.notice');
Route::get('/', [NoticeController::class, 'welcome'])->name('welcome');


//view addnotice
Route::view('addnotice', '/operations/addnotice');
Route::post('/addnotice',[NoticeController::class,'addnotice']);

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
Route::match(['put', 'post'], '/adminsChangePassword/{id}', [UserController::class, 'changePassword']);
Route::delete('/deleteadmins/{id}', [UserController::class,'destroy']);
Route::get('/admins/{id}', [UserController::class, 'show']);

Route::view('lecturers', '/operations/managelectureruser');
Route::get('lecturers', [UserController::class,'indexLecturers']);
Route::put('/lecturers/{id}', [UserController::class,'update']);
Route::match(['put', 'post'], '/lecturersChangePassword/{id}', [UserController::class, 'changePassword']);
Route::delete('/deletelecturers/{id}', [UserController::class,'destroy']);
Route::get('/lecturers/{id}', [UserController::class, 'show']);



