@extends("layouts._account_layout")

@section("title", "تحديد فئات المخصصة للمستوى الإداري /$item->name  ")

@section("content")
 من هنا يمكنك تحديد صلاحيات المستوى الإداري ({{$item->name}}) على كل نوع من انواع الشكاوى والاقتراحات المدرجة في النظام.

<br><br>
    <form method="post" action="/account/circle/select-category-post/{{$item->id}}">
        @csrf
        <div class="form-group row">

            <div class="col-sm-5">
               <ul class="list-unstyled">
                   <?php $i = 0?>

                   @foreach($categories as $category)
                   @if($category->id != 1)

                         <li>
                            <label>
                                <input  type='hidden' value='0' name='category_ids[{{$i}}]' checked>


                                <input  {{$item->category->contains($category->id)?'checked':''}} type="checkbox" name="category_ids[{{$i}}]"

                                          value="{{$category->id}}" /> <b> {{$category->name}} </b></label>
                            @if($category->circle_categories->where('circle_id','=',$item->id)->first())
                                <ul  class="list-unstyled">
                                    <li>
                                        <label><input type="hidden" name="to_add[{{$i}}]" value="0"><input
                                                    {{($category->circle_categories->where('circle_id','=',$item->id)->first()->to_add)?"checked":""}}
                                                    type="checkbox" name="to_add[{{$i}}]"
                                                    value="1"/>
                                            إضافة نماذج على الفئة
                                        </label>
                                    </li>
                                    <li>
                                        <label><input type="hidden" name="to_edit[{{$i}}]" value="0"><input
                                                    {{($category->circle_categories->where('circle_id','=',$item->id)->first()->to_edit)?"checked":""}}
                                                    type="checkbox" name="to_edit[{{$i}}]"
                                                    value="1"/>
                                            {{-- تعديل فئات غير مناسبة لنماذج الفئة --}}
                                            امكانية معالجة النموذج
                                        </label>

                                    </li>

                                    <li>
                                        <label><input type="hidden" name="to_stop[{{$i}}]" value="0"><input
                                                    {{($category->circle_categories->where('circle_id','=',$item->id)->first()->to_stop)?"checked":""}}
                                                    type="checkbox" name="to_stop[{{$i}}]"
                                                    value="1"/>
                                            ايقاف (اغلاق النموذج)</label>

                                    </li>

                                    <li>
                                        <label><input type="hidden" name="to_replay[{{$i}}]" value="0"><input
                                                    {{($category->circle_categories->where('circle_id','=',$item->id)->first()->to_replay)?"checked":""}}
                                                    type="checkbox" name="to_replay[{{$i}}]"
                                                    value="1"/>
                                              الرد على النموذج</label>

                                    </li>
                                    <li>
                                        <label><input type="hidden" name="to_notify[{{$i}}]" value="0"><input
                                                    {{($category->circle_categories->where('circle_id','=',$item->id)->first()->to_notify)?"checked":""}}
                                                    type="checkbox" name="to_notify[{{$i}}]"
                                                    value="1"/>
                                            اشعارات لهذه الفئة</label>

                                    </li>
                                    <li>
                                        <label><input type="hidden" name="to_delete[{{$i}}]" value="0"><input
                                                    {{($category->circle_categories->where('circle_id','=',$item->id)->first()->to_delete)?"checked":""}}
                                                    type="checkbox" name="to_delete[{{$i}}]"
                                                    value="1"/>
                                            حذف نماذج الفئة</label>

                                    </li>
                                </ul>
                                <hr>


                            @else
                                <ul style="margin-top: 29px " class=" list-unstyled">

                                    <li>
                                        <label><input type="hidden" name="to_add[{{$i}}]" value="0"><input
                                                    type="checkbox" name="to_add[{{$i}}]"
                                                    value="1"/>
                                                    إضافة نماذج على الفئة

                                                </label>

                                    </li>
                                    <li>
                                        <label><input type="hidden" name="to_edit[{{$i}}]" value="0"><input
                                                    type="checkbox" name="to_edit[{{$i}}]"
                                                    value="1"/>
                                            {{-- تعديل فئات غير مناسبة لنماذج الفئة --}}
                                            امكانية معالجة النموذج
                                        </label>

                                    </li>


                                    <li>
                                        <label><input type="hidden" name="to_stop[{{$i}}]" value="0"><input
                                                    type="checkbox" name="to_stop[{{$i}}]"
                                                    value="1"/>
                                                    ايقاف (اغلاق النموذج)</label>

                                    </li>
                                    <li>
                                        <label><input type="hidden" name="to_replay[{{$i}}]" value="0"><input
                                                    type="checkbox" name="to_replay[{{$i}}]"
                                                    value="1"/>
                                            الرد على النموذج</label>

                                    </li>
                                    <li>
                                        <label><input type="hidden" name="to_notify[{{$i}}]" value="0"><input
                                                    type="checkbox" name="to_notify[{{$i}}]"
                                                    value="1"/>
                                            اشعارا بأحداث نماذج الفئة</label>

                                    </li>
                                    <li>
                                        <label><input type="hidden" name="to_delete[{{$i}}]" value="0"><input
                                                    type="checkbox" name="to_delete[{{$i}}]"
                                                    value="1"/>
                                            حذف نماذج الفئة</label>

                                    </li>
                                </ul>

                            @endif
                        </li>

                           <?php $i++?>
                    @endif
                    @endforeach
                </ul>

            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-5">
                <input type="submit" class="btn btn-success" value="حفظ" />
                <a href="/account/circle" class="btn btn-light">الغاء الامر</a>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(function(){

            $(":checkbox").click(function(){
                $(this).parent().nextAll().find(":checkbox").prop("checked",$(this).prop("checked"));
                $(this).parents("ul").each(function(){
                    $(this).prevAll().find(":checkbox").prop("checked",$(this).find(":checked").size()>0);
                });
            });
//
            //
        });
    </script>
@endsection
