<?php

namespace App\Http\Helpers;

class ApiResponse
{
    public static function success($listData = [], $status = true, $statusCode = 200)
    {
        $data = [
            "status" => $status,
            "data" => $listData
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
