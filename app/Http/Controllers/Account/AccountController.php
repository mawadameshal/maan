<?php

namespace App\Http\Controllers\Account;

use App\Account_rate;
use App\Circle;
use App\Form_response;
use App\Form_status;
use App\Form_type;
use App\Sent_type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Form;
use App\Account;
use App\Rules\IdNumber;
use App\Project;
use App\User;
use App\Category;
use App\AccountProjects;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AccountRequest;
use DB;
use App\Imports\FormsExport;
use Maatwebsite\Excel\Facades\Excel;
use  PDF;
use Illuminate\Support\Facades\Storage;

class AccountController extends BaseController
{
    public function index(Request $request)
    {
        $q = $request["q"] ?? "";
        $q1 = $request["q1"] ?? "";
        $the_type = $request["the_type"] ?? "";
        $circles = $request["circles"] ?? "";
        $circles1 = $request["circles1"] ?? "";
        $accounts = $request["accounts"]?? "";
        $project_id = $request["project_id"] ?? "";
        $project_id1 = $request["project_id1"] ?? "";
        $account_id = $request["account_id"] ?? "";
        $rate_id = $request["rate_id"] ?? "";
        $items = Account::whereRaw("true");
        if ($items == null) {
            session::flash('msg', 'w:نأسف لا يوجد بيانات لعرضها');
            return redirect('/account/account');
        }

        if ($q)
            $items->whereRaw("(full_name like ? or email like ? or mobile like ?)"
                , ["%$q%", "%$q%", "%$q%"]);

        if ($q1){
            $items->whereRaw("(full_name like ?)"
                , ["%$q1%"]);

            $circlesfind = Circle::whereRaw("(name like ?)"
                , ["%$q1%"])->orderBy("name")->pluck('id');

            $items->orWhereIn("circle_id"
                , $circlesfind);
        }

        if ($circles)
            $items->where("circle_id", "=", $circles);

        if ($circles1)
            $items->where("circle_id", "=", $circles1);


        if ($project_id || $project_id == '0') {
            $accountsids = Project::find($project_id)->account_projects->pluck('account_id');
            $items->whereIn("id"
                , $accountsids);
        }

        if ($project_id1 || $project_id1 == '0') {
            $accountsids = Project::find($project_id1)->account_projects->pluck('account_id');
            $items->whereIn("id"
                , $accountsids);
        }
        if ($accounts)
            $items->where("account_id", "=", $accounts);

            if ($account_id){
                $items->where("full_name",  $account_id);

            }
        //the_type
        if ($the_type) {
            $items->where("type", "=", $the_type);
        }

        if ($request['theaction'] == 'search')
        {
            $items = $items->orderBy("full_name")->paginate(5)->appends([
                "q" => $q, "circles" => $circles,"full_name" => $account_id ,"account_id" => $account_id ,
                "project_id" => $project_id, "the_type" => $the_type, "rate_id" => $rate_id, "theaction" => 'search']);

        }elseif ($request['themainaction'] == 'search')
        {
            $items = $items->orderBy("full_name")->paginate(5)->appends([
                "q1" => $q1, "circles1" => $circles1, "project_id1" => $project_id1]);

        }else{
            $items  = "" ;
        }


            $circles = Circle::all();
        $projects = Project::all();
        $accounts = Account::all();
        $account_rates=Account_rate::all();
        return view("account.account.index", compact('items','account_rates','circles', 'projects' ,'accounts'));
    }

    public function create()
    {
        $circles = Circle::all();
        return view("account.account.create", compact('circles'));
    }

    public function store(AccountRequest $request)
    {
        $this->validate($request,$request->rules());

        $password = $request["password"];

        $user_id = DB::table('users')->insertGetId([
            'name' => $request["user_name"],
            'email' => $request["email"],
            'id_number' => $request["id_number"],
            'password' => bcrypt($password)
        ]);
        $request["user_id"] = $user_id;
        $request["type"] = 2;
        $theid = Account::create($request->all())->id;
        Session::flash("msg", "تمت عملية الاضافة بنجاح");
        // dd($theid);
        return redirect("/account/account/permission/$theid");
    }

