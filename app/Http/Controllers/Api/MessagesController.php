<?php

namespace App\Http\Controllers\Api;

use App\Message;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;


class MessagesController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request){
    
        $message = Message::create($request->all());
        if($message){
        
            return $this->apiResponse($message,null,201);
        }
        return $this->apiResponse(null ,'not found', 400);

    }
}
