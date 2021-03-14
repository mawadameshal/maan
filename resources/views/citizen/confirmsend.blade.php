@extends("layouts._citizen_layout")

@section("title", "اضافة نموذج ")


@section("content")
    <div class="row">
        <div class="col-sm-12">
            <h1 style="margin-top:120px;margin-bottom:20px;text-align: center;"> تم الإرسال<hr class="h1-hr"></h1>
        </div>
    </div>
    <div class="row">
       <div class="col-sm-12">
           <h4 class="text-center"> لقد تم ارسال الطلب الخاص بكم ومرفق لكم المعلومات الخاصة بطلبكم</h4>
       </div>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
        <tr style="background-color:#67647E">
            <th style="text-align: center;color:#ffffff">رقم الطلب</th>
            <th colspan="2" style="text-align: center;color:#ffffff">اسم المواطن</th>
            <th style="text-align: center;color:#ffffff">رقم الهوية</th>
            <th style="text-align: center;color:#ffffff">نوع الطلب المقدم</th>
            @if($form->type==1)
                <th style="text-align: center;color:#ffffff">فئة الشكوى</th>@endif
            <th style="text-align: center;color:#ffffff">تاريخ الارسال</th>
        </tr>
        </thead>
        <tbody>
        <tr style="background-color:white">
            <td style="text-align: center;"> 00970{{$form->id}}</td>
            <td colspan="2"
                style="text-align: center;">{{$form->citizen->first_name}} {{$form->citizen->father_name}} {{$form->citizen->grandfather_name}} {{$form->citizen->last_name}}</td>
            <td style="text-align: center;">{{$form->citizen->id_number}}</td>
            <td style="text-align: center;">{{$form->form_type->name}}</td>
            @if($form->type==1)
                <td style="text-align: center;">{{$form->category->name}}</td>@endif
            <td style="text-align: center;">{{$form->datee}}</td>
        </tr>
        <tr>
            <td colspan="7" style="text-align:right;height:200px;width:200px;border:none; ">
                <h5><B>عنوان الموضوع:</B>
                    {{$form->title}}</h5>
                <br>
                <h5>
                    <B>محتوى الموضوع:</B>
                </h4><br>
                <h5 style="max-width: 600px; word-wrap:break-word; white-space: normal;">
                    {{$form->content}}
                </h5>
            </td>
        </tr>
        </tbody>
    </table>
    <br>
            <h4 style="color:red;">  * يرجى الانتباه انه بإمكانكم مراجعة المركز او الموقع من خلال رقم الطلب , او رقم الهوية<h4>
<br>
    <div class="form-group row" align="center">
        <div class="col-sm-3"></div>

        <div class="col-sm-6">
            <a style="color:#ffffff;" href='javascript:window.print();'>
                <button style="background-color:#67647E ;" class="btn btn-primary"> أخذ صورة عن
                    {{$form->form_type->name}}
                </button>
            </a>
            <a style="color:#fff;text-decoration:none;" href="/">
                <button class="btn btn-danger">الرجوع إلى الصفحة الرئيسية</button>
            </a>

            <a style="color:#af0922;text-decoration:none;"
               href="/citizen/form/show/{{$form->citizen->id_number}}/{{$form->id}}">
                <button style="background-color:#A8A8A8;" class="btn btn-primary">
                    متابعة النموذج
                </button>
            </a>
        </div>
        <div class="col-sm-3"></div>

    </div>
    </div>
    <!--*************************************************POPuP  **********************************************************************-->
    <!--HTML  -->
    <div class="container">

    </div>
    <!-- use this for popup-->
    <div id="boxes">
        <div style="top: 199.5px; left: 551.5px; display: none;color:#af0922;" id="dialog" class="window">
            <img width="15%" src="{{asset("/green.png")}}">

                 <h3 style="font-weight:600;">تم الإرسال بنجاح </h3>
                 <h6 style="font-size:18px;"> رقم الطلب : 00970{{$form->id}}</h6>
        <br>
            <div id="lorem" style="color:black;text-align: center;" ;>

                <p style="margin-left:30px;text-align:center;font-size:18px;text-indent:25px; ">
                    @if($form->project_id == 1)
                        {{$form->category->citizen_msg}}
                    @else
                        {{$form->category->benefic_msg}}
                    @endif
                    سيتم الرد عليكم خلال
                    @if($form->project_id == 1)
                        {{$form->category->citizen_wait}}
                    @else
                        {{$form->category->benefic_wait}}
                    @endif
                    يوم/أيام
                </p>
                <p  style="font-size:16px;text-align: center;">في حال لم تتلقى أي رد خلال هذه المدة</p>
                <p style="font-size:16px;text-align: center;"> يمكنكم التواصل مع المركز من خلال الرقم </p>
                <p style="font-size:16px;text-align: center;"> المجاني التالي </p>
                <b style="font-size:24px;color:red;text-align: center;">{{$itemco->free_number}}</b>
            </div>
            <div id="popupfoot"><a href="http://webenlance.com/" class="close btn btn-danger" style="float: none;
    font-size: 16px;
    font-weight: 400;
    color: #fff;
    opacity: 1;">
                    <span>إغلاق</span></a></div>
        </div>
        <div style="width: 1478px; font-size: 32pt; color:white; height:760px; display: none; opacity: 0.8;"
             id="mask"></div>
    </div>

    <!--CSS  -->
    <style>
        #mask {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 9000;
            background-color: #000;
            display: none;
        }

        #boxes .window {
            position: absolute;
            left: 0;
            top: 0;
            width: 440px;
            height: 200px;
            display: none;
            z-index: 9999;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }

        #boxes #dialog {
            width: 450px;
            height: auto;
            padding: 10px;
            background-color: #ffffff;
            font-family: 'Segoe UI Light', sans-serif;
            font-size: 15pt;
        }

        .maintext {
            text-align: center;
            font-family: "Segoe UI", sans-serif;
            text-decoration: none;
        }

        body {
            background: url('bg.jpg');
        }

        #lorem {
            font-family: "Segoe UI", sans-serif;
            font-size: 12pt;
            text-align: left;
        }

        #popupfoot {
            font-family: "Segoe UI", sans-serif;
            font-size: 16pt;
            padding: 10px 20px;
        }

        #popupfoot a {
            text-decoration: none;
        }

        .agree:hover {
            background-color: #D1D1D1;
        }

        .popupoption:hover {
            background-color: #D1D1D1;
            color: green;
        }

        .popupoption2:hover {

            color: red;
        }
    </style>
    <!--java script  -->
    <script>
        var id = '#dialog';

        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();

        //Set heigth and width to mask to fill up the whole screen
        $('#mask').css({'width': maskWidth, 'height': maskHeight});

        //transition effect
        $('#mask').fadeIn(500);
        $('#mask').fadeTo("slow", 0.9);

        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();

        //Set the popup window to center
        $(id).css('top', winH / 2 - $(id).height() / 2);
        $(id).css('left', winW / 2 - $(id).width() / 2);

        //transition effect
        $(id).fadeIn(2000);

        //if close button is clicked
        $('.window .close').click(function (e) {
            //Cancel the link behavior
            e.preventDefault();

            $('#mask').hide();
            $('.window').hide();
        });

        //if mask is clicked
        $('#mask').click(function () {
            $(this).hide();
            $('.window').hide();
        });

    </script>
    <!--****************************************************** start footer ********************************************************************-->
@endsection
