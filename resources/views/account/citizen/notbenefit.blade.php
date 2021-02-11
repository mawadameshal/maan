@extends("layouts._account_layout")

@section("title", "إدارة غير مستفيدي المشاريع")

@section("content")
    <div class="row">
        <div class="col-md-9">
          <h4>هذه الواجهة مخصصة للتحكم في إدارة غير مستفيدي مشاريع المركز</h4><br>
        </div>
    </div>
	<br>

    <div class="row ">
        <div class="col-md-12">
            <form>
                <div class="row">
                    <div class="col-sm-4">
                        <button type="button"  style="width:100px;"  class="btn btn-primary adv-search-btnn">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        بحث متقدم
                        </button>

                        <button type="submit" target="_blank" name="theaction" title ="تصدير إكسل" style="width:110px;" value="excel" class="btn btn-primary ">
                            <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                        تصدير
                        </button>
                    </div>
                </div>
                <div class="col-sm-12 "><br></div>
                <div class="row">
                   <div class="col-sm-4">
                       <div class="form-group adv-searchh" style="margin-left: 10px;margin-bottom: 10px;">
                          <input type="text" class="form-control" name="id" value="" placeholder="الرقم المرجعي">
                        </div>
                   </div>
                   <div class="col-sm-4">
                        <div class="form-group adv-searchh" style="margin-left: 10px;margin-bottom: 10px;">
                          <input type="text" class="form-control" name="id_number" value="" placeholder="رقم الهوية">
                        </div>
                   </div>
                   <div class="col-sm-4">
                        <div class="form-group adv-searchh" style="margin-left: 10px;margin-bottom: 10px;">
                          <input type="text" class="form-control" name="first_name" value="" placeholder="اسم مقدم الاقتراح/ الشكوى">
                        </div>
                   </div>

                   <div class="col-sm-4">
                       <div class="form-group adv-searchh" style="margin-left: 10px;margin-bottom: 10px;">
                           <select class="form-control" name="governorate">
                            <option value=""> المحافظة</option>
                            <option value="الشمال" {{old('governorate')=='الشمال'?"selected":""}}>الشمال</option>
                            <option value="غزة" {{old('governorate')=='غزة'?"selected":""}}>غزة</option>
                            <option value="الوسطى" {{old('governorate')=='الوسطى'?"selected":""}}>الوسطى</option>
                            <option value="خانيونس" {{old('governorate')=='خانيونس'?"selected":""}}>خانيونس</option>
                            <option value="رفح" {{old('governorate')=='رفح'?"selected":""}}>رفح</option>
                        </select>
                       </div>
                   </div>

                   <div class="col-sm-4">
                     <div class="form-group" style="margin-left: 10px;margin-bottom: 10px;">
                        <button style="width: 110px" type="submit" name="theaction" title ="بحث" value="search" class="btn btn-primary adv-searchh">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                              بحث
                        </button>
                     </div>
                   </div>
                </div>
                <div class="col-sm-12 "><br></div>
            </form>
        </div>
    </div>

    <div class="mt-3"> </div>
    @if($items)
    @if($items->count()>0)
<div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>الرقم المرجعي </th>
                <th>الاسم رباعي </th>
                <th>رقم الهوية</th>
                <th>المحافظة</th>
                <th style="width:9%">رقم التواصل(1)</th>
                <th style="width:9%">رقم التواصل (2)</th>
                <th> التفاصيل ذات العلاقة بغير المستفيد</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $a)
                <tr>
                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$loop->iteration}} </td>
                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->id}}</td>
                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->first_name." ".$a->father_name." ".$a->grandfather_name." ".$a->last_name}}</td>
                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->id_number}}</td>
                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->governorate}}</td>
                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-align:center;" dir="ltr">{{$a->mobile}}</td>
                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-align:center;" dir="ltr">{{$a->mobile2}}</td>
                    <td style="text-align: center">


                        <a class="btn btn-xs btn-success" href="/account/citizen/formincitizen/{{$a->id}}">الاقتراحات/الشكاوى</a>

                        @if(Auth::user()->account->links->contains(\App\Link::where('title','=','تعديل مواطن')->first()->id))
                            <a class="btn btn-xs btn-primary" title="تعديل" href="/account/citizen/{{$a->id}}/edit"><i
                                        class="fa fa-edit"></i></a>
                            @if($a->add_byself=="1" && $a->projects->toArray()==null)
                                <a class="btn btn-xs Confirm btn-danger" title="حذف" href="/account/citizen/delete/{{$a->id}}"><i
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

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>الرقم المرجعي </th>
                <th>الاسم رباعي </th>
                <th>رقم الهوية</th>
                <th>المحافظة</th>
                <th>رقم التواصل(1)</th>
                <th>رقم التواصل (2)</th>
                <th> التفاصيل ذات العلاقة بغير المستفيد</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>



    @endif
@endsection
@section("js")

    <script>

        $(function () {
            $(".cbActive").click(function () {
                var id = $(this).val();
                $.ajax({
                        url:"/account/citizen/accept/" + id,
                    data:{_token:'{{ csrf_token() }}'},
                error : function (jqXHR, textStatus, errorThrown) {
        // User Not Logged In
        // 401 Unauthorized Response
         window.location.href = "/account/citizen";
    },
                });
            });
        });

    </script>
    <script>
        $('.adv-searchh').hide();
        $('.adv-search-btnn').click(function(){
            $('.adv-searchh').slideToggle("fast");
        });
    </script>

@endsection

