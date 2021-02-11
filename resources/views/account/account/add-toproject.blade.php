@extends("layouts._account_layout")

@section("title", "تحديد مشاريع الحساب $item->full_name")


@section("content")

    @if(Auth::user()->account->links->contains(\App\Link::where('title','=','تعديل حسابات')->first()->id))

        <form method="post" action="/account/account/select-project-post/{{$item->id}}">
            @csrf
            <div class="form-group row">

                <div class="col-sm-5">
                    <ul class="list-unstyled">
                        <?php $i = 0?>
                        @foreach($projects as $project)


                            <li class="row">
                                <label class="col-sm-5">

                                    <input id='testNameHidden' type='hidden' value='0' name='projects[{{$i}}]' checked>
                                    <input
                                            {{$item->projects->contains($project->id)?'checked':''}} type="checkbox"
                                            name="projects[{{$i}}]"

                                            value="{{$project->id}}"/>
                                    <b>{{$project->name}} - {{$project->code}}</b></label>
                                <div class="col-sm-5">
                                    @if($project->id!=1)
                                        <select class="form-control" style="width: 87% ;display: inline" name="rates[]">
                                            @if($item->account_projects->where('project_id','=',$project->id)->count()>=1)
                                                <option value="{{$item->account_projects->where('project_id','=',$project->id)->first()->rate}}">
                                                    @if($item->account_projects->where('project_id','=',$project->id)->first()->rate==1)
                                                        مدير
                                                    @elseif($item->account_projects->where('project_id','=',$project->id)->first()->rate==2)
                                                        مشرف
                                                    @elseif($item->account_projects->where('project_id','=',$project->id)->first()->rate==3)
                                                        منسق
                                                    @elseif($item->account_projects->where('project_id','=',$project->id)->first()->rate==4)
                                                        ممول
                                                    @elseif($item->account_projects->where('project_id','=',$project->id)->first()->rate==5)
                                                        لجنة
                                                    @elseif($item->account_projects->where('project_id','=',$project->id)->first()->rate==6)
                                                        موظف
                                                    @endif
                                                </option>
                                            @endif
                                            @if(!($project->account_projects->where('rate',1)->count()>=1))
                                                <option value="1">مدير</option>
                                            @endif
                                            @if(!($project->account_projects->where('rate',2)->count()>=1))
                                                <option value="2">مشرف</option>
                                            @endif
                                            @if(!($project->account_projects->where('rate',3)->count()>=1))
                                                <option value="3">منسق</option>
                                            @endif
                                            @if(!($project->account_projects->where('rate',4)->count()>=1))
                                                <option value="4">ممول</option>
                                            @endif
                                            @if(!($project->account_projects->where('rate',5)->count()>=5))
                                                <option value="5">لجنة</option>
                                            @endif
                                            <option value="6">موظف</option>
                                        </select>
                                    @else
                                        <select style="display: none;" class="form-control" name="rates[]">
                                            <option value="6" selected>موظف</option>
                                        </select>
                                    @endif
                                    @if($project->id==1)
                                        <a>
                                            <dd class="glyphicon glyphicon-question-sign" data-html="true"
                                                data-toggle="tooltip" data-placement="bottom"
                                                title="<em style='font-size=15px;direction: rtl;text-align:right;' >للتمكن من ادارة نماذج غير موجهة لأي مشروع وادارة المواطنين الغير مستفدين</em>"
                                            ></dd>
                                        </a>
                                    @else
                                        <a>
                                            <dd class="glyphicon glyphicon-question-sign" data-html="true"
                                                data-toggle="tooltip" data-placement="bottom"
                                                title="<em style='font-size=15px;direction: rtl;text-align:right;' >للتمكن من ادارة نماذج هذا المشروع وادارة المواطنين المستفدين من هذا المشروع</em>"
                                            ></dd>
                                        </a>
                                    @endif


                                </div>
                                <br>
                                @if($item->account_projects->where('project_id','=',$project->id)->first())
                                    <ul style="margin-top: 29px " class=" list-unstyled">
                                        <li>
                                            <label><input type="hidden" name="to_add[{{$i}}]" value="0"><input
                                                        {{($item->account_projects->where('project_id','=',$project->id)->first()->to_add)?"checked":""}}
                                                        type="checkbox" name="to_add[{{$i}}]"
                                                        value="1"/>
                                                إضافة نماذج على المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_edit[{{$i}}]" value="0"><input
                                                        {{($item->account_projects->where('project_id','=',$project->id)->first()->to_edit)?"checked":""}}
                                                        type="checkbox" name="to_edit[{{$i}}]"
                                                        value="1"/>
                                                تعديل فئات غير مناسبة لنماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_replay[{{$i}}]" value="0"><input
                                                        {{($item->account_projects->where('project_id','=',$project->id)->first()->to_replay)?"checked":""}}
                                                        type="checkbox" name="to_replay[{{$i}}]"
                                                        value="1"/>
                                                الرد على نماذج المشروع</label>

                                        </li>

                                        <li>
                                            <label><input type="hidden" name="to_delete[{{$i}}]" value="0"><input
                                                        {{($item->account_projects->where('project_id','=',$project->id)->first()->to_delete)?"checked":""}}
                                                        type="checkbox" name="to_delete[{{$i}}]"
                                                        value="1"/>
                                                حذف نماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_stop[{{$i}}]" value="0"><input
                                                        {{($item->account_projects->where('project_id','=',$project->id)->first()->to_stop)?"checked":""}}
                                                        type="checkbox" name="to_stop[{{$i}}]"
                                                        value="1"/>
                                                ايقاف نماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_notify[{{$i}}]" value="0"><input
                                                        {{($item->account_projects->where('project_id','=',$project->id)->first()->to_notify)?"checked":""}}
                                                        type="checkbox" name="to_notify[{{$i}}]"
                                                        value="1"/>
                                                اشعارا بأحداث نماذج المشروع</label>

                                        </li>
                                    </ul>
                                @else
                                    <ul style="margin-top: 29px " class=" list-unstyled">
                                        <li>
                                            <label><input type="hidden" name="to_add[{{$i}}]" value="0"><input
                                                        type="checkbox" name="to_add[{{$i}}]"
                                                        value="1"/>
                                                إضافة نماذج على المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_edit[{{$i}}]" value="0"><input
                                                        type="checkbox" name="to_edit[{{$i}}]"
                                                        value="1"/>
                                                تعديل فئات غير مناسبة لنماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_delete[{{$i}}]" value="0"><input
                                                        type="checkbox" name="to_delete[{{$i}}]"
                                                        value="1"/>
                                                حذف نماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_replay[{{$i}}]" value="0"><input
                                                        type="checkbox" name="to_replay[{{$i}}]"
                                                        value="1"/>
                                                الرد على نماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_stop[{{$i}}]" value="0"><input
                                                        type="checkbox" name="to_stop[{{$i}}]"
                                                        value="1"/>
                                                ايقاف نماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_notify[{{$i}}]" value="0"><input
                                                        type="checkbox" name="to_notify[{{$i}}]"
                                                        value="1"/>
                                                اشعارا بأحداث نماذج المشروع</label>

                                        </li>
                                    </ul>

                                @endif
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
