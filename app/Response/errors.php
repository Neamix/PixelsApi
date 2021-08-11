<?php

namespace App\Response;
use Illuminate\Http\Request;



class errors
{
    
    static function error($validate) 
    {
       return [
           'message' => 'failed',
           'validation' => $validate->errors()->all()
       ];
    }

}