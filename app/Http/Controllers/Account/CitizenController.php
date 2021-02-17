<?php

namespace App\Http\Controllers\Account;

use App\Form;
use App\Form_follow;
use App\Form_response;
use App\Form_file;
use App\Form_status;
use App\Form_type;
use App\Imports\CitizenExport;
use App\Imports\CitizenFormExport;
use App\Imports\CitizenNotbenfitExport;
use App\Sent_type;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use App\Citizen;
use App\Account;
use App\CitizenProjects;
use App\Project;
use App\Imports\CitizenImport;
use App\Http\Requests\CitizenRequest;
use  PDF;
use App\Imports\FormsExport;
use DB;
use Illuminate\Support\Facades\Input;
use Validator;


class CitizenController extends BaseController
{



    public function get_citizen_data(){

        if(request()->ajax() and request('id_number') )
        {
            $citizen = Citizen::where( 'id_number' , request('id_number'))->get()->first();
                // dd($citizen);
            return view('account.citizen.form' , compact('citizen'))->render();


        }
    }

     public function download_citizen_file()
    {
        $file= public_path(). "/uploads/download/citizenfile.xlsx";
        return response()->download($file);
    }

    public function save_citizen_data(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data_file' => 'required',

        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        else
        {

            if ($request->file('data_file')->isValid()) {


                try {

                    $collection = Excel::toArray(new CitizenImport, request()->file('data_file'));

                    $collection = array_collapse($collection);

                    foreach ($collection as $row) {

                        if(! $row['alasm_alaol']){
                            return redirect("/account/citizen/create");
                        }

                        $citizen = Citizen::create([
                            'first_name' => $row['alasm_alaol'],
                            'email' => $row['albryd'],
                            'father_name' => $row['asm_alab'],
                            'last_name' => $row['asm_alaaael'],
                            'grandfather_name' => $row['asm_aljd'],
                            'id_number' => $row['rkm_alhoy'],
                            'governorate' => $row['almhafth'],
                            'city' => $row['almntk'],
                            'street' => $row['alaanoan'],
                            'mobile' => $row['rkm_altoasl_1'],
                            'mobile2' => $row['rkm_altoasl_2'],
                        ]);


                        if(request('project_id')){
                            $CitizenProjects = CitizenProjects::create([
                                'citizen_id' => $citizen->id,
                                'project_id' => $request->project_id

                            ]);

                        }


                    }


                    \Session::flash('success', 'Citizen added successfully.');
                    return redirect("/account/citizen/create");

                } catch (\Exception $e) {
                    \Session::flash('error', $e->getMessage());
                }

            }

            else {
                Session::flash("msg", "e:لم يتم رفع أي ملف");
                return redirect("/account/citizen");
            }


        }
    }

