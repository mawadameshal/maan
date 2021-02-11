@extends("layouts._account_layout")
@section("title", "تقارير الاقتراحات والشكاوى الخاصة بمشاريع المركز")
@section('css')
    <style>


        #chartdiv {
            width: 100%;
            height: 500px;
        }

        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: right;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active, .accordion:hover {
            background-color: #ccc;
        }

        .accordion:after {
            content: '\002B';
            color: #777;
            font-weight: bold;
            float: left;
            margin-left: 5px;
        }

        .active:after {
            content: "\2212";
        }

        .panel {
            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }

        @media print {
            .accordion .collapsed {
                height: auto;
            }
        }

    </style>
@endsection
@section('content')
    <?php $colors = ["#3366cc","#dc3912","#ff9900","#109618","#990099","#0099c6","#dd4477","#66aa00","#b82e2e","#316395","#3366cc","#994499","#22aa99","#aaaa11","#6633cc","#e67300","#8b0707","#651067","#329262","#5574a6","#3b3eac","#b77322","#16d620","#b91383","#f4359e","#9c5935","#a9c413","#2a778d","#668d1c","#bea413","#0c5922","#743411"]; ?>

    <div class="row">
        <div class="col-md-10">
            <h4>
                عزيزي موظف المركز من خلال هذه الواجهة يمكنك استدعاء أي نوع من أنواع التقارير حول الاقتراحات والشكاوى
                المقدمة للمركز.
            </h4>
        </div>
    </div>
    <br>

    <form>
        <fieldset>
            <legend style="border: none;">خيارات استدعاء محتويات/ بيانات التقرير:
                <button  class="btn btn-primary adv-search-btnn" type="button" style="width:60px;margin-right:35px">  <span class="glyphicon glyphicon-plus-sign" ></span></button>
            </legend>
            <div id="report_critiria">
                <div class="form-group row">
                    <div class="col-sm-3 adv-search">
                        <select name="project_id" class="form-control">
                            <option value="" selected>اسم المشروع</option>
                            <option value="-1" @if(request('project_id')==='-1')selected
                                @endif>جميع المشاريع
                            </option>
                            @foreach($allprojects as $project)
                                <option
                                    @if(request('project_id')===''.$project->id)selected
                                    @endif
                                    value="{{$project->id}}">{{$project->code." ".$project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select name="active" class="form-control">
                            <option value=""> حالة المشروع</option>
                            @foreach($project_status as $pstatus)
                                <option
                                    {{request('active')==$pstatus->id?"selected":""}} value="{{$pstatus->id}}">{{$pstatus->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select class="form-control" name="governorate">
                            <option value=""> المحافظات</option>
                            <option value="الشمال" {{old('governorate')=='الشمال'?"selected":""}}>الشمال</option>
                            <option value="غزة" {{old('governorate')=='غزة'?"selected":""}}>غزة</option>
                            <option value="الوسطى" {{old('governorate')=='الوسطى'?"selected":""}}>الوسطى</option>
                            <option value="خانيونس" {{old('governorate')=='خانيونس'?"selected":""}}>خانيونس</option>
                            <option value="رفح" {{old('governorate')=='رفح'?"selected":""}}>رفح</option>
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select class="form-control" name="circles">
                            <option value="">المستوى الإداري</option>
                            <option value="-1" @if(request('circles')==='-1')selected
                                @endif>جميع المستويات الإدارية
                            </option>
                            @foreach($circles as $circle)
                                <option value="{{$circle->id}}"
                                        @if(request('circles')== $circle->id)selected @endif>{{$circle->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3 adv-search">
                        <select name="category_name" class="form-control">
                            <option value="">فئة مقدم الاقتراح/الشكوى</option>
                            <option value="0">مستفيد</option>
                            <option value="1">غير مستفيد</option>
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select name="sent_type" class="form-control">

                            <option value="">قنوات الاستقبال</option>
                            @foreach($sent_typeexx as $sent_type)
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
                    <div class="col-sm-3 adv-search">
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
                </div>
                <div class="form-group row">
                    <div class="col-sm-3 adv-search">
                        <select name="status" class="form-control">
                            <option value="">حالة الرد</option>
                            @foreach($form_status as $fstatus)
                                @if($fstatus->id != 3 && $fstatus->id != 4)

                                    {{$fstatus->name = 'قيد الدراسة'}}
                                    <option {{request('status')==$fstatus->id?"selected":""}} value="{{$fstatus->id}}">
                                        @if($fstatus->id == 1)
                                            قيد الدراسة
                                        @else
                                            تم الرد
                                        @endif

                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select name="evaluate" class="form-control">
                            <option value="">التغذية الراجعة</option>
                            <option value="0">غير راضي عن الرد</option>
                            <option value="1">راضي بشكل ضعيف</option>
                            <option value="2">راضي بشكل متوسط</option>
                            <option value="3">راضي بشكل كبير</option>

                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <input type="text" class="form-control datepicker" name="from_date" value="{{request('from_date')}}"
                               placeholder="من تاريخ تسجيل"/>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <input type="text" class="form-control datepicker" name="to_date" value="{{request('to_date')}}"
                               placeholder="إلى تاريخ تسجيل"/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 col-sm-offset-10 adv-search">
                        <button type="submit" name="theaction" title="بحث" style="width:110px;margin-right:35px"
                                value="search"
                                class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            بحث
                        </button>
                    </div>
                </div>
                <hr>
            </div>
        </fieldset>

    </form>
    <br>


    <div class="mt-3"></div>
    @if($determine == "specific_project")
        <div id="specific_project">
            <button class="accordion">
                أولاً: معلومات المشروع الأساسية
            </button>
            <div class="panel">
                @if($items)
                    @if(!empty($items))
                        <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                            <tr>
                                <td style="text-align: right">
                                    رمز المشروع
                                </td>
                                <td>
                                    {{$items['code']}}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right">
                                    اسم المشروع باللغة العربية
                                </td>
                                <td>
                                    {{$items['name']}}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right">عدد المستفيدين من المشروع</td>
                                <td> ({{$items['count_forms']}}) مستفيد</td>
                            </tr>
                            <tr>
                                <td style="text-align: right">تاريخ بداية المشروع</td>
                                <td>{{$items['start_date']}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right">تاريخ نهاية المشروع</td>
                                <td>{{$items['end_date']}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right">حالة المشروع</td>
                                <td>{{$items['names']}}</td>
                            </tr>
                        </table>
                    @endif
                @endif
            </div>


            <button class="accordion">
                ثانياً: معلومات الاقتراحات والشكاوى
            </button>
            <div class="panel">
                <br>
                <ol>
                    <li>
                        <h4>قنوات استقبال الاقتراحات والشكاوى</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>الجدول أدناه يوضح قنوات استقبال الاقتراحات والشكاوى المسجلة على النظام:</h5>
                                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                    <thead>
                                    <tr>
                                        <td style="text-align: right">#</td>
                                        <td style="text-align: right">قنوات استقبال الاقتراحات والشكاوى</td>
                                        <td style="text-align: right">العدد</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($sent_typee)
                                        @foreach($sent_typee as $key=>$sent_type)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$sent_type->name}}</td>
                                                <td>{{$sent_type->count_sent_types}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <br><br>
                                <div id="barchart_values"></div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <hr>
                        <h4>فئات الاقتراحات والشكاوى</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>الجدول أدناه يوضح فئات الاقتراحات والشكاوى المسجة على النظام في إحدى/ جميع مشاريع المركز:</h5>
                                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                    <thead>
                                    <tr>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">#</td>
                                        <td style="max-width: 150px;word-break: normal;">فئات الاقتراحات والشكاوى</td>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">النوع</td>
                                        <td style="max-width: 150px;word-break: normal;">الجهات المختصة بمعالجة الاقتراحات والشكاوى</td>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">العدد</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($categories_project)
                                        @foreach($categories_project as $key=>$category)
                                            <tr>
                                                <td  style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">{{$key+1}}</td>
                                                <td  style="max-width: 150px;word-break: normal;">{{$category->name}}</td>
                                                <td  style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">@if($category->is_complaint == 0){{'اقتراح'}}@else{{'شكوى'}}@endif</td>
                                                <td  style="max-width: 150px;word-break: normal;">{{$category->circle}}</td>
                                                <td  style="text-align: center;text-overflow: ellipsis;white-space: nowrap;">{{$category->count_categories}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4">إجمالي العدد</td>
                                        <?php $totalcategories = 0;
                                        if($categories_project){
                                            foreach($categories_project as $category_project){

                                                $totalcategories = $totalcategories +   $category_project->count_categories;

                                            }}?>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">{{$totalcategories}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <br><br>
                                <div id="barchart_values1"></div>
                            </div>
                        </div>

                    </li>
                    <li>
                        <hr>
                        <h4>الردود والمتابعات على الاقتراحات والشكاوى</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>الجدول أدناه يوضح الردود والمتابعات المسجة على النظام في إحدى/ جميع مشاريع المركز:</h5>
                                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                    <thead>
                                    <tr>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">#</td>
                                        <td style="max-width: 150px;word-break: normal;">الاقتراحات والشكاوى</td>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">العدد</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>الاقتراحات والشكاوى المسجلة على النظام</td>
                                        <td>@if($AllComplaintSuggestions){{$AllComplaintSuggestions['count_allforms']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>الاقتراحات والشكاوى التي تم الرد عليها من قبل الجهات المختصة</td>
                                        <td>@if ($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] == 2){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>الاقتراحات والشكاوى التي قيد الدراسة حالياً من قبل الجهات المختصة</td>
                                        <td>@if ($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] == 1){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>

                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>الاقتراحات والشكاوى المحذوفة من النظام</td>
                                        <td>@if ($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] == 3){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <br><br>
                                <div id="barchart_values2"></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <hr>
                        <h4>التغذية الراجعة</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>الجدول أدناه يوضح حالة تبليغ الرد للاقتراحات والشكاوى المسجة على النظام في إحدى/ جميع مشاريع المركز:</h5>
                                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                    <thead>
                                    <tr>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">#</td>
                                        <td style="max-width: 150px;word-break: normal;">حالة تبليغ الرد لمقدمي الاقتراحات والشكاوى</td>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">العدد</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>حالات تم تبليغ الرد لمقدميها</td>
                                        <td>@if ($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] == 2){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>حالات قيد تبليغ الرد لمقدميها</td>
                                        <td>@if ($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] == 1){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>حالات لم يتم تبليغ الرد لمقدميها</td>
                                        <td>@if ($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] != 1 && $ComplaintSuggestions[0]['form_status'] != 2){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br>
                                <h5>الجدول أدناه يوضح التغذية الراجعة للاقتراحات والشكاوى المسجة على النظام في إحدى/ جميع مشاريع المركز:</h5>
                                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                    <thead>
                                    <tr>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">#</td>
                                        <td style="max-width: 150px;word-break: normal;">التغذية الراجعة للحالات التي تم تبليغها الرد</td>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">العدد</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>راضي بشكل كبير عن الرد</td>
                                        <td>@if ($responces != "" && count($responces)>0 && $responces[0]['evaluate'] == 1){{$responces[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>راضي بشكل متوسط عن الرد</td>
                                        <td>@if ($responces != "" && count($responces)>0 &&  $responces[0]['evaluate'] == 2){{$responces[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>راضي بشكل ضعيف عن الرد</td>
                                        <td>@if ($responces != "" && count($responces)>0&& $responces[0]['evaluate'] == 3){{$responces[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>

                                    <tr>
                                        <td>4</td>
                                        <td>غير راضي عن الرد</td>
                                        <td>@if ($responces != "" && count($responces)>0 && $responces[0]['evaluate'] != NULL && $responces[0]['evaluate'] != 1 && $responces[0]['evaluate'] != 2 && $responces[0]['evaluate'] != 3){{$responces[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>لم يتم الرد</td>
                                        <td>@if ($responces != "" && count($responces)>0 && $responces[0]['evaluate'] == NULL){{$responces[0]['count_forms']}}@else{{"0"}}@endif</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <br><br>
                                <div id="barchart_values3"></div>
                            </div>
                        </div>
                    </li>
                </ol>

            </div>

            <button class="accordion">
                ثالثاً: معلومات الموظفين ذوي العلاقة بنظام الاقتراحات والشكاوى في المشروع:
            </button>
            <div class="panel">

                @if($staff)
                    @if(!empty($staff))
                        <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                            <tr>
                                <td style="text-align: right">
                                    عدد الموظفين:
                                </td>
                                <td>
                                    {{count($staff)}} موظف
                                </td>
                            </tr>
                        </table>

                        <br>
                        <br>
                        <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                            <thead>
                            <th>المستوى الإداري</th>
                            <th>الطاقم الميداني</th>
                            <th>منسق المشروع</th>
                            <th>ممثل المتابعة والتقييم</th>
                            <th>مدير البرنامج</th>
                            <th>مدير البرامج</th>
                            </thead>
                            <tbody>
                            @foreach($staff as $s)
                                <tr>
                                    <td style="text-align: center;">{{$s->full_name}}</td>

                                    @if($s->circle->id == 7 )
                                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok"></span></td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if($s->circle->id == 5 )
                                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok"></span></td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if($s->circle->id == 4 )
                                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok"></span></td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if($s->circle->id == 3 )
                                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok"></span></td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if($s->circle->id == 2 )
                                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok"></span></td>
                                    @else
                                        <td></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                @endif

            </div>
        </div>

    @elseif($determine == "all_projects")
        <div id="all_projects">
            <button class="accordion">
                أولاً: معلومات المشاريع الأساسية
            </button>
            <div class="panel">
                @if($items)
                    @if(!empty($items))
                        <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                            <tr>
                                <td style="text-align: right">
                                    عدد مشاريع المركز
                                </td>
                                <td>
                                    {{$items['number_of_project']}}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right">عدد المستفيدين من المشاريع</td>
                                <td> ({{$items['number_of_cizitain']}}) مستفيد</td>
                            </tr>
                            <tr>
                                <td style="text-align: right">حالة المشاريع</td>
                                <td>{{$total_status}}</td>
                            </tr>
                        </table>
                    @endif
                @endif
            </div>


            <button class="accordion">
                ثانياً: معلومات الاقتراحات والشكاوى
            </button>
            <div class="panel">
                <br>
                <ol>
                    <li>
                        <h4>قنوات استقبال الاقتراحات والشكاوى</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>الجدول أدناه يوضح قنوات استقبال الاقتراحات والشكاوى المسجلة على النظام:</h5>
                                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                    <thead>
                                    <tr>
                                        <td style="text-align: right">#</td>
                                        <td style="text-align: right">قنوات استقبال الاقتراحات والشكاوى</td>
                                        <td style="text-align: right">العدد</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($sent_typee)
                                        @foreach($sent_typee as $key=>$sent_type)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$sent_type->name}}</td>
                                                <td>{{$sent_type->count_sent_types}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <br><br>
                                <div id="barchart_values4"></div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <hr>
                        <h4>فئات الاقتراحات والشكاوى</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>الجدول أدناه يوضح فئات الاقتراحات والشكاوى المسجة على النظام في إحدى/ جميع مشاريع المركز:</h5>
                                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                    <thead>
                                    <tr>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">#</td>
                                        <td style="max-width: 150px;word-break: normal;">فئات الاقتراحات والشكاوى</td>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">النوع</td>
                                        <td style="max-width: 150px;word-break: normal;">الجهات المختصة بمعالجة الاقتراحات والشكاوى</td>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">العدد</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($categories_project)
                                        @foreach($categories_project as $key=>$category)
                                            <tr>
                                                <td  style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">{{$key+1}}</td>
                                                <td  style="max-width: 150px;word-break: normal;">{{$category->name}}</td>
                                                <td  style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">@if($category->is_complaint == 0){{'اقتراح'}}@else{{'شكوى'}}@endif</td>
                                                <td  style="max-width: 150px;word-break: normal;">{{$category->circle}}</td>
                                                <td  style="text-align: center;text-overflow: ellipsis;white-space: nowrap;">{{$category->count_categories}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4">إجمالي العدد</td>
                                        <?php $totalcategories = 0;
                                        if($categories_project){
                                            foreach($categories_project as $category_project){

                                                $totalcategories = $totalcategories +   $category_project->count_categories;

                                            }}?>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">{{$totalcategories}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <br><br>
                                <div id="barchart_values5"></div>
                            </div>
                        </div>

                    </li>
                    <li>
                        <hr>
                        <h4>الردود والمتابعات على الاقتراحات والشكاوى</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>الجدول أدناه يوضح الردود والمتابعات المسجة على النظام في إحدى/ جميع مشاريع المركز:</h5>
                                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                    <thead>
                                    <tr>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">#</td>
                                        <td style="max-width: 150px;word-break: normal;">الاقتراحات والشكاوى</td>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">العدد</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>الاقتراحات والشكاوى المسجلة على النظام</td>
                                        <td>@if($AllComplaintSuggestions){{$AllComplaintSuggestions['count_allforms']}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>الاقتراحات والشكاوى التي تم الرد عليها من قبل الجهات المختصة</td>
                                        <td>@if ($ComplaintSuggestions && $ComplaintSuggestions[0]['form_status'] == 2){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>الاقتراحات والشكاوى التي قيد الدراسة حالياً من قبل الجهات المختصة</td>
                                        <td>@if ($ComplaintSuggestions && $ComplaintSuggestions[0]['form_status'] == 1){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>

                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>الاقتراحات والشكاوى المحذوفة من النظام</td>
                                        <td>@if ($ComplaintSuggestions && $ComplaintSuggestions[0]['form_status'] == 3){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <br><br>
                                <div id="barchart_values6"></div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <hr>
                        <h4>التغذية الراجعة</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>الجدول أدناه يوضح حالة تبليغ الرد للاقتراحات والشكاوى المسجة على النظام في إحدى/ جميع مشاريع المركز:</h5>
                                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                    <thead>
                                    <tr>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">#</td>
                                        <td style="max-width: 150px;word-break: normal;">حالة تبليغ الرد لمقدمي الاقتراحات والشكاوى</td>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">العدد</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>حالات تم تبليغ الرد لمقدميها</td>
                                        <td>@if ($ComplaintSuggestions && $ComplaintSuggestions[0]['form_status'] == 2){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>حالات قيد تبليغ الرد لمقدميها</td>
                                        <td>@if ($ComplaintSuggestions && $ComplaintSuggestions[0]['form_status'] == 1){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>حالات لم يتم تبليغ الرد لمقدميها</td>
                                        <td>@if ($ComplaintSuggestions && $ComplaintSuggestions[0]['form_status'] != 1 && $ComplaintSuggestions[0]['form_status'] != 2){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br>
                                <h5>الجدول أدناه يوضح التغذية الراجعة للاقتراحات والشكاوى المسجة على النظام في إحدى/ جميع مشاريع المركز:</h5>
                                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                    <thead>
                                    <tr>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">#</td>
                                        <td style="max-width: 150px;word-break: normal;">التغذية الراجعة للحالات التي تم تبليغها الرد</td>
                                        <td style="text-align: right;text-overflow: ellipsis;white-space: nowrap;">العدد</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>راضي بشكل كبير عن الرد</td>
                                        <td>@if ($responces && $responces[0]['evaluate'] == 1){{$responces[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>راضي بشكل متوسط عن الرد</td>
                                        <td>@if ($responces &&  $responces[0]['evaluate'] == 2){{$responces[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>راضي بشكل ضعيف عن الرد</td>
                                        <td>@if ($responces && $responces[0]['evaluate'] == 3){{$responces[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>

                                    <tr>
                                        <td>4</td>
                                        <td>غير راضي عن الرد</td>
                                        <td>@if ($responces && $responces[0]['evaluate'] != NULL && $responces[0]['evaluate'] != 1 && $responces[0]['evaluate'] != 2 && $responces[0]['evaluate'] != 3){{$responces[0]['count_forms']}}@else{{"0"}}@endif</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>لم يتم الرد</td>
                                        <td>@if ($responces && $responces[0]['evaluate'] == NULL){{$responces[0]['count_forms']}}@else{{"0"}}@endif</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <br><br>
                                <div id="barchart_values7"></div>
                            </div>
                        </div>
                    </li>
                </ol>

            </div>

            <button class="accordion">
                ثالثاً: معلومات الموظفين ذوي العلاقة بنظام الاقتراحات والشكاوى في المشروع:
            </button>
            <div class="panel">
                @if($staff)
                    @if(!empty($staff))
                        <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                            <tr>
                                <td style="text-align: right">
                                    عدد الموظفين:
                                </td>
                                <td>
                                    {{count($staff)}} موظف
                                </td>
                            </tr>
                        </table>

                        <br>
                        <br>
                        <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                            <thead>
                            <th>اسم المشروع</th>
                            <th>المستوى الإداري</th>
                            <th>الطاقم الميداني</th>
                            <th>منسق المشروع</th>
                            <th>ممثل المتابعة والتقييم</th>
                            <th>مدير البرنامج</th>
                            <th>مدير البرامج</th>
                            </thead>
                            <tbody>
                            @foreach($staff as $s)
                                <tr>
                                    <td style="text-align: center;">{{$s->name}}</td>
                                    <td style="text-align: center;">{{$s->full_name}}</td>
                                    @if($s->rate == 7 )
                                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok"></span></td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if($s->rate == 5 )
                                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok"></span></td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if($s->rate == 4 )
                                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok"></span></td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if($s->rate == 3 )
                                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok"></span></td>
                                    @else
                                        <td></td>
                                    @endif

                                    @if($s->rate == 2 )
                                        <td style="text-align: center;"><span class="glyphicon glyphicon-ok"></span></td>
                                    @else
                                        <td></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                @endif
            </div>
        </div>

    @endif

    <button style="float: left;margin-top: 30px;" onclick="@if($determine == "specific_project")printDiv('specific_project')@elseif($determine == "all_projects")printDiv('all_projects')@endif"><span class="glyphicon glyphicon-print"></span> طباعة</button>



@endsection
@section('js')

    <script>
        function printDiv(divName){
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].classList.toggle("active");
                var panel = acc[i].nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            }

            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>

    <script>
        $('#report_critiria').hide();
        $('.adv-search-btnn').click(function () {
            $('#report_critiria').slideToggle()
        });

    </script>

    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Element', 'Density', { role: 'style' }],
                <?php
                if($determine == "specific_project"){
                    if($sent_typee){
                        foreach($sent_typee as $key=>$sent_type){
                            echo "['".$sent_type->name."',".$sent_type->count_sent_types.",'".$colors[$key]."'],";
                        }
                    }
                }

                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title:"شكل رقم (1): قنوات استقبال الاقتراحات والشكاوى",
                width: 450,
                // height: 400,
                bar: {groupWidth: "25%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
            chart.draw(view, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Element', 'Density', { role: 'style' }],
                <?php
                if($determine == "specific_project"){
                    if (!empty($categories_project)){
                        foreach($categories_project as $key=>$category_project){
                            echo "['".$category_project->name."',".$category_project->count_categories.",'".$colors[$key]."'],";
                        }
                    }
                }

                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title:"شكل رقم (2): فئات الاقتراحات والشكاوى",
                width: 450,
                bar: {groupWidth: "25%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.BarChart(document.getElementById("barchart_values1"));
            chart.draw(view, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Element', 'Density', { role: 'style' }],
                    <?php
                    if($determine == "specific_project"){?>

                    ['الاقتراحات والشكاوى المسجلة على النظام',<?php if($AllComplaintSuggestions != ""){ echo $AllComplaintSuggestions['count_allforms'];} ?>,<?php echo "'$colors[0]'"; ?> ],
                    ['الاقتراحات والشكاوى التي تم الرد عليها من قبل الجهات المختصة',<?php if($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] == 2){ echo $ComplaintSuggestions[0]['count_forms'];}else{ echo "0";} ?>,<?php echo "'$colors[1]'"; ?>],
                    ['الاقتراحات والشكاوى التي قيد الدراسة حالياً من قبل الجهات المختصة',<?php if($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] == 1){ echo $ComplaintSuggestions[0]['count_forms'];}else{ echo "0";} ?>,<?php echo "'$colors[2]'"; ?>],
                    ['الاقتراحات والشكاوى المحذوفة من النظام',<?php if($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] == 3){ echo $ComplaintSuggestions[0]['count_forms'];}else{echo "0";}?>,<?php echo "'$colors[3]'"; ?>]

            <?php }

                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title:"شكل رقم (3): الردود والمتابعة على الاقتراحات والشكاوى",
                width: 450,
                bar: {groupWidth: "25%"},
                // legend: { position: 'bottom', maxLines: 3 },
                legend: { position: "none" },
            };
            var chart = new google.visualization.BarChart(document.getElementById("barchart_values2"));
            chart.draw(view, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Element', 'Density', { role: 'style' }],
                    <?php
                    if($determine == "specific_project"){?>
                    ['حالات تم تبليغ الرد لمقدميها',<?php if($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] == 2){ echo $ComplaintSuggestions[0]['count_forms'];}else{ echo "0";} ?>,<?php echo "'$colors[1]'"; ?>],
                    ['حالات قيد تبليغ الرد لمقدميها',<?php if($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] == 1){ echo $ComplaintSuggestions[0]['count_forms'];}else{ echo "0";} ?>,<?php echo "'$colors[2]'"; ?>],
                    ['حالات لم يتم تبليغ الرد لمقدميها',<?php if($ComplaintSuggestions != "" && count($ComplaintSuggestions)>0 && $ComplaintSuggestions[0]['form_status'] != 1 && $ComplaintSuggestions[0]['form_status'] !=2){ echo $ComplaintSuggestions[0]['count_forms'];}else{echo "0";}?>,<?php echo "'$colors[3]'"; ?>]

            <?php }

                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title:"شكل رقم (4): التغذية الراجعة",
                width: 450,
                bar: {groupWidth: "25%"},
                // legend: { position: 'bottom', maxLines: 3 },
                legend: { position: "none" },
            };
            var chart = new google.visualization.BarChart(document.getElementById("barchart_values3"));
            chart.draw(view, options);
        }
    </script>


    {{--    All Project--}}
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Element', 'Density', { role: 'style' }],
                <?php
                if($determine == "all_projects"){
                    if($sent_typee){
                        foreach($sent_typee as $key=>$sent_type){
                            echo "['".$sent_type->name."',".$sent_type->count_sent_types.",'".$colors[$key]."'],";
                        }
                    }
                }

                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title:"شكل رقم (1): قنوات استقبال الاقتراحات والشكاوى",
                width: 450,
                // height: 400,
                bar: {groupWidth: "25%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.BarChart(document.getElementById("barchart_values4"));
            chart.draw(view, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Element', 'Density', { role: 'style' }],
                <?php

                if($determine == "all_projects"){
                    if (!empty($categories_project)){
                        foreach($categories_project as $key=>$category_project){
                            echo "['".$category_project->name."',".$category_project->count_categories.",'".$colors[$key]."'],";
                        }
                    }
                }

                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title:"شكل رقم (2): فئات الاقتراحات والشكاوى",
                width: 450,
                bar: {groupWidth: "25%"},
                legend: { position: "none" },
            };
            var chart = new google.visualization.BarChart(document.getElementById("barchart_values5"));
            chart.draw(view, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Element', 'Density', { role: 'style' }],
                    <?php

                    if($determine == "all_projects"){?>
                ['الاقتراحات والشكاوى المسجلة على النظام',<?php echo $AllComplaintSuggestions['count_allforms']; ?>,<?php echo "'$colors[0]'"; ?> ],
                ['الاقتراحات والشكاوى التي تم الرد عليها من قبل الجهات المختصة',@if ($ComplaintSuggestions[0]['form_status'] == 2){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif,<?php echo "'$colors[1]'"; ?>],
                ['الاقتراحات والشكاوى التي قيد الدراسة حالياً من قبل الجهات المختصة',@if ($ComplaintSuggestions[0]['form_status'] == 1){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif,<?php echo "'$colors[2]'"; ?>],
                ['الاقتراحات والشكاوى المحذوفة من النظام',@if ($ComplaintSuggestions[0]['form_status'] == 3){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif,<?php echo "'$colors[3]'"; ?>]

                <?php }

                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title:"شكل رقم (3): الردود والمتابعة على الاقتراحات والشكاوى",
                width: 450,
                bar: {groupWidth: "25%"},
                // legend: { position: 'bottom', maxLines: 3 },
                legend: { position: "none" },
            };
            var chart = new google.visualization.BarChart(document.getElementById("barchart_values6"));
            chart.draw(view, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Element', 'Density', { role: 'style' }],
                    <?php

                    if($determine == "all_projects"){?>
                ['حالات تم تبليغ الرد لمقدميها',@if ($ComplaintSuggestions[0]['form_status'] == 2){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif,<?php echo "'$colors[1]'"; ?>],
                ['حالات قيد تبليغ الرد لمقدميها',@if ($ComplaintSuggestions[0]['form_status'] == 1){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif,<?php echo "'$colors[2]'"; ?>],
                ['حالات لم يتم تبليغ الرد لمقدميها',@if ($ComplaintSuggestions[0]['form_status'] != 1 && $ComplaintSuggestions[0]['form_status'] !=2){{$ComplaintSuggestions[0]['count_forms']}}@else{{"0"}}@endif,<?php echo "'$colors[3]'"; ?>]

                <?php }

                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation" },
                2]);

            var options = {
                title:"شكل رقم (4): التغذية الراجعة",
                width: 450,
                bar: {groupWidth: "25%"},
                // legend: { position: 'bottom', maxLines: 3 },
                legend: { position: "none" },
            };
            var chart = new google.visualization.BarChart(document.getElementById("barchart_values7"));
            chart.draw(view, options);
        }
    </script>
@endsection
