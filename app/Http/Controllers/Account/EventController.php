<?php

namespace App\Http\Controllers\Account;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Event;

class EventController extends Controller
{
    public function index(Request $request){
        $items = Event::get();

        if ($items == null) {
            session::flash('msg', 'w:نأسف لا يوجد بيانات لعرضها');
            return redirect('/event');
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
            $items = $items->orderBy("created_at", 'desc')->paginate(5);

            $items->appends([
                "theaction" => "search",
                 "event_name"=>$request['event_name'],
                "start_date"=>$request['start_date'],
                "end_date"=>$request['end_date'],

            ]);

        }else{
            $items = "";
        }


        return view('account.event.event', compact('items') );
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
            return Redirect::to('/events')->withInput()->withErrors($validator);
        }

        $event = new Event;
        $event->event_name = $request['event_name'];
        $event->start_date = $request['start_date'];
        $event->end_date = $request['end_date'];
        $event->save();

        \Session::flash('success','Event added successfully.');
        return Redirect::to('/events');
    }
}
