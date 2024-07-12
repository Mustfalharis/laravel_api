<?php

namespace App\Http\Controllers\Helpers;
class ApiResponse
{
    public static function success($data, $status = true, $statusCode = 200)
    {
        $data = [
            "status" => $status,
            "data" => $data
        ];
        return response()->json($data, $statusCode);
    }

    public static function error($message, $statusCode)
    {
        return response()->json(['status'=>'error','message' => $message,], $statusCode);
    }
    public static function Message($message,$status,$statusCode)
    {
        return response()->json(["status"=>$status,'message' => $message,], $statusCode);
    }



}
