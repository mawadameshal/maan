<?php

namespace App\Http\Controllers\Account;;

use Illuminate\Http\Request;
use Session;
use App\Company;
use App\Message;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\MessageRequest;
class CompanyController extends BaseController{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
          public function store(MessageRequest $request)
    {

    }
	  public function show($id)
    {

        //
    }
	public function index(Request $request)
    {
        return redirect("/account");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Company::all()->first();
        if($item == null){
            session::flash('msg','w:الرجاء التأكد من الرابط المطلوب');
            return redirect('/account');
        }else{
            return view('account.company.edit',compact('item'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {

        $data = $request->validate([
            
            'steps_file' => 'sometimes|nullable|max:6400|mimes:jpeg,bmp,png,gif,svg,pdf,docx,xls,xlsx,txt,File',
        ]);
     
        if ($request->hasFile('steps_file')) {
            $fileName = time().'.'.$request->steps_file->extension();
            $request->steps_file->move(public_path('uploads'), $fileName);
            $data['steps_file'] =$fileName;
        }else{
            $data['steps_file'] = $item->steps_file;
        }

        $item= Company::find($id);
        $item->update([
            'steps_file' =>$data['steps_file'],
       ]);
        $item->save();
        session::flash('msg','s:تمت عميلة التعديل بنجاح');
        return redirect('/account');

        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account");
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
