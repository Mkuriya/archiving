<?php

use App\Http\Controllers\InstructorController;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\OldView;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PasswordController;

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
Route::get('/', function(){return view('/admin/login');}); //default display page
Route::get('/backdoor', function(){return view('/register');});// for display when the authentication is functioning


Route::controller(AdminController::class)->group(function(){
    Route::post('/backdoor', 'backdoor');
    Route::post('/admin/dashboard/admin/reset', 'resetPassword'); //process in reset admin password
    Route::post('/admin/dashboard/profile/changepassword/update','updatePassword')->name('adminchangepassword'); //for changepassword process
    Route::post('/admin/register','adminRegister'); //for registration process
    Route::post('/admin/loginprocess','adminLogin'); //for login process
    Route::post('/admin/logout','adminLogout'); //for logout process
    Route::put('/admin/dashboard/profile/edit/{admin}','adminProfile')->name('admin.update')->middleware('auth:admin'); // for edit profile
    Route::put('/admin/dashboard/admin/edit/{admin}',  'adminUpdate')->name('admin.update')->middleware('auth:admin'); //to update the data from database
    Route::put('/admin/dashboard/student/edit/{student}',  'studentUpdate'); //to update the data from database

    Route::delete('/admin/dashboard/admin/delete/{admin}',  'adminDelete')->name('admin.delete')->middleware('auth:admin'); //to delete the data from database
    Route::delete('/admin/dashboard/student/delete/{student}',  'studentDelete'); //to delete the data from database


});


Route::controller(PasswordController::class)->group(function(){
    Route::get('/forgotpassword', 'forget_password')->name("forget.password");//display the forgot password form that will reset email
    Route::post('/forgotpassword', 'forget_password_post')->name("forget.password.post"); // process in sending a email
    Route::post('/reset-password', 'reset_password')->name("reset_password"); //process in reset the password
    Route::get('/reset-password/{token}', 'passwordReset')->name("resetpassword"); // the form that send in email
});

Route::controller(FileController::class)->group(function(){

    Route::put('/admin/dashboard/archive/decline/status/{file}', 'declinefileUpdate'); // for edit profile
    Route::put('/admin/dashboard/archive/pending/status/{file}', 'fileUpdate'); // for edit profile
    Route::post('/admin/dashboard/upload/file','fileUpload'); // for file uploading
    Route::post('/save-document',  'saveDocument');//save history
    Route::delete('/student/dashboard/history/{id}',  'destroy')->name('history.destroy');
    Route::delete('/items/{id}', 'destroy')->name('items.destroy');
    Route::put('/files/{id}/abstract', 'updateAbstract')->name('abstract.update');

    Route::post('/admin/dashboard/borrow/input', 'createBorrow')->name('createBorrow');
});


Route::controller(BorrowController::class)->group(function(){

    Route::delete('/items/{id}', 'destroy')->name('items.destroy');

    Route::put('/admin/dashboard/borrow/list/{file}', 'borrowUpdate');
});

Route::controller(ViewController::class)->group(function(){

    Route::get('/admin/dashboard/thesis/upload', 'adminUpload')->name('admin.adminUpload')->middleware('auth:admin'); // for display the upload form
    Route::get('/admin/dashboard','adminDashboard')->name('admin.dashboard')->middleware('auth:admin'); //for display the admin dashboard
    Route::get('/admin/dashboard/admin/view/{admin}', 'adminView')->name('admin.adminview')->middleware('auth:admin'); // to display the admin details
    Route::get('/admin/dashboard/admin/profile/{admin}', 'adminprofileView')->name('admin.adminprofile')->middleware('auth:admin'); // to display the admin profile details
    Route::get('/admin/login','adminLogin'); // to display the admin login

    Route::get('/admin/dashboard/archive/pending', 'pending'); //for display the pending list in admin
    Route::get('/admin/dashboard/profile/{admin}','adminprofileView')->name('admin.adminprofile')->middleware('auth:admin'); // for display the profile
    Route::get('/admin/dashboard/profile/changepassword/{admin}', 'adminPassword'); // for display the change adminpassword
    Route::get('/admin/dashboard/admin', 'adminList')->name('admin.admin')->middleware('auth:admin'); //to display the admin list
    Route::get('/admin/dashboard/admin/register','register'); // to display the admin register
    Route::get('/admin/dashboard/archive',  'adminArchiveList'); //for display the archive list/table
    Route::get('/admin/dashboard/archive/decline', 'decline')->name('decline'); // display the decline list
    Route::get('/admin/dashboard/search', 'fileSearch')->name('search'); //for display the search in student page
    Route::get('/archive/search', 'fileSearch');
    Route::get('/archive/search-result',  'searchFile');
    Route::get('/archive/details/{id}',  'viewDetails');
    Route::get('/admin/dashboard/archive/details/{id}',  'viewDetails');
    Route::get('/admin/dashboard/admin/edit/{admin}', 'adminEdit')->name('admin.adminedit')->middleware('auth:admin'); // for display the edit page
    Route::get('/admin/dashboard/archive/print', 'print')->name('archive.print');
    Route::get('/admin/dashboard/borrow', 'borrow')->name('archive.borrow');
    Route::get('/get-book/{book_number}', 'getBook')->name('get.book');
    Route::get('/admin/dashboard/borrow/list', 'b_list')->name('archive.b_list');
    Route::get('/admin/dashboard/search/details/{id}', 'details')->name('archive.viewdetailss');
    Route::get('/admin/dashboard/instructor', 'instructor')->name('instructor');
    Route::get('/admin/dashboard/instructor/list', 'instructorlist')->name('instructorlist');
});

