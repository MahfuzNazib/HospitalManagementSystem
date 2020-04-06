<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use App\AppointmentTime;
use PhpParser\Comment\Doc;
use SebastianBergmann\Environment\Console;

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
            'name'       => 'required',
            'dob'        => 'required',
            'gender'     => 'required',
            'phone'      => 'required|max:12|min:11',
            'email'      => 'required|email',
            'department' => 'required',
            'specialist' => 'required',
            // 'time'       => 'required',
            'visitingFee'=> 'required',
            'department' => 'required',
            'comission'  => 'required',
            'closingDay' => 'required',
        ]);

        //Insert Data into Doctors DB Table

        $doctor = new Doctor;
        $doctor->Name       = $req->name;
        $doctor->DOB        = $req->dob;
        $doctor->Gender     = $req->gender;
        $doctor->Phone      = $req->phone;
        $doctor->Emergency  = $req->emergency;
        $doctor->Email      = $req->email;
        $doctor->Address    = $req->address;
        $doctor->Department = $req->department;
        $doctor->Specialist = $req->specialist; 
        // $doctor->VisitingHour = $req->time;
        $doctor->VisitingFee = $req->visitingFee;
        $doctor->Commission  = $req->comission;
        $doctor->ClosingDay  = $req->closingDay;

        // Insert Profile Picture

        if($req->hasFile('profile')){
			$file = $req->file('profile');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extension;
            
            $file->move('uploads/',$filename);
            $doctor->ProfilePicture = $filename;

		}else{
            return $req;
            $doctor->ProfilePicture = null;
		}

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

        $doctorList = Doctor::paginate(10);
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
    public function doctorProfile($DoctorId){
        $doctor = Doctor::find($DoctorId);
        return view('HR.DoctorProfile',$doctor);
    }

    //Edt Doctor Profile
    public function editDoctor($DoctorId){
        $doctor = Doctor::find($DoctorId);
        return view('HR.EditDoctor',$doctor);
    }

    //Update Doctor
    public function updateDoctor($DoctorId, Request $req){
        $doctor = Doctor::find($DoctorId);

        $this->validate($req,[
            'name'       => 'required',
            'dob'        => 'required',
            'gender'     => 'required',
            'phone'      => 'required|max:12|min:11',
            'email'      => 'required|email',
            'department' => 'required',
            'specialist' => 'required',
            // 'time'       => 'required',
            'visitingFee'=> 'required',
            'department' => 'required',
            'comission'  => 'required',
            'closingDay' => 'required',
        ]);

        $doctor->Name       = $req->name;
        $doctor->DOB        = $req->dob;
        $doctor->Gender     = $req->gender;
        $doctor->Phone      = $req->phone;
        $doctor->Emergency  = $req->emergency;
        $doctor->Email      = $req->email;
        $doctor->Address    = $req->address;
        $doctor->Department = $req->department;
        $doctor->Specialist = $req->specialist; 
        // $doctor->VisitingHour = $req->time;
        $doctor->VisitingFee = $req->visitingFee;
        $doctor->Commission  = $req->comission;
        $doctor->ClosingDay  = $req->closingDay;

        

        $doctor->save();

        return redirect()->route('HR.editDoctor',$DoctorId)
                        ->with('msg','Doctor Successfully Updated');
    }

    //Upload Doctor Profile Picture
    public function profilePicture(Request $req){
        if($req->hasFile('profile')){
			$file = $req->file('profile');
			echo "File Name: ". $file->getClientOriginalName()."<br>";
			echo "File Extension: ". $file->getClientOriginalExtension()."<br>";
			echo "File Size: ". $file->getSize()."<br>";
			echo "File Mime Type: ". $file->getMimeType();

			if($file->move('uploads', "abc.".$file->getClientOriginalExtension())){
				echo "<h1>success</h1>";
			}else{
				echo "<h1>Error!</h1>";
			}

		}else{
			echo "File not found!";
		}
    }

    //Doctor Appointment Timing

    public function timing(){
        return view('HR.DoctorTiming');
    }

    public function search($DoctorId){
        $doctor = Doctor::find($DoctorId);
        return view('HR.DoctorTiming',$doctor);

        // return view('HR.DoctorTiming',['doctors' => $doctorList]);

    }


    //Doctor Appointment Timing Scedule Function
    public function schedule($DoctorId, Request $req){
        
        $DoctorId  = $req->dId; //Get Doctor Id
        $Name = $req->name; //Get Doctor Name
        $shift = $req->shift; //Get Shift
        $Day = $req->selectDay; //get Day
        $startingTime = $req->startingTime;
        $duration = $req->duration;
        $endTime = $req->endTime;
        $presetTime = $req->presetTime;


        //Insert Data
        $AppTime = new AppointmentTime;

        $AppTime->DrId = $DoctorId;
        $AppTime->DrName = $Name;
        $AppTime->DayName = $Day;

        $NOP = $duration / $presetTime; //Get Total Number of Patient

        $starts = $startingTime;
        $startingHour = str_split($starts,2);
        $startingMin = str_split($starts,3);
        
        $ends = $endTime;

        $endingHour = str_split($ends,2);
        $endingMin = str_split($ends,3);
        
        $st = $startingHour[0];
        $et = $endingHour[0];

        $sm = $startingMin[1];
        $em = $endingMin[1];

        $finishHour; //Extra Variable Taken for Hour Counting
        $finishMin;  //Extra Variable taken for Minute Counting
        $amPm;  //Extra Variable Taken for Set AM or PM 
        $Timing; //Final Timing
        if($shift == "Evening"){
            $amPm = "PM";
        }
        else{
            $amPm = "AM";
        }
        
        for($i = 0; $i< $NOP ; $i++){
            
            $finishHour = $st;
            $finishMin = $sm + $presetTime;

            if($finishHour > 12){
                $finishHour = $finishHour - 12;
            }
            
            //Check AM or PM on Globally;
            if($finishHour > 11){
                $amPm = "PM";
            }
            if($finishMin == 60){


                $finishHour = $st+1;
                $finishMin = 0;
                $Timing = $st.":".$sm." ".$amPm." - ".$finishHour.":".$finishMin."0"." ".$amPm;
                echo $Timing;
                $AppTime->TimeSchedule = $Timing;
                $AppTime->save();
                echo "<br>";
            }
            else{
                
                $Timing = $finishHour.":".$sm." ".$amPm." - ".$finishHour.":".$finishMin." ".$amPm;
                echo $Timing;
                $AppTime->TimeSchedule = $Timing;
                $AppTime->save();
                echo "<br>";
            }
                
            $st = $finishHour;
            $sm = $finishMin;
        }

        $AppTime->save();

        // return redirect()->route('HR.search',$DoctorId);
        
    }
}