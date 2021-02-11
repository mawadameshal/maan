







<meta http-equiv='Content-Type' charset=utf-8 content='text/html'>


<style type="text/css">
    *, body,table,th,tr,td,tbody {
        font-family: 'examplefont', sans-serif;
        text-align: right;

    }

    div{
        margin-top: 10px;
        margin-bottom: 20px;
    }
    .mo{
        background: #9cc2eb;
    }
    img{
        height: 150px;
        width: 250px;
        margin-right: 40%;
        margin-bottom: 20px;
    }
    h3{
        padding: 10px;
    }
</style>
<body>
<div class="container" style="max-width: 1400px;">

    <div>
        <img class="images" src="{{asset('public/uploads/w.PNG')}}">
    </div>

    <div class="mo" >
        <h3>أ) المعلومات الاساسية لمتقدم الاقتراح /الشكوي </h3>
    </div>
    <table  class="table">
        <thead >
        <tr>
            <th style="display: none;"  scope="col"></th>
            <th style="display: none;"  scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$item->id}}</td>
            <td class="mo">الرقم المرجعي  </td>
        </tr>
        <tr>
            <td>{{$item->citizen->first_name." ".$item->citizen->father_name." ".$item->citizen->grandfather_name." ".$item->citizen->last_name}}</td>
            <td class="mo">الاسم رباعي </td>
        </tr>
        <tr>
            <td>{{ $item->citizen->id_number }}</td>
            <td class="mo">رقم الهوية </td>
        </tr>
        <tr>
            <td>{{$item->citizen->governorate}} -- {{$item->citizen->city}} -- {{$item->citizen->street}} </td>
            <td class="mo">العنوان </td>
        </tr>
        <tr>
            <td>{{$item->citizen->mobile}}</td>
            <td class="mo">رقم الجوال </td>
        </tr>
        <tr>
            <td>{{$item->project->name}}</td>
            <td class="mo">فئة مقدم الاقتراح / الشكوي</td>
        </tr>
        <tr>
            <td>{{$item->project->project_status->name}}</td>
            <td class="mo">اسم المشروع الذي يتبعه مقدم الاقتراح / الشكوي </td>
        </tr>



        </tbody>
    </table>


    <div class="mo" >
        <h3>ب) تفاصيل الاقتراح / الشكوي </h3>
    </div>

    <table  class="table">
        <thead >
        <tr>
            <th style="display: none;"  scope="col"></th>
            <th style="display: none;"  scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$item->sent_typee->name}}</td>
            <td class="mo">طريقة الاستقبال </td>
        </tr>
        <tr>
            <td>@if($item->type=='1'){{$item->category->name}}@endif</td>
            <td class="mo">فئة الاقتراح / الشكوي</td>
        </tr>
        <tr>
{{--            <td>{{$item->datee}}</td>--}}
            <td>{{date('d-m-Y', strtotime( $item->created_at))}}</td>
            <td class="mo">تاريخ تقديم الاقتراح / الشكوي </td>
        </tr>
        <tr>
            <td>{{date('d-m-Y', strtotime( $item->created_at))}}</td>
            <td class="mo">تاريخ تسجيل الاقتراح / الشكوي علي النظام </td>
        </tr>

        </tbody>
    </table>


    <div class="mo" >
        <h3>ت) تفاصيل الردود والمتابعة </h3>
    </div>
@php

@endphp
    <table  class="table">
        <thead >
        <tr>
            <th style="display: none;"  scope="col"></th>
            <th style="display: none;"  scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @if(count($responses) > 0)
        <tr>
            <td>{{$item->response_type == 1 ? 'يحتاج الي اجراءات مطولة ' : 'لا يحتاج الي اجراءات مطولة'}}</td>
            <td>{{$item->required_respond}}</td>
            <td class="mo">طبيعة الاجراءات التي اتخدت للرد علي الاقتراح / الشكوي</td>
        </tr>
        @endif
        <tr>
            <td>{{$item->project->project_status->name}}</td>
            <td class="mo">حالة الرد </td>
        </tr>
        @if(count($responses) > 0)
        <tr>
            <td>{{$item->form_response()->first()->response}}</td>
            <td class="mo">تفاصيل الرد</td>
        </tr>
        <tr>
            <td>{{$item->form_response()->first()->datee}}</td>
            <td class="mo">تاريخ تسجيل الرد</td>
        </tr>
        @endif
        <tr>
            <td></td>
            <td class="mo">التغذية الراجعة</td>
        </tr>

        </tbody>
    </table>


    <div style="margin-top: 60px; margin-right: 20px;" >
        <p>ملاحظة في حال وجود اي استفسار او اعتراض من طرفك حول محتوي الاقتراح او الشكوي والرد عليه /ا يمكنك اعادة التواصل مع المركز علي الرقم 1900100101</p>
    </div>
</div>

</body>



