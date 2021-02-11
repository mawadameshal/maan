@extends("layouts._account_layout")

@section("title", " الاقتراحات/الشكاوى  التي تقدم بها $item->first_name $item->father_name $item->grandfather_name $item->last_name ")


@section("content")

<div class="row">

    <div class="col-sm-12 col-md-12">
        <h4>هذه الواجهة مخصصة للتحكم في إدارة الاقتراحات والشكاوى المسجلة في النظام باسم المواطن</h4>
    </div>


    </div>
<br>
<br>
<div class="form-group row filter-div">
    <div class="col-sm-12">
        <form>
            <div class="row">
                {{-- <div class="col-sm-4">
                    <input type="text" class="form-control" name="q" value="{{request('q')}}"
                           placeholder="ابحث في الرقم المرجعي ,الاسم او رقم الهوية "/>
                </div> --}}
                <div class="col-sm-4">
                    <button type="button" style="width:110px;" class="btn btn-primary adv-search-btn">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    بحث متقدم
                    </button>
                    <button type="submit" target="_blank" name="theaction" title="تصدير إكسل" style="width:110px;"
                            value="excel" class="btn btn-primary">
                        <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                    تصدير
                    </button>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-3 adv-search">
                    <input type="text" class="form-control" name="form_id" placeholder="الرقم المرجعي" >
                </div>

                <div class="col-sm-3 adv-search">
                    <input type="text" class="form-control" name="id_number" placeholder="رقم الهوية" >
                </div>

                <div class="col-sm-3 adv-search">
                    <select name="project_id" class="form-control">
                        <option value="" selected>اسم المشروع</option>
                        <option value="-1" @if(request('project_id')==='-1')selected
                            @endif>جميع المشاريع
                        </option>
                        @foreach($projects as $project)
                            <option
                                @if(request('project_id')===''.$project->id)selected
                                @endif
                                value="{{$project->id}}">{{$project->code." ".$project->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-3 adv-search">
                    <select name="category_name" class="form-control">
                        <option value="" >فئة مقدم الاقتراح/الشكوى</option>
                        <option value="0" >مستفد</option>
                        <option value="1">غير مستفيد</option>
                    </select>
                </div>

                <div class="col-sm-3 adv-search">
                    <select name="sent_type" class="form-control">

                        <option value="">قناة الاستقبال</option>
                        @foreach($sent_typee as $sent_type)
                            <option {{request('sent_type')==$sent_type->id?"selected":""}} value="{{$sent_type->id}}">{{$sent_type->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-3 adv-search">
                    <select name="type" class="form-control">
                        <option value="">التصنيف (اقتراح أو شكوى)</option>
                        @foreach($form_type as $ftype)
                            @if($ftype->id != 3)
                                <option {{request('type')==$ftype->id?"selected":""}} value="{{$ftype->id}}">{{$ftype->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3  adv-search">
                    <select name="category_id" class="form-control">
                        <option value="" selected>فئة الاقتراح/شكوى</option>
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
                    <select name="form_status" class="form-control">
                        <option value="">حالة الرد</option>
                        @foreach($form_status as $fstatus)
                            @if($fstatus->id != 3 && $fstatus->id != 4)

                                {{$fstatus->name = 'لم يتم الرد'}}
                                <option {{request('status')==$fstatus->id?"selected":""}} value="{{$fstatus->id}}">
                                    @if($fstatus->id == 1)
                                        لم يتم الرد
                                    @else
                                        تم الرد
                                    @endif

                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-3  adv-search">
                    <select name="evaluate" class="form-control">
                        <option value="">التغذية الراجعة</option>
                        <option value="0" >غير راضي عن الرد</option>
                        <option value="1">راضي بشكل ضعيف</option>
                        <option value="2">راضي بشكل متوسط </option>
                        <option value="3">راضي بشكل كبير</option>

                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3 adv-search">
                    <label for="from_date">تاريخ تسجيل محدد</label>
                    <input type="text" class="form-control datepicker" name="datee" value="{{request('datee')}}"
                           placeholder="يوم / شهر / سنة"/>
                </div>

                <div class="col-sm-3 adv-search">
                    <label for="from_date">من تاريخ تسجيل </label>
                    <input type="text" class="form-control datepicker" name="from_date" value="{{request('from_date')}}"
                           placeholder="يوم / شهر / سنة"/>
                </div>

                <div class="col-sm-3 adv-search">
                    <label for="to_date">إلى تاريخ تسجيل</label>
                    <input type="text" class="form-control datepicker" name="to_date" value="{{request('to_date')}}"
                           placeholder="يوم / شهر / سنة"/>
                </div>

                <div class="col-sm-3 adv-search">
                    <button type="submit" name="theaction" title="بحث" style="width:110px;margin-top:25px" value="search"
                    class="btn btn-primary">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    بحث
                    </button>
            </div>

            </div>

            <div class="row" style="margin-top:15px;">


                <div class="col-sm-6">
                    {{-- <button type="submit" target="_blank" name="theaction" title="طباعة" style="width:70px;" value="print"
                            class="btn btn-primary "/>
                    <i class="glyphicon glyphicon-print icon-white"></i>
                    </button> --}}


                </div>


            </div>
        </form>

    </div>

</div>

    @if($items)
    @if($items->count()>0)
<div class="table-responsive">

        <table class="table table-hover table-striped" style="width:170% !important;max-width:170% !important;white-space:normal;">
            <thead>
            <tr>
                <th style="word-break: normal;">الرقم المرجعي</th>
                <th style="max-width: 250px;word-break: normal;">الاسم رباعي</th>
                <th style="max-width: 100px;word-break: normal;">رقم الهوية</th>
                <th style="max-width: 150px;word-break: normal;">فئة مقدم الاقتراح /الشكوى</th>
                <th style="max-width: 100px;word-break: normal;">اسم المشروع</th>
                <th style="max-width: 100px;word-break: normal;">حالة المشروع</th>
                <th style="max-width: 100px;word-break: normal;">قناة الاستقبال</th>
                <th style="max-width: 100px;word-break: normal;">النوع</th>
                @if($type!=2 && $type!=3)<th style="max-width: 400px;word-break: normal;">فئة الاقتراح/الشكوى</th>@endif
                <th style="max-width: 100px;word-break: normal;">تاريخ تسجيل الاقتراح/الشكوى</th>
                <th style="max-width: 100px;word-break: normal;">حالة الرد</th>
                <th style="max-width: 100px;word-break: normal;">حالة تبليغ الرد</th>
                <th style="max-width: 100px;word-break: normal;">التغذية الراجعة</th>
                <th style="max-width: 110px;word-break: normal;text-align: center;"> معاينة </th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $a)
                @if(Auth::user()->account->projects->contains($a->project->id) && Auth::user()->account->circle->category->contains($a->category->id))
                    <tr class="tr-id-{{$a->id}}">
                        <td style="word-break: normal;">{{$a->id}}</td>
                        <td style="word-break: normal;">{{$a->citizen->first_name." ".$a->citizen->father_name." ".$a->citizen->grandfather_name." ".$a->citizen->last_name}}</td>
                        <td style="word-break: normal;">{{$a->citizen->id_number}}</td>
                        <td style="word-break: normal;;">{{$a->project->id == 1 ? 'غير مستفيد' : ' مستفيد' }}</td>
                        <td style="word-break: normal;">{{$a->project->name}}</td>
                        <td style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->project->end_date <= now() ?  'منتهي' : 'مستمر'}}</td>
                        <td style="word-break: normal;"> {{$a->sent_typee->name}}</td>
                        <td style="word-break: normal;">{{$a->form_type->name}}</td>
                        @if($type!=2 && $type!=3)
                            <td style="max-width: 400px;word-break: normal;"
                                style="padding-left: 0px;padding-right: 0px">

                                {{$a->category->name}}

                            </td>
                        @endif
                        <td style="word-break: normal;">{{$a->datee}}</td>

                        @if($a->form_status->id == 2)
                            <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">تم الرد </td>
                        @else
                            <td style="max-width: 100px;word-break: normal;">قيد الدراسة</td>
                        @endif

                        @if($a->form_status->id == 1)
                            <td style="max-width: 100px;word-break: normal;"> قيد التبليغ </td>
                        @elseif($a->form_status->id == 2)
                            <td style="max-width: 100px;word-break: normal;"> تم التبليغ </td>
                        @else
                            <td style="max-width: 100px;word-break: normal;"> لم يتم التبليغ </td>
                        @endif

                        @if($a->evaluate)
                            @if($a->evaluate == 1)
                                <td style="max-width: 100px;word-break: normal;"> راضي بشكل كبير </td>
                            @elseif($a->evaluate==2)
                                <td style="max-width: 100px;word-break: normal;"> راضي بشكل متوسط </td>
                            @elseif($a->evaluate == 3)
                                <td style="max-width: 100px;word-break: normal;"> راضي بشكل ضعيف </td>
                            @else
                                <td style="max-width: 100px;word-break: normal;"> غير راضي عن الرد </td>
                            @endif
                        @else
                            <td style="max-width: 100px;word-break: normal;">لا يوجد رد</td>
                        @endif

                        <td style="width: 110px;word-break: normal;text-align: center;">
                            <a
                                target="_blank" title="عرض" class="btn btn-xs btn-primary"
                                href="/citizen/form/show/{{$a->citizen->id_number}}/{{$a->id}}">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                            @if(
                            Auth::user()->account->circle->circle_categories->where('category_id',$a->category->id)->where('to_delete',1)->first()
                            &&
                            Auth::user()->account->account_projects->where('project_id',$a->project->id)->where('to_delete',1)->first()
                            )
                                @if ($a->status == "3" )
                                    <a class="btn btn-xs Confirm22 btn-danger" data-id="{{$a->id}}" title="يمكن حذفها لأنها مغلقة"><i class="fa fa-trash"></i></a>
                                @endif
                        </td>
                        @else
                            <td></td>
                        @endif

                    </tr>
                @endif
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
                <th style="word-break: normal;">الرقم المرجعي</th>
                <th style="max-width: 250px;word-break: normal;">الاسم رباعي</th>
                <th style="max-width: 100px;word-break: normal;">رقم الهوية</th>
                <th style="max-width: 150px;word-break: normal;">فئة مقدم الاقتراح /الشكوى</th>
                <th style="max-width: 100px;word-break: normal;">اسم المشروع</th>
                <th style="max-width: 100px;word-break: normal;">حالة المشروع</th>
                <th style="max-width: 100px;word-break: normal;">قناة الاستقبال</th>
                <th style="max-width: 100px;word-break: normal;">النوع</th>
                @if($type!=2 && $type!=3)<th style="max-width: 400px;word-break: normal;">فئة الاقتراح/الشكوى</th>@endif
                <th style="max-width: 100px;word-break: normal;">تاريخ تسجيل الاقتراح/الشكوى</th>
                <th style="max-width: 100px;word-break: normal;">حالة الرد</th>
                <th style="max-width: 100px;word-break: normal;">حالة تبليغ الرد</th>
                <th style="max-width: 100px;word-break: normal;">التغذية الراجعة</th>
                <th style="max-width: 110px;word-break: normal;text-align: center;"> معاينة </th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
</div>
    @endif
    <div class="form-group row">
        <div class="col-sm-2 col-md-offset-10">
            <a href="/account/citizen"  class="btn btn-success">رجوع للخلف</a>
        </div>
    </div>
@endsection

@section("js")

    <script>
        $('.adv-search').hide();
        $('.adv-search-btn').click(function(){
            $('.adv-search').slideToggle("fast");
        });
    </script>

@endsection

