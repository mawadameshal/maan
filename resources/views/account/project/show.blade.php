@extends("layouts._account_layout")

@section("title", " مشروع $item->name $item->code ")


@section("content")
    <div class="row">
        <div class="col-xs-4 padding-0 margin-0" style="padding-right:15px ; padding-left:0">
            <table class="table table-bordered padding-0 margin-0">
                <thead>
                <tr>
                    <th colspan=2 width="40%">اسم المشروع : {{ $item->name }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th style="font-weight: bold;">التفاصيل</th>
                    <td style="word-break:normal;">{{$item->details}}</td>

                </tr>
                <tr>
                    <th style="font-weight: bold">الحالة</th>
                    <td>{{$item->project_status->name}}</td>

                </tr>
                <tr>
                    <th style="font-weight: bold">عدد الشكاوى : {{count($forms->toArray())}}</th>
                    <th style="font-weight: bold">فئة الشكوى</th>
                </tr>
                @foreach($forms as $form)
                    <tr>
                        {{-- <td>{{$form->title}}</td>
                        <td>{{$form->category->name}}</td> --}}

                    </tr>
                @endforeach
                <tr>
                    <td style="font-weight: bold">تاريخ البدء</td>
                    <td>{{$item->start_date}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">تاريخ الانتهاء</td>
                    <td>{{$item->end_date}}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">كود المشروع</td>
                    <td>{{$item->code}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-4 " style="padding-right:0 ; padding-left:0">
            <table class="table table-bordered padding-0 margin-0">
                <thead>
                <tr>
                    <th style="font-weight: bold" width="50%">عدد الموظفين: {{count($item->accounts->toArray())}}</th>
                    <th style="font-weight: bold">عدد المواطنين : {{count($item->citizens->toArray())}}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th style="font-weight: bold"> الموظف</th>
                    <th style="font-weight: bold">الدائرة الوظيفية</th>
                </tr>
                @foreach($accounts as $account)
                    @if($account->account_projects->where('project_id',"=",$item->id))
                        @if(!($account->account_projects->where('project_id',"=",$item->id)->first()->rate==3 ||$account->account_projects->where('project_id',"=",$item->id)->first()->rate==2 ||$account->account_projects->where('project_id',"=",$item->id)->first()->rate==1||$account->account_projects->where('project_id',"=",$item->id)->first()->rate==4))
                            <tr>
                                <td>{{$account->full_name}}</td>
                                <td>{{$account->circle->name}}</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td>{{$account->full_name}}</td>
                            <td>{{$account->circle->name}}</td>
                        </tr>
                    @endif
                @endforeach

                <tr>
                    <td style="font-weight: bold">المدير</td>
                    <td>@if($item->account_projects->where('rate','=','1')->where('project_id',"=",$item->id)->first())
                            {{$item->account_projects->where('rate','=','1')->where('project_id',"=",$item->id)->first()->account->full_name}}
                        @endif</td>

                </tr>
                <tr>
                    <td style="font-weight: bold">المشرف</td>
                    <td>@if($item->account_projects->where('rate','=','2')->where('project_id',"=",$item->id)->first())
                            {{$item->account_projects->where('rate','=','2')->where('project_id',"=",$item->id)->first()->account->full_name}}
                        @endif</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">المنسق</td>
                    <td>@if($item->account_projects->where('rate','=','3')->where('project_id',"=",$item->id)->first())
                            {{$item->account_projects->where('rate','=','3')->where('project_id',"=",$item->id)->first()->account->full_name}}
                        @endif</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">الممول</td>
                    <td>@if($item->account_projects->where('rate','=','4')->where('project_id',"=",$item->id)->first())
                            {{$item->account_projects->where('rate','=','4')->where('project_id',"=",$item->id)->first()->account->full_name}}
                        @endif</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-2">
            <form action="/account/project/{{$item->id}}">
                <button type="submit" target="_blank" name="theaction" title="طباعة" style="width:70px;" value="print"
                        class="btn btn-primary "/>
                <i class="glyphicon glyphicon-print"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5 col-md-offset-1">
            <a href="/account/project" class="btn btn-success">الغاء الامر</a>
        </div>
    </div>
@endsection
