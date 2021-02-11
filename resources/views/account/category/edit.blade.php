@extends("layouts._account_layout")

@section("title", "تعديل فئة اقتراح/شكوى")

<?php
$name = "";
$main = "";
if($item->is_complaint == 1){
    $name =$item->parentCategory->name;
    $main = $item->main_category_id;
}else{
    $name =$item->parentSuggest->name;
    $main = $item->main_suggest_id;
}

$Cat = [];
foreach ($CategoryCircles as $CategoryCircle){
    array_push($Cat,$CategoryCircle->procedure_type.'_'.$CategoryCircle->circle);
}


?>

@section("content")
    <div class="row">
        <div class="col-md-12">
            <h4>
                هذه الواجهة مخصصة للتحكم في إضافة فئات الاقتراحات والشكاوى الجديدة والمستويات الإدارية في التعامل معها.
            </h4>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12" id="app">
            <form method="post" enctype="multipart/form-data" action="/account/category/update/{{$item->id}}">
                @csrf
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <div class="col-md-2">
                                <label>اضافة فئة فرعية جديدة</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="اضافة فئة فرعية جديدة" name="name"
                                       value="{{$item->name}}">
                            </div>
                        </div>

                        <div class="col-md-12"></div>
                        <br><br>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label>نوع الفئة</label>
                            </div>
                            <div class="col-md-4">
                                <select name="is_complaint" class="form-control">
                                    <option value="">نوع الفئة</option>
                                    <option value="0" {{$item->is_complaint == 0 ? 'selected' : ''}}>اقتراح</option>
                                    <option value="1" {{$item->is_complaint == 1 ? 'selected' : ''}}>شكوى</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12"></div>
                        <br><br>

                        <div class="form-group">
                            <div class="col-md-2">
                                <label>اسم الفئة الرئيسية </label>
                            </div>

                            <div class="col-md-4">
                                <select class="form-control" class="col-md-12" name="main_category_id">
                                    <option value="{{$item->main_category_id}}">الفئات الرئيسية</option>
                                    @foreach($mainCategories as $category)
                                        <option
                                            value="{{$category->id}}" {{$main ==$category->id ? 'selected' : ''}} >  {{$category->name}} </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="main_suggest_id" id="main_suggest_id" value="{{$main}}">

                            </div>
                        </div>

                        <div class="col-md-12"></div>
                        <br><br>

                        <div class="form-group">
                            <div class="col-md-4">
                                <label>فئة مقدم الاقتراح/ الشكوى</label>
                            </div>
                            <div class="col-md-12"></div><br><br>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="citizen_show" type="hidden" value="0">
                                    <input class="form-check-input" :checked="{{$item->citizen_show}}"  type="checkbox" id="citizen_show"
                                           name="citizen_show" v-model="citizen_show">
                                    <label class="form-check-label" for="citizen_show">
                                        غير مستفيد من مشاريع المركز
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-12">

                                <div v-if="citizen_show">
                                    <hr>
                                    <div v-cloak class="form-group">
                                        <label for="code">رسالة تأكيد الإرسال لغير المستفيد</label>
                                        <textarea class="form-control" id="details" name="citizen_msg">
                {{$item->citizen_msg}}
            </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>اقصى مدة للرد على غير المستفيد</label>
                                        <input type="number" class="form-control" placeholder="المدة" name="citizen_wait"
                                               value="{{$item->citizen_wait}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="benefic_show" type="hidden" value="0">
                                    <input class="form-check-input" :checked="{{$item->benefic_show}}"  type="checkbox" id="benefic_show"
                                           name="benefic_show" v-model="benefic_show">
                                    <label class="form-check-label" for="benefic_show">

                                        مستفيد من مشاريع المركز
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-12">

                                <div v-if="benefic_show">
                                    <hr>
                                    <div v-cloak class="form-group">
                                        <label for="code">رسالة تأكيد الإرسال للمستفيد</label>
                                        <textarea class="form-control" id="details" name="benefic_msg">
                           {{$item->benefic_msg}}
                         </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>اقصى مدة للرد على المستفيد</label>
                                        <input type="number" class="form-control" placeholder="المدة" name="benefic_wait"
                                               value="{{$item->benefic_wait}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-check">

                    <div class="col-md-12"></div>
                    <br><br>
                    <input id="editLevelCheck2" type="checkbox" name="editLevel" value="editLevel"
                           onclick="editLevel2()" @if($CategoryCircles) {{'checked'}} @endif >
                    <label for="editLevel" style="vertical-align: middle;">اضافة المستويات الإدارية المختصة في التعامل
                        مع هذه الفئة</label>
                </div>
                <br>

                <div class="mt-3"></div>
                <div class="table-responsive" id="editLevelTable2">
                    <table style="width:185% !important;max-width:185% !important;white-space:normal;" class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="max-width: 100px;word-break: normal;">الفئة الرئيسية</th>
                            <th style="max-width: 100px;word-break: normal;">الفئة الفرعية</th>
                            <th style="max-width: 100px;word-break: normal;">نوع الإجراء</th>
                            @foreach($circles as $circle)
                                <th style="max-width: 100px;word-break: normal;">{{$circle->name}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td  colspan="1" rowspan="5" scope="col" style="word-break: normal;" id="maincat">{{$name}}</td>
                            <td  colspan="1" rowspan="5" scope="col" style="word-break: normal;" id="subcat">{{$item->name}}</td>
                        </tr>
                        @foreach($procedureTypes as $procedureType)
                            <tr>
                                <td style="word-break: normal;" id="{{$procedureType->id}}">{{$procedureType->name}}</td>
                                @foreach($circles as $circle)
                                    <td  style="text-align:center;max-width: 100px;word-break: normal;">
                                        <input type="checkbox" name="category_circle[]" value="{{$procedureType->id.'_'.$circle->id}}" @if(in_array($procedureType->id.'_'.$circle->id,$Cat)) {{'checked'}} @endif>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <br>
                <br>
                <br>
                <div class="form-actions" style="
    text-align: center;">
                    <input type="submit" class="btn btn-success" value="تعديل">
                    <a type="button" href="/account/category" class="btn btn-light">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                benefic_show: false,
                citizen_show: false,
            },
        });

        function editLevel2() {
            // Get the checkbox
            var checkBox = document.getElementById("editLevelCheck2");
            // Get the output text
            var text = document.getElementById("editLevelTable2");

            // If the checkbox is checked, display the output text
            if (checkBox.checked == true) {
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }
    </script>
    <script>
        $('#main_category_id').change(function () {
            $('#main_suggest_id').val($('#main_category_id').val());
        });
    </script>
@endsection
