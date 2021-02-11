<?php

namespace App\Http\Controllers\Api;

use App\Form;
use App\Citizen;

use App\Rules\IdNumber;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Resources\CreateCitizenResource;
use Validator;


class CreateCitizenController extends Controller{

    use ApiResponseTrait;

    public function store(Request $request){

        $data = Validator::make(request()->all(), [
            'id_number' => ['required', 'digits:9', new IdNumber , 'unique:citizens,id_number' ]
        ]);
        
        $data1 = Validator::make(request()->all(), [
            'id_number' => 'required',
            'first_name' => 'required',
            'father_name'=> 'required',
            'grandfather_name'=> 'required',
            'last_name'=> 'required',
            'governorate' => 'required',
            'city'=> 'required',
            'street'=> 'required',
            'mobile'=> 'sometimes|nullable',
            'mobile2'=> 'sometimes|nullable',
            'add_byself'=> 'sometimes|nullable',
            'email'=> 'sometimes|nullable',
        ]);
            $request['add_byself'] = 1 ;

        if ($data->fails()) {
            return $this->apiResponse([], $data->errors(), 406);
        }

     if ($data1->fails()) {
                return $this->apiResponse([], $data->errors(), 400);
            }
            
        $CitizenData = Citizen::create($request->all());
        if($CitizenData){

            return $this->apiResponse([$CitizenData],null,201);
        }

        return $this->apiResponse([] ,'not found', 404);

    }
/*
public function index(){
    $forms = FormResource::collection(Form::get());
    return $this->apiResponse($forms);

}*/
/*
public function show($id){
    // $form = Form::find($id);   this is without a resource , so it will  return all fields of object
    $form = new FormResource(Form::find($id));   // but here we will limit some fields to return
    if($form){

        return $this->apiResponse($form);

    }
    return $this->apiResponse(null ,'not found', 404);
}*/





}
