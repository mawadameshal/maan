<?php

namespace App\Http\Controllers\Account;


use App\Account;
use App\Notification;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Pusher\Pusher;


class NotificationController extends BaseController
{
    public function index(Request $request)
    {

        $notification_type = $request["notification_type"]??"";
        $user_name = $request["user_name"]??"";
        $project_id = $request["project_id"]??"";
        $notification_status = $request["notification_status"]??"";
        $datee = $request["datee"]??"";
        $from_date = $request["from_date"]??"";
        $to_date = $request["to_date"]??"";

//        $items = auth()->user()->notifications()->whereRaw("true");
        $items = Notification::whereRaw("true");

        if ($items == null) {
            session::flash('msg', 'w:نأسف لا يوجد بيانات لعرضها');
            return redirect('/account/notifications');
        }

        if (!is_null($request['notification_status']))
        {
            if($request['notification_status'] == 1 ){
                $items = $items->where('read_at','=',"");
            }else{
                $items = $items->where('read_at','!=',"");
            }

        }

        if ($notification_type)
            $items->where("title", "=", $notification_type);

        if ($datee)
            $items->where('created_at' , Carbon::parse(request('datee'))->format('Y-m-d'));

        if($to_date)
            $items->where([['created_at' ,'>=', Carbon::parse(request('from_date'))->format('Y-m-d')] , ['created_at' ,'<=', Carbon::parse(request('to_date'))->format('Y-m-d')]]);


        if($from_date)
            $items->where([['created_at' ,'>=', Carbon::parse(request('from_date'))->format('Y-m-d')] , ['created_at' ,'<=', Carbon::parse(request('to_date'))->format('Y-m-d')]]);


        if ($user_name)
            $items->whereRaw("(type like ?)"
            , ["%$user_name%"]);

//        $items->getQuery()->getQuery()->where('user_id',auth()->user()->id)->update(['read_at' => date('Y-m-d h:m:s')]);

        if(request("theaction") == 'search'){
            $items = $items->paginate(5)->appends(
                [
                    "notification_type" => $notification_type,
                    "user_name" => $user_name,
                    "notification_status" => $notification_status
                ]);
        }else{
            $items = "";
        }
        $projects = Project::all();
        $notifications = Notification::select('title')->distinct()->get();
        return view("account.notifications.index", compact('items','projects','notifications'));


    }
     static function insert($not_body){
         $a=Notification::create($not_body);
         $items=Account::where('user_id','=',$a->user_id)->first()->user->notifications()->whereNull('read_at')->get();
         $options = array(
             'cluster' => 'ap2',
             'useTLS' => true
         );
         $pusher = new \Pusher\Pusher(
             '078a9e270cf0ebc41e05',
             '3f01865fa022e6f8c099',
             '746988',
             $options
         );

         $data['type'] = $a->type;
         $data['user_id'] = $a->user_id;
         $data['title'] = $a->title;
         $data['date'] = $a->created_at->format('m/d/Y');
         $data['link'] = $a->link;
         $data['num_notif'] = count($items->toArray());
         $pusher->trigger('my-channel', $data['user_id'].'', $data);
     }
    public function store(Request $request)
    {
       /* $options = array(
            'cluster' => 'ap2',
            'useTLS' => false
        );
        $pusher = new Pusher(
            'f95a8f56bcfd8de728c8',
            'c806d81c36a7112e8f1a',
            '703924',
            $options
        );

        $data['comment'] = $comment->comment;
        $data['user'] = $comment->user->name;
        $pusher->trigger('my-channel', 'my-event', $data);*/
    }
}
