@extends("layouts._account_layout")

@section("title", "   الاقتراحات والشكاوى المقدمة ضمن مشروع   $item->name $item->code ")


@section("content")
 <div class="row">
    <div class="col-md-12">
        <h4>هذه الواجهة مخصصة للتحكم في إدارة الاقتراحات والشكاوى المسجلة في النظام ضمن هذا المشروع. </h4>
    </div>
 </div>
 <br><br>
 <form>
     <div class="form-group row">
         <div class="col-sm-4">
             <button type="button"  style="width:110px;"  class="btn btn-primary adv-search-btnn">
                 <span class="glyphicon glyphicon-search"></span>
                 بحث متقدم
             </button>
             <button type="submit" target="_blank" name="theaction" title ="تصدير إكسل" style="width:110px;" value="excel" class="btn btn-primary ">
                 <span class="glyphicon glyphicon-export"></span>
                 تصدير
             </button>
         </div>
     </div>
     <br>
    <div class="form-group row">
            <div class="col-sm-3 adv-searchh">
                <input type="text" class="form-control" name="id" value="{{old('id')}}" placeholder="الرقم المرجعي"/>
            </div>

            <div class="col-sm-3 adv-searchh">
                <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}" placeholder="اسم مقدم الاقتراح/ الشكوى"/>
            </div>

            <div class="col-sm-3 adv-searchh">
                <input type="text" class="form-control" name="id_number" value="{{old('id_number')}}" placeholder="رقم الهوية"/>
            </div>
            
            <div class="col-sm-3 adv-searchh">
                <select name="category_name" class="form-control">
                    <option value="" >فئة مقدم الاقتراح/الشكوى</option>
                    <option value="0" >مستفد</option>
                    <option value="1">غير مستفيد</option>
                </select>
            </div>

          
           <div class="col-sm-12 adv-searchh"><br></div>

           <div class="col-sm-3 adv-searchh">
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

      
    <div class="col-sm-3 adv-searchh">
        <select name="active" class="form-control">
            <option value="" > حالة المشروع</option>
            <option value="1" >مستمر</option>
            <option value="2">منتهي</option>
        </select>
    </div>
        

            <div class="col-sm-3 adv-searchh">
                <select name="sent_type" class="form-control">

                    <option value="">قناة الاستقبال</option>
                    @foreach($sent_typee as $sent_type)
                        <option {{request('sent_type')==$sent_type->id?"selected":""}} value="{{$sent_type->id}}">{{$sent_type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3 adv-searchh">
                <select name="type" class="form-control">
                    <option value="">التصنيف (اقتراح أو شكوى)</option>
                    @foreach($form_type as $ftype)
                        @if($ftype->id != 3)
                            <option {{request('type')==$ftype->id?"selected":""}} value="{{$ftype->id}}">{{$ftype->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            
           <div class="col-sm-12 adv-searchh"><br></div>

          

            <div class="col-sm-3 adv-searchh">
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

           
            <div class="col-sm-3 adv-searchh">
                <select name="status" class="form-control">
                    <option value="">حالة الرد</option>
                    @foreach($form_status as $fstatus)
                        @if($fstatus->id != 3 && $fstatus->id != 4)

                            {{$fstatus->name = 'لم يتم الرد'}}
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

            <div class="col-sm-3 adv-searchh">
                <select name="replay_status" class="form-control">
                    <option value="">حالة تبليغ الرد </option>
                    <option value="2" >تم التبليغ</option>
                    <option value="1">قيد التبليغ</option>
                    <option value="0">لم يتم التبليغ</option>

                </select>
            </div>
      
                 


            <div class="col-sm-3 adv-searchh">
                <select name="evaluate" class="form-control">
                    <option value="">التغذية الراجعة</option>
                    <option value="0" >غير راضي عن الرد</option>
                    <option value="1">راضي بشكل ضعيف</option>
                    <option value="2">راضي بشكل متوسط </option>
                    <option value="3">راضي بشكل كبير</option>

                </select>
            </div>

        <div class="col-sm-12 adv-searchh"><br></div>

            <div class="col-sm-3 adv-searchh">
                <label for="from_date">تاريخ تسجيل محدد</label>
                <input type="text" class="form-control datepicker" name="datee"  value="{{request('datee')}}"
                       placeholder="يوم / شهر / سنة"/>
            </div>
            <div class="col-sm-3 adv-searchh">
                <label for="from_date">من تاريخ تسجيل </label>
                <input type="text" class="form-control datepicker" name="from_date" value="{{request('from_date')}}"
                       placeholder="يوم / شهر / سنة"/>
            </div>
            <div class="col-sm-3 adv-searchh">
                <label for="to_date">إلى تاريخ تسجيل</label>
                <input type="text" class="form-control datepicker" name="to_date" value="{{request('to_date')}}"
                       placeholder="يوم / شهر / سنة"/>
            </div>
            <div class="col-sm-3 adv-searchh">
                <button type="submit" name="theaction" title="بحث" style="width:70px;margin-top:25px" value="search"
                        class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    بحث
                </button>
            </div>
            <div class="col-sm-12 adv-searchh"><br></div>

    </div>
 </form>
<br>
<div class="mt-3"></div>
@if($items)
    @if($items->count()>0)
        <div class="table-responsive">
            <table class="table table-hover table-striped" style="width:170% !important;max-width:170% !important;white-space:normal;">
                <thead>
                <tr>
                    <th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">الرقم المرجعي</th>
                    <th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">الاسم رباعي</th>
                    <th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رقم الهوية</th>
                    <th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">فئة مقدم الاقتراح/الشكوى</th>
                    <th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">قناة الاستقبال</th>
                    <th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">النوع</th>
                    @if($type!=2 && $type!=3)<th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">فئة الاقتراح/الشكوى</th>@endif
                    <th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">تاريخ تسجيل الاقتراح/الشكوى</th>
                    <th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">حالة الرد</th>
                    <th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">حالة تبليغ الرد</th>
                    <th style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">التغذية الراجعة</th>
                    <th style="white-space:normal;">معاينة</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($items as $a)
                            <tr>
                                <td style="word-break: normal;">{{$a->id}}</td>
                                <td style="max-width: 250px;word-break: normal;">{{$a->citizen->first_name." ".$a->citizen->father_name." ".$a->citizen->grandfather_name." ".$a->citizen->last_name}}</td>
                                <td style="max-width: 100px;word-break: normal;">{{$a->citizen->id_number}}</td>
                                <td style="max-width: 150px;word-break: normal;;">{{$a->project->id == 1 ? 'غير مستفيد' : ' مستفيد' }}</td>
                                <td style="max-width: 100px;word-break: normal;"> {{$a->sent_typee->name}}</td>
                                <td style="max-width: 100px;word-break: normal;">{{$a->form_type->name}}</td>
                                @if($type!=2 && $type!=3)
                                    <td style="max-width: 400px;word-break: normal;"
                                        style="padding-left: 0px;padding-right: 0px">

                                        {{$a->category->name}}

                                    </td>
                                @endif
                                {{-- <td style="max-width: 100px;word-break: normal;">{{$a->title}}</td> --}}
                                <td style="max-width: 100px;word-break: normal;">{{$a->datee}}</td>

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
                               <td><a target="_blank" title="عرض" class="btn btn-xs btn-primary" href="/citizen/form/show/{{$a->citizen->id_number}}/{{$a->id}}"><i class="glyphicon glyphicon-eye-open"></i></a></td>
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

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">الرقم المرجعي</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">الاسم رباعي</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رقم الهوية</th>
                <th style="max-width: 100px;overflow: hidden;">فئة مقدم الاقتراح / الشكوى</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">قناة الاستقبال</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">النوع</th>
                <th style="max-width: 70px;overflow: hidden;">فئة الاقتراح/ الشكوى</th>
                <th style="max-width: 105px;overflow: hidden;">تاريخ تسجيل الاقتراح/الشكوى</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">حالة الرد</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">حالة تبليغ الرد</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">التغذية الراجعة</th>
                <th style="white-space:normal;">معاينة</th>
            </tr>
            </thead>
        </table>
    </div>
@endif

 <br>
 <br>
    <div class="form-group row">
        <div class="col-sm-2 col-md-offset-10">
            <a href="/account/project"  class="btn btn-success">إلغاء الأمر</a>
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
