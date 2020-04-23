<?php

namespace App\Http\Controllers;

use Carbon\Carbon; //Use Package for Date and Time;
use Illuminate\Http\Request;
use App\Doctor;
use App\HospitalDepartment;
use App\AppointmentTime;
use App\PatientAppointment;
use App\PatientlistMaster;
// use DB;
use Illuminate\Support\Facades\DB;

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

            // error_log($query);
            if($query != ''){
                $doctorName = Doctor::where('Department', $query)->get(['Name']);

                // error_log($doctorName);
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

    ####################################################################
    /* **********************End Doctors Appointment********************/
    ####################################################################



    ####################################################################
    /* **********************Patient Registration**********************/
    ####################################################################

    public function registration(){
        return view('Reception.PatientRegistration');
    }


    ####################################################################
    /* **********************End Patient Registration********************/
    ####################################################################


}
