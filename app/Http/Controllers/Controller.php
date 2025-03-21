<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function responseData($message,$data){
        return[
            "status"  => "Success",
            "message" => $message,
            "data"    => $data
        ];
    }
}
