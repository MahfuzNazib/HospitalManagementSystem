<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use App\HospitalDepartment;
use DB;

class ReceptionController extends Controller
{
    public function index(){
        return view('Reception.index');
    }


    //Appointment Function
    public function appointment(){
        $dept = HospitalDepartment::all();
        return view('Reception.Appointment',['dept' => $dept]);
    }

    // function findDoctor(Request $req){
    //     $doctor = Doctor::where('Department',)
    // }
    function action(Request $req){
        if($req->ajax()){
            $query = $req->get('query');

            error_log($query);
            if($query != ''){
                //Select Name FROM doctors WHERE Department = $query;
                //Select Only Name Column from Doctors Table;
                $doctorName = Doctor::where('Department', $query)->get(['Name']);

                error_log($doctorName);
                return response()->json($doctorName);
            }
            
        }
    }


}
