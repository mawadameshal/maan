@extends("layouts._account_layout")

@section("title", "ملاحق ذات علاقة بمتطلبات النظام ")

@section("content")



<div class="row">
    <div class="col-md-8">
        <h4>يمكنك من خلال هذه الواجهة تعريف الملاحق ذات العلاقة بمتطلبات النظام.</h4>
<br>

    </div>


</div>
     <br>

     <div class="row">
        <div class="col-sm-12">

                <form method="post" action="/account/appendix" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <div class="col-sm-2">
                    <label for="appendix_name" class="col-form-label">اسم الملحق:</label>
                </div>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" value="" id="appendix_name" name="appendix_name">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                            <label for="appendix_describe" class="col-form-label">وصف عن الملحق: </label>
                        </div>
                        <div class="col-sm-4">
                    <input type="text"  class="form-control " value="" id="appendix_describe" name="appendix_describe">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                            <label for="" class="col-form-label">  رفع الملحق:</label>
                        </div>
                        <div class="col-sm-4">
                    <input type="file"  class="form-control " value="" id="appendix_file" name="appendix_file">
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
<br>



<div class="mt-3"></div>
@if($items)
@if($items->count()>0)
    <div class="table-responsive">
        <table class="table table-hover table-striped">
        <thead>
            <hr>

            <tr>
                <th style="max-width: 30px;word-break: normal;"># </th>
            <th style="max-width: 100px;word-break: normal;">اسم الملحق</th>
            <th style="max-width: 100px;word-break: normal;">وصف الملحق</th>
            <th style="max-width: 100px;word-break: normal;">تاريخ تحديث الملحق</th>
            <th style="word-break: normal;">تفاصيل ذات علاقة بالملحق</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $a)

            @if($a->id)
                <tr>
                    <td style="word-break: normal;">{{$a->id}}</td>
                    <td style="word-break: normal;">{{$a->appendix_name }}</td>
                    <td style="max-width: 250px;word-break: normal;">{{$a->appendix_describe}}</td>
                    <td style="max-width: 60px;word-break: normal;">{{$a->updated_at }}</td>
                    <td style="text-align: center;">

                        <a class="btn btn-xs btn-primary" data-toggle="modal" id="smallButton" data-target="#smallModal"
                           data-attr="{{ route('showappendix', $a->id) }}" title="معاينة">
                            <i class="glyphicon glyphicon-eye-open"></i>
                        </a>

                        <a class="btn btn-xs btn-primary" title="تعديل" href="/account/appendix/edit/{{$a->id}}">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a class="btn btn-xs Confirm btn-danger"
                        href="/account/appendix/delete/{{$a->id}}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>

                </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    </div>
    <br>
    <div style="float:left; " >  {{$items->links()}} </div>
    <br> <br><br>
@else
    <br><br>
    <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
@endif
@else
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th style="max-width: 30px;word-break: normal;"># </th>
            <th style="max-width: 100px;word-break: normal;">اسم الملحق</th>
            <th style="max-width: 100px;word-break: normal;">وصف الملحق</th>
            <th style="max-width: 100px;word-break: normal;">تاريخ تحديث الملحق</th>
            <th style="word-break: normal;">تفاصيل ذات علاقة بالملحق</th>
        </tr>
        </thead>
    </table>
</div>
@endif



<div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
     aria-hidden="true" style=" position: absolute;left: 42%;top: 40%;transform: translate(-50%, -50%);">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section("js")
    <script>
        $(document).on('click', '#smallButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>
@endsection

