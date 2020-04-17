<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;

class ReceptionController extends Controller
{
    public function index(){
        return view('Reception.index');
    }


    //Appointment Function
    public function appointment(){
        return view('Reception.Appointment');
    }

    function action(Request $req){
        if($req->ajax()){
            $output = '';
            $query = $req->get('query');

            error_log($query);
            if($query != ''){
                $doctorName = Doctor::where('Department', $query)->get();
                
                error_log($doctorName);
                // return redirect()->route('Reception.appointment')
                //                  ->with('doctorName', $doctorName);
            }
            else{
                $doctorName = Doctor::where('Department', 'Dental')->get();
                
                // return redirect()->route('Reception.appointment')
                //                  ->with('doctorName', $doctorName);
            }
        }
    }


}
