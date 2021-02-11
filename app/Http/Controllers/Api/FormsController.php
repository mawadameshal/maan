<?php

namespace App\Http\Controllers\Api;

use App\Form;
use App\Citizen;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormResource;


class FormsController extends Controller{

    use ApiResponseTrait;

public function index(){
    $forms = FormResource::collection(Form::get());
    return $this->apiResponse($forms);
    
}

public function show($id){
    // $form = Form::find($id);   this is without a resource , so it will  return all fields of object 
    $form = new FormResource(Form::find($id));   // but here we will limit some fields to return
    if($form){
        
        return $this->apiResponse($form);

    }
    return $this->apiResponse(null ,'not found', 404);
}



}
