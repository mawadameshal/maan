@extends("layouts._account_layout")

@section("title", "تحديد مشاريع الحساب $item->full_name")


@section("content")

    @if(check_permission('تعديل حسابات'))

        <form method="post" action="/account/account/select-project-post/{{$item->id}}">
            @csrf
            <div class="form-group row">

                <div class="col-sm-5">
                    <ul class="list-unstyled">
                        <?php $i = 0?>
                        @foreach($projects as $project)


                            <li class="row">
                                <label class="col-sm-12">

                                    <input id='testNameHidden' type='hidden' value='0' name='projects[{{$i}}]' checked>
                                    <input style="margin-left: 20px;margin-right: 20px;"
                                            {{$item->projects->contains($project->id)?'checked':''}} type="checkbox"
                                            name="projects[{{$i}}]"

                                            value="{{$project->id}}"/>
                                    <b>{{$project->name}} - {{$project->code}}</b></label>

                                <br>
                            </li><br>
                            <?php $i++?>
                        @endforeach
                    </ul>

                </div>
            </div>


            <div class="form-group row">
                <div class="col-sm-5">
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
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        if (document.getElementById("testName").checked) {
            document.getElementById('testNameHidden').disabled = true;
        }

    </script>
    <script>
        $(function(){

            $(":checkbox").click(function(){
                $(this).parent().nextAll().find(":checkbox").prop("checked",$(this).prop("checked"));
                /*$(this).parents("ul").each(function(){
                    $(this).prevAll().find(":checkbox").prop("checked",$(this).find(":checked").size()>0);
                });*/
            });
//
            //
        });
    </script>
@endsection
