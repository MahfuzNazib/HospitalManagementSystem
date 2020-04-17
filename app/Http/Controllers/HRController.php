<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doctor;
use App\Employee;
use App\AppointmentTime;
use App\AppointmentTimeMaster;
use App\HospitalTest;
use DB;
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


    //********************************************************* */
    //********************Start Doctor Module******************* */
    //********************************************************* */


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


    //View All Doctor List from Doctors Table
    public function doctorList(){

        $doctorList = Doctor::paginate(10);
        return view('HR.DoctorList',['doctors' => $doctorList]);
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
        $doctor->VisitingFee = $req->visitingFee;
        $doctor->Commission  = $req->comission;
        $doctor->ClosingDay  = $req->closingDay;

        $doctor->save();

        return redirect()->route('HR.editDoctor',$DoctorId)
                        ->with('msg','Doctor Successfully Updated');
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

        //Get Total Time Duration
        if($st > 12){
            $st = $st-12;
            $totalDuration = $st.":".$sm." ".$amPm." - ".$et.":".$em." ".$amPm;

        }
        else{
            $totalDuration = $st.":".$sm." ".$amPm." - ".$et.":".$em." ".$amPm;
        }

        //Data Insert into AppointmentTimeMaster Table
        $AppTimeMaster = new AppointmentTimeMaster;

        $AppTimeMaster->DrId = $DoctorId;
        $AppTimeMaster->DrName = $Name;
        $AppTimeMaster->Shift = $shift;
        $AppTimeMaster->TimeDuration = $totalDuration;
        $AppTimeMaster->DayName = $Day;
        $AppTimeMaster->save();


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
                

                $AppTime = new AppointmentTime;

                $AppTime->DrId = $DoctorId;
                $AppTime->DrName = $Name;
                $AppTime->DayName = $Day;
                $AppTime->TimeSchedule = $Timing;
                $AppTime->Shift = $shift;
                $AppTime->TotalDuration = $totalDuration;
                $AppTime->save(); 
                echo "<br>";
            }
            else{
                
                $Timing = $finishHour.":".$sm." ".$amPm." - ".$finishHour.":".$finishMin." ".$amPm;
                
                $AppTime = new AppointmentTime;

                $AppTime->DrId = $DoctorId;
                $AppTime->DrName = $Name;
                $AppTime->DayName = $Day;
                $AppTime->TimeSchedule = $Timing;
                $AppTime->Shift = $shift;
                $AppTime->TotalDuration = $totalDuration;
                $AppTime->save();
                echo "<br>";
            }
                
            $st = $finishHour;
            $sm = $finishMin;
        }

        $AppTime->save();

        return redirect()->route('HR.search',$DoctorId);
        
    }


    //Doctor Appointment Timing

    public function timing(){
        return view('HR.DoctorTiming');
    }

    public function search($DoctorId){
        $doctor = Doctor::find($DoctorId);

        //getTime List
        $timeList = AppointmentTime::where('DrId', $DoctorId)->paginate(6);
        $timeDuration = AppointmentTimeMaster::where('DrId',$DoctorId)->paginate(8);
        
        return view('HR.DoctorTiming',['doctor'=> $doctor, 'timeList'=> $timeList, 'timeDuration'=>$timeDuration]);
    }



    ####################################################################
    /* **********************End Doctor Module *************************/
    ####################################################################



    ####################################################################
    /* **********************Start Employee Module ********************/
    ####################################################################

    
    // View Add Employee Page
    public function addEmployee(){
        return view('HR.AddEmployee');
    }

    //Insert New Employee
    public function insertEmployee(Request $req){
        //Form Validation
        $this->validate($req, [
            'name'        => 'required',
            'dob'         => 'required',
            'gender'      => 'required',
            'phone'       => 'required|max:11|min:11',
            'email'       => 'required|email',
            'designation' => 'required',
            'monthlyfee'  => 'required|max:10',
            'address'     => 'required',
        ]);

        //Insert Data in Employees Table
        $emp = new Employee();
        $emp->name        = $req->name;
        $emp->dob         = $req->dob;
        $emp->gender      = $req->gender;
        $emp->phone       = $req->phone;
        $emp->email       = $req->email;
        $emp->designation = $req->designation;
        $emp->monthlyfee  = $req->monthlyfee;
        $emp->address     = $req->address;

        $emp->save();
        
        $designation = $req->designation;
        if($designation == "HR"){
            return redirect()->route('HR.hrList')
                        ->with('msg', 'Employee Successfully Added');
        }

        if ($designation == "Manager") {
            
        }

        if ($designation == "Receiptionist") {
            return redirect()->route('HR.receiptionistList')
                        ->with('msg', 'Receiptionist ['.$req->name.'] Successfully Added');
        }

    }

    
    /****************************HR Dept Employee Module ******************************************/

    //Get All HR Employee Lists
    public function hrList(){
        $hr = Employee::where('designation', 'HR')->paginate(10);
        return view('HR.HRList',['hr' => $hr]);
    }


    /*******************************End HR Dept Employee Module ***********************************/
    

    /******************************Receptionist Employee Module *********************************/
    
    //View Receptionist List Page
    public function receiptionistList(){
        $reception = Employee::where('designation' , 'Receiptionist')->paginate(10);
        return view('HR.ReceiptionistList',['reception' => $reception]);
    }

    
    /********************End Receptionist Employee Module *******************/
    

    ####################################################################
    /* **********************End Employee Module **********************/
    ####################################################################



    ####################################################################
    /* **********************Hospital Test Module **********************/
    ####################################################################


    //View New Hospital Test
    public function newTest(){
        return view('HR.AddTest');
    }

    //Insert New Test
    public function insertTest(Request $req){
        $this->validate($req, [
            'testName'      => 'required',
            'testShortName' => 'required',
            'testCost'      => 'required'
        ]);

        $test = new HospitalTest();

        $test->addingDate = $req->addingDate;
        $test->testName = $req->testName;
        $test->testShortName = $req->testShortName;
        $test->testCost = $req->testCost;

        $test->save();

        return redirect()->route('HR.testList')->with('msg','Test Added Successfully Done !');
    }

    //View Test List Page
    public function testList(){
        return view('HR.TestList');
    }

    //Search Test
    function action(request $request){
        if($request->ajax()){
            $output = '';
            $query = $request->get('query');
            // error_log($query);
            if($query != ''){
                $data = DB::table('hospital_tests')
                        -> where('testName','like','%'. $query .'%')
                        ->orWhere('testShortName','like','%'.$query.'%')
                        ->orWhere('Id','like','%'.$query.'%')
                        ->get();
            }
            else{
                $data = DB::table('hospital_tests')->get();
            }
            $total_row = $data->count();
            if($total_row > 0){
                foreach($data as $row){
                    $output .= '
                        <tr>
                            <td>'.$row->Id.'</td>
                            <td>'.$row->addingDate.'</td>
                            <td>'.$row->testName.'</td>
                            <td>'.$row->testShortName.'</td>
                            <td>'.$row->testCost.'</td>
                            <td>
                                <a href="/HR/EditTest/'.$row->Id.'">
                                    <input type="submit" class="btn btn-info" value="Edit">
                                </a>

                                <a href="/HR/TestList">
                                <input type="submit" class="btn btn-danger" value="Delete" data-toggle="model" data-target="#logoutModel">
                                </a>
                            </td>
                        </tr>
                    ';
                }
            }
            else{
                $output = '
                    <tr>
                        <td align="center" colspan="5"> No Data Found  </td>
                    </tr>
                ';
            }

            $data = array(
                'table_data'    => $output
            );

            echo json_encode($data);
        }
    }


    //Edit Test List
    public function editTest($Id){
        $testInfo = HospitalTest::find($Id);
        return view('HR.EditTest',['testInfo' => $testInfo]);
    }


    //Update test 
    public function updateTest($Id, Request $req){
        //Validate Edit Test Information
        $this->validate($req, [
            'addingDate'    => 'required',
            'testName'      => 'required',
            'testShortName' => 'required',
            'testCost'      => 'required'
        ]);

        $testInfo = HospitalTest::find($Id);

        $testInfo->addingDate       =   $req->addingDate;
        $testInfo->testName         =   $req->testName;
        $testInfo->testShortName    =   $req->testShortName;
        $testInfo->testCost         =   $req->testCost;

        $testInfo->update();

        return redirect()->route('HR.testList')->with('msg', 'Test Successfully Updated');
    }



    #########################################################################
    /* **********************End Hospital Test Module **********************/
    #########################################################################


    #########################################################################
    /* ***************************Notice Module ****************************/
    #########################################################################
    public function notice(){
        $date = date('Y-m-d H:i:s');
        return view('HR.Notice');
    }

    #########################################################################
    /* ************************End Notice Module ****************************/
    #########################################################################
    

    //Manager List

    public function managerList(){
        return view('HR.ManagerList');
    }

    
}