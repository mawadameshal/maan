<?php

namespace App\Http\Controllers\Account;

use App\Account;
use App\Citizen;
use App\Form;
use App\Form_status;
use App\Form_type;
use App\Project;
use App\Category;
use App\Imports\MessageImport;
use App\MessageType;
use App\Project_status;
use App\Sent_type;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Sms;
use Illuminate\Http\Request;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use  PDF;
use Illuminate\Support\Facades\Redirect;

class MessageController extends BaseController
{

    public function index(Request $request)
    {
        $citizen_id = $request["citizen_id"] ?? "";
        $id_number = $request["id_number"] ?? "";
        $project_id = $request["project_id"] ?? "";
        $datee = $request["datee"] ?? "";
        $from_date = $request["from_date"] ?? "";
        $to_date = $request["to_date"] ?? "";
        $messageType = $request["messageType"] ?? "";
        $sent_type = $request["sent_type"] ?? "";
        $account_id = $request["account_id"] ?? "";
        $send_status = $request["send_status"] ?? "";

        $messagesType = MessageType::get();
        $items = Sms::where('form_id','!=',null)
            ->join('forms','forms.id','=','sms.form_id')
            ->join('projects', 'projects.id', '=', 'forms.project_id')
            ->join('accounts', 'accounts.id', '=', 'sms.user_id')
            ->join('citizens', 'citizens.id', '=', 'sms.citizen_id')
            ->join('message_type', 'message_type.id', '=', 'sms.message_type_id')
            ->select('sms.id',
                'citizens.first_name',
                'citizens.father_name',
                'citizens.grandfather_name',
                'citizens.last_name',
                'citizens.id_number',
                'citizens.mobile',
                'projects.name as binfit',
                'accounts.full_name as employee_name',
                'message_type.name as message_type',
                'sms.send_status as send_status',
                DB::raw('DATE(`sms`.`created_at`) as datee'),
                DB::raw('Time(`sms`.`created_at`) as timee'),
                'message_type.send_procedure as send_procedure'
            )->whereRaw("true")

            ->where(function($query){
                return $query->when( request('id_number') , function($query){
                    return $query->where('citizens.id_number' , request('id_number'));
                });

            })->where(function($query){
                return $query->when( request('citizen_id') , function($query){
                    $citizen_id = request('citizen_id');

                    $keywords = preg_split("/[\s,]+/", $citizen_id);

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

                    return $query->whereRaw("(
                    first_name like ? or father_name like ? or grandfather_name like ? or last_name like ?)"
                        , ["'%$keywords[0]%'", "'%$keywords[1]%'", "'%$keywords[2]%'", "'%$keywords[3]%'",
                            /**/
                            "'%$citizen_id%'", "%$citizen_id%", "%$citizen_id%", "%$citizen_id%"]);
                });

            })->where(function($query){
                return $query->when( request('project_id') , function($query){
                    return $query->where('forms.project_id' , request('project_id'));
                });

            })->where(function($query){
                return $query->when( request('messageType') , function($query){
                    return $query->where('sms.message_type_id' , request('messageType'));
                });

            })->where(function($query){
                return $query->when( request('sent_type') , function($query){
                    return $query->where('message_type.send_procedure' , request('sent_type'));
                });

            })->where(function($query){
                return $query->when( request('send_status') , function($query){
                    return $query->where('sms.send_status' , request('send_status'));
                });

            })->where(function($query){
                return $query->when( request('account_id') , function($query){
                    return $query->where('sms.user_id' , request('account_id'));
                });

            })->where(function($query){
                return $query->when( request('datee') , function($query){
                    return $query->where('forms.datee' , Carbon::parse(request('datee'))->format('Y-m-d'));
                });

            })->where(function($query){
                return $query->when( request('from_date') , function($query){
                    return $query->where([['forms.datee' ,'>=', Carbon::parse(request('from_date'))->format('Y-m-d') ] , ['forms.datee' ,'<=', Carbon::parse(request('to_date'))->format('Y-m-d')]]);
                });
            })->where(function($query) {
                return $query->when(request('to_date'), function ($query) {
                    return $query->where([['forms.datee', '>=', Carbon::parse(request('from_date'))->format('Y-m-d')], ['forms.datee', '<=', Carbon::parse(request('to_date'))->format('Y-m-d')]]);
                });
            });


