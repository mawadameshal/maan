<?php

namespace App\Http\Controllers\Api;

use App\Form;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShowFormResource;

class ShowFormController extends Controller {
	use ApiResponseTrait;
	public function show($id) {
		// $form = Form::find($id);   this is without a resource , so it will  return all fields of object

		$form = Form::find($id); // but here we will limit some fields to return

		if ($form) {
			$showform = new ShowFormResource($form); // but here we will limit some fields to return

			return $this->apiResponse($showform);

		}
		return $this->apiResponse(null, 'not found', 404);
	}

}
