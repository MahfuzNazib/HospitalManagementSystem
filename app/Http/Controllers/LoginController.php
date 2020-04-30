<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use App\Login;

class LoginController extends Controller
{
    public function index(){
        return view('Login.index');
    }

    public function verifyUser(Request $req){
        $username =  $req->username;
        $password =  $req->password;

        //Null Validation

        $this->validate($req,[
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = Login::where('username', '=', $username)
                    ->where('password', '=', $password)
                    ->first();
        
        if($user != null){
            if($user['type'] == 'Doctor'){
                echo 'Doctor Login Request';
            }
            if($user['type'] == 'Receiptionist'){
                return redirect()->route('Reception.index');
            }
        }
        else{
            return redirect()->route('Login.index')->with('msg', 'Invalid Username or Password');
        }
        
    }
}
