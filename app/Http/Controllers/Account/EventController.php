<?php

namespace App\Http\Controllers\Account;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Event;
use Session;

class EventController extends Controller
{
    public function index(Request $request){
        $items = Event::whereRaw("true");

        if ($items == null) {
            session::flash('msg', 'w:نأسف لا يوجد بيانات لعرضها');
            return redirect('/account/events');
        }
        if (!is_null($request['event_name']))
        {
            $items = $items->where(['event_name'=>$request['event_name']]);
        }

        if (!is_null($request['start_date']))
        {
            $items = $items->where(['start_date'=>$request['start_date']]);
        }

        if (!is_null($request['end_date']))
        {
            $items = $items->where(['end_date'=>$request['end_date']]);
        }

        if ($request['theaction'] == 'search'){
            $items = $items->orderBy("id")->paginate(5);

            $items->appends([
                "theaction" => "search",
                 "event_name"=>$request['event_name'],
                "start_date"=>$request['start_date'],
                "end_date"=>$request['end_date'],

            ]);

        }else{
            $items = "";
        }


        return view('account.events.event', compact('items') );
    }

    public function addEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        if ($validator->fails()) {
        	\Session::flash('warnning','Please enter the valid details');
            return Redirect::to('/account/events')->withInput()->withErrors($validator);
        }

        $event = new Event;
        $event->event_name = $request['event_name'];
        $event->start_date = $request['start_date'];
        $event->end_date = $request['end_date'];
        $event->save();

        Session::flash('msg','تم عملية اضافة بنجاح');
        return Redirect::to('/account/events');
    }


    public function edit($id){

        $item =Event::find($id);

        if(!$item){
            return Redirect::to('/account/events');
        }else
        return view('account.events.edit')-> with([
            'item' => $item,

        ]);

    }

    public function update(Request $request ,$id)
    {
        $item=Event::find($id);

        if(!$item){
     		return  Redirect::to('/account/events');
     	}
         $item->update([

        'event_name'=>$request->input('event_name'),
        'start_date'=>$request->input('start_date'),
        'end_date'=>$request->input('end_date'),
        ]);
        if($item == NULL){
            session::flash('msg','w:الرجاء التأكد من الرابط المطلوب');
            return redirect('/account/events');
        }else{
            return Redirect::to('/account/events')->with('message','تم تعديل الإجازة بنجاح');
        }
    }

    public function destory(Request $request ,$id){

        $item =Event::find($id);

        if(!$item){
     		return  Redirect::to('/account/events')->with('message','غير متوفرة');

     	}
     	$item->delete();
        Session::flash("msg", "تم حذف الإجازة بنجاح");
        $items = Event::orderBy("id")->paginate(5)->appends([
            "theaction" => "search",
            "event_name"=>$request['event_name'],
            "start_date"=>$request['start_date'],
            "end_date"=>$request['end_date'],

        ]);
        return view('account.events.event', compact('items') );
//        return  Redirect::to('/account/events')->with('items',$items);

     }
}
