<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HRController extends Controller
{
    public function index(){
        return view('HR.index');
    }

    public function chart(){
        return view('HR.charts');
    }

    public function addDoctor(){
        return view('HR.AddDoctor');
    }
}
