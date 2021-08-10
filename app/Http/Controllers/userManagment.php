<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class userManagment extends Controller
{
    
    public function reset(Request $request) {
        $userOldPassword = $request->user()->password;
        if(password_verify($request->oldpassword,$userOldPassword)) {
            $validation = Validator::make($request->all(),[
                'password' => 'required|confirmed',
            ]);

            if ($validation->fails())  {
                return response()->json([
                    'validation' => $validation->messages()
                ]);
            } else {
               $request->user()->password = Hash::make($request->password);
               $request->user()->save();
               return response()->json([
                   'message' => 'password has been changed'
               ]);
            }

        } else {
            return response()->json([
                'message' => 'failed to change password'
            ]);
        }
    }

    public function update(User $user,Request $request) {
        $user = $request->user();
        $validator = Validator::make($request->all(),[
            'name' => 'min:3|max:20',
            'email' => 'unique:users|email',
            'password' => 'min:8|max:20|confirmed'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message'    => 'failed',
                'validFailsMessage'=>$validator->messages()
            ]);
        }

        $user->update($request->all());

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function snip(Request $request) {
        $user = $request->user();
        return $user;
    }

    public function index(Request $request)
    {
        //add validation rules and check the request inputs
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        //send fails messages in case of failing to validate
        if($validator->fails()) {
            return response()->json([
                'login' => 'fail',
                'validFailsMessage'=>$validator->messages()
            ]);
        }

        else {

            //try to loged in by the givin credintions
            if(Auth::attempt($request->only(['email','password']))) {
            
                $token = $request->user()->createToken('token')->plainTextToken; 

                return response()->json([
                    'login'=>'success',
                    'User' => Auth::user(),
                    'token'=>$token
                ]);

            } else {
                //in case of wrong credintions send fail

                return response()->json([
                    'login' => 'wrong credintions'
                ]);

            }

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|max:20',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|max:20|confirmed'
        ]);

        if($validator->fails())  {

            return response()->json([
                'register'=>'fail',
                'validations'=>$validator->messages()
            ]);

        } else {
            
            $user = User::create([
                'email' => $request->email,
                'name'  => $request->name,
                'password' => password_hash($request->password,PASSWORD_BCRYPT)
            ]);


            Auth::attempt($request->only(['email','password']));

            $token = $request->user()->createToken('token')->plainTextToken; 

            return  response()->json([
                'register' => 'success',
                'User' => Auth::user(),
                'token' => $token
            ]);

        }
    }

    /**
     *  Logout : destroy the current token
     */

    public function logout(Request $request) 
    {
        $token = $request->user()->currentAccessToken()->delete();

        return true;
    }

}
