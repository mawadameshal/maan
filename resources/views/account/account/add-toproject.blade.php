@extends("layouts._account_layout")

@section("title", "تعريف المشاريع ")

@section("content")

    <div class="row">
        <div class="col-md-12">
            <h4>يمكنك من خلال هذه الواجهة تعريف المشاريع التي يعمل عليها المستخدم {{$item->full_name}} </h4>
        </div>
    </div>
    <br>

    <div class="form-group" style="margin-left: 10px;margin-bottom: 10px;">
        <button type="button"  style="width:110px;"  class="btn btn-primary adv-search-btnn"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            بحث متقدم
        </button>
    </div>

    <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-12">
            <form class="form-inline">
                <div class="form-group adv-searchh" style="margin-left: 20px;">
                    <select name="status_work" class="form-control" style="width: 230px;">
                        <option value="" selected>حالة العمل على المشاريع </option>
                        <option value="1">المشاريع التي يعمل عليها حالياً</option>
                        <option value="2">المشاريع التي لا يعمل عليها حالياً</option>

                    </select>
                </div>
                <div class="form-group adv-searchh" style="margin-left: 20px;">
                    <select name="project_code" class="form-control" style="width: 230px;">
                        <option value="" selected>كود المشروع </option>
                        @foreach($projects_for_select as $project)
                            <option value="{{$project->id}}">{{$project->code}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group adv-searchh" style="margin-left: 20px;">
                    <select name="project_name" class="form-control" style="width: 230px;">
                        <option value="" selected>اسم المشروع </option>
                        @foreach($projects_for_select as $project)
                            <option value="{{$project->id}}">{{$project->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group adv-searchh" style="margin-left: 20px;">
                    <select name="project_status" class="form-control" style="width: 230px;">
                        <option value="" selected>حالة المشروع </option>
                        @foreach($project_status as $status)
                            <option
                                @if(request('project_status')===''.$status->id)selected
                                @endif
                                value="{{$status->id}}">{{$status->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group adv-searchh" style="margin-top:10px;margin-left: 20px;">
                    <div>
                        <label for="from_date">تاريخ بداية المشروع </label>
                    </div>
                    <input style="width: 230px;" type="text" class="form-control datepicker" name="from_date" value="{{request('from_date')}}"
                           placeholder="يوم / شهر / سنة"/>
                </div>
                <div class="form-group adv-searchh" style="margin-top:10px;margin-left: 20px;">
                    <div>
                        <label for="to_date">تاريخ نهاية المشروع</label>
                    </div>

                    <input style="width: 230px;" type="text" class="form-control datepicker" name="to_date" value="{{request('to_date')}}"
                           placeholder="يوم / شهر / سنة"/>
                </div>

                <button type="submit" name="theaction" value="search" style="width:110px;margin-top:30px"
                        class="btn btn-primary adv-searchh"><span class="glyphicon glyphicon-search"
                                                                  aria-hidden="true"></span>     بحث    </button>
            </form>
        </div>
    </div>
    <div class="mt-3"></div>

    @if(check_permission('تعديل حسابات'))

        <form method="post" action="/account/account/select-project-post/{{$item->id}}">
            @csrf
            @if($projects)
                @if($projects->count()>0)
                    <table class="table table-hover table-striped" style="width:100% !important;max-width:100% !important;white-space:normal;">
                        <thead>
                        <tr>
                            <th style="word-break: normal;text-align: center">
                                <input type="checkbox" id="checkAll" name="checkbox" value="">
                                تحديد الكل
                            </th>
                            <th style="word-break: normal;">#</th>
                            <th style="max-width: 100px;word-break: normal;">رمز المشروع</th>
                            <th style="max-width: 100px;word-break: normal;">اسم المشروع</th>
                            <th style="max-width: 100px;word-break: normal;">تاريخ بداية المشروع</th>
                            <th style="max-width: 100px;word-break: normal;">تاريخ نهاية المشروع</th>
                            <th style="max-width: 100px;word-break: normal;text-align: center;">حالة المشروع</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $key=>$a)
                            <tr>
                                <th style="word-break: normal;text-align: center">
                                    <input class="checkbox_name"  value="{{$a->id}}"
                                           {{$item->projects->contains($a->id)?'checked':''}} type="checkbox"
                                           name="projects[]">
                                    <input type="hidden" name="project_id[]" value="{{$a->id}}">

                                </th>
                                <td style="word-break: normal;">{{$a->id}}</td>
                                <td style="max-width: 250px;word-break: normal;">{{$a->code}}</td>
                                <td style="max-width: 100px;word-break: normal;">{{$a->name}}</td>
                                <td style="max-width: 100px;word-break: normal;">{{$a->start_date}}</td>
                                <td style="max-width: 100px;word-break: normal;"> {{$a->end_date}}</td>
                                <td style="max-width: 100px;word-break: normal;text-align: center">  @if($a->end_date < now() )  منتهي@elseمستمر@endif</td>

                            </tr>
                        @endforeach


                        </tbody>
                    </table>

                    <br>
                    <div style="float:left" >{{$projects->links()}} </div>
                    <br> <br><br>
                @else
                    <br><br>
                    <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
                @endif
            @else
                <table class="table table-hover table-striped" style="white-space:normal;">
                    <thead>
                    <tr>
                        <th style="word-break: normal;">
                            <input type="checkbox" id="checkAll" name="checkbox" value="">
                            تحديد الكل
                        </th>
                        <th style="word-break: normal;">#</th>
                        <th style="max-width: 100px;word-break: normal;">رمز المشروع</th>
                        <th style="max-width: 100px;word-break: normal;">اسم المشروع</th>
                        <th style="max-width: 100px;word-break: normal;">تاريخ بداية المشروع</th>
                        <th style="max-width: 100px;word-break: normal;">تاريخ نهاية المشروع</th>
                        <th style="max-width: 100px;word-break: normal;">حالة المشروع</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            @endif

            <div class="form-group row" style="float: left">
                <div class="col-sm-12" >
                    <input type="submit" class="btn btn-success" value="حفظ"/>
                    <a href="/account/account" class="btn btn-light">الغاء الامر</a>
                </div>
            </div>
        </form>
    @else
        <br><br>
        <div class="alert alert-warning">ليس من صلاحيتك هذه الصفحة</div>
    @endif
@endsection
@section('js')
    <script>
        $('.adv-searchh').hide();
        $('.adv-search-btnn').click(function () {

            $('.adv-searchh').slideToggle("fast", function() {
                if ($('.adv-searchh').is(':hidden'))
                {
                    $('#searchonly').show();
                }
                else
                {
                    $('#searchonly').hide();
                }
            });
        });

        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });


        $('.checkbox_name').click(function() {
            var checkboxes = $('.checkbox_name:checked').length;
            $('#count_of_names').text(checkboxes  +'  ' + 'اسم')
        })



    </script>
@endsection
