@extends("layouts._account_layout")

@section("title", "ملاحق ذات علاقة بمتطلبات النظام ")

@section("content")



<div class="row">
    <div class="col-md-8">
        <h4>يمكنك من خلال هذه الواجهة تعديل الملاحق ذات العلاقة بمتطلبات النظام.</h4>
<br>

    </div>


</div>
     <br>

     <div class="row">
        <div class="col-sm-12">

                <form method="post" action="/account/appendix/update/{{$item->id}}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <div class="col-sm-2">
                    <label for="appendix_name" class="col-form-label">اسم الملحق:</label>
                </div>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" value="{{$item->appendix_name}}" id="appendix_name"
                    name="appendix_name">
                </div>
            </div>


            <div class="form-group row">
                <div class="col-sm-2">
                            <label for="appendix_describe" class="col-form-label">وصف عن الملحق: </label>
                        </div>
                        <div class="col-sm-4">
                    <input type="text"  class="form-control " value="{{$item->appendix_describe}}" id="appendix_describe"
                     name="appendix_describe">
                </div>
            </div>


            <div class="form-group row">
                <div class="col-sm-2">
                            <label for="appendix_file" class="col-form-label">  رفع الملحق:</label>
                        </div>
                        <div class="col-sm-4">
                    <input type="file"  class="form-control" value="{{$item->appendix_file}}" id="appendix_file"
                    name="appendix_file">
                </div>
            </div>

            <div class="form-group row" style="margin-right:400px;margin-bottom: 10px;">
                <div class="col-sm-5 col-md-offset-5">
                    <input type="submit" class="btn btn-success" value="تعديل"/>
                    <a href="events" class="btn btn-light">الغاء الامر</a>
                </div>
            </div>
        </form>
        </div>
    </div>
<br>
@endsection
