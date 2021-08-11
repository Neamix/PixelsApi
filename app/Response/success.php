<?php

namespace App\Response;


class success
{
  private $workArray = [];
    
  static function success($success,$user='',$token='') {
     return [
       'message' => $success,
       'User'    => $user,
       'token'   => $token
     ];
  }
}