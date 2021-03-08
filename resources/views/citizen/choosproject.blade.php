@extends("layouts._citizen_layout")

@section("title", "متابعة نموذج ")


@section("content")

<div class="row">
    <div class="col-sm-12">
    <h2 style="margin-top:120px;margin-bottom:20px;margin-left:0px;text-align:center;">
                 @if($citizen)
            أهلاً بك عزيزي
            {{$citizen->first_name}} {{$citizen->father_name}} {{$citizen->grandfather_name}} {{$citizen->last_name}}
        @else
            أنت غير مسجل ضمن قائمة المواطنين
        @endif<hr class="h1-hr"></h2>
    </div>
    </div>
<div class="row">
    <div class="col-sm-12">
    <h4 class="wow bounceIn" style="margin-top:50px;text-align:center;">
        @if($citizen)
            @if($projects)
                @if($projects->first())
                    أنت مستفيد من مشاريعنا يرجى اختيار مشروع لتقديم طلبك
                @else
                    أنت غير مستفيد من مشروع،
                    @if($type>2)
                        نأسف لا يمكنك تقديم نموذج شكر ، يمكنكم الذهاب لصفحة اضافة الاقتراحات أو الشكاوى
                    @else
                        لكن بامكانك تقديم طلبك بالضغط على الرابط أدناه
                    @endif
                @endif
            @endif
        @else
            أنت غير مسجل لدينا
            @if($type>2)
                نأسف لا يمكنك تقديم نموذج شكر ، يمكنكم الذهاب لصفحة اضافة الاقتراحات أو الشكاوى
            @else
                لكن بامكانك تقديم طلبك بالضغط على الرابط أدناه
            @endif
        @endif  </h4>
</div>
</div>
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-3">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <div class="col-sm-3"></div>
</div>

<!--first row  -->
<div class="row">
    <div class="col-sm-12">
        <form method="get" action="/citizen/editorcreatcitizen">


    <div class="row">
<div class="col-sm-3"></div>
        <div class="col-sm-6 text-center">

            @if($projects)
                @if($projects->first())
                    <select style="text-align:center; margin-bottom:20px;" class="form-control input" name="project_id">
                        <option value="">اختر مشروعك</option>
                        @foreach($projects as $project)
                            @if($project->id != 1)
                                <option value="{{$project->id}}">{{$project->name}}</option>
                            @endif
                        @endforeach
                    </select>

                @else
                    <input type="hidden" name="project_id" value="1">
                @endif
            @else
                <input type="hidden" name="project_id" value="1">
            @endif

            <input type="hidden" name="id_number" value="{{$_GET['id_number']}}">
            @if($citizen)
                <input type="hidden" name="citizen_id" value="{{$citizen->id}}">
            @else
                <input type="hidden" name="citizen_id" value="0">
            @endif

            <input type="hidden" name="type" value="{{$type}}">
        </div>
        <div class="col-sm-3"></div>
    </div>

    <!-- second row -->
    @if(!($projects) && ($type>2))

    @else
      <div class="form-group row" align="center">
        <div class="col-sm-3"></div>
            <!--<label class="col-lg-1 col-form-label form-control-label"></label>-->
            <div class="col-sm-6">
                <button style="width:60%; background-color:#BE2D45;"
                        type="submit" class="btn btn-info wow bounceIn">الإنتقال لتعبئة النموذج
                </button>
            </div>
        <div class="col-sm-3"></div>
    </div>
    @endif
</form>
</div>
</div>

<!--****************************************************** start footer **************************************************************-->
@endsection
