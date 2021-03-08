@extends("layouts._account_layout")

@section("title", "إدارة فئات الاقتراحات والشكاوى")

@section('content')

    <div class="row">
            <div class="col-md-8">
            <h4>هذه الواجهة مخصصة للتحكم في إدارة فئات الاقتراحات والشكاوى</h4><br>
            </div>
            <div class="col-md-4">
                <a class="btn btn-success" href="/account/category/create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>إضافة فئة اقتراح/شكوى جديدة</a>
            </div>

        </div>
        <br>
        <div class="form-group" style="margin-left: 10px;margin-bottom: 10px;">
	            <button type="button"  style="width:110px;"  class="btn btn-primary adv-search-btnn"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
	                بحث متقدم
	                 </button>
		</div>

        <div class="row" style="margin-bottom: 10px;margin-top: 30px;margin-right: 0px;">
            <form class="form-inline">
                <div class="form-group adv-searchh" style="margin-left: 10px;">
              <select   class="form-control" name="main_category_id" style="width: 230px">
                  <option value="">الفئات الرئيسية</option>
                  @foreach($mainCategories as $category)
                      <option value="{{$category->id}}" {{old('main_category_id') ==$category->id ? 'selected' : ''}}  >  {{$category->name}} </option>
                  @endforeach
              </select>
            </div>
                <div class="form-group adv-searchh" style="margin-left: 10px;">
                    <select   class="form-control" name="category_id" style="width: 230px">
                        <option value="">الفئات الفرعية</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{old('category_id') ==$category->id ? 'selected' : ''}}  >  {{$category->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group adv-searchh" style="margin-left: 10px;">
                <select class="form-control" name="is_complaint" style="width: 230px">
                    <option value="">نوع الفئة</option>
                    <option value="0">اقتراح</option>
                    <option value="1">شكوى</option>

                 </select>
            </div>
                <div class="form-group adv-searchh" style="margin-left: 10px;">
                    <select class="form-control" name="citizen_benefic" style="width: 230px">
                        <option value="">فئة مقدم الاقتراح/الشكوى</option>
                        <option value="0" >مستفيد</option>
                        <option value="1">غير مستفيد</option>

                     </select>
                </div>
                <button type="submit"  name="theaction"  value="search" style="width:70px;margin-left: 10px;" class="btn btn-primary adv-searchh">
                          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>بحث
                      </button>
             </form>
        </div>
        <div class="mt-3"></div>

    @if($items)
        @if($items->count()>0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                <thead>
                    <hr>

                    <tr>
                        <th style="max-width: 30px;word-break: normal;"># </th>
                        <th style="max-width: 100px;word-break: normal;">اسم الفئة الرئيسية</th>
                        <th style="max-width: 100px;word-break: normal;">اسم الفئة الفرعية</th>
                        <th style="max-width: 100px;word-break: normal;">نوع الفئة</th>
                        <th style="word-break: normal;">فئة مقدم الاقتراح/الشكوى</th>
                        <th style="word-break: normal;">التفاصيل ذات العلاقة بالفئة الفرعية</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $a)
                        <tr>
                            <td style="word-break: normal;">{{$a->id}}</td>
                            <td style="word-break: normal;">{{$a->is_complaint == 1 ? $a->parentCategory->name  : $a->parentSuggest->name }}</td>
                            <td style="word-break: normal;">{{$a->name}}</td>
                            <td style="max-width: 60px;word-break: normal;">{{$a->is_complaint == 1 ?  ' شكوي '  : ' اقتراح '}}</td>
                            <td style="word-break: normal;">{{$a->citizen_show == 1 ?  ' غير مستفيد من مشاريع المركز '  : ' مستفيد من مشاريع المركز '}}</td>

                            <td style="text-align:center;word-break: normal;">
                                <a class="btn btn-xs btn-danger" href="/account/category/showcircle/{{$a->id}}">
                                        المستويات الإدارية</a>
                                @if(check_permission('تعديل فئة'))
                                    <a class="btn btn-xs btn-primary" title="تعديل" href="/account/category/{{$a->id}}/edit"><i
                                                class="fa fa-edit"></i></a>
                                    @if($a->id > 12)
                                        <a class="btn btn-xs Confirm btn-danger" title="حذف" href="/account/category/delete/{{$a->id}}"><i
                                                    class="fa fa-trash"></i></a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <br>
            <div style="float:left" >  {{$items->links()}} </div>
            <br> <br><br>
        @else
            <br><br>
            <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
        @endif
    @else
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th style="max-width: 30px;word-break: normal;"># </th>
                    <th style="max-width: 100px;word-break: normal;">اسم الفئة الرئيسية</th>
                    <th style="max-width: 100px;word-break: normal;">اسم الفئة الفرعية</th>
                    <th style="max-width: 100px;word-break: normal;">نوع الفئة</th>
                    <th style="word-break: normal;">فئة مقدم الاقتراح/الشكوى</th>
                    <th style="word-break: normal;">التفاصيل ذات العلاقة بالفئة الفرعية</th>
                </tr>
                </thead>
            </table>
        </div>
    @endif
@endsection
@section('js')
<script>
    $('.adv-searchh').hide();
    $('.adv-search-btnn').click(function(){
        $('.adv-searchh').slideToggle("fast");
    });
</script>
@endsection