    public function not_benefit(Request $request)
    {
        $q = $request["q"] ?? "";
        $accept = $request["accept"] ?? "";
        $project_id = $request["project_id"] ?? "";
        $usefull = $request["usefull"] ?? "";
        $keywords = preg_split("/[\s,]+/", $q);

        if (count($keywords) == 3) {
            $keywords[3] = "";
        }
        if (count($keywords) == 2) {
            $keywords[2] = "";
            $keywords[3] = "";
        }
        if (count($keywords) == 1) {
            $keywords[1] = "";
            $keywords[2] = "";
            $keywords[3] = "";
        }
        //dd($keywords);

        $project_ids = Account::find(auth()->user()->account->id)->projects()->pluck('projects.id');
        // $citizen_ids = CitizenProjects::whereIn('project_id', $project_ids)->pluck('citizen_id');
        // $items = Citizen::whereIn('id', $citizen_ids)->select(
        //     'id',
        //     'first_name',
        //     'father_name',
        //     'grandfather_name',
        //     'last_name',
        //     'id_number',
        //     'mobile',
        //     'mobile2',
        //     'governorate',
        //     'city',
        //     'street'
        //     )

        //     ->whereRaw("true");
        $citizensids = CitizenProjects::pluck('citizen_id');
        $items = Citizen::whereNotIn("id", $citizensids)->select('id', 'first_name', 'father_name', 'grandfather_name', 'last_name',
            'id_number', 'mobile','mobile2', 'governorate', 'city', 'street');


        if ($q) {
            // $items->whereRaw("(
            // (first_name like ? and father_name like ? and grandfather_name like ? and last_name like ?)
            // or (first_name like ? and last_name like ? and grandfather_name like ? and father_name like ?)
            // or (first_name like ? and grandfather_name like ? and last_name like ? and father_name like ?)
            // or (father_name like ? and grandfather_name like ? and first_name like ? and last_name like ?)
            // or (father_name like ? and last_name like ? and grandfather_name like ? and first_name like ?)
            // or (grandfather_name like ? and last_name like ? and father_name like ? and first_name like ?)
            // or first_name like ? or  father_name like? or grandfather_name like?  or  last_name like?

            // or id_number like ? or governorate like ? or city like ?)"
            //     , ["%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$q%", "%$q%", "%$q%", "%$q%",

            //         "%$q%", "%$q%", "%$q%"]);
            $items->whereRaw("(
            (first_name like ? and father_name like ? and grandfather_name like ? and last_name like ?)
            or (first_name like ? and last_name like ? and grandfather_name like ? and father_name like ?)
            or (first_name like ? and grandfather_name like ? and last_name like ? and father_name like ?)
            or (father_name like ? and grandfather_name like ? and first_name like ? and last_name like ?)
            or (father_name like ? and last_name like ? and grandfather_name like ? and first_name like ?)
            or (grandfather_name like ? and last_name like ? and father_name like ? and first_name like ?)
            or first_name like ? or  father_name like? or grandfather_name like?  or  last_name like?

            or id_number like ? or governorate like ? or city like ?)"
                , ["%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$q%", "%$q%", "%$q%", "%$q%",

                    "%$q%", "%$q%", "%$q%"]);
        }
        if ($usefull) {
            if ($usefull == 1) {
                $citizensids = CitizenProjects::pluck('citizen_id');
                //dd($citizensids);
                // $items->whereIn("id"
                //     , $citizensids);
                $items->whereIn("id"
                    , $citizensids);
            } else if ($usefull == 2) {
                $citizensids = CitizenProjects::pluck('citizen_id');
                // $items->whereNotIn("id"
                //     , $citizensids);
                $items->whereNotIn("id"
                    , $citizensids);
            }
        }
        if (($project_id || $project_id == '0') && $project_id != '1') {
            $citizensids = Project::find($project_id)->citizen_projects->pluck('citizen_id');
            // $items->whereIn("id"
            //     , $citizensids);
            $items->whereIn("id"
                , $citizensids);
            $project_name = Project::find($project_id)->name;
        } else
            $project_name = "";

        /*
          $items->whereRaw("((first_name like ? and father_name like ? and grandfather_name like ? and last_name like ?) or (first_name like ? and father_name like ?) or (first_name like ? and last_name like ?) or (father_name like ? and grandfather_name like ?) or (grandfather_name like ? and last_name like ?) or (father_name like ? and last_name like ?) or (first_name like ? and father_name like ? and last_name like ?) or (first_name like ? and father_name like ? and grandfather_name like ?) or (father_name like ? and grandfather_name like ? and last_name like ?)  or first_name like ? or  father_name like? or grandfather_name like?  or  last_name like? or id_number like ? or governorate like ? or city like ?)"
              , ["%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%","%$keywords[3]%", "%$keywords[0]%", "%$keywords[1]%", "%$keywords[0]%", "%$keywords[1]%", "%$keywords[0]%", "%$keywords[1]%", "%$keywords[0]%", "%$keywords[1]%" ,"%$keywords[0]%", "%$keywords[1]%" ,"%$keywords[0]%", "%$keywords[1]%" ,"%$keywords[2]%" ,"%$keywords[0]%", "%$keywords[1]%" ,"%$keywords[2]%" ,"%$keywords[0]%", "%$keywords[1]%" ,"%$keywords[2]%","%$q%", "%$q%", "%$q%", "%$q%", "%$q%", "%$q%", "%$q%"]);
        */
        if ($accept != "") {
            // $items->whereRaw("add_byself = ?", [$accept]);
            $items->whereRaw("add_byself = ?", [$accept]);
        }
        if (($project_id || $project_id == '0') && $project_id != '1') {
            if (in_array(1, $project_ids->toArray())) {
                // $items = $items->union($items2);
            }
        } else {
            // $items = $items->union($items2);
        }


        if(request('id_number')){
            $items->where("id_number", request('id_number'));
        }
        if(request('id')){
            $items->where("id", request('id'));
        }
        if(request('first_name')){
            $items->where("first_name", request('first_name'));
        }

        if(request('governorate')){
            $items->where("governorate", request('governorate'));
        }

        $projects = Account::find(auth()->user()->account->id)->projects->all();

