<?php

namespace App\Http\Controllers\Account;
;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Circle;
use App\Http\Requests\CircleRequest;

class CircleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request["q"] ?? "";
        $items = Circle::whereRaw("true");
        if ($items == null) {
            session::flash('msg', 'w:نأسف لا يوجد بيانات لعرضها');
            return redirect('/account/circle');
        }
        if ($q)
            $items->whereRaw("(name like ?)"
                , ["%$q%"]);

        $items = $items->orderBy("id")->paginate(5)->appends([
            "q" => $q]);
        return view("account.circle.index", compact('items'));
    }

    public function create()
    {
        return view("account.circle.create");
    }

    public function store(CircleRequest $request)
    {
        $isExists = Circle::where("name", $request["name"])->count();
        if ($isExists) {
            Session::flash("msg", "e:القيمة المدخلة موجودة مسبقاً");
            return redirect("/account/circle/create")->withInput();
        }
        $items = new Circle();
        $theid=$items::create($request->all())->id;
        session::flash('msg', 's:تمت عميلة الإضافة بنجاح');
        return redirect("/account/circle/select-category/$theid");

    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $items = Circle::find($id);
        if ($items == null) {
            session::flash('msg', 'w:الرجاء التأكد من الرابط المطلوب');
            return redirect('/account/circle');
        } else {
            return view('account.circle.edit', compact('items'));
        }
    }

    public function update(CircleRequest $request, $id)
    {
        $isExists = Circle::where("name", $request["name"])->where("id", "!=", $id)->count();
        if ($isExists) {
            Session::flash("msg", "e:القيمة المدخلة موجودة مسبقاً");
            return redirect("/account/circle/$id/edit");
        }
        $item = Circle::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/circle");
        }
        $item->update($request->all());
        session::flash('msg', 's:تمت عميلة التعديل بنجاح');
        return redirect('/account/circle');
    }

    public function destroy($id)
    {

        $item = Circle::find($id);
        if ($item == NULL || $item->id == 1) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/circle");
        }
        if ($item->Account->first()) {
            Session::flash("msg", "e:لا يمكن حذف دائرة بها موظفين");
            return redirect("/account/circle");
        }
        if ($item->category->toArray() != null) {
            Session::flash("msg", "e:لا يمكن حذف دائرة مرتبط بفئات");
            return redirect("/account/circle");
        } else {
            $item = Circle::find($id);
            $item->delete();
            Session::flash("msg", "تم حذف دائرة بنجاح");
            return redirect("/account/circle");
        }


    }

    public function selectcategory($id)
    {
        $item = Circle::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/circle");
        }
        $categories=Category::all();
        return view("account.circle.add-category", compact("categories","item"));
    }

    public function selectcategoryPost(Request $request, $id)
    {
        $item = Circle::find($id);
        \DB::table("circle_categorie")->where("circle_id", $id)->delete();
        if ($request["category_ids"]) {
            for ($i = 0; $i < count($request["category_ids"]); $i++) {
                if ($request["category_ids"][$i] == 0)
                    continue;


                \DB::table("circle_categorie")->insert(["circle_id" => $id
                    , "category_id" => $request["category_ids"][$i]
                    , "to_delete" => $request["to_delete"][$i]
                    , "to_add" => $request["to_add"][$i]
                    , "to_edit" => $request["to_edit"][$i]
                    , "to_replay" => $request["to_replay"][$i]
                    , "to_stop" => $request["to_stop"][$i]
                    , "to_notify" => $request["to_notify"][$i]
                ]);
            }
            Session::flash("msg", "i:تمت عملية الحفظ بنجاح");
            return redirect("/account/circle");
        }
    }

    public function permission($id)
    {
        $item = Circle::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/circle");
        }
        return view("account.circle.permission", compact("item"));
    }

    public function permissionPost(Request $request, $id)
    {
        $item = Circle::find($id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/circle");
        }
        \DB::table("circle_link")->where("circle_id", $id)->delete();
        if ($request["permission"]) {
            foreach ($request["permission"] as $link)
                \DB::table("circle_link")->insert(["circle_id" => $id,
                    "link_id" => $link]);
        }
        Session::flash("msg", "i:تمت عملية الحفظ بنجاح");
        return redirect("/account/circle");
    }
}
