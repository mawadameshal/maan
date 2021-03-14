<?php

namespace App\Http\Controllers\Account;;

use App\CategoryCircles;
use App\Circle;
use App\ProcedureType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Category;
use App\MainCategory;
use App\Http\Requests\CategoryRequest;

class SuggestController extends BaseController{




    public function create()
    {
        $mainCategories = MainCategory::whereIsComplaint( 0)->get();
        return view("account.suggest.create" , compact('mainCategories'));
    }


    public function store(CategoryRequest $request)
    {
        $mainCategories = MainCategory::all();
        $isExists = Category::where("name",$request["name"])->count();
        if($isExists)
        {
            Session::flash("msg","e:القيمة المدخلة موجودة مسبقاً");
            return redirect("/account/category/create")->withInput();
        }
        $items = new Category();
       // $request['main_category_id'];
        $items->main_category_id = $request->input('main_category_id');
        $items->main_suggest_id = $request->input('main_suggest_id');
        //dd($items);
//        if($request['citizen_show']=='citizen_show')
//            $request['citizen_show']=1;
//        else
//            $request['citizen_msg']=' ';
//
//        if($request['citizen_show']=='benefic_show')
//            $request['benefic_show']=1;
//        else
//            $request['benefic_msg']=' ';

//
//        if($request['citizen_show']==1)
//        $this->validate($request,[
//        'benefic_msg'=>'required',
//        ]);
//        if($request['citizen_show']==1)
//            $this->validate($request,[
//                'citizen_msg'=>'required',
//            ]);

        $cat_id=$items::create($request->all())->id;

        $category_circles = $request->input('category_circle');
        if(!empty($category_circles)){
            foreach($category_circles as $category_circle){

                $Category = new CategoryCircles();
                $Category->category = $cat_id;
                $Category->main_category = $request->input('main_category_id');
                $Category->sub_category = $cat_id;
                $arr = explode("_", $category_circle, 2);
                $Category->procedure_type = $arr[0];
                $Category->circle = substr($category_circle, strpos($category_circle, "_") + 1);
                $Category->save();
            }
        }

        $circles = Circle::get();
        $procedureTypes = ProcedureType::get();

       $test = \DB::table("circle_categorie")->insertGetID(["circle_id" => 1,
                "category_id" => $cat_id]);

        session::flash('msg','s:تمت عميلة الإضافة بنجاح');
        return view ('account.category.create',['mainCategories' => $mainCategories,'circles'=>$circles,'procedureTypes'=>$procedureTypes]);
    }

}
