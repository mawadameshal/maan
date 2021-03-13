<?php

namespace App\Http\Controllers\Account;
;

use App\AccountProjects;
use App\appendix;
use App\CategoryCircles;
use App\Form_status;
use App\Form_type;
use App\Http\Requests\Form_responseRequest;
use App\Project_status;
use App\Recommendation;
use App\Sent_type;
use App\User;
use Carbon\Carbon;
use http\Env\Response;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use App\Form;
use App\Form_response;
use App\Form_follow;
use App\Form_file;
use  PDF;
use App\Imports\FormsExport;
use App\Imports\DeletedFormsExport;
use App\Imports\Deleted_formsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Category;
use App\Project;
use App\Account;
use App\Citizen;
use App\Circle;
use App\Http\Requests\FormRequest;

class FormController extends BaseController
{


    public function change_response($id , Request $request){

        $response_type = $request->response_type ;
        $form = Form::find($id);
        $form->update([
            'response_type' =>  $response_type,
        ]);
        $form->save();
        return back();
    }



    public function update_form_data($id , Request $request){
        $data = $request->validate([
            'required_respond' => 'required',
            'form_data' => 'required',
            'form_file' => 'sometimes|nullable|max:6400|mimes:jpeg,bmp,png,gif,svg,pdf,docx,xls,xlsx,txt,File',
        ]);

        if ($request->hasFile('form_file')) {
            $myfile = $request->file('form_file');
            $filename = rand(11111, 99999) . '.' . $myfile->getClientOriginalExtension();
            $myfile->move(public_path() . '/uploads/files/', $filename);
            $data['form_file'] = $filename;
        }
        $form = Form::find($id);
        $form->update([
            'required_respond'=>$data['required_respond'],
            'form_data'=>$data['form_data'],
            'form_file'=>$data['form_file'],
        ]);
        $form->save();
        return back()->with('success' , 'تم تحديث البيانات بنجاح');
    }

    public function change_response_and_update_form_data($id , Request $request){
        $form = Form::find($id);

        $response_type = $request->response_type ;
        $required_respond = $request->required_respond ;
        $form_data = $request->form_data ;
        $form_file = "";


        if($request->hasFile('form_file')){
            $fileName = time().'.'.$request->form_file->extension();
            $request->form_file->move(public_path('uploads/files'), $fileName);
            $form_file=$fileName;
        }

        $form->response_type = $response_type;
        $form->required_respond = $required_respond;
        $form->form_data = $form_data;
        $form->form_file = $form_file;
        $form->save();


        // add_repaly

        if($request->response){
            $form->fill(['status' => '2']);
            $form->save();

            $item = new Form_response();
            $request['form_id'] = $id;
            $request['datee'] = date('Y-m-d');
            $request['account_id'] = Auth::user()->account->id;
            $item::create($request->all());

            $categoryCircles_users1 = $auth_circle_users = array();

            $categoryCircles = CategoryCircles::where('category' ,'=', $form->category->id)
                ->get();

            $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$form->project_id)
                ->pluck('rate','account_id')->toArray();

            foreach ($categoryCircles as $categoryCircle){
                if($categoryCircle->procedure_type == 3){
                    array_push($categoryCircles_users1,$categoryCircle->circle);
                }
            }

            foreach ($userinprojects as $key=>$userinproject){
                if(in_array($userinproject,$categoryCircles_users1)){
                    array_push($auth_circle_users,$key);
                }

            }

            foreach($auth_circle_users as $AccountProjects_user){
                $user = Account::find($AccountProjects_user);
                NotificationController::insert(['user_id' => $user->user_id, 'type' => 'موظف','form_id' => $form->id, 'title' => 'لديك اقتراح/ شكوى جديدة بحاجة للمصادقة على الرد', 'link' => "/citizen/form/show/" . $form->citizen->id_number . "/$form->id"]);
            }
        }

