@extends("layouts._account_layout")

@section("title", "اضافة فئة اقتراح/شكوى جديدة")
@section('css')
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
@endsection
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
            <form action="/account/category" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <div class="col-md-2">
                                <label>اضافة فئة فرعية جديدة</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="اضافة فئة فرعية جديدة" name="name"
                                       value="" id="name">
                            </div>
                        </div>

                        <div class="col-md-12"></div>
                        <br><br>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label>نوع الفئة</label>
                            </div>
                            <div class="col-md-4">
                                <select name="is_complaint" class="form-control" id="is_complaint">
                                    <option value="">نوع الفئة</option>
                                    <option value="0">اقتراح</option>
                                    <option value="1">شكوى</option>
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
                                <select class="form-control" class="col-md-12" name="main_category_id" id="main_category_id">
                                    <option value="">الفئات الرئيسية</option>
                                    @foreach($mainCategories as $category)
                                        <option
                                            value="{{$category->id}}" {{old('main_category_id') ==$category->id ? 'selected' : ''}} >  {{$category->name}} </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="main_suggest_id" id="main_suggest_id" value="{{old('main_category_id')}}">
                            </div>
                        </div>

                        <div class="col-md-12"></div>
                        <br><br>

                        <div class="form-group">
                            <div class="col-md-4">
                                <label>فئة مقدم الاقتراح/ الشكوى</label>
                            </div>
                            <div class="col-md-12"></div><br><br>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"  id="citizen_show" name="citizen_show" value="1">
                                <label class="form-check-label" for="citizen_show">
                                    غير مستفيد من مشاريع المركز
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"  id="benefic_show" name="benefic_show" value="1">
                                <label class="form-check-label" for="citizen_show">

                                    مستفيد من مشاريع المركز
                                </label>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-check">

                    <div class="col-md-12"></div>
                    <br><br>
                    <input id="editLevelCheck2" type="checkbox" name="editLevel" value="editLevel"
                           onclick="editLevel2()">
                    <label for="editLevel" style="vertical-align: middle;">اضافة المستويات الإدارية المختصة في التعامل
                        مع هذه الفئة</label>
                </div>
                <br>

                <div class="mt-3"></div>
             
                <div class="table-responsive" id="editLevelTable2" style="display:none;">
                    <table style="width:185% !important;max-width:185% !important;white-space:normal;" class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="max-width: 100px;word-break: normal;">الفئة الرئيسية</th>
                            <th style="max-width: 100px;word-break: normal;">الفئة الفرعية</th>
                            <th colspan="2" style="max-width: 100px;word-break: normal;">نوع الإجراء</th>
                            @foreach($circles as $circle)
                                <th style="max-width: 100px;word-break: normal;">{{$circle->name}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td  colspan="1" rowspan="6" scope="col" style="word-break: normal;" id="maincat"></td>
                            <td  colspan="1" rowspan="6" scope="col" style="word-break: normal;" id="subcat"></td>
                        </tr>
                        @foreach($procedureTypes as $procedureType)
                            <tr>
                                @if($procedureType->id != 2 && $procedureType->id != 3)
                                    <td colspan="2" style="word-break: normal;" id="{{$procedureType->id}}">{{$procedureType->name}}</td>
                                @else
                                    <td  style="word-break: normal;">الجهات المختصة بمعالجة الشكوى</td>
                                    <td  style="word-break: normal;" id="{{$procedureType->id}}">{{$procedureType->name}}</td>
                                @endif
                                @foreach($circles as $circle)
                                    <td style="text-align:center;max-width: 100px;word-break: normal;">
                                        <input type="checkbox" name="category_circle[]" value="{{$procedureType->id.'_'.$circle->id}}">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="form-actions" style="
    text-align: center;">
                    <input type="submit" class="btn btn-success" value="حفظ">
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

            $('#subcat').text($('#name').val());
            $('#maincat').text($('#main_category_id option:selected').text());
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


        $("#is_complaint").change(function () {
            var is_complaint = $("#is_complaint").val();
            route = '/account/category/get_categories/'+ is_complaint;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: route,
                dataType : 'json',
                type: 'POST',
                data: {},
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response)
                    $("#main_category_id").empty();
                    $("#main_category_id").append("<option value=''>الفئات الرئيسية</option>");
                    $.each(response, function (key, value) {
                        $("#main_category_id").append('<option value="' + value.id + '">' + value.name + '</option>');

                    });
                }
            });
        });

    </script>

    <script>
        const table = document.querySelector('table');

        let headerCell = null;

        for (let row of table.rows) {
            const firstCell = row.cells[0];

            if (headerCell === null || firstCell.innerText !== headerCell.innerText) {
                headerCell = firstCell;
            } else {
                headerCell.rowSpan++;
                headerCell.style = "vertical-align: middle";
                firstCell.remove();
            }
        }
    </script>
@endsection
