<?php

namespace App\Http\Controllers\Api;

use App\Message;
use App\Form_follow;
use App\Http\Resources\EvaluateResource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;


class EvaluateController extends Controller
{
    use ApiResponseTrait;

    public function index($id){
        	$evaluate = Form_follow::find($form_id); 
        		if ($evaluate) {
			$evaluate = new EvaluateResource($evaluate); // but here we will limit some fields to return

			return $this->apiResponse($evaluate);

		}
		
		return $this->apiResponse(null, 'not found', 404);

        		
        		    
        		
    
    }
}
