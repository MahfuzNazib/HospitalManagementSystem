<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class LoginController extends Controller
{
    public function index(){
        return view('Login.index');
    }

    public function verifyUser(Request $req){
        if($req->username == $req->password){
            return redirect('/admin');
        }
        else{
            // return redirect('/login');
            echo "Invalid Username or Password";
        }
    }
}