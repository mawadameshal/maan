@extends("layouts._account_layout")

@section("title", "إدارة الإجازات السنوية ")

@section("content")

<div class="row">
    <div class="col-sm-12">

            <form method="post" action="/account/events/update/{{$item->id}}">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <div class="col-sm-2">
                <label for="event_name" class="col-form-label">طبيعة الاجازة: </label>
            </div>
                <div class="col-sm-4">
                <input type="text" class="form-control" value="{{$item->event_name}}" id="event_name" name="event_name">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                        <label for="start_date" class="col-form-label"> من تاريخ:</label>
                    </div>
                    <div class="col-sm-4">
                <input type="date"  class="form-control " value="{{$item->start_date}}" id="start_date" name="start_date">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2">
                        <label for="end_date" class="col-form-label"> الي تاريخ:</label>
                    </div>
                    <div class="col-sm-4">
                <input type="date"  class="form-control " value="{{$item->end_date}}" id="end_date" name="end_date">
            </div>
        </div>

        <div class="form-group row" style="margin-right:400px;margin-bottom: 10px;">
            <div class="col-sm-5 col-md-offset-5">
                <input type="submit" class="btn btn-success" value="إضافة"/>
                <a href="events" class="btn btn-light">الغاء الامر</a>
            </div>
        </div>
    </form>
    </div>
</div>



@endsection