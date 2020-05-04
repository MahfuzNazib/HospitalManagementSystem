<?php

namespace App\Http\Controllers;

use Carbon\Carbon; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use DB;
use App\Doctor;
use App\HospitalDepartment;
use App\AppointmentTime;
use App\AppointmentTimeMaster;
use App\HospitalTest;
use App\PatientAppointment;
use App\PatientlistMaster;
use App\TempTestlist;
use App\InvoiceMaster;
use App\InvoiceDetails;

use DateTime;
use SebastianBergmann\Environment\Console;

class ReceptionController extends Controller
{
    //Genarate Invoice
    public function invoice(){
        $dt = new Carbon();
        $dt->timezone('Asia/Dhaka');
        $year =  $dt->year;
        $month = $dt->month;
        $day = $dt->day;
        if($month < 10){
            $month = '0'.$month;
        }
        if($day < 10){
            $day = '0'.$day;
        }
        // echo $day;
        // echo '<br>';
        // echo $month;
        // echo '<br>';
        // echo $year;
        // echo '<br>';
        $invoice = $year.$month.$day;
        // echo $invoice;
        return $invoice;
    }

    public function index(){
        $testList = HospitalTest::all();
        // $getInvoice = InvoiceMaster::max('invoiceNo');
        // $invoice;
        // if($getInvoice == null){
            // $netInvoiceNo = invoice();
            $dt = new Carbon();
            $dt->timezone('Asia/Dhaka');
            $year =  $dt->year;
            $month = $dt->month;
            $day = $dt->day;
            $seconds = $dt->second;
            $milisec = $dt->millisecond;
            $incrementDigits = '0000';
            $lastDayofCurrentMonth = $dt->daysInMonth;
            $lastDay = $lastDayofCurrentMonth;
            if($month < 10){
                $month = '0'.$month;
            }
            if($day < 10){
                $day = '0'.$day;
            }
            if($lastDay > $lastDayofCurrentMonth+1){
                $incrementDigits = '0000';
            }
            $invoice = $year.$month.$day.$seconds.$milisec;
            $nextInvoiceNo = $invoice;

        // }
        // else{
            // $invoice = $year.$month.$day.$seconds;
            // $nextInvoiceNo = $getInvoice+1;
        // }
        return view('Reception.index',['testList' => $testList, 'invoiceNo' => $nextInvoiceNo]);
    }

    ####################################################################
    /* **********************Doctors Appointment Set ********************/
    ####################################################################

    //Appointment Function
    public function appointment(){
        $dept = HospitalDepartment::all();
        $pId = PatientAppointment::max('patientId');

        if($pId == null){
            $nextId = 1001;
        }
        else{
            $nextId = $pId+1;
        }   
        
        error_log($nextId);
        
        return view('Reception.Appointment',['dept' => $dept,'nextId'=>$nextId]);
    }

    //Ajax Request to Load Doctor Name With Selected Department
    function action(Request $req){
        if($req->ajax()){
            $query = $req->get('query');

            if($query != ''){
                $doctorName = Doctor::where('Department', $query)->get(['DoctorId','Name']);
                return response()->json($doctorName);
            }
            
        }
    }

