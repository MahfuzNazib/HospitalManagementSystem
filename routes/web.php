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
Route::post('/HR/Notice', 'HRController@postNotice')->name('HR.notice');
Route::get('/HR/AllNotices', 'HRController@allNotices')->name('HR.allNotices');

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
    // $date = '2020-04-19';
    // $d = new DateTime($date);
    // echo $d->format('l');

    $dt = new Carbon();
    $dt->timezone('Asia/Dhaka');
    $year =  $dt->year;
    $month = $dt->month;
    $day = $dt->day;
    $sec = $dt->second;
    $milisec = $dt->millisecond;
    if($month < 10){
        $month = '0'.$month;
    }
    if($day < 10){
        $day = '0'.$day;
    }
    echo $day;
    echo '<br>';
    echo $month;
    echo '<br>';
    echo $year;
    echo '<br>';
    echo $sec;
    echo '<br>';
    echo $milisec;
    echo '<br>';
    $invoice = $year.$month.$day;
    echo $invoice;


    for($i=0; $i<30;$i++){
        $invoice++;
        echo $invoice.'<br>';
    }
});

Route::get('/HR/SetTime/{DoctorId}', 'HRController@search')->name('HR.search');
Route::post('/HR/SetTime/{DoctorId}', 'HRController@schedule')->name('HR.schedule');


//Receptionist Route
Route::get('/ReceptionIndex', 'ReceptionController@index')->name('Reception.index');


Route::get('/Appointment', 'ReceptionController@appointment')->name('Reception.appointment');
Route::get('/action', 'ReceptionController@action')->name('Reception.action');
Route::get('/doctorDate', 'ReceptionController@doctorDate')->name('Reception.doctorDate');

//set Patient Appointment
Route::get('/setAppointment', 'ReceptionController@setAppointment')->name('Reception.setAppointment');


//Patient Registration
Route::get('/Registration', 'ReceptionController@registration')->name('Reception.registration');
//Insert New Patient
Route::post('/Registration', 'ReceptionController@insertPatient')->name('Reception.insertPatient');

//Patient AppointmentList
Route::get('/AppointmentList', 'ReceptionController@appointmentList')->name('Reception.appointmentList');

Route::get('/searchAppointment', 'ReceptionController@searchAppointment')->name('Reception.searchAppointment');

//See Doctors Schedule
Route::get('/DoctorSchedule', 'ReceptionController@doctorSchedule')->name('Reception.doctorSchedule');
Route::get('/DoctorScheduleDetails/{DrId}', 'ReceptionController@doctorScheduleDetails')->name('Reception.doctorScheduleDetails');
Route::get('/SearchDoctorTime', 'ReceptionController@searchDoctorTime')->name('Reception.searchDoctorTime');

//get Patient Data from PID
Route::get('/PatientInfo', 'ReceptionController@patientInfo')->name('Reception.patientInfo');


//Print Appointment Page as Blank Prescription
Route::get('/EmptyPrecription/{patientId}', 'ReceptionController@emptyPrecription')->name('Reception.emptyPrecription');

//Get Registered PatientInfo from Patient ID
Route::get('/PatientData', 'ReceptionController@patientData')->name('Reception.patientData');

//Get TestInfo from TestCode
Route::get('/TestInfo', 'ReceptionController@testInfo')->name('Reception.testInfo');

//Remove Test
Route::get('/removeTest', 'ReceptionController@removeTest')->name('Reception.removeTest');
Route::get('/TempTest', 'ReceptionController@tempTestList')->name('Reception.tempTestList');

//Delete All Data from TempTest List
Route::get('/DeleteTempTest', 'ReceptionController@deleteTempData')->name('Reception.deleteTempData');

//Patient Invoice Section
Route::get('/CreateInvoice', 'ReceptionController@createInvoice')->name('Reception.createInvoice');
Route::get('/InvoiceDetails', 'ReceptionController@invoiceDetails')->name('Reception.invoiceDetails');
//Print Invoice 
Route::get('/PrintInvoice/{invoiceNo}', 'ReceptionController@printInvoice')->name('Reception.printInvoice');


//Report Delivery
Route::get('/ReportDelivey', 'ReceptionController@reportDelivery')->name('Reception.reportDelivery');


//Report Delivery Section
Route::get('/ReportDeliveyInfo', 'ReceptionController@reportDeliveryInfo')->name('Reception.reportDeliveryInfo');

//Report Delivery And Update Invoice_Masters Table
Route::get('/UpdateInvoice', 'ReceptionController@updateInvoice')->name('Reception.updateInvoice');
                                                                        

