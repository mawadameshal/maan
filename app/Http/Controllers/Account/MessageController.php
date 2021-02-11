<?php

namespace App\Http\Controllers\Account;


use App\Account;
use App\Category;
use App\Form;
use App\Form_status;
use App\Form_type;
use App\Project;

use App\Imports\MessageImport;
use App\MessageType;
use App\Project_status;
use App\Sent_type;
use Carbon\Carbon;
use Validator;
use App\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use App\Imports\FormsExport;
use Maatwebsite\Excel\Facades\Excel;
use  PDF;
use Illuminate\Support\Facades\Storage;

class MessageController extends BaseController
{
    public function index(Request $request)
    {
        $messagesType = MessageType::get();
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


        $items = $items->where(function($query){

            return $query->when( request('read') , function($query){

                return $query->where('read' , request('read'));

            });

        })->where(function($query){

            return $query->when( request('status') , function($query){

                return $query->where('status' , request('status'));

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


        if ($request['theaction'] == 'excel') {
//            return Excel::download(new MessageExport, "Annex Template 07-".date('d-m-Y').".xlsx");
        }else {
            if ($request['theaction'] == 'search') {
               $items = Form::whereIn('id', $items->pluck('id'))->paginate(5);
            } else {
                $items = "";
            }
        }
        return view("account.message.index", compact('items','projects','messagesType'));
    }

    public function create()
    {
        $messagesType = MessageType::get();
        return view("account.message.create" , compact('messagesType'));
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

            $items::create($request->all())->id;
        }

        if($request["update_id"]){
            $texts = $request["update_text"];
            foreach ($request["update_id"] as $i => $prc){
                $x = MessageType::find($prc);
                if($x){
                    $x->text = $texts[$i];
                    $x->save();
                }
            }

        }

        session::flash('msg','s:تمت عميلة الحفظ بنجاح');
        return redirect("/account/message/create");


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

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10',
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }
        else {
            $message = new Sms();
            $message->mobile = $request->mobile;
            $message->message_type_id = $request->message_type_id_1;
            $message->message_text = $request->message_text;
            $message->count_message = strlen($request->message_text);
            $message->name = $request->mobile;
            $message->save();
            Session::flash('msg', 'تم ارسال الرسائل بنجاح');
            return redirect("/account/message/create");
        }
    }
}
