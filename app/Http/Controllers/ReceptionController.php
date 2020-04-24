<?php

namespace App\Http\Controllers;

use Carbon\Carbon; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Doctor;
use App\HospitalDepartment;
use App\AppointmentTime;
use App\AppointmentTimeMaster;
use App\PatientAppointment;
use App\PatientlistMaster;

use DateTime;


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
        $pId = PatientlistMaster::max('patientId');

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
                $doctorName = Doctor::where('Department', $query)->get(['Name']);
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
            //Get Day
            $d = new DateTime($date);
            $day = ($d->format('l'));

            $apntTime = AppointmentTime::where([
                                        ['DrName', '=', $name],
                                        ['DayName', '=', $day]
            ])->get(['Id', 'Shift','TimeSchedule']);

            // $apntTime =  DB::table('patient_appointments')
            //             ->join('appointment_times', 'appointment_times.TimeSchedule', 'patient_appointments.appointmentTime')
            //             ->select('patient_appointments.appointmentDate','appointment_times.Shift','patient_appointments.appointmentTime')
            //             ->get();

            // $apntTime = DB::table('appointment_times')
            //             ->join('patient_appointments',  'patient_appointments.appointmentDate' ,'=', $date)
            //             ->get();

            // print_r($apntTime);

            // error_log($apntTime);

            // error_log($data);

            $total_row = $apntTime->count();
            if($total_row > 0){
                $AppointmentTimes = $apntTime;
            }
            else{
                $AppointmentTimes = 'Dr.'.$name.' is not Available on that Day';
            }
            // error_log($AppointmentTimes);
            return response()->json($AppointmentTimes);
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


            //Insert Data Into Patientlist_Mater Table First

            $patientlistMaster = new PatientlistMaster();

            $patientlistMaster->patientId = $patientId;
            $patientlistMaster->name = $patientName;
            $patientlistMaster->contact = $patientContact;
            $patientlistMaster->save();

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
        error_log($doctorTimes);
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
        echo $req->pId;
        echo $req->pName;

    }


    ####################################################################
    /* **********************End Patient Registration********************/
    ####################################################################


}
