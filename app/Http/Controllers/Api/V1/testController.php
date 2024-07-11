<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use Illuminate\Http\Request;

class testController extends Controller
{

    
   public function index(){
    return ApiResponse::Message("hi",true,200);
   }
}