        return back()->with(['success' => true ,'msg' => "تم ارسال الرد للمصادقة بنجاح"]);

    }

    public function change_replay_status_feedback($id , Request $request){
        $form = Form::find($id);

        $Form_follow = new Form_follow();
        $Form_follow->form_id=$form->id;
        $Form_follow->citizen_id=$form->citizen_id;
        $Form_follow->account_id=Auth::user()->account->id;;
        $Form_follow->solve= $request['follow_form_status'];
        $Form_follow->follow_reason_not= $request['follow_reason_not'];
        $Form_follow->evaluate=$request['evaluate'];
        $Form_follow->notes=$request['notes'];
        $Form_follow->datee=date('Y-m-d');
        $Form_follow->save();

        if ($request['evaluate'] && ($request['evaluate'] == 1 || $request['evaluate'] == 2 || $request['evaluate'] == 3)){
            $form->fill(['status' => '3']);
            $form->save();
        }
            $categoryCircles_users1 = $auth_circle_users = array();

            $categoryCircles = CategoryCircles::where('category' ,'=', $form->category->id)
                ->get();

            $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$form->project_id)
                ->pluck('rate','account_id')->toArray();

            foreach ($categoryCircles as $categoryCircle){
                if($categoryCircle->procedure_type == 5){
                    array_push($categoryCircles_users1,$categoryCircle->circle);
                }

                if($categoryCircle->procedure_type == 2){
                    array_push($categoryCircles_users1,$categoryCircle->circle);
                }
            }

            foreach ($userinprojects as $key=>$userinproject){
                if(in_array($userinproject,$categoryCircles_users1)){
                    array_push($auth_circle_users,$key);
                }

            }

            foreach($auth_circle_users as $AccountProjects_user){
                $user = Account::find($AccountProjects_user);
                NotificationController::insert(['user_id' => $user->user_id, 'type' => 'موظف','form_id' => $form->id, 'title' => 'تنبيه بإتمام المهمة ', 'link' => "/citizen/form/show/" . $form->citizen->id_number . "/$form->id"]);
            }

        return back()->with(['success' => true ,'msg' => "تم حفظ التغذية الراجعة بنجاح"]);

    }

    public function change_confirm_and_update_form_data($id , Request $request){
        $form = Form::find($id);

        if($form->form_response){
            $item = Form_response::where(['form_id'=>$id])->first();
            if($item){
                $item->objection_response = $request->optradio8;
                $item->confirm_account_id = Auth::user()->account->id;
                $item->confirmation_date = date('Y-m-d');
                $item->confirmation_status = 2;
                if($request->optradio8 == 1){
                    $item->old_response = $request->old_response;
                }
                $item->save();

            }
        }

        // Notifications
        $categoryCircles_users1 = $auth_circle_users = array();
        $categoryCircles = CategoryCircles::where('category' ,'=', $form->category->id)
            ->get();
        $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$form->project_id)
            ->pluck('rate','account_id')->toArray();
        foreach ($categoryCircles as $categoryCircle){
            if($categoryCircle->procedure_type == 4){
                array_push($categoryCircles_users1,$categoryCircle->circle);
            }
        }
        foreach ($userinprojects as $key=>$userinproject){
            if(in_array($userinproject,$categoryCircles_users1)){
                array_push($auth_circle_users,$key);
            }

        }
        foreach($auth_circle_users as $AccountProjects_user){
            $user = Account::find($AccountProjects_user);
            NotificationController::insert(['user_id' => $user->user_id, 'type' => 'موظف','form_id' => $form->id, 'title' => 'لديك اقتراح/ شكوى جديدة بحاجة لتبليغ الرد', 'link' => "/citizen/form/show/" . $form->citizen->id_number . "/$form->id"]);
        }


        return back()->with(['success' => true ,'msg' => "تم المصادقة بنجاح"]);

    }


