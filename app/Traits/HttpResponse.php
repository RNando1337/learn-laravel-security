<?php

namespace App\Traits;

trait HttpResponse
{
    public function apiResponseSuccess($message, $data = [], $code = 200){
        return response()->json([
            "status" => TRUE, 
            "response" => $code,
            "message" => $message,
            "data" => $data
        ], $code);
    }

    public function apiResponseErrors($message, $data = [], $code = 400){
        return response()->json([
            "status" => FALSE,
            "response" => $code, 
            "message" => $message,
            "errors" => $data
        ], $code);
    }
}