@extends("layouts._account_layout")

@section("title", "إدارة المشاريع")


@section("content")
    <div class="row">
                <div class="col-md-9"><h4>هذه الواجهة مخصصة للتحكم في إدارة مشاريع المركز </h4></div>
                <div class="col-md-2">
 		@if(check_permission('تعديل مشروع'))
                <div class="col-sm-2" style="margin-left: 0px">
                    <a class="btn btn-success" href="/account/project/create">
                        <span class="glyphicon glyphicon-plus"></span>
                        إضافة مشروع جديد
                    </a>
                </div>
            @endif
            </div>
        </div>
        <br>

    <div class="form-group row" style="padding-right:20px;">
        <form>
            <div class="row">

                <div  class="col-sm-4">
                    <button type="button" style="width:100px;" class="btn btn-primary adv-search-btnn">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        بحث متقدم
                    </button>
                    <button type="submit" target="_blank" name="theaction" title="تصدير إكسل" style="width:100px;"
                            value="excel" class="btn btn-primary">
                        <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                        تصدير
                    </button>
                </div>
            </div>
            <div style="margin-bottom: 20px;margin-top: 25px;" class="row">

               <div class="col-sm-4 adv-searchh">
                   <select name="code" class="form-control">
                       <option value="" selected>رمز المشروع</option>
                       @foreach($projects as $project)
                           <option
                               @if(request('code')===''.$project->id)selected
                               @endif
                               value="{{$project->code}}">{{$project->code}}</option>
                       @endforeach
                   </select>
               </div>

               <div class="col-sm-4 adv-searchh">
                   <select name="coordinator" class="form-control" >
                       <option value="" selected>منسق المشروع </option>
                       @foreach($accounts as $account)
                           <option
                               @if(request('coordinator')===''.$account->id)selected
                               @endif
                               value="{{$account->full_name}}">{{$account->full_name}}</option>
                       @endforeach
                   </select>
               </div>

               <div class="col-sm-4 adv-searchh">
                   <select name="project_name" class="form-control">
                       <option value="" selected>اسم المشروع</option>
                       @foreach($projects as $project)
                           <option
                               @if(request('project_name')===''.$project->id)selected
                               @endif
                               value="{{$project->name}}">{{$project->name}}</option>
                       @endforeach
                   </select>
               </div>

            </div>
            <div style="margin-bottom: 20px" class="row">

                <div class="col-sm-4 adv-searchh">
                    <select name="manager" class="form-control" >
                        <option value="" selected>مدير البرنامج </option>
                        @foreach($accounts as $account)
                            <option
                                @if(request('manager')===''.$account->id)selected
                                @endif
                                value="{{$account->full_name}}">{{$account->full_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-4 adv-searchh">
                    <select name="support" class="form-control" >
                        <option value="" selected>ممثل المتابعة و التقييم </option>
                        @foreach($accounts as $account)
                            <option
                                @if(request('support')===''.$account->id)selected
                                @endif
                                value="{{$account->full_name}}">{{$account->full_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-4 adv-searchh">
                    <select name="active" class="form-control">
                        <option value=""> حالة المشروع </option>
                        @foreach($project_status as $pstatus)
                            <option {{request('active')==$pstatus->id?"selected":""}} value="{{$pstatus->id}}">{{$pstatus->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-4 adv-searchh">
                    <label for="from_date">تاريخ بداية المشروع</label>
                    <input   type="text" class="form-control datepicker" name="start_date"
                             placeholder="يوم / شهر / سنة"/>
                </div>

                <div class="col-sm-4 adv-searchh">
                    <label for="from_date">تاريخ نهاية المشروع</label>
                    <input  type="text" class="form-control datepicker" name="end_date"
                            placeholder="يوم / شهر / سنة"/>
                </div>

                <div class="col-sm-4  adv-searchh">
                    <button type="submit" name="theaction" title ="بحث" style="width:110px;margin-top: 24px;" value="search" class="btn btn-primary ">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    بحث
                    </button>
                 </div>

            </div>
        </form>
    </div>

    <div class="mt-3"></div>
    @if($items)
    @if($items->count()>0)
        <div class="table-responsive">

            <table class="table table-hover table-striped" style="width:170% !important;max-width:170% !important;white-space:normal;">
                <thead>
                    <tr>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">#</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رمز المشروع</th>
                        <th style="max-width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"> اسم المشروع باللغة العربية</th>
                        <th style="max-width: 120px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">منسق المشروع</th>
                        <th style="max-width: 150px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">مدير البرنامج </th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">  ممثل قسم المتابعة والتقييم</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">تاريخ بداية المشروع</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">تاريخ نهاية المشروع</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">حالة المشروع</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">التفاصيل ذات العلاقة بالمشروع</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($items as $a)

                    <tr>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->id}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->code}}</td>

                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->name}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">@if($a->account_projects->where('rate','=','3')->first())
                                {{$a->account_projects->where('rate','=','3')->first()->account->full_name}}
                            @endif
                        </td>

                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">@if($a->account_projects->where('rate','=','1')->first())
                                {{$a->account_projects->where('rate','=','1')->first()->account->full_name}}
                            @endif
                        </td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{ $a->supervisor }}
                        </td>
                        {{-- <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">@if($a->account_projects->where('rate','=','2')->first())
                                {{$a->account_projects->where('rate','=','2')->first()->account->full_name}}
                            @endif
                        </td> --}}

                       <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap">{{$a->start_date}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;font-size:12px">{{$a->end_date}}</td>

                        <td>
                            @if($a->end_date < now() )  منتهي@elseمستمر@endif
                        </td>

                        <td style="max-width: 350px;padding-right:50px;">
                            @if($a->id!=1)
                                <a class="btn btn-xs btn-danger" href="/account/project/citizeninproject/{{$a->id}}">
                                    المستفيدين</a>
                                    @else
                                    <a class="btn btn-xs btn-danger" href="/notbenfit">
                                       غير المستفيدين</a>
                                        
                            @endif
                            <a class="btn btn-xs btn-danger" href="/account/project/accountinproject/{{$a->id}}">الموظفين
                            </a>
                                <a class="btn btn-xs btn-danger" href="/account/project/stuffinproject/{{$a->id}}">توظيف
                                </a>
                            <a class="btn btn-xs btn-danger"
                               href="/account/project/forminproject/{{$a->id}}">الاقتراحات/الشكاوى</a>
{{--                                <form style="display:inline" action="/account/project/{{$a->id}}">--}}
{{--                                    <button class="btn btn-xs btn-primary" type="submit" target="_blank"  title ="معاينة" value="print" class="btn btn-primary ">--}}
{{--                                    <i class="glyphicon glyphicon-eye-open"></i>--}}
{{--                                    </button>--}}
{{--                                </form>--}}
                            @if(check_permission('تعديل مشروع'))
                                
                                    <a class="btn btn-xs btn-primary" title="تعديل"
                                       href="/account/project/edit/{{$a->id}}"><i
                                                class="fa fa-edit"></i></a>
                                
                                @if($a->id !=1 && count($a->Accounts->toArray())<=1 && $a->citizens->toArray() == null && $a->forms->toArray() == null)

                                    <a class="btn btn-xs Confirm btn-danger"
                                       title="حذف" href="/account/project/delete/{{$a->id}}"><i
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
        <div style="float:left" >{{$items->links()}} </div>
        <br> <br><br>
    @else
        <br><br>
        <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
    @endif
    @else

    <div class="table-responsive">

        <table class="table table-hover table-striped" style="white-space:normal;">
            <thead>
            <tr>
                <th style="max-width: 100px;word-break: normal;overflow: hidden;text-overflow: ellipsis;">#</th>
                <th style="max-width: 100px;word-break: normal;overflow: hidden;text-overflow: ellipsis;">رمز المشروع</th>
                <th style="max-width: 200px;word-break: normal;overflow: hidden;text-overflow: ellipsis;"> اسم المشروع باللغة العربية</th>
                <th style="max-width: 120px;word-break: normal;overflow: hidden;text-overflow: ellipsis;">منسق المشروع</th>
                <th style="max-width: 150px;word-break: normal;overflow: hidden;text-overflow: ellipsis;">مدير البرنامج </th>
                <th style="max-width: 100px;word-break: normal;overflow: hidden;text-overflow: ellipsis;">  ممثل قسم المتابعة والتقييم</th>
                <th style="max-width: 100px;word-break: normal;overflow: hidden;text-overflow: ellipsis;">تاريخ بداية المشروع</th>
                <th style="max-width: 100px;word-break: normal;overflow: hidden;text-overflow: ellipsis;">تاريخ نهاية المشروع</th>
                <th style="max-width: 100px;word-break: normal;overflow: hidden;text-overflow: ellipsis;">حالة المشروع</th>
                <th style="max-width: 100px;word-break: normal;overflow: hidden;text-overflow: ellipsis;">التفاصيل ذات العلاقة بالمشروع</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    @endif

@endsection
@section("js")
    <script>
        $(function () {
            $(".cbActive").click(function () {
                var id = $(this).val();
                $.ajax({
                    url: "/account/project/active/" + id,
                    data: {_token: '{{ csrf_token() }}'},
                    error: function (jqXHR, textStatus, errorThrown) {
                        // User Not Logged In
                        // 401 Unauthorized Response
                        window.location.href = "/account/project";
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
