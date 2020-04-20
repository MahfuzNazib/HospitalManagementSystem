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

//View HR Profile
Route::get('/HR/HRProfile/{id}', 'HRController@viewHRProfile')->name('HR.HRProfile');
//View Receptionist Profile
Route::get('/HR/ReceptionProfile/{id}', 'HRController@viewReceptionProfile')->name('HR.ReceptionProfile');
Route::get('/HR/EditReception/{id}', 'HRController@editReception')->name('HR.editReception');
Route::post('/HR/EditReception/{id}', 'HRController@updateReception')->name('HR.updateReception');


//Insert Doctor
Route::get('/HR/AddDoctor', 'HRController@addDoctor')->name('HR.addDoctor');
Route::post('/HR/AddDoctor', 'HRController@insertDoctor')->name('HR.insertDoctor');

//Insert Employees
Route::get('/HR/AddEmployee', 'HRController@addEmployee')->name('HR.addEmployee');
Route::post('/HR/AddEmployee', 'HRController@insertEmployee')->name('HR.insertEmployee');

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

//New Hospital Test Add
Route::get('/HR/NewTest', 'HRController@newTest')->name('HR.newTest');
Route::post('/HR/NewTest', 'HRController@insertTest')->name('HR.insertTest');

//View Test List 
Route::get('/HR/TestList', 'HRController@testList')->name('HR.testList');
//Search Test List on HR Department
Route::get('/HR/action', 'HRController@action')->name('HR.searchTest');

//Edit Hospital Test
Route::get('/HR/EditTest/{Id}', 'HRController@editTest')->name('HR.editTest');
//Update Hospital TestInfo
Route::post('/HR/EditTest/{Id}', 'HRController@updateTest')->name('HR.updateTest');

//Hospital Department
Route::get('/HR/AddDepartment', 'HRController@addDepartment')->name('HR.addDepartment');
Route::post('/HR/AddDepartment', 'HRController@insertDept')->name('HR.insertDept');




// Day Testing Routing
Route::get('/day', function(){
    $date = '2020-04-19';
    $d = new DateTime($date);
    echo $d->format('l');
    
});

Route::get('/HR/SetTime/{DoctorId}', 'HRController@search')->name('HR.search');
Route::post('/HR/SetTime/{DoctorId}', 'HRController@schedule')->name('HR.schedule');


//Receptionist Route
Route::get('/ReceptionIndex', 'ReceptionController@index')->name('Reception.index');
Route::get('/Appointment', 'ReceptionController@appointment')->name('Reception.appointment');
Route::get('/action', 'ReceptionController@action')->name('Reception.action');
Route::get('/doctorDate', 'ReceptionController@doctorDate')->name('Reception.doctorDate');


//Patient Registration
Route::get('/Registration', 'ReceptionController@registration')->name('Reception.registration');
