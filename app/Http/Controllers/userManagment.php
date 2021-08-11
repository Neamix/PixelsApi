<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Response\errors;
use App\Response\rules;
use App\Response\success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 

class userManagment extends Controller
{
    
   
    public function update(User $user,Request $request) {

        $user = $request->user();

        $validator = Validator::make($request->all(),rules::updateRules());

        if($validator->fails()) {
            return response()->json(errors::error($validator));
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

    public function login(Request $request)
    {
 
        $validator = Validator::make($request->all(),rules::loginRules());
        if($validator->fails()) {
            return response()->json(errors::error($validator));
        }

        else {

            if(Auth::attempt($request->only(['email','password']))) {
            
                $token = $request->user()->createToken('token')->plainTextToken; 

                return response()->json([
                    'message'=>'success',
                    'User' => Auth::user(),
                    'token'=>$token
                ]);

            } else {

                return response()->json([
                    'login' => 'wrong credintions'
                ]);

            }

        }

    }
   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),rules::registerRules());

        if($validator->fails())  {
            return response()->json(errors::error($validator));
        } else {

            $user = User::create([
                'email' => $request->email,
                'name'  => $request->name,
                'password' => password_hash($request->password,PASSWORD_BCRYPT)
            ]);

            Auth::attempt($request->only(['email','password']));
            $token = $request->user()->createToken('token')->plainTextToken; 
            return  response()->json(success::success('success',Auth::user(),$token));

        }
    }

    public function logout(Request $request) 
    {
        $token = $request->user()->currentAccessToken()->delete();
        return true;
    }

    public function reset(Request $request) {
        $userOldPassword = $request->user()->password;

        if(password_verify($request->oldpassword,$userOldPassword)) {
            $validation = Validator::make($request->all(),[
                'password' => 'required|confirmed',
            ]);

            if ($validation->fails())  {
                return response()->json(errors::error($validation));
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


}
