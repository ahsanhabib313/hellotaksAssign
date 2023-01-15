<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function resetCredentials(Request $request){

        $email = $request->email;
        $password = $request->password;

        if(is_null($email) && is_null($password)){

            return back()->with('error', 'can not keep all fields empty..!');
        }

        if($email){
             $request->validate([
           
                    'email' => 'email',

                    ]);
        }

        if($password){
            $request->validate([
           
                    'password' => 'min:8',

                    ]);
        }
       
        $user = User::find(Auth::user()->id);

        if($email){
            $user->email = $email;
        }

        if($password){
            $user->password = Hash::make($password);
        }

        
        $update = $user->save();

        if($update){
            return back()->with('success', 'successfully updated');
        }else{
             return back()->with('error', 'Internal Server Error');
        }


    }
}
