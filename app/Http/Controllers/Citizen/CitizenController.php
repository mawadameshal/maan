<?php

namespace App\Http\Controllers\Citizen;

use App\Category;
use App\Citizen;
use App\Form;
use App\Form_status;
use App\Form_type;
use App\Http\Controllers\Controller;
use App\Http\Requests\CitizenRequest;
use App\Project;
use App\Recommendation;
use App\Rules\IdNumber;
use App\Sent_type;
use Illuminate\Http\Request;

class CitizenController extends Controller {
	public function searchbyidnum($type) {
		$itemco = \App\Company::all()->first();
		return view("citizen.searchcitizen", compact('itemco', 'type'));
	}

	public function gethisproject(Request $request) {
		$type = $request['type'];
		$projects = null;
        $id_number = $this->validate($request, [
            'id_number' => ['numeric', 'digits:9', new IdNumber],

        ]);
		if ($id_number) {

			$citizen = Citizen::where('id_number', '=', $id_number)->first();
			if ($citizen) {
				if (!auth()->user()) {
					$projects = $citizen->projects;
				} else {
					$projects = $citizen->projects()->whereIn('projects.id',
						\App\Account::find(auth()->user()->account->id)->projects()->with('account_projects')->where('to_add', 1)->pluck('projects.id'))->get();
				}

			}
			$itemco = \App\Company::all()->first();
			return view("citizen.choosproject", compact('itemco', 'citizen', 'projects', 'type'));
		} else {
			$itemco = \App\Company::all()->first();
			return view("citizen.searchcitizen", compact('itemco', 'type'));
		}
	}

	public function editorcreatcitizen(Request $request) {

		$type = $request['type'];
		$citizen_id = $request['citizen_id'];
		$project_id = $request['project_id'];
		$id_number = $request['id_number'];
        $projects = Project::get();

        $itemco = \App\Company::all()->first();
        $citizen = Citizen::where('id_number', '=', $request['id_number'])->first();

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
            $project_code = $project->code;
        } else {
            $project = Project::find(1);
            $project_name = $project->name;
            $project_id = $project->id;
            $project_code = $project->code;
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

		if ($citizen_id == 0) {
			$itemco = \App\Company::all()->first();
			$citzen_id = $_GET['id_number'];
			return view("citizen.create", compact('itemco', 'type', 'id_number','projects','form_type'
                , "form_status", "sent_typee", 'type', 'category', 'citzen_id', 'project_id','project_code', 'citizen_name', 'project_name'));
		} else {
			$testeroor = $this->validate($request, ['project_id' => 'required']);
			$citizen = Citizen::find($citizen_id);
			$itemco = \App\Company::all()->first();
			return view("citizen.edit", compact('itemco', 'type', 'citizen', 'project_id','projects','form_type'
                , "form_status", "sent_typee", 'type', 'category', 'citzen_id', 'project_id','project_code', 'citizen_name', 'project_name'));
		}
	}

	public function store(CitizenRequest $request) {

		$type = $request['type'];
		$project_id = $request['project_id'];

		$isExists = Citizen::where("id_number", $request["id_number"])->count();
		if ($isExists) {
			$testeroor = $this->validate($request, [
				'id_number' => ['numeric', 'digits:9', new IdNumber],

			]);
			return redirect("/account/citizen/create")->withInput();
		}
		$citizen_id = Citizen::create($request->all())->id_number;

		return redirect('form/addform/' . $type . '/' . $citizen_id . '/' . $project_id);
	}


	public function update($id, CitizenRequest $request) {
        $type = $request['type'];
		$citizen_id = Citizen::find($id)->id_number;
		$project_id = $request['project_id'];
//        $Citizen = Citizen::find($id);
//        $Citizen->update($request->all());

		Citizen::find($id)->fill([
		        'first_name' => $request['first_name'],
                'father_name' => $request['father_name'],
                'grandfather_name' => $request['grandfather_name'],
                'last_name' => $request['last_name'],
                'governorate' => $request['governorate'],
                'city' => $request['city'],
                'street' => $request['street'],
                'mobile' => $request['mobile'],
                'mobile2' => $request['mobile2'],
            ])->save();
        return redirect('form/addform/' . $type . '/' . $citizen_id . '/' . $project_id);

	}

}
