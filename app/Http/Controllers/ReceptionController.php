<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceptionController extends Controller
{
    public function index(){
        return view('Reception.index');
    }


    //Appointment Function
    public function appointment(){
        return view('Reception.Appointment');
    }
}
