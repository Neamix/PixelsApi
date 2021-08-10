<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class adminController extends Controller
{ 
    /**
     * admin : promote user to admin 
     * requirement : admin token
     */
    public function admin(Request $request) {
        if($request->user()->role == 1) {
           $user = User::find($request->userid);
           if($user !== null) {
            $user->role = '1';
            $user->save();
            return ['message'=> 'success'];
           } else {
            return ['message'=>'Failed to find User'];
           }
        } else {
           return ['message'=>'Unauthorized'];
        }
    } 

}