    //Ajax Request to Show Selected Doctor Time Slots for Appointment Booking;
    public function doctorDate(Request $req){
        if($req->ajax()){
            $date = $req->get('date');
            $name = $req->get('name');
            $dept = $req->get('dept');

            error_log('Date   : '.$date);
            error_log('DrName : '.$name);
            error_log('Dept   : '.$dept);
            //Get Day
            $d = new DateTime($date);
            $day = ($d->format('l'));
            error_log($day);

            // $apntTime = AppointmentTime::where([
            //                             ['DrName', '=', $name],
            //                             ['DayName', '=', $day]
            // ])->get(['Id', 'Shift','TimeSchedule']);

            //Raw SQL Query for Getting Doctor Available Time Slots Joining appointment_times and patient_appointments Table;
            $apntTime = DB::select('SELECT  Shift,TimeSchedule FROM appointment_times
            WHERE  DayName=? AND DrName = ? AND TimeSchedule NOT IN(SELECT appointmentTime FROM patient_appointments WHERE appointmentDate = ? AND drName = ? and appointmentDay = ?)',[$day,$name,$date,$name,$day]);
            error_log('Before $apntTime');
            return $apntTime;

            //This Part would not work Because we return the DB Value;
            // error_log('After $apntTime');

            
            // $total_row = $apntTime->count();
            // error_log('Total Row :'.$total_row);
            // if($total_row > 0){
            //     $AppointmentTimes = $apntTime;
            // }
            // else{
            //     $AppointmentTimes = 'Dr.'.$name.' is not Available on that Day';
            // }

            // return response()->json($AppointmentTimes);
        }
    }



    /*******************Set Patient Appointment Booking ***************************** */

    public function setAppointment(Request $req){
        if($req->ajax()){
            $patientName = $req->get('patientName');
            $patientId = $req->get('patientId');
            $patientContact = $req->get('patientContact');
            $DrName = $req->get('DrName');
            $appointmentDate = $req->get('appointmentDate');
            $bookingTime = $req->get('bookingTime');

            //get Appointment Day from appointmentDate
            $d = new DateTime($appointmentDate);
            $appointmentDay = ($d->format('l'));

            $bookingDate = new Carbon();
            $bookingDate -> timezone('Asia/Dhaka');

            // Now Insert Data into Patient_Appointments Table
            $appointment = new PatientAppointment();

            $appointment->appointmentDate = $appointmentDate;
            $appointment->bookingDate = $bookingDate;
            $appointment->appointmentDay = $appointmentDay;
            $appointment->appointmentTime = $bookingTime;
            $appointment->drName = $DrName;
            $appointment->patientName = $patientName;
            $appointment->patientId = $patientId;
            $appointment->pContact = $patientContact;

            $appointment->save();
            

        }
    }


    /**********************Patient All Appointment List**************** */

    public function appointmentList(){
        $patientAppointment = PatientAppointment::orderBy('id','desc')->paginate(10);
        return view('Reception.AppointmentList',['patientAppointment' => $patientAppointment]);
    }

    /**********************Search Appointment Patient List *************************/
    public function searchAppointment(Request $req){
        if($req->ajax()){
            $query = $req->get('query');
            $patientAppnt = '';
            $result = '';
            if($query != ''){
                $patientAppnt = PatientAppointment::where('patientId', 'like', '%'. $query .'%')
                                            ->orWhere('patientName', 'like', '%'. $query .'%')
                                            ->orWhere('pContact', 'like', '%'. $query .'%')
                                            ->get();
            }
            else{
                $patientAppnt = PatientAppointment::orderBy('id','desc')->get();
            }

            $row_data = $patientAppnt->count(); //Check Total Data Row.

            if($row_data > 0){
                $result = $patientAppnt;
            }
            else{
                $result = "No Data Found";
            }

            return response()->json($result);
            
            
        }
    }

    ####################################################################
    /* **********************End Doctors Appointment********************/
    ####################################################################


    /*******************View Doctor Time Schedule******************* */
    public function doctorSchedule(){

        $doctorTimes = DB::table('appointment_time_masters')
                        ->join('doctors','doctors.DoctorId', '=', 'appointment_time_masters.DrId')
                        ->select('appointment_time_masters.DrId','appointment_time_masters.DrName','doctors.Department')
                        // ->groupBy('doctors.DoctorId')
                        ->paginate(10);
                        
        return view('Reception.DoctorSchedule',['doctorTimes' => $doctorTimes]);
    }

    /*******************View Doctor Time Schedule Details******************* */

    public function doctorScheduleDetails($DrId){
        $DrDetails = AppointmentTimeMaster::where('DrId', '=', $DrId)
                                            ->get();
        $getDrName = DB::table('doctors')
                        ->where('DoctorId', '=', $DrId)
                        ->select('Name')
                        ->get();
        return view('Reception.ViewDoctorTimeDetails',['DrDetails' => $DrDetails,'DrName' => $getDrName]);
    }

    //Search Doctor Time Schedule

    public function searchDoctorTime(Request $req){
        if($req->ajax()){
            $query = $req->get('search');
            $doctorTimes;
            if($query!=''){
                $doctorTimes = DB::table('appointment_time_masters')
                        ->join('doctors','doctors.DoctorId', '=', 'appointment_time_masters.DrId')
                        ->where('appointment_time_masters.DrName','like','%'.$query. '%')
                        ->orWhere('doctors.Department','like','%'.$query. '%')
                        // ->groupBy('appointment_time_masters.DrName')
                        ->select('appointment_time_masters.DrId','appointment_time_masters.DrName','doctors.Department')
                        ->get();

               
            }

            return response()->json($doctorTimes);
        }
    }


    ####################################################################
    /* **********************Patient Registration**********************/
    ####################################################################

    public function registration(){
        return view('Reception.PatientRegistration');
    }

    //Get Patient Data From AJAX REQUEST
    public function patientInfo(Request $req){
        if($req->ajax()){
            $pId = $req->get('patientId');
            $patientInfo;
            $doctorInfo;
            // $pInfo = PatientlistMaster::where('patientId', '=', $pId)->get();
            // $dInfo = DB::table('patient_appointments')
            //         ->where('patientId', '=', $pId)
            //         ->get();
            
            $pInfo = PatientAppointment::where('patientId', '=', $pId)->get();


            $data_row = $pInfo->count();
            if($data_row > 0){
                $patientInfo = $pInfo;
                // $doctorInfo  = $dInfo; 
            }
            else{
                $patientInfo = 'No Record Found';
            }
        }

        return response()->json($patientInfo);
    }

    public function insertPatient(Request $req){
        $this->validate($req,[
            'pName' => 'required',
            'type' => 'required',
            'pContact' => 'required',
            'pGender' => 'required',
            'pAge' => 'required'
        ]);

        //Create Registered Date
        $registerDate = new Carbon();
        $registerDate -> timezone('Asia/Dhaka');
        
        $newPatient = new PatientlistMaster();
        
        $newPatient->patientId = $req->pId;
        $newPatient->name = $req->pName;
        $newPatient->contact = $req->pContact;
        $newPatient->gender = $req->pGender;
        $newPatient->age = $req->pAge;
        $newPatient->type = $req->type;
        $newPatient->registerDate = $registerDate;
        

        $newPatient->save();

        return redirect()->route('Reception.registration')
                         ->with('msg', 'Patient Registration Successfully Done!!');
    }


    ####################################################################
    /* **********************End Patient Registration********************/
    ####################################################################


    ####################################################################
    /* **********************Print Empty Prescription********************/
    ####################################################################

    public function emptyPrecription($patientId){
        $information = PatientAppointment::where('patientId', '=', $patientId)->get();
        error_log($information);
        return view('Reception.EmptyPrecription',['information' => $information]);
    }

    ####################################################################
    /* *****************End Print Empty Prescription********************/
    ####################################################################

    ####################################################################
    /* *****************Patient Invoice Module Page********************/
    ####################################################################

    public function patientData(Request $req){
        if($req->ajax()){
            $patientId = $req->get('pId');
            $patientData;
            $pInfo = PatientlistMaster::where('patientId', '=', $patientId)->get();
            
            $total_row = $pInfo->count();
            if($total_row > 0){
                $patientData = $pInfo;
            }
            else{
                $patientData = 'No Record Found!';
            }

            return response()->json($patientData);
        }
    }

    public function testInfo(Request $req){
        if($req->ajax()){
            $testInfo;
            $testCode = $req->get('testCode');
            
            if($testCode != ''){
                $tInfo = HospitalTest::where('testShortName', '=', $testCode)->get();
            }
            else{
                $tInfo = HospitalTest::all();
            }
            
            $total_row = $tInfo->count();

            if($total_row > 0){
                $testCode = $tInfo;
            }
            else{
                $testCode = 'Test Code dosent Matched';
            }

            return response()->json($testCode);
        }
    }

    public function tempTestList(Request $req){
        if($req->ajax()){
            $testCode = $req->get('testCode');
            $testName = $req->get('testName');
            $testCost = $req->get('testCost');

            $testList = new TempTestlist();

            $testList->testCode = $testCode;
            $testList->testName = $testName;
            $testList->testCost = $testCost;

            $testList->save();

            //Get All TestList after Saving into TempTest Table;
            $testRecord = TempTestlist::all();

            return response()->json($testRecord);
        }
    }

    public function deleteTempData(Request $req){
        if($req->ajax()){
            $deleteTest = DB::table('temp_testlists')->delete();

            //Get All TestList after Saving into TempTest Table;
            $testRecord = TempTestlist::all();

            return response()->json($testRecord);     
        }
    }

    public function removeTest(Request $req){
        if($req->ajax()){
            $id = $req->get('tid');
            $getTestPrice = DB::table('temp_testlists')
                            ->where('id', '=', $id)
                            ->select('testCost')
                            ->get();
                            
            error_log('Delete Test Price is :::: --- '.$getTestPrice);
            $removeTest = DB::table('temp_testlists')
                    ->where('id', '=', $id)
                    ->delete();
            
            $testRecord = TempTestlist::all();
            // error_log($testRecord);
            return response()->json(array('testRecord'=>$testRecord, 'price'=>$getTestPrice));
        }
        
    }
    // Invoice Work

    public function createInvoice(Request $req){
        if($req->ajax()){
            // $data = ($req->get('testListRecords'));
            $status = 'Not Clear';
            $invoiceDate = new Carbon();
            $invoiceDate -> timezone('Asia/Dhaka');
            
            //Save Data into Invoice_Masters Table
            error_log('Function Called');
            
            
            $inv = $req->get('invoiceNo');
            error_log('InvNo'.$inv);
            error_log('Date '.$invoiceDate);
            error_log( 'Pid'.$req->get('patientId'));
            error_log( 'PNAME'.$req->get('patientName'));
            error_log( 'PPhone'.$req->get('patientPhone'));
            error_log( 'TotalCost'.$req->get('totalCost'));
            error_log( 'Dis'.$req->get('discount'));
            error_log( 'Net'.$req->get('netAmount'));
            error_log( 'Paid'.$req->get('paidAmount'));
            error_log( 'Due'.$req->get('dueAmount'));
            error_log( 'given'.$req->get('givenAmount'));
            error_log( 'Return'.$req->get('returnAmount'));
            error_log( 'Status :'.$status);

            $dueAmount = $req->get('dueAmount');
            if($dueAmount == 0){
                $status = 'Clear';
            }

            $data = array();
            $data['invoiceNo'] = $req->get('invoiceNo');
            $data['invoiceDate'] = $invoiceDate;
            $data['patientId'] = $req->get('patientId');
            $data['patientName'] = $req->get('patientName');
            $data['patientPhone'] = $req->get('patientPhone');
            $data['totalCost'] = $req->get('totalCost');
            $data['discount'] = $req->get('discount');
            $data['netAmount'] = $req->get('netAmount');
            $data['paidAmount'] = $req->get('paidAmount');
            $data['dueAmount'] = $dueAmount;
            $data['givenAmount'] = $req->get('givenAmount');
            $data['returnAmount'] = $req->get('returnAmount');
            $data['status'] = $status;

            $invoiceMaster = DB::table('invoice_masters')->insert($data);

            
            return redirect()->route('Reception.index');
        }
    }

    ####################################################################
    /* *****************EndPatient Invoice Module Page********************/
    ####################################################################


}
