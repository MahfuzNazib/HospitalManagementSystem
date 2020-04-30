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
use App\PatientAppointment;
use App\PatientlistMaster;

use DateTime;
use SebastianBergmann\Environment\Console;

class ReceptionController extends Controller
{
    public function index(){
        return view('Reception.index');
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


}
