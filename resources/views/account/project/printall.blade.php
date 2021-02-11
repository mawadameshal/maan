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
<br><br><br><br><br><br>
<table border="1" style="text-align:right;width: 100%;margin: 45px">
    <tbody>
    <tr>

        <td style="font-weight: bold">عدد الشكاوى</td>
        <td style="font-weight: bold">عدد الموظفين</td>
        <td style="font-weight: bold">عدد المستفيدين</td>
        <td style="font-weight: bold">الحالة</td>
        <td style="font-weight: bold">تاريخ الإنتهاء</td>
        <td style="font-weight: bold">تاريخ البدء</td>
        <td style="font-weight: bold">الممول</td>
        <td style="font-weight: bold">المنسق</td>
        <td style="font-weight: bold">المشرف</td>
        <td style="font-weight: bold">المدير</td>
        <td style="font-weight: bold">الكود</td>
        <td style="font-weight: bold">المشروع</td>
    </tr>
    @foreach($items as $item)
        @if(Auth::user()->account->projects->contains($item->id))
            <tr>

                <td style="font-weight: bold">{{count($item->forms->toArray())}}</td>
                <td style="font-weight: bold">{{count($item->accounts->toArray())}}</td>
                <td style="font-weight: bold">{{count($item->citizens->toArray())}}</td>
                <td style="font-weight: bold">{{$item->project_status->name}}</td>
                <td style="font-weight: bold">{{$item->end_date}}</td>
                <td style="font-weight: bold">{{$item->start_date}}</td>
                <td>@if($item->account_projects->where('rate','=','4')->first())
                        {{$item->account_projects->where('rate','=','4')->first()->account->full_name}}
                    @endif
                </td>
                <td>@if($item->account_projects->where('rate','=','3')->first())
                        {{$item->account_projects->where('rate','=','3')->first()->account->full_name}}
                    @endif
                </td>
                <td>@if($item->account_projects->where('rate','=','2')->first())
                        {{$item->account_projects->where('rate','=','2')->first()->account->full_name}}
                    @endif
                </td>
                <td>@if($item->account_projects->where('rate','=','1')->first())
                        {{$item->account_projects->where('rate','=','1')->first()->account->full_name}}
                    @endif
                </td>
                <td style="font-weight: bold">{{$item->code }}</td>
                <td style="font-weight: bold">{{ $item->name}}</td>
            </tr>
        @endif
    @endforeach
    <tr>
        <td colspan=10>{{date('Y-m-d')}}</td>
        <td colspan=2>تاريخ الطباعة</td>
    </tr>
    </tbody>
</table>
</body>
