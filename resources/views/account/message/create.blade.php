@extends("layouts._account_layout")
@section("title", "تعريف الرسائل النصية (SMS)")
@section("content")
    <div class="col-md-12">
        <h4>هذه الواجهة مخصصة للتحكم في تعريف الرسائل النصية (SMS) في النظام.</h4>
    </div>

    <div class="col-sm-12">
        <br>
        <button type="button" style="width:50px;margin-left: 10px;" class="btn btn-primary msg-btn">
            <span class="icon-plus" aria-hidden="true"></span>
        </button>
        يمكنك تعريف الرسائل النصية التي يقوم النظام بإرسالها من خلال التالي:
    </div>

    <div class="col-sm-12 msg">
        <br>
        <br>
        <form method="post" action="/account/message/store" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="message_name" class="col-form-label">نوع الرسالة: </label>
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control" value="" id="name" name="name">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="text" class="col-form-label">نص الرسالة:</label>
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control" onkeyup="countChar(this);" value="" id="message_text" name="text">
                </div>

            </div>

{{--            <div class="form-group row">--}}
{{--                <div class="col-sm-4">--}}
{{--                    <label for="send_procedure" class="col-form-label">آلية الإرسال:</label>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6">--}}
{{--                    <select name="send_procedure" class="form-control">--}}
{{--                        <option value="" >آلية الإرسال</option>--}}
{{--                        <option value="تلقائي" >تلقائي</option>--}}
{{--                        <option value="يدوي">يدوي</option>--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--            </div>--}}
            <br>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="" class="col-form-label">تفاصيل ذات علاقة بحجم الرسالة:</label>
                </div>

                <div class="col-sm-2" style="margin-right: 15px;margin-left: 10px;padding:5px;border-radius: 5px;border: 1px solid red;">
                    <label for="Remaining_letters" class="col-form-label">عدد الرسائل :</label>
                    <span id="count_of_letter" style="color:red;" name="count_of_letter">0</span>
                    <input type="hidden" id="hidden_count_of_letter" name="count_of_letter">
                </div>

                <div class="col-sm-2" style="margin-left: 10px;padding:5px;border-radius: 5px;border: 1px solid gray;">
                    <label for="Remaining_letters" class="col-form-label">الحروف المتبقية :</label>
                    <span id="charNum" style="color:red;" name="Remaining_letters">0</span>
                    <input type="hidden"  id="hidden_Remaining_letters" name="Remaining_letters">
                </div>

                <div class="col-sm-2" style="margin-left: 10px;padding:5px;border-radius: 5px;border: 1px solid yellow;">
                    <label for="consumed_letters" class="col-form-label">الحروف المستهلكة :</label>
                    <span id="count_of_letters" style="color:red;" name="consumed_letters">0</span>
                    <input type="hidden"  id="hidden_consumed_letters" name="consumed_letters">

                </div>

            </div>
            <br>
            <div class="form-group row" style="float:left;margin-bottom: 10px;">
                <input type="submit" class="btn btn-success" value="إضافة"/>
                <a href="events" class="btn btn-light">الغاء الامر</a>
            </div>
        </form>
    </div>

    <div class="clearfix"></div>
    <br><hr>
    @if($items)
        @if($items->count()>0)

            <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th style="max-width: 30px;word-break: normal;">#</th>
                        <th style="max-width: 100px;word-break: normal;">نوع الرسالة</th>
                        <th style="max-width: 200px;word-break: normal;"> نص رسالة</th>
                        <th style="word-break: normal;" colspan="3">تفاصيل ذات علاقة بالرسالة</th>
                        <th style="word-break: normal;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $a)

                        @if($a->id)
                            <tr>
                                <td style="word-break: normal;">{{$a->id}}</td>
                                <td style="word-break: normal;">{{$a->name }}</td>
                                <td style="max-width:200px;word-break: normal;">{{$a->text}}</td>
                                <td style="word-break: normal;" colspan="3">
                                    <div class="col-sm-3" style="margin-right: 15px;margin-left: 10px;padding:5px;border-radius: 5px;border: 1px solid red;">
                                        <label for="Remaining_letters" class="col-form-label">عدد الرسائل :</label>
                                        <span id="count_of_letter" style="color:red;" name="count_of_letter">{{$a->count_of_letter}}</span>
                                    </div>

                                    <div class="col-sm-3" style="margin-left: 10px;padding:5px;border-radius: 5px;border: 1px solid gray;">
                                        <label for="Remaining_letters" class="col-form-label">الحروف المتبقية :</label>
                                        <span id="charNum" style="color:red;" name="Remaining_letters">{{$a->Remaining_letters}}</span>
                                    </div>

                                    <div class="col-sm-4" style="margin-left: 10px;padding:5px;border-radius: 5px;border: 1px solid yellow;">
                                        <label for="consumed_letters" class="col-form-label">الحروف المستهلكة :</label>
                                        <span id="count_of_letters" style="color:red;" name="consumed_letters">{{$a->consumed_letters}}</span>

                                    </div>
                                </td>

                                <td>
                                    @if(Auth::user()->account->circle_id==1)
                                        <a class="btn btn-xs btn-primary" title="تعديل"
                                           href="/account/message/edit/{{$a->id}}"><i class="fa fa-edit"></i></a>

                                        <a class="btn btn-xs Confirm btn-danger"
                                           href="/account/message/delete/{{$a->id}}"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                </td>

                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            <br>
            <br>
        @else
            <br><br>
            <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
        @endif
    @else
        <br>
        <br>
        <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th style="max-width: 30px;word-break: normal;">#</th>
                    <th style="max-width: 100px;word-break: normal;">نوع الرسالة</th>
                    <th style="max-width: 100px;word-break: normal;"> نص رسالة</th>
                    <th style="word-break: normal;" colspan="2">تفاصيل ذات علاقة بالرسالة</th>
                </tr>
                </thead>
            </table>
    @endif



@endsection

@section('js')
    <script src="https://unpkg.com/vue"></script>
    <script src="http://code.jquery.com/jquery-1.5.js"></script>
    <script>
        $('.msg').hide();
        $('.msg-btn').click(function () {

            $('.msg').slideToggle("fast", function () {
                if ($('.msg').is(':hidden')) {
                    $('#searchonly').show();
                } else {
                    $('#searchonly').hide();
                }
            });
        });


    </script>
    <script>
        function countChar(val) {
            var message = 70;
            var len = val.value.length;
            $('#count_of_letters').text(len);
            $('#hidden_consumed_letters').val(len);
            if(len <= message && len != 0){
                $('#count_of_letter').text(1);
                $('#hidden_count_of_letter').val(1);
                $('#charNum').text(message - len);
                $('#hidden_Remaining_letters').val(message - len);
            }else if(len <= message*2 && len != 0){
                $('#count_of_letter').text(2);
                $('#hidden_count_of_letter').val(2);
                $('#charNum').text(message*2 - len);
                $('#hidden_Remaining_letters').val(message*2 - len);
            }else if(len <= message*3 && len != 0){
                $('#count_of_letter').text(3);
                $('#hidden_count_of_letter').val(3);
                $('#charNum').text(message*3 - len);
                $('#hidden_Remaining_letters').val(message*3 - len);
            }else{
                $('#count_of_letter').text(4);
                $('#hidden_count_of_letter').val(4);
                $('#charNum').text(message*4 - len);
                $('#hidden_Remaining_letters').val(message*4 - len);
            }

        }
    </script>
@endsection