        $projects = Account::find(auth()->user()->account->id)->projects->all();
        $accounts = Account::all();

        if ($request['theaction'] == 'excel') {
//            return Excel::download(new MessageExport, "Annex Template 07-".date('d-m-Y').".xlsx");
        }else {
            if ($request['theaction'] == 'search') {
                $items = $items->orderBy("sms.id", 'asc')->paginate(5)
                ->appends([
                    'citizen_id'=>$citizen_id,'id_number'=>$id_number,
                    'project_id'=>$project_id,'datee'=>$datee,
                    'to_date'=>$to_date,'from_date'=>$from_date,
                    'messageType'=>$messageType,'sent_type'=>$sent_type,
                    'account_id'=>$account_id,'send_status'=>$send_status,
                    'theaction'=>'search'
                    ]);
            } else {
                $items = "";
            }
        }
        return view("account.message.index", compact('items','projects','messagesType','accounts'));
    }

    public function create()
    {
        $items = MessageType::all();
        return view("account.message.create" , compact('items'));
    }

    public function store(Request $request){

        if(!empty($request["name"])){

            $isExists = MessageType::where("name",$request["name"])->count();
            if($isExists)
            {
                Session::flash("msg","e:القيمة المدخلة موجودة مسبقاً");
                return redirect("/account/message/create")->withInput();
            }

            $items = new MessageType();
            $items->name = $request["name"] ;
            $items->text = $request["text"];
            $items->count_of_letter = $request["count_of_letter"];
            $items->Remaining_letters = $request["Remaining_letters"];
            $items->consumed_letters = $request["consumed_letters"];
            $items->send_procedure = "يدوي";
            $items->save();
            session::flash('msg','s:تمت عميلة الحفظ بنجاح');
            return redirect("/account/message/create");
        }
    }

    public function download_sample_file()
    {
        $file= public_path(). "/uploads/download/SmsSamplefile.xlsx";
        return response()->download($file);
    }

    public function send_group_messages(Request $request)
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

                try
                {
                    $collection = Excel::toArray(new MessageImport($request->message_type_id), request()->file('data_file'));
                    $collection = array_collapse($collection);
                    foreach ($collection as $row) {
                        if(! $row['alasm']){
                            return redirect("/account/citizen/create");
                        }
                        $messages = Sms::create([
                            'name' => $row['alasm'],
                            'mobile' => $row['rkm_altoasl'],
                            'message_type_id' => $request->message_type_id,
                            'message_text' => $row['ns_alrsal_alnsy'],
                            'count_message' => strlen($row['ns_alrsal_alnsy']),
                        ]);

                    }

                } catch (\Exception $e) {
                    Session::flash('error', $e->getMessage());
                }

                Session::flash('msg', 'تم ارسال الرسائل بنجاح');
                return redirect("/account/message/create");

            }

            else {
                Session::flash("msg", "e:لم يتم رفع أي ملف");
                return redirect("/account/message/create");
            }


        }
    }


    public function send_single_message(Request $request)
    {
        if(count($request->mobile) == 0){
            session::flash('msg','w:الرجاء اختيار مواطنين لإرسال Sms');
            return Redirect::to('/account/message/send_message');
        }
        else {
            foreach ($request->mobile as $key=>$mobile){
                $message = new Sms();
                $message->mobile = $mobile;
                $message->citizen_id = $request->citizen_id[$key];
                $message->message_type_id = $request->message_type_id;
                $message->user_id = Auth::user()->account->id;
                $message->form_id = $request->form_id[$key];

                if($message->save()){
                    $messageText = MessageType::select('text')->where('id','=',$request->message_type_id)->pluck('text')[0];
                    if (str_contains($messageText, 'xxx')) {
                        $citizen = Citizen::select('first_name', 'father_name', 'grandfather_name', 'last_name')->where('id', '=', $request->citizen_id[$key])->first();
                        $messageText_new = str_replace( 'xxx',$citizen->full_name, $messageText);
                   }else{
                       $messageText_new = $messageText;
                   }


                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://hotsms.ps/sendbulksms.php?user_name=MAAN-FCS&user_pass=7110874&sender=MAAN-FCS&mobile=$mobile&type=0&text=".urlencode($messageText_new),
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

            Session::flash('msg', 'تم ارسال الرسائل بنجاح');
            return redirect("/account/message/send_message");
        }
    }

    public function edit($id){

        $item =MessageType::find($id);

        if(!$item){
            return Redirect::to('/account/message/create');
        }else
            return view('account.message.edit')-> with([
                'item' => $item,

            ]);

    }

    public function update(Request $request ,$id)
    {
        $item=MessageType::find($id);

        if(!$item){
            return  Redirect::to('/account/message/create');
        }

        $item->update(
            [
                'name'=>$request->input('name'),
                'text'=>$request->input('text'),
                'count_of_letter' => $request->input('count_of_letter'),
                'Remaining_letters' => $request->input('Remaining_letters'),
                'consumed_letters' => $request->input('consumed_letters'),
            ]
        );

        if($item == NULL){
            session::flash('msg','w:الرجاء التأكد من الرابط المطلوب');
            return Redirect::to('/account/message/create');
        }else{
            return Redirect::to('/account/message/create')->with('msg','تم تعديل نوع الرسالة بنجاح');

        }

    }

    public function destory(Request $request ,$id){

        $item = MessageType::find($id);

        if(!$item){
            return  Redirect::to('/account/message/create')->with('message','غير متوفرة');

        }
        $item->delete();

        return Redirect::to('/account/message/create')->with('msg','تم حدف نوع الرسالة بنجاح');

    }

    public function show( Request $request)
    {

        $from_date = $request["from_date"] ?? "";
        $to_date = $request["to_date"] ?? "";
        $category_id = $request["category_id"] ?? "";
        $datee = $request["datee"] ?? "";
        $type = $request["type"] ?? "";
        $project_id = $request["project_id"] ?? "";
        $replay_status = $request["replay_status"] ?? "";
        $category_name = $request["category_name"] ?? "";
        $citizen_id = $request["citizen_id"] ?? "";
        $id_number = $request["id_number"] ?? "";




        $items = Form::where('deleted_at', null)
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

            ->whereRaw("true")




        ->where(function($query){

            return $query->when( request('replay_status') , function($query){

                return $query->where('status' , request('replay_status'));

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

            return $query->when( request('citizen_id') , function($query){
                $citizen_id = request('citizen_id');

                $keywords = preg_split("/[\s,]+/", $citizen_id);

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

                return $query->whereRaw("(
                    first_name like ? or father_name like ? or grandfather_name like ? or last_name like ?)"
                , ["'%$keywords[0]%'", "'%$keywords[1]%'", "'%$keywords[2]%'", "'%$keywords[3]%'",
                    /**/
                    "'%$citizen_id%'", "%$citizen_id%", "%$citizen_id%", "%$citizen_id%"]);
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

            return $query->when( request('project_id') , function($query){

                return $query->where('project_id' , request('project_id'));

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


        $projects = Project::where('active','=',1)->get();
        $form_type = Form_type::all();
        $categories =Category::all();
        $messagesType = MessageType::all();

        foreach($items as $item){

            if($item->binfit == 'غير مستفيد'){
                $item->binfit = "غير مستفيد";
            }else{
                $item->binfit = " مستفيد";

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

        if ($request['theaction'] == 'search') {
            $items = Form::whereIn('id', $items->pluck('id'))->paginate(5);
            $items->appends(['theaction'=>'search',
                'from_date' => $from_date,'to_date'=>$to_date, 'category_id' => $category_id,'datee'=>$datee,
                'type' => $type,'project_id'=>$project_id, 'replay_status'=>$replay_status, 'category_name'=>$category_name,
                'id_number'=>$id_number, 'citizen_id'=>$citizen_id,
            ]);
        } else {
            $items = "";
        }


        return view("account.message.show", compact('items','form_type','projects','categories','messagesType'));



    }

    public function get_messagecount($id){

        $count_of_letter = MessageType::select('count_of_letter')->where('id', '=', $id)->first();
        return response()->json($count_of_letter);

    }


}
