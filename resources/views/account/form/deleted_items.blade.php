@extends("layouts._account_layout")

@section("title", "إدارة الاقتراحات والشكاوى المحذوفة ")
@section("content")

    <div class="row">

        <div class="col-md-9"><h4>هذه الواجهة مخصصة للتحكم في إدارة الاقتراحات والشكاوى المحذوفة من النظام
            </h4></div>

    </div>
    <br>

    <div class="form-group row filter-div">
        <div class="col-sm-12">
            <form>
                <div class="row">
{{--                    <div class="col-sm-6">--}}
{{--                        <input type="text" class="form-control" name="q" value="{{request('q')}}"--}}
{{--                               placeholder="ابحث في الرقم المرجعي، الاسم، رقم الهوية أو اسم المشروع للاقتراح/ الشكوى"/>--}}
{{--                    </div>--}}
                    <div class="col-sm-4">
{{--                        <button id="searchonly" type="submit" name="themainaction" value="search" style="width:100px;"--}}
{{--                                class="btn btn-primary"><span class="glyphicon glyphicon-search"--}}
{{--                                                              aria-hidden="true"></span> بحث--}}
{{--                        </button>--}}

                        <button type="button" style="width:100px;" class="btn btn-primary adv-search-btn"><span
                                class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            بحث متقدم
                        </button>

                        <button type="submit" target="_blank" name="theaction" title="تصدير إكسل" style="width:100px;"
                                value="excel" class="btn btn-primary">
                            <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                            تصدير
                        </button>

                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm-3 adv-search">
                        <input type="text" class="form-control" name="id" placeholder="الرقم المرجعي" >
                    </div>

                    <div class="col-sm-3 adv-search">
                        <input type="text" class="form-control" name="citizen_id" placeholder="اسم مقدم الاقتراح / الشكوى" >
                    </div>

                    <div class="col-sm-3 adv-search">
                        <input type="text" class="form-control" name="id_number" placeholder="رقم الهوية" >
                    </div>

                    <div class="col-sm-3 adv-search">
                        <select name="category_name" class="form-control">
                            <option value="">فئة مقدم الاقتراح/الشكوى</option>
                            <option value="0">مستفد</option>
                            <option value="1">غير مستفيد</option>
                        </select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-3 adv-search">
                        <select name="project_id" class="form-control">
                            <option value="" selected>اسم المشروع</option>
                            @foreach($projects as $project)
                                <option
                                    @if(request('project_id')===''.$project->id)selected
                                    @endif
                                    value="{{$project->id}}">{{$project->code." ".$project->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <select name="active" class="form-control">
                            <option value=""> حالة المشروع </option>
                            @foreach($project_status as $pstatus)
                                <option {{request('active')==$pstatus->id?"selected":""}} value="{{$pstatus->id}}">{{$pstatus->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <select name="sent_type" class="form-control">

                            <option value="">قناة الاستقبال</option>
                            @foreach($sent_typee as $sent_type)
                                <option
                                    {{request('sent_type')==$sent_type->id?"selected":""}} value="{{$sent_type->id}}">{{$sent_type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select name="type" class="form-control">
                            <option value="">التصنيف (اقتراح أو شكوى)</option>
                            @foreach($form_type as $ftype)
                                @if($ftype->id != 3)
                                    <option
                                        {{request('type')==$ftype->id?"selected":""}} value="{{$ftype->id}}">{{$ftype->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-3 adv-search">
                        <select name="category_id" class="form-control">
                            <option value="" selected>فئة الاقتراح/الشكوى</option>
                            @foreach($categories as $category)
                                @if($category->id != 1 && $category->id != 2)
                                    <option
                                        @if(request('category_id')===''.$category->id)selected
                                        @endif
                                        value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <select name="deleted_by" class="form-control">

                            <option value="">اسم المستخدم الذي قام بالحذف</option>
                            @foreach($accounts as $account)
                                <option
                                    {{request('deleted_by')==$account->id?"selected":""}} value="{{$account->id}}">{{$account->full_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <select name="circle_id" class="form-control">
                            <option value="">المستوى الإداري</option>
                            @foreach($circles as $circle)
                                <option
                                    {{request('circle_id')==$circle->id ?"selected":""}} value="{{$circle->id}}">{{$circle->name}}</option>
                            @endforeach
                        </select>
                    </div>



                </div>

                <div class="row">

                    <div class="col-sm-3 adv-search">
                        <label for="from_date">تاريخ تسجيل محدد</label>
                        <input type="text" class="form-control datepicker" name="datee" value="{{request('datee')}}"
                               placeholder="يوم / شهر / سنة" />
                    </div>
                    <div class="col-sm-3 adv-search">
                        <label for="from_date">من تاريخ تسجيل</label>
                        <input type="text" class="form-control datepicker" name="from_date" value="{{request('from_date')}}"
                               placeholder="يوم / شهر / سنة" />
                    </div>
                    <div class="col-sm-3 adv-search">
                        <label for="to_date">إلى تاريخ تسجيل</label>
                        <input type="text" class="form-control datepicker" name="to_date" value="{{request('to_date')}}"
                               placeholder="يوم / شهر / سنة"/>
                    </div>

                    <div class="col-sm-3 adv-search">

                        <button type="submit" name="theaction" title="بحث" style="width:70px;margin-top:22px"
                                value="search"
                                class="btn btn-primary adv-search">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            بحث
                        </button>
                    </div>
                </div>
                <div class="row" style="margin-top:15px;">
                </div>
            </form>

        </div>

    </div>
    <div class="mt-3"></div>
    @if($items)
        @if($items->count()>0)
            <div class="table-responsive">

                <table class="table table-hover table-striped"
                       style="width:170% !important;max-width:170%;white-space:normal;">
                    <thead>
                    <tr>
                        <th style="max-width: 100px;word-break: normal;">الرقم المرجعي</th>
                        <th style="max-width: 100px;word-break: normal;">الاسم رباعي
                        </th>
                        <th style="max-width: 100px;word-break: normal;">رقم الهوية
                        </th>
                        <th style="max-width: 100px;word-break: normal;">فئة مقدم الاقتراح/الشكوى
                        </th>
                        <th style="max-width: 100px;word-break: normal;">اسم المشروع
                        </th>
                        <th style="max-width: 100px;word-break: normal;">حالة المشروع
                        </th>
                        <th style="max-width: 100px;word-break: normal;">قناة الاستقبال
                        </th>
                        <th style="max-width: 100px;word-break: normal;">التصنيف
                        </th>
                        <th style="max-width: 100px;word-break: normal;">فئة الاقتراح/الشكوى
                        </th>
                        <th style="max-width: 100px;word-break: normal;">تاريخ تسجيل الاقتراح/الشكوى
                        </th>
                        <th style="max-width: 100px;word-break: normal;">اسم المستخدم الذي قام بالحذف
                        </th>
                        <th style="max-width: 100px;word-break: normal;">مستواه الاداري
                        </th>


                        <th style="max-width: 100px;word-break: normal;">سبب الحذف
                        </th>
                        <th style="max-width: 100px;word-break: normal;">تاريخ الحذف
                        </th>
                        <th style="max-width: 100px;word-break: normal;">المرفقات
                        </th>
                        <th style="max-width: 100px;white-space:nowrap;">معاينة</th>


                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $a)

                        <tr>
                            <td style="max-width: 100px;word-break: normal;">{{$a->id}}</td>
                            <td style="max-width: 300px;word-break: normal;">{{$a->citizen->first_name." ".$a->citizen->father_name." ".$a->citizen->grandfather_name." ".$a->citizen->last_name}}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$a->citizen->id_number}}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$a->project->id == 1 ? 'غير مستفيد' : ' مستفيد' }}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$a->project->name}}</td>

                            <td style="max-width: 100px;word-break: normal;">{{$a->project->end_date <= now() ?  'منتهي' : 'مستمر'}}</td>
                            <td style="max-width: 100px;word-break: normal;"> {{$a->sent_typee->name}}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$a->form_type->name}}</td>
                            <td style="max-width: 300px;word-break: normal;">{{$a->category->name}}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$a->datee}}</td>


                        <!--          @if($type!=2 && $type!=3)
                            <td style="max-width: 100px;word-break: normal;"
                                style="padding-left: 0px;padding-right: 0px">

