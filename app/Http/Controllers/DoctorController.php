<?php

namespace App\Http\Controllers;

use App\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function index(){
        return view('Doctor.Index');
    }

    //Profile 
    public function myProfile()
    {
        $username = session('username');
        $password = session('password');
        $userInformation = DB::table('logins')
                        ->join('doctors', 'doctors.email', '=', 'logins.email')
                        ->where('logins.username', '=', $username)
                        ->where('logins.password', '=', $password)
                        ->get();
        return view('Doctor.MyProfile',['userInformation' => $userInformation]);
    }

    public function editProfile($DoctorId){
        $editUser = Doctor::find($DoctorId);
        error_log($editUser);
        return view('Doctor.EditProfile',$editUser);
        error_log('Function Called');
    }

    public function editInformations($DoctorId, Request $req){
        $this->validate($req,[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'address' => 'required'
        ]);

        $email = $req->email;
        $phone = $req->phone;
        $name = $req->name;
        $empId = $req->empId;

        $update = Doctor::find($DoctorId);
        $update->Name = $name;
        $update->Email = $email;
        $update->Phone = $phone;
        $update->DOB = $req->dob;
        $update->Address = $req->address;

        //Update Profile Picture
        if($req->hasFile('profilePicture')){
			$file = $req->file('profilePicture');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.' .$extension;
            
            $file->move('uploads/',$filename);
            $update->ProfilePicture = $filename;

		}else{
            $update->ProfilePicture = $req->defaultPicture;
        }
        $update->save();

        //Update Login Table
        $updateLogin = [
            'email' => $email,
            'phone' => $phone
        ];
        DB::table('logins')
            ->where('empId', '=', $empId)
            ->update($updateLogin);

        return redirect()->route('Reception.editProfile',$DoctorId)->with('msg', 'Successfully Updated');
    }

    public function settings(){
        $username = session('username');
        $password = session('password');
        $userInformation = DB::table('logins')
                        ->join('doctors', 'doctors.email', '=', 'logins.email')
                        ->where('logins.username', '=', $username)
                        ->where('logins.password', '=', $password)
                        ->get();

        return view('Doctor.Settings',['userInformation' => $userInformation]);
        // return view('Doctor.Settings');
    }
}
