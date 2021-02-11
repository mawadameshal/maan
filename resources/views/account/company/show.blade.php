@extends("layouts._account_layout")

@section("title", " رسالة $item->title ")


@section("content")
    <div class="row">
        <div class="col-xs-10 padding-0 margin-0" style="padding-right:15px ; padding-left:0">
            <table class="table table-bordered padding-0 margin-0">
                <thead>
                <tr>
                    <th colspan=3 width="40%">المرسل : {{ $item->title }}</th>
					<th > {{ $item->datee }}</th>
					<th > {{ $item->mail }}</th>
					@if($item->mopile)<th > {{ $item->mopile }}</th>@endif
                </tr>
                </thead>
                <tbody>
                <tr>

                    <td colspan=6>{{ $item->content }}</td>

                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5 col-md-offset-1">
            <a href="/account/message" class="btn btn-success">الغاء الامر</a>
        </div>
    </div>
@endsection