    public function edit($id)
    {
        $item = Account::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/account");
        }
        $circles = Circle::all();
        return view("account.account.edit", compact("item", "circles"));
    }

    public function profile($id)
    {
        $item = Account::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/account");
        }
        if ($item->id != auth()->user()->account->id) {
            Session::flash("msg", "e:لا تملك الصلاحية التعديل");
            return redirect("/account/account");
        }
        $circles = Circle::all();
        return view("account.account.profile", compact("item", "circles"));
    }

    public function profileup(ProfileRequest $request, $id)
    {
        $testeroor = $this->validate($request, [
            'imge' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $isExists = Account::where("email", $request["email"])->where("id", "!=", $id)->count();
        if ($isExists) {
            Session::flash("msg", "e:القيمة المدخلة موجودة مسبقاً");
            return redirect("/account/account/$id/edit");
        }//
        $isExists = Account::where("user_name", $request["user_name"])->where("id", "!=", $id)->count();
        if ($isExists) {
            Session::flash("msg", "e:القيمة المدخلة موجودة مسبقاً");
            return redirect("/account/account/$id/edit");
        }
        $item = Account::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account");
        }
        $user = User::find($item->user_id);
        if ($request["password"] != "") {
            $user->password = bcrypt($request["password"]);
        }
        $user->name = $request["user_name"];

        if ($request->hasFile('imge')) {
            //deleted old
            $aoldimg = $item->getAttribute('image');
            $mypath = public_path() . '/images/' . $item['id'] . '/';
            if (file_exists($mypath . $aoldimg) && $aoldimg != null) {
                unlink($mypath . $aoldimg);
            }
            $imge = $request->file('imge');
            $imagename = rand(11111, 99999) . '.' . $imge->getClientOriginalExtension();
            if (!file_exists(public_path() . '/images/' . $item['id']))
                Storage::disk('uploads')->makeDirectory('/images/' . $item['id']);

            $imge->move(public_path() . '/images/' . $item['id'] . '/', $imagename);
            // $item->fill(['image'=>$imagename]);
            //$imagename
            //$item->save();
            unset($request['imge']);
            $request['image'] = $imagename;

        }
//dd($request->all());
        $item->update($request->all());
        /**********تعديل الإسم بالمشاريع***********/
        $hisprojectsid=$item->account_projects->pluck('project_id')->toArray();
        for($i=0;$i>count($hisprojectsid);$i++){
            $manager = "";
            $supervisor = "";
            $coordinator = "";
            $support = "";
            $project = Project::find($hisprojectsid[$i]);
            if ($project->account_projects->where('rate', '=', '1')->first()) {
                $manager = $project->account_projects->where('rate', '=', '1')->first()->account->full_name;
            }
            if ($project->account_projects->where('rate', '=', '2')->first()) {
                $supervisor = $project->account_projects->where('rate', '=', '2')->first()->account->full_name;
            }
            if ($project->account_projects->where('rate', '=', '3')->first()) {
                $coordinator = $project->account_projects->where('rate', '=', '3')->first()->account->full_name;
            }
            if ($project->account_projects->where('rate', '=', '4')->first()) {
                $support = $project->account_projects->where('rate', '=', '4')->first()->account->full_name;
            }
            $project->update([
                'manager' => $manager
                , 'supervisor' => $supervisor
                , 'coordinator' => $coordinator
                , 'support' => $support]);

        }
        Session::flash("msg", "i:تمت عملية الحفظ بنجاح");
        return redirect("/account");
    }

    public function update(AccountRequest $request, $id)
    {
        $item = Account::find($id);

        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/account");
        }
        $this->validate($request,$request->rules($id));
//        $this->validate($request,$request->rules());
        $user = User::find($item->user_id);
        if ($request["password"] != "") {
            $user->password = bcrypt($request["password"]);
        }
        $user->name = $request["user_name"];
        $user->save();

        $item->update($request->all());
        if($item->type==2) {
        \DB::table("account_link")->where("account_id", $id)->whereIn("link_id", [1, 2, 3, 4, 5, 6, 7, 8, 9])->delete();

        }
/**********تعديل الإسم بالمشاريع***********/
       $hisprojectsid=$item->account_projects->pluck('project_id')->toArray();
       for($i=0;$i>count($hisprojectsid);$i++){
           $manager = "";
           $supervisor = "";
           $coordinator = "";
           $support = "";
           $project = Project::find($hisprojectsid[$i]);
           if ($project->account_projects->where('rate', '=', '1')->first()) {
               $manager = $project->account_projects->where('rate', '=', '1')->first()->account->full_name;
           }
           if ($project->account_projects->where('rate', '=', '2')->first()) {
               $supervisor = $project->account_projects->where('rate', '=', '2')->first()->account->full_name;
           }
           if ($project->account_projects->where('rate', '=', '3')->first()) {
               $coordinator = $project->account_projects->where('rate', '=', '3')->first()->account->full_name;
           }
           if ($project->account_projects->where('rate', '=', '4')->first()) {
               $support = $project->account_projects->where('rate', '=', '4')->first()->account->full_name;
           }
           $project->update([
               'manager' => $manager
               , 'supervisor' => $supervisor
               , 'coordinator' => $coordinator
               , 'support' => $support]);

       }


        Session::flash("msg", "i:تمت عملية الحفظ بنجاح");
        return redirect("/account/account/".$id."/edit");
    }

    public function destroy($id)
    {
        $item = Account::find($id);
        if ($item == NULL || Auth::user()->account->id == $item->id || $item->id == 1) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/account");
        }
        if ($item->projects->toArray() != null) {
            Session::flash("msg", "e:لا يمكن حذف الموظف اذا كان مشترك في مشاريع");
            return redirect("/account/account");
        } else {
            $item = Account::find($id);
            $aoldimg = $item->getAttribute('image');
            $mypath = public_path() . '/images/' . $item['id'] . '/';
            if (file_exists($mypath . $aoldimg) && $aoldimg != null) {
                unlink($mypath . $aoldimg);
            }
            if ($item->form_response->first()) {
                $form_response = $item->form_response->pluck('id');
                Form_response::destroy($form_response);

            }
            $projects = Project::all();
            foreach ($projects as $project) {
                if ($project->supervisor == $item->full_name)
                    $project->supervisor = "";
                if ($project->manager == $item->full_name)
                    $project->manager = "";
                if ($project->coordinator == $item->full_name)
                    $project->coordinator = "";
                if ($project->support == $item->full_name)
                    $project->support = "";
            }

            $accounlin = DB::table('account_link')->whereIn('account_id', [$item->id])->pluck('id');
            if (count($accounlin) > 0)
                DB::table('account_link')->whereIn('id', $accounlin)->delete();
            $theuser = $item->user;
            $item->delete();

            $theuser->delete();
            Session::flash("msg", "تم حذف موظف بنجاح");
            return redirect("/account/account");
        }


    }

    public function permission($id)
    {
        $item = Account::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/account");
        }
        return view("account.account.permission", compact("item"));
    }

    public function permissionPost(Request $request, $id)
    {
        $item = Account::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/account");
        }
        \DB::table("account_link")->where("account_id", $id)->delete();
        if ($request["permission"]) {
            foreach ($request["permission"] as $link)
                \DB::table("account_link")->insert(["account_id" => $id,
                    "link_id" => $link]);
        }
        Session::flash("msg", "i:تمت عملية الحفظ بنجاح");
        return redirect("/account/account/select-project/$id");
        //return redirect("/account/account");
    }

    public function formtoaccount($id, Request $request)
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
        $item = Account::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }
        $form_responses = $item->form_response->pluck('form_id');
        //$items= Form::find($form_responses);
        $items = Form::whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->pluck('projects.id'))
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
                'projects.name as zammes', 'project_status.name as pstaname',
                'forms.datee', 'form_status.name as satname'
                , 'form_type.name as typname', 'sent_type.name as senname', 'forms.content')
            ->whereRaw("true");;
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
        if ($category_id && $type == 1)
            $items->whereRaw("(category_id = ?)"
                , [$category_id]);
        if ($project_id || $project_id == '0')
            if ($project_id == '-1')
                $items->whereRaw("(projects.id > ?)"
                    , ["1"]);
            else
                $items->whereRaw("(projects.id = ?)"
                    , ["$project_id"]);
        if ($from_date && $to_date) {
            $items = $items->whereRaw("datee >= ? and datee <= ?", [$from_date, $to_date]);
        }
        if ($datee)
            $items = $items->whereRaw("datee = ?", [$datee]);
        if ($status)
            $items = $items->whereRaw("status = ?", [$status]);
        if ($type)
            $items = $items->whereRaw("type = ?", [$type]);
        if ($sent_type)
            $items = $items->whereRaw("sent_type = ?", [$sent_type]);

        if ($read) {
            if ($read == 1)
                $items = $items->whereRaw(" `read` = ?", [$read]);
            else
                $items = $items->whereNull("read");
        }

        $items = $items->orderBy("forms.id", 'desc')->get()->find($form_responses);
        $projects = Account::find(auth()->user()->account->id)->projects->all();
        $categories = auth()->user()->account->circle->category->all();
        $form_type = Form_type::all();
        $form_status = Form_status::all();
        $sent_typee = Sent_type::all();
        if ($request['theaction'] == 'excel')
            return Excel::download(new FormsExport($items), 'forms.xlsx');
        elseif ($request['theaction'] == 'print') {

            $items = Form::find($items->pluck('id'));
            $pdf = PDF::loadView('account.form.printall', compact('items', "projects"));
            return $pdf->stream('document.pdf');
        } else {
            $items = Form::whereIn('id',$items->pluck('id'))->paginate(5);
            return view("account.account.formtoaccount", compact("items","form_type","form_status","sent_typee" , "item", "projects", "type", "categories"));
        }

    }

    public function forminaccount($id, Request $request)
    {
        $item = Account::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/account");
        }
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
                'projects.name as zammes', 'project_status.name as pstaname',
                'forms.datee', 'form_status.name as staname'
                , 'form_type.name as typname', 'sent_type.name as senname', 'forms.content')
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



        // if ($evaluate) {

        //     if ($evaluate == 1) {
        //         $items->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
        //             ->where("form_follows.solve", ">=", "0");
        //     } elseif ($evaluate == 2) {
        //         $items->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
        //             ->where("form_follows.solve", "=", "1");
        //     } elseif ($evaluate == 3) {
        //         $items->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
        //             ->where("form_follows.solve", "=", "2");
        //     } elseif ($evaluate == 4) {


        //         $items->whereNotIn('forms.id', function ($query) {
        //             $query->select('form_follows.form_id')
        //                 ->where("form_follows.solve", ">=", "1")
        //                 ->from('form_follows');

        //         });
        //     }
        // }
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

        // $items = $items->orderBy("forms.id", 'desc')->get();

        $items = $items->where(function($query){

            return $query->when( request('status') , function($query){

                return $query->where('status' , request('status'));

            });



        })->where(function($query){

            return $query->when( request('type') , function($query){

                return $query->where('forms.type' , request('type'));

            });



        })->where(function($query){

            return $query->when( request('form_id') , function($query){

                return $query->where('forms.id' , request('form_id'));

            });




        })->where(function($query){

            return $query->when( request('id_number') , function($query){

                return $query->where('citizens.id_number' , request('id_number'));

            });




        })->where(function($query){

            return $query->when( request('citizen_id') , function($query){

                return $query->where('citizens.first_name' , 'like' ,   request('citizen_id'));

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

                return $query->whereDate('forms.datee' ,Carbon::parse(request('datee'))->format('Y-m-d'));

        });

        })->where(function($query){

            return $query->when( request('from_date') , function($query){

                return $query->where([['forms.datee' ,'>=', Carbon::parse(request('from_date'))->format('Y-m-d')] , ['forms.datee' ,'<=', Carbon::parse(request('to_date'))->format('Y-m-d')]]);

        });

        })->where(function($query){

            return $query->when( request('to_date') , function($query){

                return $query->where([['forms.datee' ,'>=', Carbon::parse(request('from_date'))->format('Y-m-d')] , ['forms.datee' ,'<=', Carbon::parse(request('to_date'))->format('Y-m-d')]]);

        });

    })->orderBy("forms.id", 'desc')->get();







        if ($items == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }
        $projects = Account::find(auth()->user()->account->id)->projects->all();
        $categories = auth()->user()->account->circle->category->all();
        $form_type = Form_type::all();
        $form_status = Form_status::all();
        $sent_typee = Sent_type::all();

        if ($request['theaction'] == 'excel') {
            return Excel::download(new FormsExport($items), 'forms.xlsx');
        } elseif ($request['theaction'] == 'print') {

            $items = Form::find($items->pluck('id'));
            $pdf = PDF::loadView('account.form.printall', compact('items', "projects"));
            return $pdf->stream('document.pdf');
        } else {

            if ($request['theaction'] == 'search'){
                $items = Form::whereIn('id', $items->pluck('id'))->paginate(5);
                $items->appends(['q' => $q,'theaction'=>'search','read'=>$read,'evaluate'=>$evaluate,
                    'from_date' => $from_date,'to_date'=>$to_date,
                    'category_id' => $category_id,'datee'=>$datee,'status'=>$status,
                    'type' => $type,'sent_type'=>$sent_type,'project_id'=>$project_id,
                ]);
            }elseif ($request['themainaction'] == 'search')
            {
                $items = Form::whereIn('id', $items->pluck('id'))->paginate(5);
                $items->appends(['q' => $q,'theaction'=>'search','read'=>$read,'evaluate'=>$evaluate,
                    'from_date' => $from_date,'to_date'=>$to_date,
                    'category_id' => $category_id,'datee'=>$datee,'status'=>$status,
                    'type' => $type,'sent_type'=>$sent_type,'project_id'=>$project_id,
                ]);


            }else{
                $items  = "" ;
            }

            return view("account.account.forminaccount", compact("items","form_type","form_status","sent_typee" , "item", "projects", "type", "categories"));
        }
    }

    public function selectproject($id)
    {
        $item = Account::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/account");
        }
        $projects = Project::all();
        $account_rates=Account_rate::all();
        return view("account.account.add-toproject", compact("account_rates","item","projects"));
    }

    public function selectprojectPost(Request $request, $id)
    {
        $item = Account::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/account");
        }
        \DB::table("account_project")->where("account_id", $id)->delete();

        if ($request["projects"]) {

            for ($i = 0; $i < count($request["projects"]); $i++) {
                if ($request["projects"][$i] == 0)
                    continue;
                if (!$request["rates"][$i]) {
                    Session::flash("msg", "e:يجب ادخال دورا للموظف");
                    return redirect("/account/select-project");
                } else {

                    $test = \DB::table("account_project")->insertGetID(["account_id" => $id,
                        "project_id" => $request["projects"][$i]
                        , "rate" => $request["rates"][$i]
                        , "to_delete" => $request["to_delete"][$i]
                        , "to_add" => $request["to_add"][$i]
                        , "to_edit" => $request["to_edit"][$i]
                        , "to_replay" => $request["to_replay"][$i]
                        , "to_stop" => $request["to_stop"][$i]
                        , "to_notify" => $request["to_notify"][$i]
                    ]);

                    /**************اضافتهم بالبروجكت*************/
                    $manager = "";
                    $supervisor = "";
                    $coordinator = "";
                    $support = "";
                    $item = Project::find($request["projects"][$i]);
                    if ($item->account_projects->where('rate', '=', '1')->first()) {
                        $manager = $item->account_projects->where('rate', '=', '1')->first()->account->full_name;
                    }
                    if ($item->account_projects->where('rate', '=', '2')->first()) {
                        $supervisor = $item->account_projects->where('rate', '=', '2')->first()->account->full_name;
                    }
                    if ($item->account_projects->where('rate', '=', '3')->first()) {
                        $coordinator = $item->account_projects->where('rate', '=', '3')->first()->account->full_name;
                    }
                    if ($item->account_projects->where('rate', '=', '4')->first()) {
                        $support = $item->account_projects->where('rate', '=', '4')->first()->account->full_name;
                    }
                    $item->update([
                        'manager' => $manager
                        , 'supervisor' => $supervisor
                        , 'coordinator' => $coordinator
                        , 'support' => $support]);

                }
            }

        }
        Session::flash("msg", "i:تمت عملية الحفظ بنجاح");
        return redirect("/account/account");
    }

}
