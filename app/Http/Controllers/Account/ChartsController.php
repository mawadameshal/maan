<?php

namespace App\Http\Controllers\Account;

use App\Account;
use App\AccountProjects;
use App\Category;
use App\Circle;
use App\Citizen;
use App\CitizenProjects;
use App\Form;
use App\Form_status;
use App\Form_type;
use App\Project;
use App\Project_status;
use App\Sent_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class ChartsController extends BaseController
{
    function citizenstoprojects(Request $request)
    {
        $accept = request()["accept"] ?? "";
        $governorate = request()["governorate"] ?? "";

        $projectsbeforjeson = Project::where('id', '!=', 1);
        $projectsbeforjeson = $projectsbeforjeson->select('name')->withcount(['citizens' => function ($q) use ($accept, $governorate) {
            if ($governorate != "")
                $q->where("governorate", [$governorate]);

            if ($accept != "")
                $q->where("add_byself", [$accept]);

        }])->get();
        $projects = json_encode($projectsbeforjeson);

        return view('account.charts.citizenstoprojects', compact('projects'));
    }

    function formstoprojects(Request $request)
    {
        $total_status = "";
        $determine = "";
        $staff = "";
        $categories_project = "";
        $AllComplaintSuggestions = "";
        $ComplaintSuggestions = "";
        $responces = "";
        $sent_typee ="";
        if(!empty(request('project_id')) ){

            if(request('project_id')  != -1){
                $determine = "specific_project";
                $items = Project::leftjoin('project_status', 'projects.active', '=', 'project_status.id')
                    ->leftjoin('citizen_project', 'citizen_project.project_id', '=', 'projects.id')
                    ->select('projects.id',
                        'projects.code',
                        'projects.name',
                        'project_status.name as names',
                        'projects.start_date',
                        'projects.end_date',
                        DB::raw('count(citizen_project.project_id) as count_forms')
                    )
                    ->where('projects.id', request('project_id'))->groupBy('projects.id');
                $items = $items->first();

                $staff = Project::find(request('project_id'))->accounts()->orderBy("accounts.full_name")->get();

                $sent_typee = Project::find(request('project_id'))->forms()
                    ->whereIn('project_id', Account::find(auth()->user()->account->id)
                        ->projects()->pluck('projects.id'))
                    ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                        ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
                    ->join('sent_type', 'forms.sent_type', '=', 'sent_type.id')
                    ->select(
                        'sent_type.name as name',
                        DB::raw('count(sent_type.name) as count_sent_types'))
                    ->groupBy('sent_type.name')
                    ->get();

                $categories_project = Project::find(request('project_id'))->forms()
                        ->whereIn('project_id', Account::find(auth()->user()->account->id)
                            ->projects()->pluck('projects.id'))
                        ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                            ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
                        ->join('categories', 'forms.category_id', '=', 'categories.id')
                        ->leftjoin('category_circles','category_circles.category','=','categories.id')
                        ->leftJoin('circles', function($join){
                            $join->on('circles.id','=','category_circles.circle');
                            $join->where('category_circles.procedure_type','=',2);
                        })
                        ->select(
                            'categories.name as name',
                            'is_complaint',
                            'circles.name as circle',
                            DB::raw('count(categories.name) as count_categories'))
                        ->groupBy('categories.name','is_complaint')
                        ->get();

                $AllComplaintSuggestions = Project::find(request('project_id'))->forms()
                    ->whereIn('project_id', Account::find(auth()->user()->account->id)
                        ->projects()->pluck('projects.id'))
                    ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                        ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
                    ->leftjoin('form_status','forms.status','=','form_status.id')
                    ->select(
                        DB::raw('count(forms.id) as count_allforms')
                    )
                    ->first();

                $ComplaintSuggestions = Project::find(request('project_id'))->forms()
                    ->whereIn('project_id', Account::find(auth()->user()->account->id)
                        ->projects()->pluck('projects.id'))
                    ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                        ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
                    ->leftjoin('form_status','forms.status','=','form_status.id')
                    ->select(
                        'form_status.id as form_status',
                        DB::raw('count(forms.id) as count_forms')
                    )
                    ->groupBy('form_status.id')
                    ->orderBy('form_status.id')
                    ->get();

                $responces = Project::find(request('project_id'))->forms()
                    ->whereIn('project_id', Account::find(auth()->user()->account->id)
                        ->projects()->pluck('projects.id'))
                    ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                        ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
                    ->select(
                        'forms.evaluate',
                        DB::raw('count(forms.id) as count_forms')
                    )
                    ->groupBy('forms.evaluate')
                    ->orderBy('forms.evaluate')
                    ->get();

            }
            else{
                $determine = "all_projects";
                $items = Project::select(
                    DB::raw('count(projects.id) as number_of_project'),
                        DB::raw('(select count(citizen_project.id) from citizen_project) as number_of_cizitain')
                    )->first();

                $status = Project::select('projects.active')->get();
                $status_array = [];
                foreach ($status as $s){
                    array_push($status_array,$s->active);
                }

                if (in_array("1", $status_array) && in_array("2", $status_array)) {
                    $total_status = "منتهية و مستمرة";
                }elseif (in_array("0", $status_array)) {
                    $total_status = "منتهية";
                }else{
                    $total_status = "مستمرة";
                }

                $staff = Project::join('account_project', 'projects.id', '=', 'account_project.project_id')
                    ->join('accounts','accounts.id','=','account_id')
                    ->select('projects.name','accounts.full_name','account_project.rate')
                    ->orderBy("project_id")->get();


                $sent_typee = Form::join('projects', 'projects.id', '=', 'forms.project_id')
                    ->join('sent_type', 'forms.sent_type', '=', 'sent_type.id')
                    ->select(
                        'sent_type.name as name',
                        DB::raw('count(sent_type.name) as count_sent_types'))
                    ->groupBy('sent_type.name')
                    ->get();


                $categories_project = Form::whereIn('project_id', Account::find(auth()->user()->account->id)
                        ->projects()->pluck('projects.id'))
                    ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                        ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
                    ->join('categories', 'forms.category_id', '=', 'categories.id')
                    ->leftjoin('category_circles','category_circles.category','=','categories.id')
                    ->leftJoin('circles', function($join){
                        $join->on('circles.id','=','category_circles.circle');
                        $join->where('category_circles.procedure_type','=',2);
                    })
                    ->select(
                        'categories.name as name',
                        'is_complaint',
                        'circles.name as circle',
                        DB::raw('count(categories.name) as count_categories'))
                    ->groupBy('categories.name','is_complaint')
                    ->get();
//
                $AllComplaintSuggestions =Form::whereIn('project_id', Account::find(auth()->user()->account->id)
                        ->projects()->pluck('projects.id'))
                    ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                        ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
                    ->leftjoin('form_status','forms.status','=','form_status.id')
                    ->select(
                        DB::raw('count(forms.id) as count_allforms')
                    )
                    ->first();
//
                $ComplaintSuggestions =Form::whereIn('project_id', Account::find(auth()->user()->account->id)
                        ->projects()->pluck('projects.id'))
                    ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                        ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
                    ->leftjoin('form_status','forms.status','=','form_status.id')
                    ->select(
                        'form_status.id as form_status',
                        DB::raw('count(forms.id) as count_forms')
                    )
                    ->groupBy('form_status.id')
                    ->orderBy('form_status.id')
                    ->get();

                $responces = Form::whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                        ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
                    ->select(
                        'forms.evaluate',
                        DB::raw('count(forms.id) as count_forms')
                    )
                    ->groupBy('forms.evaluate')
                    ->orderBy('forms.evaluate')
                    ->get();

            }
        }else{
            $items = "";
        }

        $categories = auth()->user()->account->circle->category->all();
        $form_type = Form_type::all();
        $form_status = Form_status::all();
        $allprojects = Project::all();
        $project_status = Project_status::all();
        $circles = Circle::all();
        $sent_typeexx = Sent_type::all();
        return view('account.charts.formstoprojects', compact("items","sent_typeexx","staff","determine","total_status","categories_project","circles","allprojects","project_status", "form_type", "form_status", "sent_typee", "categories","AllComplaintSuggestions","ComplaintSuggestions","responces"));

    }

    function formstocatigoreis(Request $request)
    {
        $read = $request["read"] ?? "";
        $evaluate = $request["evaluate"] ?? "";
        $datee = $request["datee"] ?? "";
        $status = $request["status"] ?? "";
        $type = $request["type"] ?? "";
        $sent_type = $request["sent_type"] ?? "";
        $from_date = $request["from_date"] ?? "";
        $to_date = $request["to_date"] ?? "";
        $category_id = $request["category_id"] ?? "";
        $project_id = $request["project_id"] ?? "";


        $categoriesbeforjeson = Category::select('name')
            ->withcount(['form' =>
            function ($q) use ($read, $evaluate, $datee, $status, $type, $sent_type, $project_id, $from_date, $to_date, $category_id) {

                if ($evaluate) {
                    if ($evaluate == 1) {
                        $q->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
                            ->where("form_follows.solve", ">=", "0");
                    } elseif ($evaluate == 2) {
                        $q->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
                            ->where("form_follows.solve", "=", "1");
                    } elseif ($evaluate == 3) {
                        $q->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
                            ->where("form_follows.solve", "=", "2");
                    } elseif ($evaluate == 4) {


                        $q->whereNotIn('forms.id', function ($query) {
                            $query->select('form_follows.form_id')
                                ->where("form_follows.solve", ">=", "1")
                                ->from('form_follows');

                        });
                    }
                }
                if ($category_id && $type == 1)
                    $q->whereRaw("(category_id = ?)"
                        , [$category_id]);
                if ($project_id || $project_id == '0')
                    if ($project_id == '-1')
                        $q->whereRaw("(projects.id > ?)"
                            , ["1"]);
                    else
                        $q->whereRaw("(projects.id = ?)"
                            , ["$project_id"]);
                if ($from_date && $to_date) {
                    $q = $q->whereRaw("datee >= ? and datee <= ?", [$from_date, $to_date]);
                }
                if ($datee)
                    $q = $q->whereRaw("datee = ?", [$datee]);
                if ($status)
                    $q = $q->whereRaw("status = ?", [$status]);
                if ($type)
                    $q = $q->whereRaw("type = ?", [$type]);
                if ($sent_type)
                    $q = $q->whereRaw("sent_type = ?", [$sent_type]);

                if ($read) {
                    if ($read == 1)
                        $q = $q->whereRaw(" `read` = ?", [$read]);
                    else
                        $q = $q->whereNull("read");
                }
                if ($project_id || $project_id == '0')
                    if ($project_id == '-1')
                        $q->whereRaw("(projects.id > ?)"
                            , ["1"]);
                    else
                        $q->whereRaw("(projects.id = ?)"
                            , ["$project_id"]);

            }])->get();
        $categories = json_encode($categoriesbeforjeson);

        $projects = Account::find(auth()->user()->account->id)->projects->all();
        $form_type = Form_type::all();
        $form_status = Form_status::all();
        $sent_typee = Sent_type::all();
        return view('account.charts.formstocatigoreis', compact('categories', "form_type", "form_status", "sent_typee", "type", "projects"));
    }


}
