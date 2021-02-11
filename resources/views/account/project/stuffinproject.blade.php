@extends("layouts._account_layout")

@section("title", "توظيف حسابات في مشروع $item->name $item->code ")


@section("content")
    <div class="row">
        <form>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="q" value="{{request('q')}}"
                       placeholder="ابحث في الإسم او البريد أو الهاتف"/>
            </div>
            <div class="col-sm-4">
                <input type="submit" style="width:70px;" value="بحث" class="btn btn-primary"/>
            </div>
        </form>
    </div>
    <br>
    <div class="mt-3"></div>
    @if($items->count()>0)
        <form method="post" action="/account/project/stuffinproject/{{$item->id}}">
            @csrf
            <div class="form-group row">

                <div class="col-sm-5">
                    <ul class="list-unstyled">
                        <?php $i = 0?>
                        @foreach($items as $account)


                            <li class="row">
                                <label class="col-sm-5">

                                    <input id='testNameHidden' type='hidden' value='0' name='accounts[{{$i}}]' checked>
                                    <input
                                            {{$item->accounts->contains($account->id)?'checked':''}} type="checkbox"
                                            name="accounts[{{$i}}]"

                                            value="{{$account->id}}"/>
                                    <b>{{$account->full_name}}</b></label>
                                <div class="col-sm-5">
                                        <select class="form-control" style="width: 87% ;display: inline" id="rates" name="rates[]" >
                                            @if($item->account_projects->where('account_id','=',$account->id)->count()>=1)
                                                <option value="{{$item->account_projects->where('account_id','=',$account->id)->first()->rate}}">
                                                    @if($item->account_projects->where('account_id','=',$account->id)->first()->rate==1)
                                                        مدير
                                                    @elseif($item->account_projects->where('account_id','=',$account->id)->first()->rate==2)
                                                        مشرف
                                                    @elseif($item->account_projects->where('account_id','=',$account->id)->first()->rate==3)
                                                        منسق
                                                    @elseif($item->account_projects->where('account_id','=',$account->id)->first()->rate==4)
                                                        ممول
                                                    @elseif($item->account_projects->where('account_id','=',$account->id)->first()->rate==5)
                                                        لجنة
                                                    @elseif($item->account_projects->where('account_id','=',$account->id)->first()->rate==6)
                                                        موظف
                                                    @endif
                                                </option>
                                            @endif
                                            @if(!($item->account_projects->where('rate',1)->count()>=1))
                                                <option value="1">مدير</option>
                                            @endif
                                            @if(!($item->account_projects->where('rate',2)->count()>=1))
                                                <option value="2">مشرف</option>
                                            @endif
                                            @if(!($item->account_projects->where('rate',3)->count()>=1))
                                                <option value="3">منسق</option>
                                            @endif
                                            @if(!($item->account_projects->where('rate',4)->count()>=1))
                                                <option value="4">ممول</option>
                                            @endif
                                            @if(!($item->account_projects->where('rate',5)->count()>=5))
                                                <option value="5">لجنة</option>
                                            @endif
                                            <option value="6">موظف</option>
                                        </select>

                                </div>
                                <br>
                                @if($account->account_projects->where('project_id','=',$item->id)->first())
                                    <ul style="margin-top: 29px " class=" list-unstyled">
                                        <li>
                                            <label><input type="hidden" name="to_add[{{$i}}]" value="0"><input
                                                        {{($account->account_projects->where('project_id','=',$item->id)->first()->to_add)?"checked":""}}
                                                        type="checkbox" name="to_add[{{$i}}]"
                                                        value="1"/>
                                                إضافة نماذج على المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_edit[{{$i}}]" value="0"><input
                                                        {{($account->account_projects->where('project_id','=',$item->id)->first()->to_edit)?"checked":""}}
                                                        type="checkbox" name="to_edit[{{$i}}]"
                                                        value="1"/>
                                                تعديل فئات غير مناسبة لنماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_delete[{{$i}}]" value="0"><input
                                                        {{($account->account_projects->where('project_id','=',$item->id)->first()->to_delete)?"checked":""}}
                                                        type="checkbox" name="to_delete[{{$i}}]"
                                                        value="1"/>
                                                حذف نماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_replay[{{$i}}]" value="0"><input
                                                        {{($account->account_projects->where('project_id','=',$item->id)->first()->to_replay)?"checked":""}}
                                                        type="checkbox" name="to_replay[{{$i}}]"
                                                        value="1"/>
                                                الرد على نماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_stop[{{$i}}]" value="0"><input
                                                        {{($account->account_projects->where('project_id','=',$item->id)->first()->to_stop)?"checked":""}}
                                                        type="checkbox" name="to_stop[{{$i}}]"
                                                        value="1"/>
                                                ايقاف نماذج المشروع</label>

                                        </li>
                                        <li>
                                            <label><input type="hidden" name="to_notify[{{$i}}]" value="0"><input
                                                        {{($account->account_projects->where('project_id','=',$item->id)->first()->to_notify)?"checked":""}}
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
                    <a href="/account/project" class="btn btn-light">الغاء الامر</a>
                </div>
            </div>
        </form>
    @else
        <br><br>
        <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
    @endif
@endsection
@section('js')
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
            $(document).ready(function(){
                $('select').on('change', function(event ) {
                    //restore previously selected value
                    var prevValue = $(this).data('previous');
                    var value = $(this).val();
                    $('select').not(this).find('option[value="' + prevValue + '"]').show();

                    if(value!=5 &&value!=6) {
                        //hide option selected
                        //update previously selected data
                        $(this).data('previous', value);
                        $('select').not(this).find('option[value="' + value + '"]').hide();
                    }
                });
            });
        });
    </script>
    @endsection
