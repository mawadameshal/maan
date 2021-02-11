<meta http-equiv='Content-Type' charset=utf-8 content='text/html'>
<style type="text/css">
    *, body, table, th, tr, td, tbody {
        font-family: 'examplefont', sans-serif;
        text-align: right;

    }

    td {
        padding: 7px
    }
</style>
<body>
<!--<h4>مركز العمل التنموي معاً</h4>
<p><span>{{date('Y-m-d')}}</span> <span>maq@hotmail.com</span> <span>+972 599 636 064</span></p>
<hr>-->
<br><br><br><br><br><br>
<hr>
<table border="1" style="text-align:right;width: 100%;margin: 45px">
    
    <tbody>
    <tr>
        <td style="font-weight: bold">طريقة الإستقبال</td>
        <td style="font-weight: bold">نوع الطلب</td>
        <td style="font-weight: bold">حالة الطلب</td>
        <td style="font-weight: bold">تاريخ الإرسال</td>
        <td style="font-weight: bold">حالة المشروع</td>
        <td style="font-weight: bold">المشروع</td>
        <td style="font-weight: bold">عنوان النموذج</td>
        <td style="font-weight: bold">فئة الشكوى</td>
        <td style="font-weight: bold">رقم الهوية</td>
        <td style="font-weight: bold">المواطن</td>
        <td style="font-weight: bold">رقم الطلب</td>
    </tr>
    @foreach($items as $item)
	    <tr>
                <td> {{$item->sent_typee->name}}</td>
                <td>{{$item->form_type->name}}</td>
                <td>{{$item->form_status->name}}</td>
                <td>{{$item->datee}}</td>
                <td>{{$item->project->project_status->name}}</td>
                <td>{{ $item->project->name ." ".$item->project->code }}</td>
                <td>{{$item->title}}</td>
                <td>@if($item->type=='1'){{$item->category->name}}@endif</td>
                <td>{{$item->citizen->id_number}}</td>
                <td>{{$item->citizen->first_name." ".$item->citizen->father_name." ".$item->citizen->grandfather_name." ".$item->citizen->last_name}}</td>
                <td>{{$item->id}}</td>
            </tr>    @endforeach
        <tr><td colspan=9>{{date('Y-m-d')}}</td><td colspan=2>تاريخ الطباعة</td></tr>
    </tbody>
    
   
</table>
</body>