//changecategory
    public function changecategory($id, Request $request)
    {

        $item = Form::whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->with('account_projects')->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->with('circle_categories')->pluck('categories.id'))
            ->find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }

        if ($item->category_id) {
            $item->old_category_id = $item->category_id;
            $item->change_by = \auth()->user()->id;
            $item->user_change_category_id = \auth()->user()->id;
            $item->category_id = $request['category_id'];
            $item->save();

            $theform = $item;
            if ($theform->project->account_projects->first() && $theform->category->circle_categories->first()) {
                $accouts_ids_in_circle = Account::WhereIn('circle_id', $theform->category->circle_categories->where('to_notify', 1)
                    ->pluck('circle_id')->toArray())->where('id','!=',auth()->user()->id)->pluck('id')->toArray();
                $accouts_ids_in_project = $theform->project->account_projects->where('to_notify', 1)
                    ->where('account_id','!=',auth()->user()->id)->pluck('account_id')->toArray();
                $accouts_ids = array_merge($accouts_ids_in_circle, $accouts_ids_in_project);

                $users_ids = Account::find($accouts_ids)->pluck('user_id');
                for ($i = 0; $i < count($users_ids); $i++) {
//                    if (User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id))
                    if (check_permission_with_user_id('الإشعارات', $users_ids[$i]))
                        NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'من موظف', 'title' => 'تم تعديل فئة غير مناسبة لشكوى', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);

                }
            }

            return Response(['success' => true,'msg' => "تم تغيير الفئة بنجاح",'thecat' => Category::find($request['category_id'])->name]);
        }



    }

    public function clarification_from_citizian($id, Request $request)
    {

        $item = Form::whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->with('account_projects')->pluck('projects.id'))
            ->find($id);

        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }




        if ($request['need_clarification']){

            $item->need_clarification = $request["need_clarification"] ?? $item->need_clarification;
            $item->have_clarified = $request['have_clarified'] ?? $item->have_clarified;
            $item->reprocessing = $request['reprocessing'] ?? $item->reprocessing;
            $item->reformulate_content =  $request['reformulate_content'] ?? $item->reformulate_content;
            $item->user_change_content_id = auth()->user()->account->id ?? $item->user_change_content_id;
            $item->reason_lack_clarification = $request['reason_lack_clarification'] ?? $item->reason_lack_clarification;
            $item->user_change_content_id = auth()->user()->account->id ?? $item->user_change_content_id;
            $item->reprocessing_recommendations = $request['reprocessing_recommendations'] ?? $item->reprocessing_recommendations;
            $item->user_reprocessing_recommendations_id = auth()->user()->account->id ?? $item->user_reprocessing_recommendations_id;
            $item->save();

            if(!empty($request['reason_lack_clarification'])){

                $categoryCircles_users1 = $auth_circle_users = array();

                $categoryCircles = CategoryCircles::where('category' ,'=', $item->category->id)
                    ->get();

                $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$item->project_id)
                    ->pluck('rate','account_id')->toArray();

                foreach ($categoryCircles as $categoryCircle){
                    if($categoryCircle->procedure_type == 5){
                        array_push($categoryCircles_users1,$categoryCircle->circle);
                    }
                }

                foreach ($userinprojects as $key=>$userinproject){
                    if(in_array($userinproject,$categoryCircles_users1)){
                        array_push($auth_circle_users,$key);
                    }

                }

                foreach($auth_circle_users as $AccountProjects_user){
                    $user = Account::find($AccountProjects_user);
                    NotificationController::insert(['user_id' => $user->user_id, 'type' => 'موظف','form_id' => $item->id, 'title' => 'تنبيه بوجود اقتراح / شكوى لا يمكن الاستيضاح عن مضمونه/ا', 'link' => "/citizen/form/show/" . $item->citizen->id_number . "/$item->id"]);
                }
            }
        }

        if(!empty($request['reprocessing_recommendations'])){
            $item->need_clarification = $request["need_clarification"] ?? $item->need_clarification;
            $item->have_clarified = $request['have_clarified'] ?? $item->have_clarified;
            $item->reprocessing = $request['reprocessing'] ?? $item->reprocessing;
            $item->reformulate_content =  $request['reformulate_content'] ?? $item->reformulate_content;
            $item->user_change_content_id = auth()->user()->account->id ?? $item->user_change_content_id;
            $item->reason_lack_clarification = $request['reason_lack_clarification'] ?? $item->reason_lack_clarification;
            $item->user_change_content_id = auth()->user()->account->id ?? $item->user_change_content_id;
            $item->reprocessing_recommendations = $request['reprocessing_recommendations'] ?? $item->reprocessing_recommendations;
            $item->user_reprocessing_recommendations_id = auth()->user()->account->id ?? $item->user_reprocessing_recommendations_id;
            $item->save();

            $recommendations = new Recommendation();
            $recommendations->form_id = $item->id;
            $recommendations->user_id = auth()->user()->id;
            $recommendations->recommendations_content = $request['reprocessing_recommendations'];
            $recommendations->save();

            $categoryCircles_users1 = $auth_circle_users = array();

            $categoryCircles = CategoryCircles::where('category' ,'=', $item->category->id)
                ->get();

            $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$item->project_id)
                ->pluck('rate','account_id')->toArray();

            foreach ($categoryCircles as $categoryCircle){
                if($categoryCircle->procedure_type == 2){
                    array_push($categoryCircles_users1,$categoryCircle->circle);
                }
            }

            foreach ($userinprojects as $key=>$userinproject){
                if(in_array($userinproject,$categoryCircles_users1)){
                    array_push($auth_circle_users,$key);
                }

            }

            foreach($auth_circle_users as $AccountProjects_user){
                $user = Account::find($AccountProjects_user);
                NotificationController::insert(['user_id' => $user->user_id, 'type' => 'موظف','form_id' => $item->id, 'title' => 'تنبيه بإعادة معالجة الاقتراح/الشكوى', 'link' => "/citizen/form/show/" . $item->citizen->id_number . "/$item->id"]);
            }
        }

        return Response(['success' => true,'msg' => "تم الحفظ بنجاح"]);

    }


        public function download_form_file($id)
    {
        $form = Form::find($id);
        $file= public_path(). "/uploads/files/".$form->form_file;
        return response()->download($file);
    }




    public function index(Request $request)

    {

        $read = $request["read"] ?? "";
        $evaluate = $request["evaluate"] ?? "";
        $from_date = $request["from_date"] ?? "";
        $to_date = $request["to_date"] ?? "";
        $q = $request["q"] ?? "";
        $q1 = $request["q1"] ?? "";
        $category_id = $request["category_id"] ?? "";
        $datee = $request["datee"] ?? "";
        $status = $request["status"] ?? "";
        $type = $request["type"] ?? "";
        $sent_type = $request["sent_type"] ?? "";
        $project_id = $request["project_id"] ?? "";
        $replay_status = $request["replay_status"] ?? "";
        $active = $request["active"] ?? "";
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

        $items = Form::where('deleted_at', null)->whereIn('project_id', Account::find(auth()->user()->account->id)
            ->projects()->with('account_projects')->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->with('circle_categories')->pluck('categories.id'))
            ->join('projects', 'projects.id', '=', 'forms.project_id')
            ->join('accounts', 'accounts.id', '=', 'forms.account_id')
            ->join('project_status', 'projects.active', '=', 'project_status.id')
            ->join('sent_type', 'forms.sent_type', '=', 'sent_type.id')
            ->join('form_status', 'forms.status', '=', 'form_status.id')
            ->join('form_type', 'forms.type', '=', 'form_type.id')
            ->join('categories', 'categories.id', '=', 'forms.category_id')
            ->join('citizens', 'citizens.id', '=', 'forms.citizen_id')
            ->select('forms.id',
                'citizens.first_name',
                'citizens.father_name',
                'citizens.grandfather_name',
                'citizens.last_name',
                'citizens.id_number',
                'citizens.governorate',
                'citizens.city',
                'citizens.street',
                'citizens.mobile',
                'citizens.mobile2',
                'projects.name as binfit',
                'projects.name as zammes',
                'projects.end_date  as project_status',
                'sent_type.name  as senmmes',
                'forms.account_id',
                'accounts.full_name as employee_name',
                'forms.datee',
                'forms.created_at',
                'form_type.name  as ammes',
                'categories.name as nammes',
                'forms.title',
                'forms.content',
                'form_status.name',
                'forms.response_type',
                'forms.required_respond',
                'form_status.id as replay_status')

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


        $items = $items->where(function($query){

            return $query->when( request('read') , function($query){

                return $query->where('read' , request('read'));

            });

        })->where(function($query){

            return $query->when( request('status') , function($query){

                return $query->where('status' , request('status'));

            });


        })->where(function($query){

            return $query->when( request('replay_status') , function($query){

                return $query->where('status' , request('replay_status'));

            });


        })->where(function($query){

            return $query->when( request('type') , function($query){

                return $query->where('forms.type' , request('type'));

            });



        })->where(function($query){

            return $query->when( request('id') , function($query){

                return $query->where('forms.id' , request('id'));

            });




        })->where(function($query){

            return $query->when( request('active') , function($query){

                return $query->where('projects.active' , request('active'));

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

                return $query->where('forms.datee' , Carbon::parse(request('datee'))->format('Y-m-d'));

        });


        })->where(function($query){

            return $query->when( request('from_date') , function($query){

                return $query->where([['forms.datee' ,'>=', Carbon::parse(request('from_date'))->format('Y-m-d') ] , ['forms.datee' ,'<=', Carbon::parse(request('to_date'))->format('Y-m-d')]]);

        });

        })->where(function($query){

            return $query->when( request('to_date') , function($query){

                return $query->where([['forms.datee' ,'>=', Carbon::parse(request('from_date'))->format('Y-m-d')] , ['forms.datee' ,'<=', Carbon::parse(request('to_date'))->format('Y-m-d')]]);

        });

    })->orderBy("forms.id", 'desc')->get();


        $projects = Account::find(auth()->user()->account->id)->projects->all();
        $categories = auth()->user()->account->circle->category->all();
        $form_type = Form_type::all();
        $form_status = Form_status::all();
        $sent_typee = Sent_type::all();
        $project_status = Project_status::all();

        foreach($items as $item){

            if($item->binfit == 'غير مستفيد'){
                $item->binfit = "غير مستفيد";
            }else{
                $item->binfit = " مستفيد";

            }

            if($item->project_status < now()){
                $item->project_status = "منتهي";
            }else{
                $item->project_status = "مستمر";
            }

            if($item->account_id == null){
                $item->account_id = "المواطن نفسه";
            }else{
                $item->account_id = "أحد موظفي المركز";
            }

            if($item->response_type == 1){
                $item->response_type = "تتطلب اجراءات مطولة للرد";
            }else{
                $item->response_type = "يمكن الرد عليها مباشرة";
            }

            if($item->replay_status == 1){
                $item->replay_status = "قيد الدراسة";
            }elseif($item->replay_status == 2){
                $item->replay_status = "تم الرد";
            }else{
                $item->replay_status= "";

            }
        }


        $project_name= "";

        if ($request['theaction'] == 'excel')
            return Excel::download(new FormsExport, "Annex Template 01-".date('d-m-Y').".xlsx");
        elseif ($request['theaction'] == 'print') {
            $items = Form::find($items->pluck('id'));
            $pdf = PDF::loadView('account.form.printall', compact('items', 'form_type', "form_status", "sent_typee", "projects"));
            return $pdf->stream("forms_$project_name.pdf");
        } else {

            if ($request['theaction'] == 'search'){
                $items = Form::whereIn('id', $items->pluck('id'))->paginate(5);
                $items->appends(['q' => $q,'theaction'=>'search','read'=>$read,'evaluate'=>$evaluate,
                    'from_date' => $from_date,'to_date'=>$to_date,'q1'=>$q1,
                    'category_id' => $category_id,'datee'=>$datee,'status'=>$status,
                    'type' => $type,'sent_type'=>$sent_type,'project_id'=>$project_id,'replay_status'=>$replay_status
                    ]);


            }elseif ($request['themainaction'] == 'search'){
                $items = Form::whereIn('id', $items->pluck('id'))->paginate(5);
                $items->appends(['q' => $q,'themainaction'=>'search','read'=>$read,'evaluate'=>$evaluate,
                    'from_date' => $from_date,'to_date'=>$to_date,'q1'=>$q1,
                    'category_id' => $category_id,'datee'=>$datee,'status'=>$status,
                    'type' => $type,'sent_type'=>$sent_type,'project_id'=>$project_id,
                ]);
            }else{
                $items  = "" ;
            }

            return view("account.form.index", compact("items", 'form_type', "form_status", "sent_typee", "projects", "type", "categories","project_status"));
        }
    }



    public function edit($id)
    {
        Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
        return redirect("/account/form");
    }

    public function create()
    {
        Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
        return redirect("/account/form");
    }

    public function store(FormsRequest $request)
    {

    }

    public function addreplay($id, Form_responseRequest $request)
    {
        $item = Form::whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->with('account_projects')->where('to_replay',1)->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->with('circle_categories')->where('to_replay',1)->pluck('categories.id'))
            ->find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:ليس لك صلاحية إضافة رد");
            return redirect("/account/form");
        }

        $item = new Form_response();
        $form = Form::find($id);
        $form->fill(['status' => '2']);
        $form->save();
        $request['form_id'] = $id;
        $request['datee'] = date('Y-m-d');
        $request['account_id'] = Auth::user()->account->id;
        $item::create($request->all());
        session::flash('msg', 's:تمت إضافة رد بنجاح');

        $theform = $form;
        if ($theform->project->account_projects->first() && $theform->category->circle_categories->first()) {
            $accouts_ids_in_circle = Account::WhereIn('circle_id', $theform->category->circle_categories->where('to_notify', 1)
                ->pluck('circle_id')->toArray())->where('id','!=',auth()->user()->id)->pluck('id')->toArray();
            $accouts_ids_in_project = $theform->project->account_projects->where('to_notify', 1)
                ->where('account_id','!=',auth()->user()->id)->pluck('account_id')->toArray();
            $accouts_ids = array_merge($accouts_ids_in_circle, $accouts_ids_in_project);

            $users_ids = Account::find($accouts_ids)->pluck('user_id');
            for ($i = 0; $i < count($users_ids); $i++) {
//                if (User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id))
                if (check_permission_with_user_id('الإشعارات', $users_ids[$i]))
                    NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'من موظف', 'title' => 'تم اضافة رد من قبل موظف', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);

            }
        }

        return redirect('/citizen/form/show/' . Form::find($id)->citizen->id_number . '/' . $id);
    }

    public function terminateform($id)
    {
        $form = Form::whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->with('account_projects')->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->with('circle_categories')->pluck('categories.id'))
            ->find($id);
        if ($form == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }
        $form->fill(['status' => '3']);
        $form->save();
        session::flash('msg', 's:تم إيقاف الشكوى');

        $theform = $form;
        if ($theform->project->account_projects->first() && $theform->category->circle_categories->first()) {
            $accouts_ids_in_circle = Account::WhereIn('circle_id', $theform->category->circle_categories
                ->pluck('circle_id')->toArray())->where('id','!=',auth()->user()->id)->pluck('id')->toArray();
            $accouts_ids_in_project = $theform->project->account_projects
                ->where('account_id','!=',auth()->user()->id)->pluck('account_id')->toArray();
            $accouts_ids = array_merge($accouts_ids_in_circle, $accouts_ids_in_project);

            $users_ids = Account::find($accouts_ids)->pluck('user_id');
            for ($i = 0; $i < count($users_ids); $i++) {
//                if (User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id))
                if (check_permission_with_user_id('الإشعارات', $users_ids[$i]))
                    NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'من موظف', 'title' => 'تم ايقاف نموذج من قبل موظف', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);

            }
        }

        return redirect('/citizen/form/show/' . $form->citizen->id_number . '/' . $id);
    }

    public function allowform($id)
    {
        $form =Form::whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->with('account_projects')->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->with('circle_categories')->pluck('categories.id'))
            ->find($id);
        if ($form == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }
        $formresp = Form_response::whereIn('form_id', [$form->id])->pluck('id');
        if (count($formresp) > 0)
            $form->fill(['status' => '2']);
        else
            $form->fill(['status' => '1']);
        $form->save();
        session::flash('msg', 's:تم السماح بالشكوى');

        $theform = $form;
        if ($theform->project->account_projects->first() && $theform->category->circle_categories->first()) {
            $accouts_ids_in_circle = Account::WhereIn('circle_id', $theform->category->circle_categories->where('to_notify', 1)
                ->where('id','!=',auth()->user()->id)->pluck('circle_id')->toArray())->pluck('id')->toArray();
            $accouts_ids_in_project = $theform->project->account_projects->where('to_notify', 1)
                ->where('account_id','!=',auth()->user()->id)->pluck('account_id')->toArray();
            $accouts_ids = array_merge($accouts_ids_in_circle, $accouts_ids_in_project);

            $users_ids = Account::find($accouts_ids)->pluck('user_id');
            for ($i = 0; $i < count($users_ids); $i++) {
//                if (User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id))
                if (check_permission_with_user_id('الإشعارات', $users_ids[$i]))
                    NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'موظف', 'title' => 'تم اعادة السماح لنموذج من موظف', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);

            }
        }

        return redirect('/citizen/form/show/' . $form->citizen->id_number . '/' . $id);
    }

    public function addfollw($id)
    {
        return view("account.form.addfollw");
    }

    public function update(FormsRequest $request, $id)
    {

    }

    public function destroy(Request $request)
    {
        $item = Form::whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->with('account_projects')->where('to_edit',1)->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->with('circle_categories')->where('to_edit',1)->pluck('categories.id'))->find($request['id']);

            if ($item == NULL) {
                Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
                return redirect("/account/form");
            }
            if ($item->status != "3") {
                Session::flash("msg", "e:لا يمكن حذف نموذج قبل تعليقه");
                return redirect("/account/form");
            }
            $formresp = Form_response::whereIn('form_id', [$item->id])->pluck('id');
            $formfoll = Form_follow::whereIn('form_id', [$item->id])->pluck('id');
            $formfile = Form_file::whereIn('form_id', [$item->id])->pluck('id');
         //   $formfile_name = Form_file::whereIn('form_id', [$item->id])->pluck('name');

        if (count($formresp) > 0){
            foreach ($formresp as $one){
                $response = Form_response::where('id',$one)->first();
                $response->deleted_at = Carbon::now();
                $response->save();
            }
        }

        if (count($formfoll) > 0){
            foreach ($formfoll as $foll){
                $follow = Form_follow::where('id',$foll)->first();
                $follow->deleted_at = Carbon::now();
                $follow->save();
            }
        }

        if (count($formfile) > 0){
            foreach ($formfile as $file){
                $the_file = Form_file::where('id',$file)->first();
                $the_file->deleted_at = Carbon::now();
                $the_file->save();
            }
        }

             $item->deleted_at = Carbon::now();
             $item->deleted_by = Auth::id();
             $item->deleted_because = $request['reason'];
             $item->save();
            Session::flash("msg", "تم حذف نموذج بنجاح");
            return Response(['success' => true]);


    }

    public function confirm_destroy_from_citizian(Request $request)
    {
        $item = Form::find($request['id']);

        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }

        $formresp = Form_response::whereIn('form_id', [$item->id])->pluck('id');
        $formfoll = Form_follow::whereIn('form_id', [$item->id])->pluck('id');
        $formfile = Form_file::whereIn('form_id', [$item->id])->pluck('id');
        //   $formfile_name = Form_file::whereIn('form_id', [$item->id])->pluck('name');

        if (count($formresp) > 0){
            foreach ($formresp as $one){
                $response = Form_response::where('id',$one)->first();
                $response->deleted_at = Carbon::now();
                $response->save();
            }
        }

        if (count($formfoll) > 0){
            foreach ($formfoll as $foll){
                $follow = Form_follow::where('id',$foll)->first();
                $follow->deleted_at = Carbon::now();
                $follow->save();
            }
        }

        if (count($formfile) > 0){
            foreach ($formfile as $file){
                $the_file = Form_file::where('id',$file)->first();
                $the_file->deleted_at = Carbon::now();
                $the_file->save();
            }
        }

        $item->deleted_at = Carbon::now();
        $item->recommendations_for_deleting = "يوصي بإتمام عملية الحذف";
        $item->user_recommendations_for_deleting_id = auth()->user()->account->id;
        $item->save();

        $categoryCircles_users1 = $auth_circle_users = array();

        $categoryCircles = CategoryCircles::where('category' ,'=', $item->category->id)
            ->get();

        $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$item->project_id)
            ->pluck('rate','account_id')->toArray();

        foreach ($categoryCircles as $categoryCircle){
            if($categoryCircle->procedure_type == 2){
                array_push($categoryCircles_users1,$categoryCircle->circle);
            }
        }

        foreach ($userinprojects as $key=>$userinproject){
            if(in_array($userinproject,$categoryCircles_users1)){
                array_push($auth_circle_users,$key);
            }

        }

        foreach($auth_circle_users as $AccountProjects_user){
            $user = Account::find($AccountProjects_user);
            NotificationController::insert(['user_id' => $user->user_id, 'type' => 'موظف','form_id' => $item->id, 'title' => 'تنبيه بإتمام عملية الحذف ', 'link' => "/citizen/form/show/" . $item->citizen->id_number . "/$item->id"]);
        }
        return Response(['success' => true,'msg'=>"تمت تأكيد عملية الحذف بنجاح"]);

    }

    public function confirm_detory_reprocessing_recommendations_from_citizian(Request $request)
    {
        $item = Form::find($request['id']);
        if($item->type){
            $formtype = "الشكوى";
        }else{
            $formtype = "الاقتراح";
        }

        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }

        $item->recommendations_for_deleting = "يوصي بإعادة معالجة ".$formtype." مع أخذ بعين الاعتبار التوصيات التالية:".$request['recommendations_for_deleting'];
        $item->user_recommendations_for_deleting_id = auth()->user()->account->id;
        $item->save();

        $categoryCircles_users1 = $auth_circle_users = array();

        $categoryCircles = CategoryCircles::where('category' ,'=', $item->category->id)
            ->get();

        $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$item->project_id)
            ->pluck('rate','account_id')->toArray();

        foreach ($categoryCircles as $categoryCircle){
            if($categoryCircle->procedure_type == 2){
                array_push($categoryCircles_users1,$categoryCircle->circle);
            }
        }

        foreach ($userinprojects as $key=>$userinproject){
            if(in_array($userinproject,$categoryCircles_users1)){
                array_push($auth_circle_users,$key);
            }

        }

        foreach($auth_circle_users as $AccountProjects_user){
            $user = Account::find($AccountProjects_user);
            NotificationController::insert(['user_id' => $user->user_id, 'type' => 'موظف','form_id' => $item->id, 'title' => 'تنبيه بإعادة معالجة الاقتراح/الشكوى ', 'link' => "/citizen/form/show/" . $item->citizen->id_number . "/$item->id"]);
        }
        return Response(['success' => true,'msg'=>"تمت تأكيد عملية الحذف بنجاح"]);

    }


    public function destroy_from_citizian(Request $request)
    {
        $item = Form::whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->with('account_projects')->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->with('circle_categories')->pluck('categories.id'))->find($request['id']);

        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }

        $item->confirm_deleting = Carbon::now();
        $item->deleted_by = Auth::id();
        $item->deleted_because = $request['reason'];
        $item->save();

        $categoryCircles_users1 = $auth_circle_users = array();

        $categoryCircles = CategoryCircles::where('category' ,'=', $item->category->id)
            ->get();

        $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$item->project_id)
            ->pluck('rate','account_id')->toArray();

        foreach ($categoryCircles as $categoryCircle){
            if($categoryCircle->procedure_type == 5){
                array_push($categoryCircles_users1,$categoryCircle->circle);
            }
        }

        foreach ($userinprojects as $key=>$userinproject){
            if(in_array($userinproject,$categoryCircles_users1)){
                array_push($auth_circle_users,$key);
            }

        }

        foreach($auth_circle_users as $AccountProjects_user){
            $user = Account::find($AccountProjects_user);
            NotificationController::insert(['user_id' => $user->user_id, 'type' => 'موظف','form_id' => $item->id, 'title' => 'تنبيه بوجود اقتراح/ شكوى تم حذفها من حساب موظف', 'link' => "/citizen/form/show/" . $item->citizen->id_number . "/$item->id"]);
        }
