<?php

namespace App\Http\Controllers\Account;

use App\Form;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Appendix;
use Session;

class AppendixController extends Controller
{
    public function index(Request $request)
    {
        $items = Appendix::whereRaw("true");
        $items= $items->orderBy("id")->paginate(5);
        return view('account.appendix.index', compact('items') );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appendix_name' => 'required',
            'appendix_describe' => 'required',
            'appendix_file' => 'required'
        ]);

        if ($validator->fails()) {
        	Session::flash('warnning','يرجى إضافة تفاصيل الملحق');
            return Redirect::to('/account/appendix')->withInput()->withErrors($validator);
        }
        $appendix = new Appendix();
        $appendix->appendix_name = $request['appendix_name'];
        $appendix->appendix_describe = $request['appendix_describe'];

        if($request->hasFile('appendix_file')){
            $fileName = time().'.'.$request->appendix_file->extension();
            $request->appendix_file->move(public_path('uploads/appendix'), $fileName);
            $appendix->appendix_file=$fileName;
        }

        $appendix->save();


        Session::flash('msg','تم عمليةإضافة بنجاح.');
        return Redirect::to('/account/appendix');
    }

    public function edit($id){

        $item =Appendix::find($id);

        if(!$item){
            return Redirect::to('/account/appendix');
        }else
        return view('account.appendix.edit')-> with([
            'item' => $item,

        ]);

    }

    public function update(Request $request ,$id)
    {
        $item= Appendix::find($id);

        if(!$item){
     		return  Redirect::to('/account/appendix');
     	}
         $data = $request->validate([
            'appendix_name' => 'required',
            'appendix_describe' => 'required',
            'appendix_file' => 'sometimes|nullable|max:6400|mimes:jpeg,bmp,png,gif,svg,pdf,docx,xls,xlsx,txt,File',
        ]);

         if ($request->hasFile('appendix_file')) {
             $fileName = time().'.'.$request->appendix_file->extension();
             $request->appendix_file->move(public_path('uploads/appendix'), $fileName);
             $data['appendix_file'] =$fileName;
         }else{
             $data['appendix_file'] = $item->appendix_file;
         }

         $item= Appendix::find($id);
         $item->update([
        'appendix_name'=>$request->input('appendix_name'),
        'appendix_describe'=>$request->input('appendix_describe'),
             'appendix_file'=>$data['appendix_file'],
        ]);
         $item->save();

        Session::flash('msg','تم تعديل الملحق بنجاح');
        return Redirect::to('/account/appendix');

        if($item == NULL){
            session::flash('msg','w:الرجاء التأكد من الرابط المطلوب');
            return redirect('/account/appendix');
        }
    }

    public function destory(Request $request ,$id)
    {

        $item =Appendix::find($id);

        if(!$item){
     		return  Redirect::to('/account/appendix')->with('msg','غير متوفرة');

     	}
     	$item->delete();
     	return Redirect::to('/account/appendix')->with('msg','تم حدف الملحق بنجاح');

     }

    public function showappendix($id) {

        $item = Appendix::find($id);
        if ($item)
            return view("account.appendix.itemsfiles", compact( 'item'));

    }

    public function showfiles($id)
    {
        $item = Appendix::find($id);
        if ($item){

            $file= public_path(). "/uploads/appendix/".$item->appendix_file;
            return response()->download($file);
        }
    }


}
