<?php

namespace App\Http\Controllers\Citizen;

use App\Account;
use App\AccountProjects;
use App\Category;

use App\CategoryCircles;
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
use App\MessageType;
use App\Notification;
use App\Project;
use App\Recommendation;
use App\Rules\IdNumber;
use App\Sent_type;
use App\Sms;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $categoryCircles_users1 = $categoryCircles_users2 = $categoryCircles_users3 = $categoryCircles_users4 = $auth_circle_users = $auth_circle_users2 = $auth_circle_users3 = $auth_circle_users4 = array();
        $categoryCircles = CategoryCircles::where('category' ,'=', $item->category->id)
            ->get();

        $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$item->project_id)
            ->pluck('rate','account_id')->toArray();




        foreach ($categoryCircles as $categoryCircle){
            if($categoryCircle->procedure_type == 2){
                array_push($categoryCircles_users1,$categoryCircle->circle);
            }

            if($categoryCircle->procedure_type == 5){
                array_push($categoryCircles_users2,$categoryCircle->circle);
            }

            if($categoryCircle->procedure_type == 3){
                array_push($categoryCircles_users3,$categoryCircle->circle);
            }

            if($categoryCircle->procedure_type == 4){
                array_push($categoryCircles_users4,$categoryCircle->circle);
            }
        }



//        array_push($auth_circle_users,1);
//        array_push($auth_circle_users2,1);
        foreach ($userinprojects as $key=>$userinproject){
            if(in_array($userinproject,$categoryCircles_users1)){
                array_push($auth_circle_users,$key);
            }

            if(in_array($userinproject,$categoryCircles_users2)){
                array_push($auth_circle_users2,$key);
            }

            if(in_array($userinproject,$categoryCircles_users3)){
                array_push($auth_circle_users3,$key);
            }

            if(in_array($userinproject,$categoryCircles_users4)){
                array_push($auth_circle_users4,$key);
            }

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
            $recomendations = Recommendation::where('form_id','=',$item->id)->get();
            if ($item->citizen->id_number == $ido) {
                return view("citizen.form-show", compact('item', 'categories', 'itemco','form_type','type','auth_circle_users','auth_circle_users2','auth_circle_users3','auth_circle_users4','recomendations'));
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
//                print_r('test');exit();
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


            $type="مواطن";
            if (auth()->user()) {
                $request['account_id'] = auth()->user()->account->id;
                $type = "موظف";
            }
            for ($i = 0; $i < count($users_ids); $i++) {


//						User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id) ;
                if (check_permission_with_user_id('الإشعارات', $users_ids[$i]))
                    NotificationController::insert(['user_id' => $users_ids[$i], 'type' => $type, 'form_id' => $theform->id ,'title' => 'تذكير نموذج عالق للتأخير', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);

            }}
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

        $type="مواطن";
        if (auth()->user()) {
            $request['account_id'] = auth()->user()->account->id;
            $type = "موظف";
        }


        $form_id = Form::create($request->all())->id;

        if ($request->hasFile('fileinput')) {
            $myfile = $request->file('fileinput'); // جلد الجديد من الانبوت فورم
            $filename = rand(11111, 99999) . '.' . $myfile->getClientOriginalExtension(); // جلب اسمه
            $myfile->move(public_path() . '/uploads/', $filename); //يخزن الجديد في الموقع المحدد
            Form_file::create(['form_id' => $form_id, 'name' => $filename, 'path' => 'uploads/']);

        }

        if(auth()->user()){
            $user_id = auth()->user()->account->id;
        }else{
            $user_id = NULL;
        }
        if ($form_id){
            $form = Form::find($form_id);
            $citizen_msg = Citizen::find($form->citizen_id);
            $message = new Sms();
            $message->mobile = $citizen_msg->mobile;
            $message->citizen_id = $citizen_msg->id;
            $message->message_type_id = 5;
            $message->user_id = $user_id;
            $message->form_id = $form_id;
            if($message->save()){
                $messageText = MessageType::select('text')->where('id','=',1)->pluck('text')[0];
                if (str_contains($messageText, 'xxx')) {
                    $citizen = Citizen::select('first_name', 'father_name', 'grandfather_name', 'last_name')->where('id', '=',  $citizen_msg->id)->first();
                    $messageText_new = str_replace( 'xxx',$citizen->full_name, $messageText);
                }else{
                    $messageText_new = $messageText;
                }

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://hotsms.ps/sendbulksms.php?user_name=MAAN-FCS&user_pass=7110874&sender=MAAN-FCS&mobile=$citizen_msg->mobile&type=0&text=".urlencode($messageText_new),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type:application/json",
                        "Accept:application/json",
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                if ($response == 1001){
                    $message->send_status = 'تم الإرسال';
                    $message->save();
                }else{
                    $message->send_status = 'قيد الإرسال';
                    $message->save();
                }
            }
        }

        $theform = Form::find($form_id);

        $categoryCircles_users1 = $auth_circle_users = array();

        $categoryCircles = CategoryCircles::where('category' ,'=', $theform->category->id)
            ->get();

        $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$theform->project_id)
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
            NotificationController::insert(['user_id' => $user->user_id, 'type' => $type,'form_id' => $theform->id, 'title' => 'لديك اقتراح/ شكوى جديدة بحاجة لمعالجة', 'link' => "/citizen/form/show/" . Form::find($form_id)->citizen->id_number . "/$form_id"]);
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
            $theform = Form::find($request['form_id']);

            $categoryCircles_users1 = $auth_circle_users = array();

            $categoryCircles = CategoryCircles::where('category' ,'=', $theform->category->id)
                ->get();

            $userinprojects = AccountProjects::select('rate','account_id')->where('project_id','=',$theform->project_id)
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

            $type="مواطن";
            if (auth()->user()) {
                $type = "موظف";
            }
            foreach($auth_circle_users as $AccountProjects_user){
                $user = Account::find($AccountProjects_user);
                NotificationController::insert(['user_id' => $user->user_id ,'type' => $type,'form_id' => $theform->id, 'title' => 'لديك توصية جديدة', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);
            }

            return redirect('/citizen/form/show/' . $citizen_ido . '/' . $form->id);
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
            $circle_ids = Account::find($users_ids )->pluck('circle_id' );

            for ($i = 0; $i < count($users_ids); $i++) {
                if($circle_ids[$i] == 2){
//					User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id);
                    if (check_permission_with_user_id('الإشعارات', $users_ids[$i]))
                        NotificationController::insert(['user_id' => $users_ids[$i], 'type' => $type ,'form_id' => $theform->id,'title' => 'تم اضافة متابعة على نموذج', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);
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
            $circle_ids = Account::find($users_ids )->pluck('circle_id' );
            for ($i = 0; $i < count($users_ids); $i++) {

                if($circle_ids[$i] == 4){
//				User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id);
                    if (check_permission_with_user_id('الإشعارات', $users_ids[$i]))
                        NotificationController::insert(['user_id' => $users_ids[$i], 'type' => $type,'form_id' => $theform->id, 'title' => 'تم اضافة تقييم لنموذج', 'link' => "/citizen/form/show/" . $theform->citizen->id_number . "/$theform->id"]);
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
