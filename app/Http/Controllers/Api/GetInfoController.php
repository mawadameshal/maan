<?php

namespace App\Http\Controllers\Api;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GetInfoResource;





class GetInfoController extends Controller
{
    use ApiResponseTrait;

    public function index(){
        $Info = GetInfoResource::collection(Company::get());
        return $this->apiResponse($Info);
        
    }

    
}
