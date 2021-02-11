<?php

namespace App\Http\Controllers\Account;


use App\Account;
use App\Notification;
use App\Project;
use Illuminate\Http\Request;
use Pusher\Pusher;


class NotificationController extends BaseController
{
    public function index(Request $request)
    {
        $q = $request["q"]??"";
        $items = auth()->user()->notifications()->whereRaw("true");
        if ($q)
            $items->whereRaw("(title like ? )"
                , ["%$q%"]);

        $items->getQuery()->getQuery()->where('user_id',auth()->user()->id)->update(['read_at' => date('Y-m-d h:m:s')]);

        if(request("theaction") == 'search'){
            $items = $items->orderBy("id",'desc')->paginate(5)->appends([
                "q" => $q]);
        }else{
            $items = "";
        }
        $projects = Project::all();
        return view("account.notifications.index", compact('items','projects'));


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
