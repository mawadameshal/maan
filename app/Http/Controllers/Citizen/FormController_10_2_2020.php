<?php

namespace App\Http\Controllers\Citizen;

use App\Account;
use App\Category;
use App\MainCategory;
use App\Citizen;
use App\Form;
use App\Form_file;
use App\Form_follow;
use App\Form_status;
use App\Form_type;
use App\Http\Controllers\Account\NotificationController;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormsRequest;
use App\Notification;
use App\Project;
use App\Recommendation;
use App\Rules\IdNumber;
use App\Sent_type;
use App\User;
use Illuminate\Http\Request;
use PDF;
use Session;
use Illuminate\Support\Str;

class FormController extends Controller {
	public function show($ido, $id) {

		$item = Form::find($id);

		if ($item == NULL) {
			Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
			return redirect('/noaccses');
		}
		if (auth()->user()) {
			$item->read = 1;
			$item->save();
			Notification::where('link', "/citizen/form/show/" . $item->citizen->id_number . "/$item->id")->where('user_id', auth()->user()->id)->update(['read_at' => date('Y-m-d h:m:s')]);
		}
		if (request()['theaction'] == 'print') {
			$responses = Form::find($id)->form_response;
			$follows = Form::find($id)->form_follow;

			$pdf = PDF::loadView('account.form.printshow2', compact('item', 'responses', 'follows'));

			return $pdf->stream('' . $item->name . 'form.pdf');

		} else {

			if (auth()->user()) {
				$categories = auth()->user()->account->circle->category->all();
			} else {
				$categories = Category::all();
			}

			$itemco = \App\Company::all()->first();
            $form_type = Form_type::all();
            $type = $item->type;
			if ($item->citizen->id_number == $ido) {
				return view("citizen.form-show", compact('item', 'categories', 'itemco','form_type','type'));
			} else {
				return view("citizen.noaccses", compact('item', 'itemco','form_type','type'));
			}

		}

	}

	public function save_form_followup($id , Request $request) {
	    $item = Form::find($id);
	    if ($item == NULL) {
			Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
			return redirect('/noaccses');
		}

		if ($request['theaction'] == 'print') {
			$responses = Form::find($id)->form_response;
			$follows = Form::find($id)->form_follow;
			$pdf = PDF::loadView('account.form.printshow2', compact('item', 'responses', 'follows'));
			return $pdf->stream('' . $item->name . 'form.pdf');
		}
        elseif ($request['theaction'] == 'save'){
		    if($request['optradio'] == 1){
		        print_r('test');exit();
            }

        } else {

			if (auth()->user()) {
				$categories = auth()->user()->account->circle->category->all();
			} else {
				$categories = Category::all();
			}

			$itemco = \App\Company::all()->first();
            $form_type = Form_type::all();
            $type = $item->type;
			if ($item->citizen->id_number == $ido) {
				return view("citizen.form-show", compact('item', 'categories', 'itemco','form_type','type'));
			} else {
				return view("citizen.noaccses", compact('item', 'itemco','form_type','type'));
			}

		}

	}

	public function show1($ido, $id) {

		$item = Form::find($id);

		if ($item == NULL) {
			Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
			return redirect('/noaccses');
		}
		if (auth()->user()) {
			$item->read = 1;
			$item->save();
			Notification::where('link', "/citizen/form/show/" . $item->citizen->id_number . "/$item->id")->where('user_id', auth()->user()->id)->update(['read_at' => date('Y-m-d h:m:s')]);
		}
		if (request()['theaction'] == 'print') {
			$responses = Form::find($id)->form_response;
			$follows = Form::find($id)->form_follow;

			$pdf = PDF::loadView('account.form.printshow2', compact('item', 'responses', 'follows'));

			return $pdf->stream('' . $item->name . 'form.pdf');

		} else {

			if (auth()->user()) {
				$categories = auth()->user()->account->circle->category->all();
			} else {
				$categories = Category::all();
			}

			$itemco = \App\Company::all()->first();
            $form_type = Form_type::all();
            $type = $item->type;
			if ($item->citizen->id_number == $ido) {
				return view("citizen.form-show1", compact('item', 'categories', 'itemco','form_type','type'));
			} else {
				return view("citizen.noaccses", compact('item', 'itemco','form_type','type'));
			}

		}

	}

	//اضافة متابعة لمن ما يكون لشكوى ردود
	public function addform($type, $citzen_id, $project_id) {
		$itemco = \App\Company::all()->first();
		$citizen = Citizen::where('id_number', '=', $citzen_id)->first();

		if ($citizen) {
			$project = $citizen->projects->find($project_id);
			$citzen_id = $citizen->id;
		} else {
			$project = null;
		}

		if ($citizen) {
			$citizen_name = $citizen->first_name . " " . $citizen->last_name;
		} else {
			$citizen_name = "";
		}

		if ($project) {
			$project_name = $project->name;
		} else {
			$project = Project::find(1);
			$project_name = $project->name;
			$project_id = $project->id;
		}


		if (!auth()->user()) {
			$category = \App\Category::get();
		} else {
			$category = \App\Category::whereIn('categories.id', \App\Account::find(auth()->user()->account->id)->circle->category()
					->with('circle_categories')->where('to_edit', 1)->pluck('categories.id'))->get();
		}


		if ($type > 2 && $project_id == 1) {
			return view('welcome', compact('itemco'));
		}

		$form_type = Form_type::all();
		$form_status = Form_status::all();
		$sent_typee = Sent_type::where('id', '!=', 1)->get();

		return view("citizen.addform", compact('itemco', 'form_type', "form_status", "sent_typee", 'type', 'category', 'citzen_id', 'project_id', 'citizen_name', 'project_name'));
	}