        if ($request['theaction'] == 'excel') {
//            $items = $items->orderBy("id", 'desc')->get();
            return Excel::download(new CitizenNotbenfitExport(), "Annex Template 04-".date('d-m-Y').".xlsx");
        } else {


               if ($request['theaction'] == 'search') {
                $items = $items->orderBy("first_name")->paginate(5)->appends([
                    "q" => $q, "accept" => $accept, "project_id" => $project_id, "usefull" => $usefull,
                    "id" => request('id') ,"id_number" => request('id_number'),
                    "first_name" => request('first_name'),"governorate" => request('governorate'), "theaction" => "search"]);
            }else{
                $items = "";
            }


            return view("account.citizen.notbenefit", compact('items', 'projects'));
        }
    }


    public function accept($id)
    {

        $item = Citizen::find($id);
        if ($item == NULL ||
            !check_permission('تعديل مواطن')
//            !(Auth::user()->account->links
//                ->contains(\App\Link::where('title', '=', 'تعديل مواطن')
//                    ->first()->id))
        ) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/citizen");
        }
        if ($item->add_byself == "0" && $item->projects->toArray() != null)
            return;
        $item->add_byself = !$item->add_byself;
        $item->save();

    }

    public function show()
    {
        Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
        return redirect("/account/citizen");
    }

    public function index(Request $request)
    {
        $q = $request["q"] ?? "";
        $accept = $request["accept"] ?? "";
        $project_id = $request["project_id"] ?? "";
        $usefull = $request["usefull"] ?? "";
        $keywords = preg_split("/[\s,]+/", $q);

        if (count($keywords) == 3) {
            $keywords[3] = "";
        }
        if (count($keywords) == 2) {
            $keywords[2] = "";
            $keywords[3] = "";
        }
        if (count($keywords) == 1) {
            $keywords[1] = "";
            $keywords[2] = "";
            $keywords[3] = "";
        }
        //dd($keywords);

        $project_ids = Account::find(auth()->user()->account->id)->projects()->pluck('projects.id');
        $citizen_ids = CitizenProjects::whereIn('project_id', $project_ids)->pluck('citizen_id');
        // dd($citizen_ids);
        $items = Citizen::whereIn('id', $citizen_ids)->select(
            'id',
            'first_name',
            'father_name',
            'grandfather_name',
            'last_name',
            'id_number',
            'mobile',
            'mobile2',
            'governorate',
            'city',
            'street'
            )

            ->whereRaw("true");
        // $citizensids = CitizenProjects::pluck('citizen_id');
        // $items2 = Citizen::whereNotIn("id", $citizensids)->select('id', 'first_name', 'father_name', 'grandfather_name', 'last_name',
        //     'id_number', 'mobile','mobile2', 'governorate', 'city', 'street');





        if ($q) {
            $items->whereRaw("(
            (first_name like ? and father_name like ? and grandfather_name like ? and last_name like ?)
            or (first_name like ? and last_name like ? and grandfather_name like ? and father_name like ?)
            or (first_name like ? and grandfather_name like ? and last_name like ? and father_name like ?)
            or (father_name like ? and grandfather_name like ? and first_name like ? and last_name like ?)
            or (father_name like ? and last_name like ? and grandfather_name like ? and first_name like ?)
            or (grandfather_name like ? and last_name like ? and father_name like ? and first_name like ?)
            or first_name like ? or  father_name like? or grandfather_name like?  or  last_name like?

            or id_number like ? or governorate like ? or city like ?)"
                , ["%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$q%", "%$q%", "%$q%", "%$q%",

                    "%$q%", "%$q%", "%$q%"]);
            // $items2->whereRaw("(
            // (first_name like ? and father_name like ? and grandfather_name like ? and last_name like ?)
            // or (first_name like ? and last_name like ? and grandfather_name like ? and father_name like ?)
            // or (first_name like ? and grandfather_name like ? and last_name like ? and father_name like ?)
            // or (father_name like ? and grandfather_name like ? and first_name like ? and last_name like ?)
            // or (father_name like ? and last_name like ? and grandfather_name like ? and first_name like ?)
            // or (grandfather_name like ? and last_name like ? and father_name like ? and first_name like ?)
            // or first_name like ? or  father_name like? or grandfather_name like?  or  last_name like?

            // or id_number like ? or governorate like ? or city like ?)"
            //     , ["%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
            //         /**/
            //         "%$q%", "%$q%", "%$q%", "%$q%",

            //         "%$q%", "%$q%", "%$q%"]);
        }
        if ($usefull) {
            if ($usefull == 1) {
                $citizensids =  CitizenProjects::pluck('citizen_id');
                //dd($citizensids);
                $items->whereIn("id"
                    , $citizensids);
                // $items2->whereIn("id"
                //     , $citizensids);
            } else if ($usefull == 2) {
                $citizensids = CitizenProjects::pluck('citizen_id');
                $items->whereNotIn("id"
                    , $citizensids);
                // $items2->whereNotIn("id"
                //     , $citizensids);
            }
        }
        if (($project_id || $project_id == '0') && $project_id != '1') {
            $citizensids = Project::find($project_id)->citizen_projects->pluck('citizen_id');
            $items->whereIn("id"
                , $citizensids);
            // $items2->whereIn("id"
            //     , $citizensids);
            $project_name = Project::find($project_id)->name;
        } else
            $project_name = "";

        /*
          $items->whereRaw("((first_name like ? and father_name like ? and grandfather_name like ? and last_name like ?) or (first_name like ? and father_name like ?) or (first_name like ? and last_name like ?) or (father_name like ? and grandfather_name like ?) or (grandfather_name like ? and last_name like ?) or (father_name like ? and last_name like ?) or (first_name like ? and father_name like ? and last_name like ?) or (first_name like ? and father_name like ? and grandfather_name like ?) or (father_name like ? and grandfather_name like ? and last_name like ?)  or first_name like ? or  father_name like? or grandfather_name like?  or  last_name like? or id_number like ? or governorate like ? or city like ?)"
              , ["%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%","%$keywords[3]%", "%$keywords[0]%", "%$keywords[1]%", "%$keywords[0]%", "%$keywords[1]%", "%$keywords[0]%", "%$keywords[1]%", "%$keywords[0]%", "%$keywords[1]%" ,"%$keywords[0]%", "%$keywords[1]%" ,"%$keywords[0]%", "%$keywords[1]%" ,"%$keywords[2]%" ,"%$keywords[0]%", "%$keywords[1]%" ,"%$keywords[2]%" ,"%$keywords[0]%", "%$keywords[1]%" ,"%$keywords[2]%","%$q%", "%$q%", "%$q%", "%$q%", "%$q%", "%$q%", "%$q%"]);
        */
        if ($accept != "") {
            $items->whereRaw("add_byself = ?", [$accept]);
            // $items2->whereRaw("add_byself = ?", [$accept]);
        }
        if (($project_id || $project_id == '0') && $project_id != '1') {
            if (in_array(1, $project_ids->toArray())) {
                // $items = $items->union($items2);
            }
        } else {
            // $items = $items->union($items2);
        }



        if(request('id_number')){
            $items->where("id_number", request('id_number'));
        }
        if(request('id')){
            $items->where("id", request('id'));
        }
        if(request('first_name')){
            $items->where("first_name", request('first_name'));
        }

        if(request('governorate')){
            $items->where("governorate", request('governorate'));
        }


        if(request('project')){

            $Project = Project::find(request('project'));

            $items = $Project->citizens();
        }







        $projects = Account::find(auth()->user()->account->id)->projects->all();

        if ($request['theaction'] == 'excel') {
            return Excel::download(new CitizenExport(), "Annex Template 03-".date('d-m-Y').".xlsx");
        } else {

            if ($request['theaction'] == 'search') {
                $items = $items->orderBy("first_name")->paginate(5)->appends([
                    "q" => $q,"theaction" => "search", "accept" => $accept, "project_id" => $project_id, "usefull" => $usefull]);

            }elseif ($request['themainaction'] == 'search') {
                $items = $items->orderBy("first_name")->paginate(5)->appends([
                    "q" => $q,"themainaction" => "search", "accept" => $accept, "project_id" => $project_id,
                    "usefull" => $usefull]);

            }else{
                $items = "";
            }

            return view("account.citizen.index", compact('items', 'projects'));
        }
    }

    public function create()
    {
        $projects = Project::all();
        return view("account.citizen.create" , compact('projects'));
    }

    public function store(CitizenRequest $request)
    {
        $isExists = Citizen::where("id_number", $request["id_number"])->count();
        if ($isExists) {
            Session::flash("msg", "e:القيمة المدخلة موجودة مسبقاً");
            return redirect("/account/citizen/create")->withInput();
        }

        $this->validate($request,$request->rules());
        $request['add_byself'] = "0";
        $theid = Citizen::create($request->all())->id;
        if(request('project_id')){
            CitizenProjects::create([
                'citizen_id' => $theid ,
                'project_id' => $request["project_id"] ,
            ]);
        }

        Session::flash("msg", "تمت عملية الاضافة بنجاح");
        return redirect("/account/citizen/select-project/$theid");/*
        $isExists = Citizen::where("id_number", $request["id_number"])->count();
        if ($isExists) {
            Session::flash("msg", "e:القيمة المدخلة موجودة مسبقاً");
            return redirect("/account/citizen/create")->withInput();
        }
        $request['add_byself'] = "0";
        $full_name = preg_split("/[\s,]+/", $request['full_name']);

        if (count($full_name) != 4) {
            Session::flash("msg", "e:يرجى إدخال إسم ثلاثي من ثلاث مقاطع");
            return redirect("/account/citizen/create")->withInput();
        } else {
            if (strlen($full_name[0]) > 50 || strlen($full_name[1]) > 50 || strlen($full_name[2]) > 50 || strlen($full_name[3]) > 50) {
                Session::flash("msg", "e:أحرف الإسم أكثر من المسموح");
                return redirect("/account/citizen/create")->withInput();
            } else {
                $request['first_name'] = $full_name[0];
                $request['father_name'] = $full_name[1];
                $request['grandfather_name'] = $full_name[2];
                $request['last_name'] = $full_name[3];//
            }
        }
        Citizen::create($request->all());
        Session::flash("msg", "تمت عملية الاضافة بنجاح");
        return redirect("/account/citizen/create");*/
    }

    public function edit($id)
    {
        $projects = Project::all();

        $item = Citizen::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/citizen");
        }
        return view("account.citizen.edit", compact("item", 'projects'));
    }

    public function update(Request $request, $id)
    {
        $isExists = Citizen::where("id_number", $request["id_number"])->where("id", "!=", $id)->count();
        if ($isExists) {
            Session::flash("msg", "e:القيمة المدخلة موجودة مسبقاً");
            return redirect("/account/citizen/$id/edit");
        }
        $item = Citizen::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/citizen");
        }
