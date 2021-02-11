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
<br><br><br><br>
<hr>
<table border="1" style="text-align:right;width: 100%;margin: 45px">
    <tbody>

    <tr>


        <th style="font-weight: bold">
            @if($item->account_projects->where('rate','=','1')->where('project_id',"=",$item->id)->first())
                {{$item->account_projects->where('rate','=','1')->where('project_id',"=",$item->id)->first()->account->full_name}}
            @endif</th>
        <th style="font-weight: bold"> المدير</th>

        <th style="font-weight: bold">عدد الموظفين: {{count($item->accounts->toArray())}}</th>

        <th style="font-weight: bold">المشروع :{{ $item->name ." ".$item->code }}</th>

    </tr>
    <tr>


        <th style="font-weight: bold" colspan="3">{{$item->details}}</th>

        <th style="font-weight: bold">التفاصيل</th>

    </tr>
    <tr>
        <td>@if($item->account_projects->where('rate','=','4')->where('project_id',"=",$item->id)->first())
                {{$item->account_projects->where('rate','=','4')->where('project_id',"=",$item->id)->first()->account->full_name}}
            @endif</td>
        <th style="font-weight: bold">الممول</th>
        <td>{{$item->start_date}}</td>
        <th style="font-weight: bold">تاريخ البدء</th>
    </tr>
    <tr>
        <td>@if($item->account_projects->where('rate','=','2')->where('project_id',"=",$item->id)->first())
                {{$item->account_projects->where('rate','=','2')->where('project_id',"=",$item->id)->first()->account->full_name}}
            @endif</td>
        <th style="font-weight: bold">المشرف</th>
        <td>{{$item->end_date}}</td>
        <th style="font-weight: bold">تاريخ الإنتهاء</th>
    </tr>
    <tr>
        <td>@if($item->account_projects->where('rate','=','3')->where('project_id',"=",$item->id)->first())
                {{$item->account_projects->where('rate','=','3')->where('project_id',"=",$item->id)->first()->account->full_name}}
            @endif</td>
        <th style="font-weight: bold">المنسق</th>
        <td> {{count($item->citizens->toArray())}}</td>
        <th>عدد المواطنين</th>
    </tr>
    <tr>
        <td>{{$item->project_status->name}}</td>
        <th>الحالة</th>

        <td>{{count($forms->toArray())}}</td>
        <th style="font-weight: bold">عدد الشكاوى</th>

    </tr>
    <tr>
        <th style="font-weight: bold">الدوائر الوظيفية</th>
        <th style="font-weight: bold">الموظفين</th>
        <th style="font-weight: bold">فئة الشكوى</th>
        <th style="font-weight: bold">الشكاوى</th>
    </tr>
    <?php
    if (count($just_stuff->toArray()) >= count($forms->toArray()))
        $max = count($just_stuff->toArray());
    else
        $max = count($forms->toArray());
    ?>

    @for($i=0;$i<=$max;$i++)
        <tr>

            @if(count($just_stuff->toArray())>$i)
                <td>{{$just_stuff[$i]->circle->name}}</td>
                <td>{{$just_stuff[$i]->full_name}}</td>

            @else
                <td></td>
                <td></td>
            @endif

            @if(count($forms->toArray())>$i)
                <td>{{$forms[$i]->category->name}}</td>
                <td>{{$forms[$i]->title}}</td>

            @endif

        </tr>
    @endfor
    <tr>
        <td colspan=3>{{date('Y-m-d')}}</td>
        <td colspan=2>تاريخ الطباعة</td>
    </tr>
    </tbody>
</table>
</body>
