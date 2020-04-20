<?php

namespace App\Http\Controllers;

use Carbon\Carbon; //Use Package for Date and Time;
use Illuminate\Http\Request;
use App\Doctor;
use App\HospitalDepartment;
use App\AppointmentTime;
use DateTime;
use DB;

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
        return view('Reception.Appointment',['dept' => $dept]);
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
            error_log('DrName = '.$name);
            error_log('Day    = '.$day);  
            error_log('Dept   = '.$dept);

            $apntTime = AppointmentTime::where([
                                        ['DrName', '=', $name],
                                        ['DayName', '=', $day]
            ])->get(['Id', 'Shift','TimeSchedule']);

            $total_row = $apntTime->count();
            error_log($total_row);
            if($total_row > 0){
                $AppointmentTimes = $apntTime;
            }
            else{
                $AppointmentTimes = 'Dr.'.$name.' is not Available on that Day';
            }
            error_log($AppointmentTimes);
            return response()->json($AppointmentTimes);
        }
    }

    ####################################################################
    /* **********************End Doctors Appointment********************/
    ####################################################################


}
