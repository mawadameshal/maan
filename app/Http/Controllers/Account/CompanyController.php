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

        $item = Company::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account");
        }

        if ($request->hasFile('file_home')) {
            $file = $request->file('file_home');
            //return $file;
            $destinationPath = public_path('uploads');
            $extension = strtolower($file->getClientOriginalExtension());
            $fileName = uniqid().'.'.$extension;
            $file->move($destinationPath, $fileName);
            $item->steps_file = $fileName;
            $item->save();
        }
        //return $item;
        $item->update($request->all());
        session::flash('msg','s:تمت عميلة التعديل بنجاح');
        return redirect('/account');
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
