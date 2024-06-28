<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BidController;

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
Route::post('/send-email/{id}', [EmailController::class, 'sendEmail'])->name('send.email');

//Result
//Check result
Route::post('searchresult', [ResultController::class, 'search'])->name('search.result');
Route::view('searchresult', '/operations/showresult');

//Notice
//Notice Board
Route::get('/notices', [NoticeController::class, 'shownotice'])->name('all.notices');
Route::get('/notice/{id}', [NoticeController::class, 'showonenotice'])->name('show.one.notice');
Route::get('/', [NoticeController::class, 'welcome'])->name('welcome');


Route::middleware('auth')->group(function () {
    Route::get('/uploadphoto/{id}', [ProfileController::class, 'show']);
    Route::post('/uploadphoto/{id}', [ProfileController::class, 'update']);


    // Routes accessible to authenticated users only
    Route::get('/home', [App\Http\Controllers\StudentController::class, 'index'])->name('home');
    Route::get('/viewprofile/{id}', [StudentController::class, 'viewprofile']);
    Route::get('/viewservice/{id}/{gig_id}', [StudentController::class, 'viewservice']);


    //view addresults
    Route::view('addresult', '/operations/addresult');
    Route::get('/addresult', [ResultController::class, 'showAddResultForm']);
    Route::post('/addResult', [ResultController::class, 'store']);

    //Manage result
    //Route::view('manageresult', '/operations/manageresult');
    Route::get('/manageresult', [ResultController::class, 'index']);
    Route::post('/resultupdate/{id}', [ResultController::class, 'update'])->name('result.update');
    Route::get('/resultdelete/{id}', [ResultController::class, 'destroy'])->name('result.delete');

    //Freelancer -> add and manage
    Route::view('/addstudent', 'operations.addstudent');
    Route::post('/add', [StudentController::class, 'store']);
    Route::get('/managestudent', [StudentController::class, 'managefreelancer']);
    Route::get('/showupdate/{id}', [StudentController::class, 'show']);
    Route::post('/update/{id}', [StudentController::class, 'update']);
    Route::get('/delete/{id}', [StudentController::class, 'destroy']);

    //Attendence
    Route::view('addattendance', '/operations/addattendance');
    Route::get('/addattendance', [AttendanceController::class, 'showAddAttendanceForm']);
    Route::post('/addAttendance', [AttendanceController::class, 'store']);
    Route::view('manageattendance', '/operations/manageattendance');
    Route::get('/manageattendance', [AttendanceController::class, 'index']);
    Route::put('/attendance/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::post('/delete/{id}', [AttendanceController::class, 'destroy']);

    //Service
    Route::view('/uploadService', 'uploadService');
    Route::get('/uploadService', [ServiceController::class, 'index']);
    Route::post('/upload', [ServiceController::class, 'store']);
    Route::view('/manageService', '/operations/manageService');
    Route::get('/manageService', [ServiceController::class, 'show']);
    Route::get('/manageService/{id}', [ServiceController::class, 'showupdate']);
    Route::post('/manageservice/{id}', [ServiceController::class, 'edit']);
    Route::delete('/manageService/{id}', [ServiceController::class, 'destroy']);


    Route::view('/manageprofile', 'operations.manageprofile');
    Route::get('/manageprofile', [ProfileController::class, 'index']);
    Route::get('/editprofile', [ProfileController::class, 'index'])->name('edit.profile');

    // Route::view('/historygig', 'operations.history');
    Route::get('/history', [HistoryController::class, 'index']);
    Route::get('/historygig/{id}', [HistoryController::class, 'showGigs'])->name('show.gigs');

    Route::post('/rating/{id}', [HistoryController::class, 'rating']);

    Route::get('receivedmessages', [MessageController::class, 'receivedMessageIndex'])->name('receivedmessages');
    Route::get('messages/create/{user}', [MessageController::class, 'create'])->name('messages.create');
    Route::post('messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('messages/{user}/{message}', [MessageController::class, 'show'])->name('messages.show');
    // Route::get('messages/{biddername}/{user_id}', [MessageController::class, 'bidshow'])->name('messages.bidshow');

    Route::get('test/messages/{biddername}/{user_id}/{service_id}', [MessageController::class, 'bidshow'])->name('messages.bidshow');


    Route::get('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notifications/markAsRead/{id}', [NotificationController::class, 'markBidNotificationAsRead'])->name('bidding.notifications.markAsRead');

    //send Message
    Route::get('sendmessages', [MessageController::class, 'sendMessageIndex'])->name('sendmessages');






    Route::post('/bid/{userid}/{serviceid}', [BidController::class, 'store'])->name('bid');


});

Route::middleware(['admin'])->group(function () {
    // Admin routes
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    //User Controls
    Route::view('admins', '/operations/manageadminuser');
    Route::get('admins', [UserController::class, 'indexAdmins']);
    Route::put('/admins/{id}', [UserController::class, 'update']);
    // Route::match(['put', 'post'], '/adminsChangePassword/{id}', [UserController::class, 'changePassword']);
    Route::post('/adminsChangePassword/{id}', [UserController::class, 'changePassword']);
    Route::delete('/deleteadmins/{id}', [UserController::class, 'destroy']);
    Route::get('/admins/{id}', [UserController::class, 'show']);

    Route::view('lecturers', '/operations/managelectureruser');
    Route::get('lecturers', [UserController::class, 'indexLecturers']);
    Route::put('/lecturers/{id}', [UserController::class, 'update']);
    Route::match(['put', 'post'], '/lecturersChangePassword/{id}', [UserController::class, 'changePassword']);
    Route::delete('/deletelecturers/{id}', [UserController::class, 'destroy']);
    Route::get('/lecturers/{id}', [UserController::class, 'show']);


    //admin action -> user list -> freelancer
    Route::view('freelancer', '/operations/managefreelanceruser');
    Route::get('freelancer', [UserController::class, 'indexFreelancer']);
    Route::delete('/deletefreelancer/{id}', [UserController::class, 'destroy']);
    Route::put('/freelancer/{id}', [UserController::class, 'update']);
    Route::put('/freelancers/{id}', [UserController::class, 'changePassword']);

    //view addnotice
    Route::view('addnotice', '/operations/addnotice');
    Route::post('/addnotice', [NoticeController::class, 'addnotice']);

    //view managenotice
    Route::view('managenotice', '/operations/managenotice');
    Route::get('managenotice', [NoticeController::class, 'shownotice']);
    Route::delete('deletenotice/{id}', [NoticeController::class, 'deletenotice']);
    Route::put('managenotice/{id}', [NoticeController::class, 'editnotice']);
    Route::get('managenotice/{id}', [NoticeController::class, 'shownotice']);



});
