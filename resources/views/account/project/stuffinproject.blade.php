@extends("layouts._account_layout")

@section("title","توظيف حسابات على المشروع")



@section("content")

    <div class="row">
        <div class="col-md-12">
            <h4>يمكنك من خلال هذه الواجهة توظيف العاملين على مشروع  {{$item->name}}</h4>
        </div>
    </div>

    <br>

    <div class="form-group" style="margin-left: 10px;margin-bottom: 10px;">
        <button type="button"  style="width:110px;"  class="btn btn-primary adv-search-btnn"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            بحث متقدم
        </button>
    </div>
    <br>
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-12">
            <form class="form-inline">
                <div class="form-group adv-searchh" style="margin-left: 20px;">
                    <select name="status_worker" class="form-control" style="width: 230px;">
                        <option value="" selected>موظفي/ غير موظفي المشروع </option>
                        <option value="1">موظفي المشروع</option>
                        <option value="2">غير موظفي المشروع</option>

                    </select>
                </div>
                <div class="form-group adv-searchh" style="margin-left: 20px;">
                    <select name="account_id" class="form-control" style="width: 230px;">
                        <option value="" selected>اسم المستخدم</option>
                        @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->full_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group adv-searchh" style="margin-left: 20px;">
                    <select name="circle_id" class="form-control" style="width: 230px;">
                        <option value="" selected>المستوى الإداري </option>
                        @foreach($circles as $circle)
                            <option value="{{$circle->id}}">{{$circle->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" name="theaction" value="search" style="width:110px;margin-top:0px"
                        class="btn btn-primary adv-searchh"><span class="glyphicon glyphicon-search"
                                                                  aria-hidden="true"></span>     بحث    </button>
            </form>
        </div>
    </div>
    <div class="mt-3"></div>
    @if($items)
    @if($items->count()>0)
        <form method="post" action="/account/project/stuffinproject/{{$item->id}}">
            @csrf
            <table class="table table-hover table-striped" style="width:100% !important;max-width:100% !important;white-space:normal;">
                <thead>
                <tr>
                    <th style="word-break: normal;text-align: center">
                        <input type="checkbox" id="checkAll" name="checkbox" value="">
                        تحديد الكل
                    </th>
                    <th style="word-break: normal;">#</th>
                    <th style="max-width: 100px;word-break: normal;">اسم المستخدم</th>
                    <th style="max-width: 100px;word-break: normal;">المستوى الإداري</th>
                    <th style="max-width: 100px;word-break: normal;text-align: center">مشاريع المستخدم الحالية</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($items as $key=>$account)

                        <tr>
                            <th style="word-break: normal;text-align: center">
                                <input class="checkbox_name"  value="{{$account->id}}"
                                       {{$item->accounts->contains($account->id)?'checked':''}} type="checkbox"
                                       name="accounts[]">
                                <input type="hidden" name="account_id[]" value="{{$account->id}}">

                            </th>
                            <td style="word-break: normal;">{{$key+1}}</td>
                            <td style="max-width: 250px;word-break: normal;">{{$account->full_name}}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$account->circle->name}}</td>
                            <td style="max-width: 100px;word-break: normal;text-align: center">
                                <a class="btn btn-xs btn-primary" target="_blank" href="/account/account/select-project/{{$account->id}}" title="اضغظ هنا">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <br>
            <div style="float:left;margin-bottom: 20px" >{{$items->links()}} </div>
            <br>
            <br>
            <div class="form-group row" style="margin-bottom:15px;float: left;">
                <div class="col-sm-12">
                    <input type="submit" class="btn btn-success" value="حفظ"/>
                    <a href="/account/project" class="btn btn-light">الغاء الامر</a>
                </div>
            </div>
        </form>
        <br><br>
    @else
        <br><br>
        <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
    @endif
    @else
        <table class="table table-hover table-striped" style="white-space:normal;">
            <thead>
            <tr>
                <th style="word-break: normal;text-align: center">
                    <input type="checkbox" id="checkAll" name="checkbox" value="">
                    تحديد الكل
                </th>
                <th style="word-break: normal;">#</th>
                <th style="max-width: 100px;word-break: normal;">اسم المستخدم</th>
                <th style="max-width: 100px;word-break: normal;">المستوى الإداري</th>
                <th style="max-width: 100px;word-break: normal;">مشاريع المستخدم الحالية</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
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
    </script>
@endsection
