<?php
use Carbon\Carbon;
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

// Route::get('/Home', function(){
//     return view('Home.index');
// });
Route::get('/Home','HomeController@index')->name('Home.index');
Route::get('/Department','HomeController@department')->name('Home.department');

//Login Page Route
Route::get('/Login','LoginController@index')->name('Login.index');
Route::post('/Login','LoginController@verifyUser')->name('Login.verifyUser');

//Admin Page Route
Route::get('/admin','AdminController@index')->name('Admin.index');

//HR Page Route
Route::get('/HR', 'HRController@index')->name('HR.index');
Route::get('/HR/Chart', 'HRController@chart')->name('HR.chart');

Route::get('/HR/AddDoctor', 'HRController@addDoctor')->name('HR.addDoctor');
Route::post('/HR/AddDoctor', 'HRController@insertDoctor')->name('HR.insertDoctor');

Route::get('/HR/AddEmployee', 'HRController@addEmployee')->name('HR.addEmployee');
Route::get('/HR/Notice', 'HRController@notice')->name('HR.notice');
Route::get('/HR/DoctorList', 'HRController@doctorList')->name('HR.doctorList');
Route::get('/HR/HRList', 'HRController@hrList')->name('HR.hrList');
Route::get('/HR/ManagerList', 'HRController@managerList')->name('HR.managerList');
Route::get('/HR/ReceiptionistList', 'HRController@receiptionistList')->name('HR.receiptionistList');

Route::get('/HR/DoctorProfile/{DoctorId}', 'HRController@doctorProfile')->name('HR.doctorProfile');
Route::get('/HR/EditDoctor/{DoctorId}', 'HRController@editDoctor')->name('HR.editDoctor');
Route::post('/HR/EditDoctor/{DoctorId}', 'HRController@updateDoctor')->name('HR.updateDoctor');

//Upload Doctor Profile Picture
Route::post('/HR/ProfilePicture', 'HRController@profilePicture')->name('HR.profilePicture');
Route::get('/HR/Timing', 'HRController@timing')->name('HR.timing');
//Day Testing Routing
// Route::get('/day', function(){
//     $date = '2020-03-20';
//     $d = new DateTime($date);
//     echo $d->format('l');
    
// });

Route::get('/HR/SetTime/{DoctorId}', 'HRController@search')->name('HR.search');
Route::post('/HR/SetTime/{DoctorId}', 'HRController@schedule')->name('HR.schedule');
