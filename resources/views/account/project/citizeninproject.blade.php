@extends("layouts._account_layout")

@section("title", " مستفيدي مشروع  $item->name $item->code ")


@section("content")
    <br>
    <br>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            @if(Auth::user()->account->links->contains(\App\Link::where('title','=','تعديل مواطن')->first()->id))
                <form action="{{ route('save-citizen-data-project', $item->id) }}" method="POST" enctype="multipart/form-data"
                      id="dataListForm" style="padding-top: 20px;border-top: 1px solid #e2e2e2;">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <span> يجب رفع بيانات المستفيدين من مشروع {{ $item->name }} حسب النموذج المرفق: </span>
                            <a href="{{ route('download-citizen-file') }}" class="btn btn-primary"
                               style="margin-top:10px;margin-right: 15%;"><i class="fa fa-download" style=""></i> تحميل
                                نموذج الملف المطلوب </a>
                        </div>

                        <div class="col-sm-4" style="display: inline-flex;margin-top: 2%;">
                            <input type="file" name="data_file" style="width: 200px;"/>
                            <input type="submit"
                                   style="width:70px;padding: 0.4rem 2rem !important;font-size: 1.3rem !important;"
                                   value="رفع" class="btn btn-primary"/>
                        </div>
                    </div>
                    <input type="hidden" name="project_id" id="project_id" value="{{$item->id}}">
                </form>
            @endif
        </div>

        <hr style="border: 1px solid #eee !important;">

        <form class="form-inline">
        <div class="col-sm-12">
            <div class="form-group" style="margin-left: 10px;margin-bottom: 10px;">
                <button type="button"  style="width:110px;"  class="btn btn-primary adv-search-btnn"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    بحث متقدم
                </button>

                <button type="submit"  name="theaction"  value="excel" class="btn btn-primary" style="width:110px;">
                    <span class="glyphicon glyphicon-export"></span>
                    تصدير
                </button>
            </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 20px;">

              <div class="form-group adv-searchh"  style="margin-left: 5px;">
                 <input type="text" class="form-control" name="id" value="{{old('id')}}"
                   placeholder="الرقم المرجعي" style="width: 230px;"/>
               </div>
              <div class="form-group adv-searchh" style="margin-left: 5px;">
                <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}"
                   placeholder="اسم مقدم الاقتراح/الشكوى" style="width: 230px;"/>
             </div>
              <div class="form-group adv-searchh" style="margin-left: 5px;">
                <input type="text" class="form-control" name="id_number" value="{{old('id_number')}}"
                   placeholder="رقم الهوية" style="width: 230px;"/>
             </div>
              <div class="form-group adv-searchh" style="margin-left: 5px;">
                  <select class="form-control" name="governorate" style="width: 230px;">
                      <option value=""> المحافظة</option>
                      <option value="الشمال" {{old('governorate')=='الشمال'?"selected":""}}>الشمال</option>
                      <option value="غزة" {{old('governorate')=='غزة'?"selected":""}}>غزة</option>
                      <option value="الوسطى" {{old('governorate')=='الوسطى'?"selected":""}}>الوسطى</option>
                      <option value="خانيونس" {{old('governorate')=='خانيونس'?"selected":""}}>خانيونس</option>
                      <option value="رفح" {{old('governorate')=='رفح'?"selected":""}}>رفح</option>
                  </select>
            </div>
            <button type="submit"  name="theaction"  value="search" class="btn btn-primary adv-searchh">
            <span class="glyphicon glyphicon-search"></span>
                بحث
            </button>


        </div>

        </form>

    </div>
    <div class="mt-3"></div>
         @if($items)
            @if($items->count()>0)
                <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th style="max-width: 50px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">#</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">الاسم رباعي</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رقم الهوية</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">المحافظة</th>
                        <!--<th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">المنطقة</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">الشارع</th>-->
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رقم التواصل (1)</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رقم التواصل (2)</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">اسم المشروع</th>
                        <th width="21%">التفاصيل ذات العلاقة بالمستفيد</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $a)
                        <tr>
                        <td style="max-width: 50px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$loop->iteration}}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$a->first_name." ".$a->father_name." ".$a->grandfather_name." ".$a->last_name}}</td>
                            <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->id_number}}</td>
                            <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->governorate}}</td>
                            <!--<td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->city}}</td>
                            <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->street}}</td>-->
                            <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-align: center;" class="text-left" dir="ltr">{{$a->mobile}}</td>
                            <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-align: center;" class="text-left" dir="ltr">{{$a->mobile2}}</td>
                            <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-align: center;" class="text-left" dir="ltr">{{$item->name}}</td>
                            <td style="text-align: center !important;">
                                @if(Auth::user()->account->links->contains(\App\Link::where('title','=','تعديل مواطن')->first()->id))
                                <a class="btn btn-xs btn-primary" title="تعديل" href="/account/citizen/{{$a->id}}/edit"><i
                                            class="fa fa-edit"></i></a>
                                <a class="btn btn-xs btn-info"
                                   href="/account/citizen/select-project/{{$a->id}}">المشاريع</a>
                                    @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
                <br>
                <div style="float:left" >{{$items->links()}} </div>
                <br>
                <br>
                <br>
            @else
                <br><br>
                <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
            @endif

        @else
             <br>
             <br>
            <div class="table-responsive">

                <table class="table table-hover table-striped" style="white-space:normal;">
                    <thead>
                    <tr>
                        <th style="max-width: 50px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">#</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">الاسم رباعي</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رقم الهوية</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">المحافظة</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رقم التواصل (1)</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رقم التواصل (2)</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">اسم المشروع</th>
                        <th>التفاصيل ذات العلاقة بالمستفيد</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        @endif


    <br><br>
    <div class="form-group row">
        <div class="col-sm-2 col-md-offset-10">
            <a href="/account/project"  class="btn btn-success">الغاء الامر</a>
        </div>
    </div>
@endsection
@section("js")
        <script>
            $('.adv-searchh').hide();
            $('.adv-search-btnn').click(function(){
                $('.adv-searchh').slideToggle("fast");
            });
        </script>
@endsection
