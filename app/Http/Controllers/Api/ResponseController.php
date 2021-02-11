<?php

namespace App\Http\Controllers\Api;

use App\Form;
use App\Form_file;
use App\Form_follow;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
		
class ResponseController extends Controller {

	use ApiResponseTrait;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$data = Validator::make($request->all(), [

			'fileinput' => 'max:2400|mimes:jpeg,bmp,png,gif,svg,pdf,docx,xls,xlsx,pdf',
			'notes' => 'required|max:300',
			'citizen_id' => 'required',
			'form_id' => 'required',

		]);
		$item = '';
		if (!$data->fails()) {
			$request['datee'] = date('Y-m-d');
			Form_follow::create($request->all());

			$form_id = $request['form_id'];

			if ($request->hasFile('fileinput')) {
				$myfile = $request->file('fileinput'); // جلد الجديد من الانبوت فورم
				$filename = rand(11111, 99999) . '.' . $myfile->getClientOriginalExtension(); // جلب اسمه
				$myfile->move(public_path() . '/uploads/', $filename); //يخزن الجديد في الموقع المحدد
				$item = Form_file::create(['form_id' => $form_id, 'name' => $filename, 'path' => 'uploads/']);

			}

			return $this->apiResponse('', $item, 200);

		}

		return $this->apiResponse('', $data->errors(), 200);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}
