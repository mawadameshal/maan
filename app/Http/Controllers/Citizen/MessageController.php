<?php

namespace App\Http\Controllers\Citizen;


use Illuminate\Http\Request;
use Session;
use App\Message;
use App\Http\Requests\MessageRequest;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
        public function store(MessageRequest $request)
    {
        $request['datee'] = date('Y-m-d');
Message::create($request->all());
Session::flash("msg", "تم ارسال رسالتك بنجاح");
        return redirect("/#اتصل بنا");
    }
	  public function show($id)
    {
        $item = Message::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/message");
        }

        return view('account.company.show', compact('item'));
        //
    }
	public function index(Request $request)
    {
        $q = $request["q"]??"";
		$datee = $request["datee"]??"";
        $items = Message::whereRaw("true");
        if($items == null) {
            session::flash('msg', 'w:نأسف لا يوجد بيانات لعرضها');
            return redirect('/account/message');
        }

        if($q)
            $items->whereRaw("(title like ? || content like ?)"
                ,["%$q%","%$q%"]);
		if ($datee)
                $items = $items->whereRaw("datee = ?", [$datee]);		

        $items = $items->orderBy("id","desc")->paginate(12)->appends([
            "q"=>$q , "datee"=>$datee]);
        return view("account.company.index",compact('items'));
    }
	 public function destroy($id)
    {
        $item = Message::find($id);
            if ($item == NULL  ) {
                Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
                return redirect("/account/message");
            }
            $item->delete();
            Session::flash("msg", "تم حذف رسالة بنجاح");
            return redirect("/account/message");

    }
}