Route::controller(InstructorController::class)->group(function(){

    Route::post('/admin/dashboard/create_instructor', 'instructorRegister');
    Route::post('/admin/dashboard/assign_instructor', 'instructorAssign');

});
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('home');








/*
Route::controller(OldView::class)->group(function(){

    Route::get('/student/dashboard/search', 'fileSearch')->name('search'); //for display the search in student page
    Route::get('/student/dashboard/archivelist','studentArchiveList')->name('archivelist'); //for display the archive list in student
    Route::get('/student/dashboard/student/profile/{student}', 'studentprofileView')->name('admin.studentprofile')->middleware('auth:student'); // to display the admin profile details
    Route::get('/student/dashboard/profile/{student}', 'studentprofileView')->name('studentprofile')->middleware('auth:student'); // to display the stuident profile details
    Route::get('/student/dashboard/upload', 'studentUpload')->name('student.studentUpload')->middleware('auth:student'); // for display the upload form
    Route::get('/student/dashboard/profile/changepassword/{student}', 'studentPassword'); // for display the change studentpassword
    Route::get('/student/login','studentLogin'); // to display the student login
    Route::get('/student/dashboard','studentDashboard')->name('student.dashboard')->middleware('auth:student'); //for student dashboard with auth
    Route::get('/student/dashboard/archivelist/document/{file}', 'viewDoc')->name('document.view'); // pdf view in student
    Route::get('/student/dashboard/history/{file}', 'historyDoc'); // pdf view in student
    Route::get('/student/dashboard/archivelist/filter', 'archivelistfilter');//filter search
    Route::get('/student/dashboard/archivelist/document/${result.document}', 'pdfviewer');//display the forgot password form that will send email
    Route::get('/student/menu', 'showMenu')->name('student.menu');



    Route::get('/admin/dashboard/student', 'studentlist')->name('admin.student')->middleware('auth:admin'); // to display the student list
    Route::get('/admin/dashboard/admin/reset/{admin}', 'adminReset')->name('resetadmin'); // display the reset form of admin
    Route::get('/admin/dashboard/archive/view/{file}', 'viewDocument'); // pdf view in admin
    Route::get('/admin/dashboard/student/filter', 'filterstudentlist'); // to display the student list
    Route::get('/forgotpassword', 'forget_password')->name("forget.password");//display the forgot password form that will send email


});
  */
/*
Route::controller(StudentController::class)->group(function(){

    Route::post('/student/dashboard/profile/changepassword/update','updatePassword')->name('studentchangepassword'); //for changepassword process
    Route::post('/student/loginprocess','loginProcess'); // to process the student login
    Route::post('/admin/dashboard/studentregister','studentRegister')->name('admin.studentregister')->middleware('auth:admin'); //for registration process
    Route::post('/student/logout','studentLogout'); //for logout process
    Route::put('/student/dashboard/profile/edit/{student}', 'studentProfile')->name('update')->middleware('auth:student'); // for edit profile

});
*/

Auth::routes();