{{$a->category->name}}

                                </td>
@endif

                            <td style="max-width: 100px;word-break: normal;">{{$a->title}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->project->name}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->project->project_status->name}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->datee}}</td>-->
                            {{-- <td style="max-width: 100px;word-break: normal;">{{$a->form_status->name}} </td> --}}

                            <td style="max-width: 300px;word-break: normal;"> @if($a->deleted_by == 1) مسؤول
                                النظام @else داليا أحمد يونس @endif</td>
                            <td style="max-width: 100px;word-break: normal;">     {{  \App\Account::where('id' , $a->deleted_by)->first()->circle->name }}


                            </td>
                            <td style="max-width: 300px;word-break: normal;"> {{$a->deleted_because}}</td>
                            <td style="max-width: 100px;word-break: normal;"> {{$a->deleted_at}}</td>
                            <td style="max-width: 100px;word-break: normal;">
                                <?php
                                $form_files = \App\Form_file::where('form_id', '=', $a->id)->get();

                                if(!$form_files->isEmpty()){
                                ?>
                                <a class="btn btn-xs btn-primary" data-toggle="modal" id="smallButton" data-target="#smallModal"
                                   data-attr="{{ route('showfiles', $a->id) }}" title="اضغظ هنا">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                                <?php }else{?>
                                <a class="btn btn-xs btn-primary" title="لا يوجد مرفقات لعرضها" disabled="disabled">
                                    <i class="glyphicon glyphicon-eye-close"></i>
                                </a>
                                <?php } ?>
                            </td>
                            <td style="max-width: 100px;word-break: normal;">
                                <a
                                    target="_blank" title="عرض" class="btn btn-xs btn-primary"
                                    href="/citizen/form/show/{{$a->citizen->id_number}}/{{$a->id}}">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                            {{--                            @if(--}}
                            {{--                            Auth::user()->account->circle->circle_categories->where('category_id',$a->category->id)->where('to_delete',1)->first()--}}
                            {{--                            &&--}}
                            {{--                            Auth::user()->account->account_projects->where('project_id',$a->project->id)->where('to_delete',1)->first()--}}
                            {{--                            )--}}
                            {{--                                @if ($a->status == "3" )--}}
                            {{--                                    <a class="btn btn-xs Confirm btn-danger" title="يمكن حذفها لأنها مغلقة"--}}
                            {{--                                       href="/account/form/delete/{{$a->id}}"><i--}}
                            {{--                                                class="fa fa-trash"></i></a>--}}
                            {{--                                @endif--}}
                            {{--                        </td>--}}
                            {{--                        @else--}}
                            {{--                        @endif--}}

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="float:left">  {{$items->links()}} </div>

            <br>
        @else
            <br><br>
            <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
        @endif


    @else
        <div class="table-responsive">

            <table class="table table-hover table-striped"
                   style="white-space:normal;">
                <thead>
                <tr>
                    <th style="max-width: 100px;word-break: normal;">الرقم المرجعي</th>
                    <th style="max-width: 100px;word-break: normal;">الاسم رباعي
                    </th>
                    <th style="max-width: 100px;word-break: normal;">رقم الهوية
                    </th>
                    <th style="max-width: 100px;word-break: normal;">فئة مقدم الاقتراح/الشكوى
                    </th>
                    <th style="max-width: 100px;word-break: normal;">اسم المشروع
                    </th>
                    <th style="max-width: 100px;word-break: normal;">حالة المشروع
                    </th>
                    <th style="max-width: 100px;word-break: normal;">قناة الاستقبال
                    </th>
                    <th style="max-width: 100px;word-break: normal;">التصنيف
                    </th>
                    <th style="max-width: 100px;word-break: normal;">فئة الاقتراح/الشكوى
                    </th>
                    <th style="max-width: 100px;word-break: normal;">تاريخ تسجيل الاقتراح/الشكوى
                    </th>
                    <th style="max-width: 100px;word-break: normal;">اسم المستخدم الذي قام بالحذف
                    </th>
                    <th style="max-width: 100px;word-break: normal;">مستواه الاداري
                    </th>


                    <th style="max-width: 100px;word-break: normal;">سبب الحذف
                    </th>
                    <th style="max-width: 100px;word-break: normal;">تاريخ الحذف
                    </th>
                    <th style="max-width: 100px;word-break: normal;">المرفقات
                    </th>
                    <th style="max-width: 100px;white-space:nowrap;">معاينة</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>


    @endif
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>المرفقات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="smallBody">
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("js")
    <script>
        $(document).on('click', '#smallButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>
    <script>
        $(function () {
            $(".cbActive").change(function () {
                var id = $(this).attr('content');
                var cat_id = $(this).val();

                $.ajax({
                    method: 'POST',
                    url: "/account/form/change-category/" + id,
                    data: {_token: '{{ csrf_token() }}', _method: 'PUT', 'category_id': cat_id},
                    error: function (jqXHR, textStatus, errorThrown) {
                        // User Not Logged In
                        // 401 Unauthorized Response
                        //window.location.href = "/account/form";
                    },
                });
            });
            $('.adv-search').hide();
            $('.adv-search-btn').click(function () {
                $('.adv-search').slideToggle("fast", function () {
                    if ($('.adv-search').is(':hidden')) {
                        $('#searchonly').show();
                    } else {
                        $('#searchonly').hide();
                    }
                });
            });
        });
    </script>
@endsection