	public function delayform($id) {
		$form = Form::find($id);
		if ($form == NULL) {
			return redirect("/");
		}
		$form->fill(['status' => '4']);
		$form->save();
		session::flash('msg', 's:تم إرسال تذكير لموظف الردود');

		$theform = $form;
		if ($theform->project->account_projects->first() && $theform->category->circle_categories->first()) {
			$accouts_ids_in_circle = Account::WhereIn('circle_id', $theform->category->circle_categories->where('to_notify', 1)
					->pluck('circle_id')->toArray())->pluck('id')->toArray();
			$accouts_ids_in_project = $theform->project->account_projects->where('to_notify', 1)
				->pluck('account_id')->toArray();
			$accouts_ids = array_merge($accouts_ids_in_circle, $accouts_ids_in_project);

			$users_ids = Account::find($accouts_ids)->pluck('user_id');
			for ($i = 0; $i < count($users_ids); $i++) {
				if (User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id)) {
					NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'مواطن', 'title' => 'تذكير نموذج عالق للتأخير', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);
				}

			}
		}

		return redirect('/citizen/form/show/' . $form->citizen->id_number . '/' . $id);
	}

	public function formstore(FormsRequest $request) {
		$testeroor = $this->validate($request, [
			'fileinput' => 'max:6400|mimes:jpeg,bmp,png,gif,svg,pdf,docx,xls,xlsx',
		]);
		$request['status'] = 1;
		if ($request['type'] == 3) {
			$request['category_id'] = 1;
		}

		if ($request['type'] == 2) {
			$request['category_id'] = 2;
		}
        $citizen = Citizen::find($request['citizen_id']);
		if(!$citizen){
            $citizen = Citizen::where('id_number', '=', $request['citizen_id'])->first();
            $request['citizen_id'] = $citizen->id;
        }

		if (!$citizen || !Project::find($request['project_id'])
			|| $request['type'] < 1 || $request['type'] > 3) {
			Session::flash("msg", "e:يرجى أدخال رابط صحيح لرقم المواطن والمشروع");
			return redirect('form/addform/' . $request['type'] . '/' . $request['citizen_id'] . '/' . $request['project_id'])->withInput();
		}
		if (auth()->user()) {
			$request['account_id'] = auth()->user()->account->id;
		}


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
					NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'مواطن', 'title' => 'لديك اقتراح/ شكوى جديدة بحاجة لمعالجة', 'link' => "/citizen/form/show/" . Form::find($form_id)->citizen_id . "/$form_id"]);
				}
			}

		}
		return redirect('form/confirm/' . $form_id);
	}

	public function saverecommendations(Request $request){
        if (!auth()->user()) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect('/noaccses');
        }else{
            Recommendation::create($request->all());
            $form =Form::find($request['form_id']);
            if($form){
                $citizen_ido = Citizen::find($form->citizen_id)->id_number;
            }
            session::flash('msg', 'تم إضافة توصيتك بنجاح ');
            return redirect('/citizen/form/show/' . $citizen_ido . '/' . $request['form_id']);
        }

    }

	public function confirmform($id) {
		$form = Form::find($id);
//		dd($form);
		if ($form == NULL) {
			Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
			return redirect('/noaccses');
		}
		$itemco = \App\Company::all()->first();
		return view("citizen.confirmsend", compact('itemco', 'form'));
	}

	/*public function editform($id)
		    {
		        $form_file = Form_file::where('form_id', '=', $id)->first();
		        $form = Form::find($id);
		        $type = $form->type;
		        $itemco = \App\Company::all()->first();
		        $category = Category::all();
		        return view("citizen.editform", compact('itemco', 'category', 'form', 'type', 'form_file'));
	*/

	/*public function formupdate($id, FormsRequest $request)
		    {
		        $request['status'] = 1;
		        Form::find($id)->fill($request->all())->save();

		        if ($request->hasFile('fileinput')) {
		            $form_files = Form_file::where('form_id', '=', $id)->
		            first();
		            //حذف القديم
		            if ($form_files) {
		                $oldfile = $form_files->getAttribute('name');//يجلب اسم الملف المخزن بداتا بيز
		                $mypath = public_path() . '/uploads/'; // مكان التخزين في البابليك ثم مجلد ابلودز
		                if (file_exists($mypath . $oldfile) && $oldfile != null) {//اذا يوجد ملف قديم مخزن
		                    unlink($mypath . $oldfile);//يقوم بحذف القديم
		                }
		            }

		            $myfile = $request->file('fileinput'); // جلد الجديد من الانبوت فورم
		            $filename = rand(11111, 99999) . '.' . $myfile->getClientOriginalExtension(); // جلب اسمه
		            $myfile->move(public_path() . '/uploads/', $filename);//يخزن الجديد في الموقع المحدد
		            if ($form_files) {
		                $form_files->fill(['form_id' => $id, 'name' => $filename, 'path' => 'uploads/'])->save();
		            } else
		                Form_file::create(['form_id' => $id, 'name' => $filename, 'path' => 'uploads/']);

		        }
		        return redirect('form/confirm/' . $id);

	*/

	/***************************************************/

	public function searchbyidnumorform() {
		$itemco = \App\Company::all()->first();
		return view("citizen.search", compact('itemco'));
	}

