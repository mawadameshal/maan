@extends("layouts._account_layout")

@section("title", "إضافة مشروع جديد")


@section("content")
<div class="row">
    <div class="col-sm-12">
            <form method="post" action="/account/project">
        @csrf
        <div class="form-group row">
            <div class="col-sm-5">
                <label for="code" class="col-form-label">رمز المشروع</label>

                <input type="text" class="form-control" value="" id="code" name="code">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-5">
                        <label for="name" class="col-form-label">  اسم المشروع باللغة العربية</label>

                <input type="text" autofocus class="form-control" value="{{old("name")}}" id="name" name="name">
            </div>
        </div>

{{--
        <!--<div class="form-group row">
            <div class="col-sm-5">
                        <label for="code" class="col-form-label">التفاصيل</label>

                <textarea class="form-control" id="details" name="details">
                    {{old("details")}}
                </textarea>
            </div>
        </div>--> --}}

        <div class="form-group row">
            <div class="col-sm-5">
                        <label for="start_date" class="col-form-label"> تاريخ بداية المشروع</label>

                <input type="text" class="form-control datepicker" value="{{old("start_date")}}" id="start_date" name="start_date" placeholder="يوم / شهر / سنة">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-5">
                        <label for="end_date" class="col-form-label"> تاريخ نهاية المشروع</label>

                <input type="text" class="form-control datepicker" value="{{old("end_date")}}" id="end_date" name="end_date" placeholder="يوم / شهر / سنة">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-5">
                <label for="active" class="col-form-label">حالة المشروع</label>
                <input type="text" class="form-control" value="" id="project_status" name="project_status" readonly>

            </div>
        </div>

        <input type="hidden" name="active" value="1" >

        <div class="form-group row">
            <div class="col-sm-5 col-md-offset-5">
                <input type="submit" class="btn btn-success" value="حفظ"/>
                <a href="/account/project" class="btn btn-light">الغاء الامر</a>
            </div>
        </div>
    </form>

    </div>
</div>
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
