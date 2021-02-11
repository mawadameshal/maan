@extends("layouts._account_layout")

@section("title", "تعديل مشروع $item->name $item->code ")


@section("content")
<br>
    <form method="post" action="/account/project/{{$item->id}}">
        @csrf
        @method('put')
        <div class="form-group row">
            <div class="col-sm-2">
                <label for="code" class="col-form-label">رمز المشروع</label>
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control" value="{{$item->code}}" id="code" name="code">
                {!! $errors->first('code', '<p class="help-block" style="color:red;">:message</p>') !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                <label for="name" class="col-form-label">اسم المشروع بالعربية</label>
            </div>
            <div class="col-sm-5">
                <input type="text" autofocus class="form-control" value="{{$item->name}}" id="name" name="name">
                {!! $errors->first('name', '<p class="help-block" style="color:red;">:message</p>') !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                <label for="start_date" class="col-form-label"> تاريخ بداية المشروع</label>
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control datepicker" value="{{$item->start_date}}" id="start_date" name="start_date" placeholder="يوم / شهر / سنة">
                {!! $errors->first('start_date', '<p class="help-block" style="color:red;">:message</p>') !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                <label for="end_date" class="col-form-label"> تاريخ نهاية المشروع</label>
            </div>
            <div class="col-sm-5">
                <input type="text" class="form-control datepicker" value="{{$item->end_date}}" id="end_date" name="end_date" placeholder="يوم / شهر / سنة">
                {!! $errors->first('end_date', '<p class="help-block" style="color:red;">:message</p>') !!}

            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                <label for="active" class="col-form-label">حالة المشروع</label>
            </div>
            <div class="col-sm-5">
                    <input type="text" class="form-control"  value="{{$item->end_date <= now() ?  'منتهي' : 'مستمر'}}" id="project_status" name="project_status" readonly>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-5 col-md-offset-2">
                <input type="submit" class="btn btn-success" value="حفظ"/>
                <a href="/account/project" class="btn btn-light">الغاء الامر</a>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script>

        $('#end_date').change(function () {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '/' + mm + '/' + dd;
            console.log(today);
            console.log($('#end_date').val());

            if($('#end_date').val() <= today){
                $('#project_status').val('منتهي');
            }else{
                $('#project_status').val('مستمر');
            }

        });
    </script>
@endsection
