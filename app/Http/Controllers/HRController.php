<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;

class HRController extends Controller
{
    public function index(){
        return view('HR.index');
    }

    public function chart(){
        return view('HR.charts');
    }

    //View Add Doctor Page
    public function addDoctor(){
        return view('HR.AddDoctor');
    }

    //Insert New Doctor
    public function insertDoctor(Request $req){
        //Validation
        $this->validate($req,[
            'name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'phone' => 'required|max:12|min:11',
            'email' => 'required|email',
            'department' => 'required',
            'specialist' => 'required',
            'time' => 'required',
            'visitingFee' => 'required',
            'department' => 'required',
            'comission' => 'required',
            'closingDay' => 'required',
        ]);

        //Insert Data into Doctors DB Table

        $doctor = new Doctor;
        $doctor->Name = $req->name;
        $doctor->DOB = $req->dob;
        $doctor->Gender = $req->gender;
        $doctor->Phone = $req->phone;
        $doctor->Emergency = $req->emergency;
        $doctor->Email = $req->email;
        $doctor->Address = $req->address;
        $doctor->Department = $req->department;
        $doctor->Specialist = $req->specialist; 
        $doctor->VisitingHour = $req->time;
        $doctor->VisitingFee = $req->visitingFee;
        $doctor->Commission = $req->comission;
        $doctor->ClosingDay = $req->closingDay;

        $doctor->save();

        return redirect()->route('HR.addDoctor')
                        ->with('msg','Doctor Added Successfully Done');
    }

    public function addEmployee(){
        return view('HR.AddEmployee');
    }

    public function notice(){
        $date = date('Y-m-d H:i:s');
        return view('HR.Notice');
    }

    //View All Doctor List from Doctors Table
    public function doctorList(){

        $doctorList = Doctor::paginate(3);
        return view('HR.DoctorList',['doctors' => $doctorList]);
    }

    //Employee List
    public function hrList(){
        return view('HR.HRList');
    }

    //Manager List

    public function managerList(){
        return view('HR.ManagerList');
    }

    public function receiptionistList(){
        return view('HR.ReceiptionistList');
    }
    //View Doctor Profile
    public function doctorProfile(){
        return view('HR.DoctorProfile');
    }

    //Edt Doctor Profile
    public function editDoctor(){
        return view('HR.EditDoctor');
    }
}