//    function hasNumber($num, $digit){
//        return $num.toString().split("").some(function($item){
//                return $item == $digit;
//            });
//    }

	public function getforms(Request $request) {
		$testeroor = $this->validate($request, [
			'type' => 'required',
			'id' => 'required',

		]);

		$type = $request['type'];
		$id = $request['id'];
		if ($type == 1) //برقم النموذج
		{

            $forms = '';
            $contains = Str::contains($id, '00970');
            if($contains){
                $id = str_replace('00970', ' ', $id);
                $forms = Form::where('id', '=', $id)->get();
            }

//
		} else {
//بهوية المواطن
			$citezens = Citizen::where('id_number', '=', $id);
			if ($citezens) {
				$citezen = $citezens->first();
				if ($citezen) {
					$forms = $citezen->forms()->orderBy('id', 'desc')->get();
//					dd($forms);
				} else {
					$forms = null;
				}

			} else {
				$forms = null;
			}

		}

		$itemco = \App\Company::all()->first();
		return view("citizen.showforms", compact('itemco', 'forms'));
	}

	/*************************************************************/
	public function addfollow(Request $request) {
		$testeroor = $this->validate($request, [
			'fileinput' => 'max:2400|mimes:jpeg,bmp,png,gif,svg,pdf,docx,xls,xlsx',
			'notes' => 'max:300',
		]);
		$testeroor = $this->validate($request, [
			'notes' => 'required',
			'citizen_id' => 'required',

		]);

		$request['datee'] = date('Y-m-d');
		Form_follow::create($request->all());
		//اضافة ملف
		$form_id = $request['form_id'];

		if ($request->hasFile('fileinput')) {
			$myfile = $request->file('fileinput'); // جلد الجديد من الانبوت فورم
			$filename = rand(11111, 99999) . '.' . $myfile->getClientOriginalExtension(); // جلب اسمه
			$myfile->move(public_path() . '/uploads/', $filename); //يخزن الجديد في الموقع المحدد
			Form_file::create(['form_id' => $form_id, 'name' => $filename, 'path' => 'uploads/']);

		}

		$citizen_ido = Citizen::find($request['citizen_id'])->id_number;

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
					NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'مواطن', 'title' => 'تم اضافة متابعة على نموذج', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);
				}

			}
		}

		return redirect('/citizen/form/show/' . $citizen_ido . '/' . $request['form_id']);
	}

	public function addevaluate(Request $request) {
		$myvalid = [
			'solve' => 'required',
			'citizen_id' => 'required',
			'fileinput' => 'max:2400|mimes:jpeg,bmp,png,gif,svg,pdf,docx,xls,xlsx',
		];
		if ($request->has('solve')) {
			if ($request['solve'] == "1") {
				$myvalid['evaluate'] = 'required';
			}

		}

		$request['datee'] = date('Y-m-d');
		$testeroor = $this->validate($request, $myvalid);
		$citizen_ido = Citizen::find($request['citizen_id'])->id_number;

		Form_follow::create($request->all());

		$theform = Form::find($request['form_id']);
		if ($theform->project->account_projects->first() && $theform->category->circle_categories->first()) {
			$accouts_ids_in_circle = Account::WhereIn('circle_id', $theform->category->circle_categories->where('to_notify', 1)
					->pluck('circle_id')->toArray())->pluck('id')->toArray();
			$accouts_ids_in_project = $theform->project->account_projects->where('to_notify', 1)
				->pluck('account_id')->toArray();
			$accouts_ids = array_merge($accouts_ids_in_circle, $accouts_ids_in_project);

			$users_ids = Account::find($accouts_ids)->pluck('user_id');
			for ($i = 0; $i < count($users_ids); $i++) {
				if (User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id)) {
					NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'مواطن', 'title' => 'تم اضافة تقييم لنموذج', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);
				}

			}
		}

		return redirect('/citizen/form/show/' . $citizen_ido . '/' . $request['form_id']);
	}

    public function showfiles($id) {

        $item = Form::find($id);
        if ($item)
            $form_files = \App\Form_file::where('form_id', '=', $item->id)->get();

        return view("citizen.itemsfiles", compact( 'form_files','item'));

    }


}
