<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Category;
use App\Citizen;
use App\Form;
use App\Form_file;
use App\Http\Controllers\Account\NotificationController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CitizenResource;
use App\Http\Resources\FormResource;
use App\Http\Resources\SentTypeResource;
use App\Project;
use App\Rules\IdNumber;
use App\Sent_type;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class HomeController extends Controller {

	use ApiResponseTrait;

	public function index() {

		$posts = PostResource::collection(Post::all());

		return $this->apiResponse($posts);
	}

	public function search() {

		if (request('type') == 'id_number') {


			$data = Validator::make(request()->all(), [
				'keyword' => ['required', 'digits:9', new IdNumber],
			]);

			if ($data->fails()) {
				return $this->apiResponse('', 'not valid', 406);
			}

			$citizen = Citizen::where('id_number', request('keyword'))->first();

			if ($citizen) {

				$forms = $citizen->forms;
				$forms = FormResource::collection($forms);

				return $this->apiResponse($forms , '' , '200');
			}
							return $this->apiResponse('', 'not found', 404);

		} elseif (request('type') == 'id') {

            $contains = Str::contains(request('keyword'), '00970');
            if($contains){
                $id =  str_replace('00970', '', request('keyword'));
                $form = Form::find($id);
            }else{
                $form = '';
            }

			if ($form) {

				$form = [new FormResource($form)];

				return $this->apiResponse($form , '' , 200);
			}else{
				return $this->apiResponse('Not Found' , '' , 406 );
            }

		}

		return $this->apiResponse('Not Found', '', 404);

	}

	// public function search() {
	// 	if (request('type') == 'id_number') {

	// 		$data = Validator::make(request()->all(), [
	// 			'keyword' => ['required'],
	// 				]);

	// 		if ($data->fails()) {
	// 			return $this->apiResponse('', $data->errors(), 200);
	// 		}

	// 		$citizen = Citizen::where('id_number', request('keyword'))->first();

	// 		if ($citizen) {

	// 			$forms = $citizen->forms;
	// 			$forms = FormResource::collection($forms);

	// 			return $this->apiResponse($forms);
	// 		}

	// 	} elseif (request('type') == 'id') {

    //         $contains = Str::contains(request('keyword'), '00970');
    //         if($contains){
    //             $id =  str_replace('00970', '', request('keyword'));
    //             $form = Form::find($id);
    //         }else{
    //             $form = '';
    //         }

	// 		if ($form) {

	// 			$form = [new FormResource($form)];

	// 			return $this->apiResponse($form);
	// 		}

	// 	}

	// 	return $this->apiResponse('Not Found', '', 404);

	// }

	public function store() {
		$data = request()->all();

		$post = Post::create($data);

		$post = new PostResource($post);

		return $this->apiResponse($post);

	}
	public function suggestions($id) {
		if ($id == 0){
			$suggestions = Category::where('citizen_show',1)->where('is_complaint',0)->get(); //غير مستفيدين
			$categosuggestionsries = CategoryResource::collection($suggestions);
		   return $this->apiResponse($suggestions);
	   }

		$id = 1;
	   $suggestions = Category::where('benefic_show',1)->where('is_complaint',0)->get(); //مستفيدين
	   $suggestions = CategoryResource::collection($suggestions);

		return $this->apiResponse($suggestions);

   }



	 public function categories($id) {
	 	if ($id == 0){
	 		$categories = Category::where('citizen_show',1)->where('is_complaint',1)->get(); //غير مستفيدين
	 		$categories = CategoryResource::collection($categories);
			return $this->apiResponse($categories);
		}

	 	$id = 1;
		$categories = Category::where('benefic_show',1)->where('is_complaint',1)->get(); //مستفيدين
		$categories = CategoryResource::collection($categories);

	 	return $this->apiResponse($categories);

	}




	// public function categories() {

	// 	$categories = Category::all();

	// 	$categories = CategoryResource::collection($categories);

	// 	return $this->apiResponse($categories);

	// }

	public function sent_types() {

		$sent_types = Sent_type::all();

		$sent_types = SentTypeResource::collection($sent_types);

		return $this->apiResponse($sent_types);

	}

	public function citizen_search($id_number) {

        $validator = Validator::make(['id_number' => $id_number], [
            'id_number' => ['required', 'digits:9', new IdNumber],
        ]);
        if ($validator->fails()) {
            return $this->apiResponse('', $validator->errors(), 406);
        }

        $citizen = Citizen::where('id_number', $id_number)->first();

		if ($citizen) {
			$citizen = [new CitizenResource($citizen)];

			return $this->apiResponse($citizen , '' , 200);

		}

		return $this->apiResponse([], '', 404);

	}

	public function store_form(Request $request) {

		$data = Validator::make($request->all(), [
			'type' => 'required|integer|max:50',
			'sent_type' => 'required|numeric|digits_between:1,10',
			'project_id' => 'required|numeric|digits_between:1,10',
			'citizen_id' => 'required|numeric|digits_between:1,10',
			'title' => 'required|max:200',
			'category_id' => 'required|numeric|digits_between:1,10',
			'content' => 'required|max:1000',
			'fileinput' => 'max:6400|mimes:jpeg,bmp,png,gif,svg,pdf,docx,xls,xlsx',
			//'account_id' => 'numeric|digits_between:1,10',


		]);

		if ($data->fails()) {
			return $this->apiResponse('', $data->errors(), 200);
		}

		$request['status'] = 1;
		if ($request['type'] == 3) {
			$request['category_id'] = 1;
		}

		if ($request['type'] == 2) {
			$request['category_id'] = 2;
		}

		if (!Citizen::find($request['citizen_id']) || !Project::find($request['project_id'])
			|| $request['type'] < 1 || $request['type'] > 3) {

			return $this->apiResponse([] , 'Success', 400);

		}

        $request['datee'] = Carbon::now();

		$form_id = Form::create($request->all())->id;

		if ($request->hasFile('fileinput')) {
			$myfile = $request->file('fileinput'); // جلد الجديد من الانبوت فورم
			$filename = rand(11111, 99999) . '.' . $myfile->getClientOriginalExtension(); // جلب اسمه
			$myfile->move(public_path() . '/uploads/', $filename); //يخزن الجديد في الموقع المحدد
			Form_file::create(['form_id' => $form_id, 'name' => $filename, 'path' => 'uploads/']);
		}
		$theform = Form::find($form_id);

		if ($theform->project->account_projects->first() && $theform->category->circle_categories->first()) {
			$accouts_ids_in_circle = Account::WhereIn('circle_id', $theform->category->circle_categories->where('to_notify', 1)
					->pluck('circle_id')->toArray())->pluck('id')->toArray();
			$accouts_ids_in_project = $theform->project->account_projects->where('to_notify', 1)
				->pluck('account_id')->toArray();
			$accouts_ids = array_merge($accouts_ids_in_circle, $accouts_ids_in_project);

			$users_ids = Account::find($accouts_ids)->pluck('user_id');
			for ($i = 0; $i < count($users_ids); $i++) {
				if (User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id)) {
					NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'مواطن', 'title' => 'تم إضافة نموذج جديد', 'link' => "/citizen/form/show/" . Form::find($form_id)->citizen->id_number . "/$form_id"]);
					NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'مواطن', 'title' => 'تم إضافة نموذج جديد', 'link' => "/citizen/form/show/" . Form::find($form_id)->citizen->id_number . "/$form_id"]);
				}
			}

		}
		$form_id= $theform->id;
        $id_number =$theform->citizen->id_number;
		$citizen_msg= $theform->category->citizen_msg;
		$wait = $theform->category->citizen_wait;
		$all = [
			'id' => $form_id,
			'id_number' => $id_number,
			'citizen_msg' => $citizen_msg,
			'time' => $wait . ''
		];
        return $this->apiResponse([$all], 'Success', 200);
	}

	public function update_mobile($id) {

		$data = Validator::make(request()->all(), [
			'mobile' => 'required|max:20',
			'mobile2' => 'max:20',
		]);

		if ($data->fails()) {
			return $this->apiResponse([], $data->errors(), 404);
		}

		$citizen = Citizen::find($id);

		$citizen->update(['mobile' => request('mobile')]);
		$citizen->update(['mobile2' => request('mobile2')]);


		if ($citizen->has('projects')){
		    foreach ($citizen->projects as $project){
		        $project_id[] = $project->id;
		        $project_name[] = $project->name;
            }


        $project_id = [];
        $project_name = [];
        if ($citizen->projects->count() > 0){
            foreach ($citizen->projects as $project){
                $project_id[] = $project->id;
                $project_name[] = $project->name;
            }
        }

		// return $this->apiResponse([$citizen , $project_id , $project_name], 'Success', 200);
		return $this->apiResponse([$citizen] , 'Success', 200);
	}


	}}