//        Session::flash("msg", "تمت عملية الحذف بنجاح");
        return Response(['success' => true,'msg'=>"تمت عملية الحذف بنجاح"]);

    }

    public function deleted_form(Request $request)
    {

        $q = $request["q"] ?? "";
        $category_name = $request["category_name"] ?? "";
        $project_id = $request["project_id"] ?? "";
        $sent_type = $request["sent_type"] ?? "";
        $type = $request["type"] ?? "";
        $category_id = $request["category_id"] ?? "";
        $datee = $request["datee"] ?? "";
        $from_date = $request["from_date"] ?? "";
        $to_date = $request["to_date"] ?? "";
        $deleted_by = $request["deleted_by"] ?? "";
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



        $items = Form::where('deleted_at', '!=' , null)->whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->with('account_projects')->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->with('circle_categories')->pluck('categories.id'))
            ->join('projects', 'projects.id', '=', 'forms.project_id')
            ->join('project_status', 'projects.active', '=', 'project_status.id')
            ->join('sent_type', 'forms.sent_type', '=', 'sent_type.id')
            ->join('form_status', 'forms.status', '=', 'form_status.id')
            ->join('form_type', 'forms.type', '=', 'form_type.id')
            ->join('accounts', 'accounts.id', '=', 'forms.account_id')
            ->join('categories', 'categories.id', '=', 'forms.category_id')
            ->join('citizens', 'citizens.id', '=', 'forms.citizen_id')
           ->select('forms.id',
                'citizens.first_name',
                'citizens.father_name',
                'citizens.grandfather_name',
                'citizens.last_name',
                'citizens.id_number',
                'citizens.governorate',
                'citizens.city',
                'citizens.street',
                'citizens.mobile',
                'citizens.mobile2',
                'projects.name as binfit',
                'projects.name as zammes',
                'projects.end_date  as project_status',
                'sent_type.name  as senmmes',
                'forms.account_id',
                'accounts.full_name as employee_name',
                'forms.datee',
                'forms.created_at',
                'form_type.name  as ammes',
                'categories.name as nammes',
                'forms.title',
                'forms.content',
                'forms.deleted_by',
                'accounts.circle_id',
                'forms.deleted_because',
                'forms.deleted_at as deleted_at')

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



        $items = $items->where(function($query){

            return $query->when( request('project_id') , function($query){

                return $query->where([ ['project_id' , request('project_id')] , ['deleted_at' , '!=' , NULL ] ]);

            });



        })->where(function($query){

            return $query->when( request('active') , function($query){

                return $query->where('projects.active' , request('active'));

            });

        })->where(function($query){

            return $query->when( request('category_name') == "1" , function($query){

                return $query->where([  ['forms.project_id'  , 1 ]  , ['deleted_at' , '!=' , NULL ] ]);

            });







        })->where(function($query){

            return $query->when( request('id') , function($query){

                return $query->where([['forms.id' , request('id')] , ['deleted_at' , '!=' , NULL ]]);

            });




        })->where(function($query){

            return $query->when( request('id_number') , function($query){

                return $query->where([['citizens.id_number' , request('id_number')] , ['deleted_at' , '!=' , NULL ]]);

            });




        })->where(function($query){

            return $query->when( request('citizen_id') , function($query){

                return $query->where([['citizens.first_name' , 'like' ,   request('citizen_id')] , ['deleted_at' , '!=' , NULL ]]);

            });











        })->where(function($query){

            return $query->when( request('category_name') == "0" , function($query){

                return $query->where([  ['forms.project_id' ,'!=', 1 ]  , ['deleted_at' , '!=' , NULL ] ]);

            });




        })->where(function($query){

            return $query->when( request('sent_type') , function($query){

                return $query->where([  ['sent_type' , request('sent_type')]  , ['deleted_at' , '!=' , NULL ] ]);

            });

        })->where(function($query){

            return $query->when( request('type') , function($query){

                return $query->where([ ['forms.type' , request('type')] , ['deleted_at' , '!=' , NULL ] ]);

            });

            })->where(function($query){

                return $query->when( request('category_id') , function($query){

                    return $query->where([ ['category_id' , request('category_id')] , ['deleted_at' , '!=' , NULL ] ]);

            });

           })->where(function($query){

            return $query->when( request('circle_id') , function($query, $x){
                $x =  Account::where('circle_id' , request('circle_id') )->first() ;
                if($x){

                return $query->where([ ['deleted_by' , $x->id] , ['deleted_at' , '!=' , NULL ] ]);

                }else{
                return $query->where('forms.id' , 0);

                }
            });





        })->where(function($query){

            return $query->when( request('evaluate') , function($query){

                return $query->where([['evaluate' , request('evaluate')] , ['deleted_at' , '!=' , NULL ] ]);

            });


        })->where(function($query){

            return $query->when( request('status') , function($query){

                return $query->where([['status' , request('status')] , ['deleted_at' , '!=' , NULL ] ]);

            });



            })->where(function($query){

                return $query->when( request('deleted_by') , function($query){

                    return $query->where([ ['deleted_by' , request('deleted_by')] , ['deleted_at' , '!=' , NULL ] ]);

            });


            })->where(function($query){

                return $query->when( request('datee') , function($query){

                    return $query->where([ ['forms.datee' ,  Carbon::parse(request('datee'))->format('Y-m-d')] , ['deleted_at' , '!=' , NULL ] ]);

            });

            })->where(function($query){

                return $query->when( request('from_date') , function($query){

                    return $query->where([ ['forms.datee' ,'>=', Carbon::parse(request('from_date'))->format('Y-m-d')] , ['forms.datee' ,'<=', Carbon::parse(request('to_date'))->format('Y-m-d')], ['deleted_at' , '!=' , NULL ] ]);

            });

            })->where(function($query){

                return $query->when( request('to_date') , function($query){

                    return $query->where([ ['forms.datee' ,'>=', Carbon::parse(request('from_date'))->format('Y-m-d')] , ['forms.datee' ,'<=', Carbon::parse(request('to_date'))->format('Y-m-d')], ['deleted_at' , '!=' , NULL ] ]);

            });

            })->where(function($query){

                return $query->when( request('delete_date') , function($query){

                    return $query->where([ ['forms.deleted_at' , request('delete_date')] , ['deleted_at' , '!=' , NULL ] ]);

            });

            })->get();

        $projects = Account::find(auth()->user()->account->id)->projects->all();
        $categories = auth()->user()->account->circle->category->all();
        $form_type = Form_type::all();
        $form_status = Form_status::all();
        $sent_typee = Sent_type::all();
        $accounts = Account::all();
        $circles = Circle::all();
        $project_status = Project_status::all();



        foreach($items as $item){

             if($item->deleted_by){
                $item->deleted_by =  \App\Account::where('id' , $item->deleted_by)->first()->full_name;
            }


            if($item->binfit == 'غير مستفيد'){
                $item->binfit = "غير مستفيد";
            }else{
                $item->binfit = " مستفيد";

            }

            if($item->project_status < now()){
                $item->project_status = "منتهي";
            }else{
                $item->project_status = "مستمر";
            }

            if($item->account_id == null){
                $item->account_id = "المواطن نفسه";
            }else{
                $item->account_id = "أحد موظفي المركز";
            }

            if($item->replay_status == 1){
                $item->replay_status = "قيد الدراسة";
            }elseif($item->replay_status == 2){
                $item->replay_status = "تم الرد";
            }else{
                $item->replay_status= "";

            }
                   foreach($accounts as $account){
            $account->circle_id =  'مدير النظام';
        }


        }

                $project_name= "";

        if ($request['theaction'] == 'excel')
            return Excel::download(new DeletedFormsExport(), "Annex Template 02-".date('d-m-Y').".xlsx");
        elseif ($request['theaction'] == 'print') {
            $items = Form::find($items->pluck('id'));
            $pdf = PDF::loadView('account.form.printall', compact('items', 'form_type', "form_status", "sent_typee", "projects","project_status"));
            return $pdf->stream("forms_$project_name.pdf");
        } else {


            if ($request['theaction'] == 'search' ){
                $items = Form::whereIn('id', $items->pluck('id'))->paginate(5);
                $items->appends(['q' => $q,'theaction'=>'search',
                    'from_date' => $from_date,'to_date'=>$to_date,
                    'category_id' => $category_id,'datee'=>$datee,
                    'type' => $type,'sent_type'=>$sent_type,'project_id'=>$project_id,
                ]);
            }elseif ($request['themainaction'] == 'search'){
                $items = Form::whereIn('id', $items->pluck('id'))->paginate(5);
                $items->appends(['q' => $q,'themainaction'=>'search',
                    'from_date' => $from_date,'to_date'=>$to_date,
                    'category_id' => $category_id,'datee'=>$datee,
                    'type' => $type,'sent_type'=>$sent_type,'project_id'=>$project_id,
                ]);
            }else{
                $items  = "" ;
            }


              return view("account.form.deleted_items", compact("items", 'form_type', "form_status", "sent_typee", "projects", "type", "categories" , 'accounts' , 'circles','project_status'));
        }







    }

    public function showfiles($id) {

        $item = Form::find($id);
        if ($item)
            $form_files = \App\Form_file::where('form_id', '=', $item->id)->get();

        return view("account.form.itemsfiles", compact( 'form_files','item'));

    }


    public function downloadfiles($id)
    {
        $item = Form::find($id);
        if ($item){
            $file= public_path(). "/uploads/files/".$item->form_file;
            return response()->download($file);
        }
    }





}
