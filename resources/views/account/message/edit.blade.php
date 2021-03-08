@extends("layouts._account_layout")
@section("title", "تعديل الرسائل النصية")
@section("content")
    <div class="col-md-12">
        <h4>هذه الواجهة مخصصة للتحكم في تعديل الرسائل النصية (SMS) في النظام.</h4>
    </div>

    <div class="col-sm-12">
        <br>
        يمكنك تعديل الرسائل النصية التي يقوم النظام بإرسالها من خلال التالي:
    </div>

    <br>

    <div class="col-sm-12">
        <br>
        <br>
        <form method="post" action="/account/message/update/{{$item->id}}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="message_name" class="col-form-label">نوع الرسالة: </label>
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control" value="{{$item->name}}" id="name" name="name">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="text" class="col-form-label">نص الرسالة:</label>
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control" onkeyup="countChar(this);" value="{{$item->text}}" id="message_text"
                           name="text">
                </div>

            </div>
            <br>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="" class="col-form-label">تفاصيل ذات علاقة بحجم الرسالة:</label>
                </div>

                <div class="col-sm-2"
                     style="margin-right: 15px;margin-left: 10px;padding:5px;border-radius: 5px;border: 1px solid red;">
                    <label for="Remaining_letters" class="col-form-label">عدد الرسائل :</label>
                    <span id="count_of_letter" style="color:red;" name="count_of_letter">{{$item->count_of_letter}}</span>
                    <input type="hidden" id="hidden_count_of_letter" name="count_of_letter">
                </div>

                <div class="col-sm-2" style="margin-left: 10px;padding:5px;border-radius: 5px;border: 1px solid gray;">
                    <label for="Remaining_letters" class="col-form-label">الحروف المتبقية :</label>
                    <span id="charNum" style="color:red;" name="Remaining_letters">{{$item->Remaining_letters}}</span>
                    <input type="hidden" id="hidden_Remaining_letters" name="Remaining_letters">
                </div>

                <div class="col-sm-2"
                     style="margin-left: 10px;padding:5px;border-radius: 5px;border: 1px solid yellow;">
                    <label for="consumed_letters" class="col-form-label">الحروف المستهلكة :</label>
                    <span id="count_of_letters" style="color:red;" name="consumed_letters">{{$item->consumed_letters}}</span>
                    <input type="hidden" id="hidden_consumed_letters" name="consumed_letters">
                </div>

            </div>
            <br>
            <div class="form-group row" style="float:left;margin-bottom: 10px;">
                <input type="submit" class="btn btn-success" value="تعديل"/>
                <a href="events" class="btn btn-light">الغاء الامر</a>
            </div>

        </form>
    </div>

@endsection

@section('js')
    <script src="https://unpkg.com/vue"></script>
    <script src="http://code.jquery.com/jquery-1.5.js"></script>
    <script>
        function countChar(val) {
            var message = 70;
            var len = val.value.length;
            $('#count_of_letters').text(len);
            $('#hidden_consumed_letters').val(len);
            if (len <= message && len != 0) {
                $('#count_of_letter').text(1);
                $('#hidden_count_of_letter').val(1);
                $('#charNum').text(message - len);
                $('#hidden_Remaining_letters').val(message - len);
            } else if (len <= message * 2 && len != 0) {
                $('#count_of_letter').text(2);
                $('#hidden_count_of_letter').val(2);
                $('#charNum').text(message * 2 - len);
                $('#hidden_Remaining_letters').val(message * 2 - len);
            } else if (len <= message * 3 && len != 0) {
                $('#count_of_letter').text(3);
                $('#hidden_count_of_letter').val(3);
                $('#charNum').text(message * 3 - len);
                $('#hidden_Remaining_letters').val(message * 3 - len);
            } else {
                $('#count_of_letter').text(4);
                $('#hidden_count_of_letter').val(4);
                $('#charNum').text(message * 4 - len);
                $('#hidden_Remaining_letters').val(message * 4 - len);
            }

        }
    </script>
@endsection