//        $this->validate($request,$request->rules($id));

        $request['add_byself'] = "0";
        $item->update($request->all());

        if(request('project_id')){
            CitizenProjects::create([
                'project_id'=> $request->project_id,
                'citizen_id'=> $item->id,
            ]);

        }

        Session::flash("msg", "i:تمت عملية الحفظ بنجاح");
        return redirect("/account/citizen/$id/edit");
    }

    public function destroy($id)
    {
        $item = Citizen::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/citizen");
        }

        if ($item->add_byself == "0" || $item->projects->toArray() != null) {
            Session::flash("msg", "e:لا يمكن حذف المواطن اذا كان فعال او مشترك في مشاريع");
            return redirect("/account/citizen");
        } else {
            $item = Citizen::find($id);
            if ($item->forms->first()) {
                $forms = $item->forms->pluck('id');
                $formresp = Form_response::whereIn('form_id', $forms)->pluck('id');
                $formfoll = Form_follow::whereIn('form_id', $forms)->pluck('id');
                $formfile = Form_file::whereIn('form_id', $forms)->pluck('id');
                $formfile_name = Form_file::whereIn('form_id', $forms)->pluck('name');

                if (count($formfoll) > 0)
                    Form_follow::destroy($formfoll);
                if (count($formresp) > 0)
                    Form_response::destroy($formresp);
                if (count($formfile) > 0) {
                    Form_file::destroy($formfile);
                    foreach ($formfile_name as $file) {
                        $mypath = public_path() . '/uploads/'; // مكان التخزين في البابليك ثم مجلد ابلودز
                        if (file_exists($mypath . $file) && $file != null) {//اذا يوجد ملف قديم مخزن
                            unlink($mypath . $file);//يقوم بحذف القديم
                        }
                    }
                }
                Form::destroy($forms);


            }
            $item->delete();
            Session::flash("msg", "تم حذف مواطن بنجاح");
            return redirect("/account/citizen");
        }


    }

    public function import(Request $request)
    {
//        if (Auth::user()->account->links->contains(\App\Link::where('title', '=', 'تعديل مواطن')->first()->id)) {
        if (check_permission('تعديل مواطن')) {
            $testeroor = $this->validate($request, [
                'data_file' => 'mimes:xlsx,xls',
            ]);
            $importerror = [];
            if ($request->hasFile('data_file')) {
                if ($request->file('data_file')->isValid()) {
                    try {
                        $file = $request->file('data_file');
                        $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
                        $xx = $request->file('data_file')->move(storage_path() . '/app/', $name);
                        $collection = Excel::toCollection(new CitizenImport, $name);
                        unlink(storage_path() . '/app/' . $name);
                        //dd($z);
                        foreach ($collection as $keys => $vals) {
                            $errori = 0;
                            if (count($vals[0]) >= 10) {
                                $index1 = "" . $vals[0][0] . "";
                                $index2 = "" . $vals[0][1] . "";
                                $index3 = "" . $vals[0][2] . "";
                                $index4 = "" . $vals[0][3] . "";
                                $index5 = "" . $vals[0][4] . "";
                                $index6 = "" . $vals[0][5] . "";
                                $index7 = "" . $vals[0][6] . "";
                                $index8 = "" . $vals[0][7] . "";
                                $index9 = "" . $vals[0][8] . "";
                                $index10 = "" . $vals[0][9] . "";
                                if (($index1 == "#" || $index1 == "id" || $index1 == "الرقم") &&
                                    ($index2 == "الاسم الاول" || $index2 == "الإسم الأول" || $index2 == "الإسم الاول" || $index2 == "الاسم الأول") &&
                                    ($index3 == "اسم الأب" || $index3 == "اسم الاب" || $index3 == "إسم الأب" || $index3 == "إسم الأب") &&
                                    ($index4 == "اسم الجد" || $index4 == "إسم الجد") &&
                                    ($index5 == "العائلة" || $index5 == "العائله") &&
                                    ($index6 == "رقم الهوية" || $index6 == "رقم الهويه") &&
                                    ($index7 == "المحافظة" || $index7 == "المحافظه") &&
                                    ($index8 == "المنطقة" || $index8 == "المدينه" || $index8 == "المدينة" || $index8 == "المنطقه") &&
                                    ($index9 == "الشارع" || $index9 == "العنوان" || $index9 == "الحي")&&
                                    ($index10 == "الجوال" || $index10 == "الهاتف" || $index10 == "رقم التواصل")
                                ) {
                                    for ($i = 1; $i < count($vals); $i++) {
                                        $hisid = trim(stripslashes(htmlspecialchars(strip_tags($vals[$i][0]))));
                                        $first_name = trim(stripslashes(htmlspecialchars(strip_tags($vals[$i][1]))));
                                        $father_name = trim(stripslashes(htmlspecialchars(strip_tags($vals[$i][2]))));
                                        $grandfather_name = trim(stripslashes(htmlspecialchars(strip_tags($vals[$i][3]))));
                                        $last_name = trim(stripslashes(htmlspecialchars(strip_tags($vals[$i][4]))));
                                        $id_number = intval(trim(stripslashes(htmlspecialchars(strip_tags($vals[$i][5])))));
                                        $governorate = trim(stripslashes(htmlspecialchars(strip_tags($vals[$i][6]))));
                                        $city = trim(stripslashes(htmlspecialchars(strip_tags($vals[$i][7]))));
                                        $street = trim(stripslashes(htmlspecialchars(strip_tags($vals[$i][8]))));
                                        $mobile = trim(stripslashes(htmlspecialchars(strip_tags($vals[$i][9]))));
                                        $add_byself = "0";
                                        $dublact = Citizen::where('id_number', '=', $id_number)->first();
                                        $governor_arryy = array("الشمال","شمال غزة", "غزة", "الوسطى","دير البلح", "خانيونس","خان يونس", "رفح");
                                        if ($dublact == null) {
                                            if ((strlen($first_name) > 2 && strlen($first_name) < 50) &&
                                                (strlen($father_name) > 2 && strlen($father_name) < 50) &&
                                                (strlen($grandfather_name) > 2 && strlen($grandfather_name) < 50) &&
                                                (strlen($last_name) > 2 && strlen($last_name) < 50) &&
                                                (strlen($id_number) == 9 && is_int($id_number)) &&
                                                (in_array($governorate, $governor_arryy)) &&
                                                (strlen($city) > 2 && strlen($city) < 50) &&
                                                (strlen($street) > 2 && strlen($street) < 100)
                                            ) {
                                                DB::table('citizens')->insertGetId(['first_name' => $first_name, 'father_name' => $father_name, 'grandfather_name' => $grandfather_name, 'last_name' => $last_name
                                                    , 'id_number' => $id_number, 'governorate' => $governorate, 'city' => $city
                                                    , 'street' => $street, 'mobile' => $mobile, 'add_byself' => $add_byself]);

                                            } else {
                                                $importerror[$errori] = $hisid;
                                                $errori++;
                                                continue;
                                            }
                                        } else {
                                            $importerror[$errori] = $hisid;
                                            $errori++;
                                            continue;
                                        }

                                    }
                                    $errorsentance = "";

                                    if (count($importerror) > 0) {

                                        $errorsentance = "ماعدا الأعمدة رقم";
                                        for ($j = 0; $j < count($importerror); $j++) {
                                            $errorsentance = $errorsentance . " " . $importerror[$j] . ",";

                                        }
                                        $errorsentance = $errorsentance . " لوجود خطأ في المدخلات";
                                    }
                                    Session::flash("msg", "تم استيراد البينات بنجاح $errorsentance");
                                    return redirect("/account/citizen");
                                } else {
                                    Session::flash("msg", "e: تنسيق ملف الإكسل غير صحيح (أسماء الأعمدة)");
                                    return redirect("/account/citizen");
                                }
                            } else {
                                Session::flash("msg", "e:تنسيق ملف الإكسل غير صحيح (عدد الأعمدة)");
                                return redirect("/account/citizen");
                            }

                        }

                    } catch (FileNotFoundException $e) {

                    }
                }
            } else {
                Session::flash("msg", "e:لم يتم رفع أي ملف");
                return redirect("/account/citizen");
            }
        } else {
            Session::flash("msg", "e:ليس لك صلاحية أضافة مواطنين");
            return redirect("/account/citizen");
        }

    }

    public function selectproject($id)
    {
//        if (Auth::user()->account->links->contains(\App\Link::where('title', '=', 'تعديل مواطن')->first()->id)) {
        if (check_permission('تعديل مواطن')) {
            $item = Citizen::find($id);
            if ($item == NULL) {
                Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
                return redirect("/account/citizen");
            }
            return view("account.citizen.add-toproject", compact("item"));
        } else {
            Session::flash("msg", "e:لا تملك صلاحية إضافة مواطن لمشروع");
            return redirect("/account/citizen");
        }
    }

    public function selectprojectPost(Request $request, $id)
    {
        $item = Citizen::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/citizen");
        }
        if (Citizen::find($id)->add_byself == 1) {
            Session::flash("msg", "e:لا يمكن اضافة مشاريع قبل قبول المواطن");
            return redirect("/account/citizen");
        }
        \DB::table("citizen_project")->where("citizen_id", $id)->delete();
        if ($request["projects"]) {
            foreach ($request["projects"] as $link)
                \DB::table("citizen_project")->insert(["citizen_id" => $id,
                    "project_id" => $link]);
        }
        Session::flash("msg", "i:تمت عملية الحفظ بنجاح");
        return redirect("/account/citizen");
    }

    public function formincitizen($id, Request $request)
    {
        $read = $request["read"] ?? "";
        $evaluate = $request["evaluate"] ?? "";
        $q = $request["q"] ?? "";
        $datee = $request["datee"] ?? "";
        $status = $request["status"] ?? "";
        $type = $request["type"] ?? "";
        $sent_type = $request["sent_type"] ?? "";
        $project_id = $request["project_id"] ?? "";
        $from_date = $request["from_date"] ?? "";
        $to_date = $request["to_date"] ?? "";
        $category_id = $request["category_id"] ?? "";
        $keywords = preg_split("/[\s,]+/", $q);

        if (count($keywords) == 3) {
            $keywords[3] = "";
        }
        if (count($keywords) == 2) {
            $keywords[2] = "";
            $keywords[3] = "";
        }
        if (count($keywords) == 1) {
            $keywords[1] = "";
            $keywords[2] = "";
            $keywords[3] = "";
        }
        $item = Citizen::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }
        $items = $item->forms()->whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
            ->join('project_status', 'projects.active', '=', 'project_status.id')
            ->join('sent_type', 'forms.sent_type', '=', 'sent_type.id')
            ->join('form_status', 'forms.status', '=', 'form_status.id')
            ->join('form_type', 'forms.type', '=', 'form_type.id')
            ->join('categories', 'categories.id', '=', 'forms.category_id')
            ->join('citizens', 'citizens.id', '=', 'forms.citizen_id')
            ->select('forms.id',
                'citizens.first_name', 'citizens.father_name', 'citizens.grandfather_name', 'citizens.last_name', 'citizens.id_number'
                , 'categories.name as nammes', 'forms.title',
                'projects.name as zammes', 'project_status.name as sammes',
                'forms.datee', 'form_status.name as fammes'
                , 'form_type.name as zzammes', 'sent_type.name as ozammes', 'forms.content')
            ->whereRaw("true");
        if ($q)
            $items->whereRaw("(
            (first_name like ? and father_name like ? and grandfather_name like ? and last_name like ?)
            or (first_name like ? and last_name like ? and grandfather_name like ? and father_name like ?)
            or (first_name like ? and grandfather_name like ? and last_name like ? and father_name like ?)
            or (father_name like ? and grandfather_name like ? and first_name like ? and last_name like ?)
            or (father_name like ? and last_name like ? and grandfather_name like ? and first_name like ?)
            or (grandfather_name like ? and last_name like ? and father_name like ? and first_name like ?)
            or first_name like ? or  father_name like? or grandfather_name like?  or  last_name like?

            or projects.name like ? or forms.title like ? or forms.id like ? or citizens.id_number like ?)"
                , ["%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$q%", "%$q%", "%$q%", "%$q%",

                    "%$q%", "%$q%", "%$q%", "%$q%"]);
        if ($evaluate) {

            if ($evaluate == 1) {
                $items->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
                    ->where("form_follows.solve", ">=", "0");
            } elseif ($evaluate == 2) {
                $items->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
                    ->where("form_follows.solve", "=", "1");
            } elseif ($evaluate == 3) {
                $items->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
                    ->where("form_follows.solve", "=", "2");
            } elseif ($evaluate == 4) {


                $items->whereNotIn('forms.id', function ($query) {
                    $query->select('form_follows.form_id')
                        ->where("form_follows.solve", ">=", "1")
                        ->from('form_follows');

                });
            }
        }
        // if ($category_id && $type == 1)
        //     $items->whereRaw("(category_id = ?)"
        //         , [$category_id]);
        // if ($project_id || $project_id == '0')
        //     if ($project_id == '-1')
        //         $items->whereRaw("(projects.id > ?)"
        //             , ["1"]);
        //     else
        //         $items->whereRaw("(projects.id = ?)"
        //             , ["$project_id"]);
        // if ($from_date && $to_date) {
        //     $items = $items->whereRaw("datee >= ? and datee <= ?", [$from_date, $to_date]);
        // }
        // if ($datee)
        //     $items = $items->whereRaw("datee = ?", [$datee]);
        // if ($status)
        //     $items = $items->whereRaw("status = ?", [$status]);
        // if ($type)
        //     $items = $items->whereRaw("type = ?", [$type]);
        // if ($sent_type)
        //     $items = $items->whereRaw("sent_type = ?", [$sent_type]);
        // if ($read) {
        //     if ($read == 1)
        //         $items = $items->whereRaw(" `read` = ?", [$read]);
        //     else
        //         $items = $items->whereNull("read");
        // }



        $items = $items->where(function($query){

        //     return $query->when( request('id') , function($query){

        //         return $query->where('forms.id' , request('id'));

        //     });

        })->where(function($query){

            return $query->when( request('form_status') , function($query){

                return $query->where('status' , request('form_status'));

            });

        })->where(function($query){

            return $query->when( request('type') , function($query){

                return $query->where('forms.type' , request('type'));

            });

        })->where(function($query){

            return $query->when( request('id_number') , function($query){

                return $query->where('citizens.id_number' , request('id_number'));

            });

        })->where(function($query){

            return $query->when( request('category_name') == "0" , function($query){

                return $query->where(  'forms.project_id' , '!=', 1);

        });

        })->where(function($query){

            return $query->when( request('category_name') == "1" , function($query){

                return $query->where(  'forms.project_id' , 1);

        });

        })->where(function($query){

        return $query->when( request('evaluate') , function($query){

            return $query->where('evaluate' , request('evaluate'));

        });

        })->where(function($query){

        return $query->when( request('project_id') , function($query){

            return $query->where('project_id' , request('project_id'));

        });

        })->where(function($query){

            return $query->when( request('sent_type') , function($query){

                return $query->where('sent_type' , request('sent_type'));

        });
        })->where(function($query){

            return $query->when( request('category_id') , function($query){

                return $query->where('category_id' , request('category_id'));

        });

        })->where(function($query){

            return $query->when( request('datee') , function($query){

                return $query->whereDate('forms.datee' , request('datee'));

        });

        })->where(function($query){

            return $query->when( request('from_date') , function($query){

                return $query->where([['forms.datee' ,'>=', request('from_date')] , ['forms.datee' ,'<=', request('to_date')]]);

        });

        })->where(function($query){

            return $query->when( request('to_date') , function($query){

                return $query->where([['forms.datee' ,'>=', request('from_date')] , ['forms.datee' ,'<=', request('to_date')]]);

        });

    })->orderBy("forms.id", 'desc')->get();







        // $items = $items->orderBy("forms.id", 'desc')->get();
        $projects = Account::find(auth()->user()->account->id)->projects->all();
        $categories = auth()->user()->account->circle->category->all();
        $form_type = Form_type::all();
        $form_status = Form_status::all();
        $sent_typee = Sent_type::all();
        if ($request['theaction'] == 'excel')
            return Excel::download(new CitizenFormExport($id), "citizen_".date('dmYHS').".xlsx");
        elseif ($request['theaction'] == 'print') {
            $items = Form::find($items->pluck('id'));
            $pdf = PDF::loadView('account.form.printall', compact('items', "projects"));
            return $pdf->stream('forms_' . $item->first_name . ' ' . $item->last_name . '.pdf');
        } else {

            if ($request['theaction'] == 'search'){
                $items = Form::whereIn('id', $items->pluck('id'))->paginate(5);

                $items->appends([
                    'form_id' => request('form_id'),
                    'theaction'=>'search',
                    'id_number'=>request('id_number'),
                    'project_id'=>request('project_id'),
                    'category_name' => request('category_name'),
                    'sent_type'=> request('sent_type'),
                    'type' => request('type'),
                    'category_id'=> request('category_id'),
                    'form_status'=> request('form_status'),
                    'evaluate' => request('evaluate'),
                    'datee'=> request('datee'),
                    'from_date'=> request('from_date'),
                    'to_date'=> request('to_date'),

                ]);
            }else{
                $items  = "" ;
            }

            return view("account.citizen.formincitizen", compact("items", "form_type", "form_status", "sent_typee", "item", "projects", "type", "categories"));
        }
    }

}
