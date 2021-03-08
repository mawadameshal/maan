<?php

namespace App\Http\Controllers\Account;


use App\Recommendation;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use App\Account;
use App\Project;
use DB;
use  PDF;


class RecommendationsController  extends BaseController
{
    public function index(Request $request)
    {
        $project_id = $request["project_id"] ?? "";
        $account_id = $request["account_id"] ?? "";
        $from_date = $request["from_date"] ?? "";
        $to_date = $request["to_date"] ?? "";

        $items = Recommendation::join('forms', 'forms.id', '=', 'recommendations.form_id')
            ->join('projects', 'projects.id', '=', 'forms.project_id')
            ->whereRaw("true");
        if ($items == null) {
            session::flash('msg', 'w:نأسف لا يوجد بيانات لعرضها');
            return redirect('/account/recommendations');
        }


        if ($project_id || $project_id == '0') {

            $items->where('forms.project_id', '=', $project_id);
        }

        if ($account_id) {
            $items->where("user_id", $account_id);

        }

        if ($from_date) {
            $items->where([['recommendations.created_at', '>=', Carbon::parse($from_date)->format('Y-m-d')], ['recommendations.created_at', '<=', Carbon::parse($to_date)->format('Y-m-d')]]);
        }

        if ($to_date) {
            $items->where([['recommendations.created_at', '>=', Carbon::parse($from_date)->format('Y-m-d')], ['recommendations.created_at', '<=', Carbon::parse($to_date)->format('Y-m-d')]]);
        }

        if ($request['theaction'] == 'search')
        {
            $items = $items->paginate(5)->appends([
                "account_id" => $account_id ,
                "project_id" => $project_id,
                "from_date" => $from_date,
                "to_date" => $to_date,
                "theaction" => 'search']);

        }else{
            $items  = "" ;
        }

        $projects = Project::all();
        $accounts = Account::all();

        return view("account.recommendations.index", compact('items', 'projects' ,'accounts'));
    }

}
