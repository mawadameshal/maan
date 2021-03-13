@extends("layouts._citizen_layout")

@section("title", "متابعة نموذج ")


@section("content")
<div class="row">
        <div class="col-sm-12">
            <h1 style="margin-top:120px;margin-bottom:20px;text-align: center;"> نتائج البحث<hr class="h1-hr"></h1>
        </div>
    </div>
    <div class="row">
       <div class="col-sm-12">
             <h4 class="text-center">يمكنك هنا مراجعة جميع النماذج التي قدماتها ومعاينتها</h4>
       </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
         @if($forms!=null)
            @if($forms->first())
                <h5 class="wow bounceIn"
                    style="text-align:center;font-size:18px;"><b>اسم المواطن</b>
                    {{$forms->first()->citizen->first_name}}
                    {{$forms->first()->citizen->father_name}}
                    {{$forms->first()->citizen->grandfather_name}}
                    {{$forms->first()->citizen->last_name}} </h5>
                <br><br><br><br>
            @endif
        @endif
    </div></div>
    @if($forms!=null)
        @if($forms->count()>0)
            <table style="margin-bottom:20px;" class="table table-bordered wow bounceIn">
                <thead>
                <tr style="background-color:#67647E">
                    <th style="text-align: center;color:white;">رقم الطلب</th>
                    <th style="text-align: center;color:white;">اسم المواطن</th>
                    <th style="text-align: center;color:white;">رقم الهوية</th>
                    <th style="text-align: center;color:white;">المشروع</th>
                    <th style="text-align: center;color:white;">فئة الطلب</th>
                    <th style="text-align: center;color:white;">تاريخ الارسال</th>
                    <th style="text-align: center;color:white;">موضوع الطلب</th>
                    <th style="text-align: center;color:white;">حالة الطلب</th>
                    <th style="text-align: center;color:white;">نوع الطلب</th>
                    <th style="text-align: center;color:white;">مشاهدة الرد</th>
                </tr>
                </thead>
                <tbody>

                @if($forms!=null)
                    @foreach ($forms as $form)


                        <tr style="background-color:white">
                            <td style="text-align: center;">{{$form->id}}</td>
                            <td style="text-align: center;">{{$form->citizen->first_name}} {{$form->citizen->last_name}}</td>
                            <td style="text-align: center;">{{$form->citizen->id_number}}</td>
                            <td style="text-align: center;"> @if($form->project)  {{$form->project->name }} @endif </td>
                            <td style="text-align: center;"> @if($form->category)  {{$form->category->name }} @endif </td>
                            <td style="text-align: center;">{{$form->datee}}</td>
                            <td style="text-align: center;">{{$form->title}}</td>
                            <td style="text-align: center;">{{$form->form_status->name}}
                            </td>
                            <td style="text-align: center;">{{$form->form_type->name}}</td>
                            <td style="text-align: center;">
                                @if(Auth::user())
                                <a target="_blank" title="عرض"
                                       class="btn btn-xs btn-primary"
                                       href="/citizen/form/show/{{$form->citizen->id_number}}/{{$form->id}}">
                                    عرض
                                </a>
                                @else
                                    <a target="_blank" title="عرض"
                                       class="btn btn-xs btn-primary"
                                       href="#">
                                        عرض
                                    </a>
                                @endif
                            </td>

                    @endforeach
                @endif

                </tbody>
            </table>
        @else
            <br><br>
            <div class="alert alert-danger">نأسف لا يوجد بيانات لعرضها</div>
        @endif
    @else
        <br><br>
        <div class="alert alert-danger">نأسف لا يوجد بيانات لعرضها</div>
    @endif
    <br><br><br><br>
    </div>
@endsection

