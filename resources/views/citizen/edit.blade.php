@extends("layouts._citizen_layout")

@section('css')
    <style>
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: right;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active, .accordion:hover {
            background-color: #ccc;
        }

        .accordion:after {
            content: '\002B';
            color: #777;
            font-weight: bold;
            float: left;
            margin-left: 5px;
        }

        .active:after {
            content: "\2212";
        }

        .panel {
            padding: 0 18px;
            background-color: white;
            /*max-height: 0;*/
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }
    </style>
@endsection

@section("title", "متابعة نموذج ")

@section("content")

    <div class="row">
        <div class="col-md-12">
            @if($project_id != 1)
                <h1 class="wow bounceIn" style="color:#af0922;margin-top:120px;"> أهلاً بك عزيزي {{$citizen["full_name"]}}</h1>
            @else
                <h1 class="wow bounceIn" style="color:#af0922;margin-top:120px;"> أهلاً بك عزيزي المواطن</h1>
            @endif
        </div>
        @if($type == 1)
        <div class="col-md-12">
            <h4>الرجاء القيام بشرح الشكوى/ المشكلة التي تواجهها مع التأكيد على أنه سيتم التعامل مع المعلومات التي ستقدمها بكل جدية وبسرية تامة.</h4>
        </div>
        @else
            <div class="col-md-12">
                <h4>            نسعد باستقبال مقترحاتكم بما يساهم في تحسين الخدمات التي يقدمها المركز، يرجى التفضل بتوضيح مقترحاتكم.
                </h4>
            </div>
        @endif
    </div>
    <hr>

    <div class="row" style="" id="app">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div style="display: inline-flex;margin-top:15px;margin-bottom:25px">
                        <div style="width: 3px;height: 20px;background-color: #BE2D45;margin-left: 5px;"></div>
                        <span>هذه الحقول إجبارية</span>
                    </div>
                    <br>
                </div>
            </div>
            <h4>
                أولاً: معلوماتك الأساسية:
            </h4>
            <div class="panel">
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" class="form-horizontal" id="form1" action="/citizen/saveolde/{{$citizen['id']}}">
                            @method('patch')
                            @csrf
                            <input type="hidden" name="type" value="{{$type}}">
                            <input type="hidden" name="project_id" value="{{$project_id}}">

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label for="first_name"  class="col-sm-4 col-form-label">الاسم الأول</label>
                                    <input class="form-control {{($errors->first('first_name') ? " form-error" : "")}}" type="text"  value="{{$citizen["first_name"]}}" id="first_name" name="first_name" autocomplete="off">
                                    {!! $errors->first('first_name', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>

                                <div class="col-sm-6">
                                    <label for="father_name"  class="col-sm-4 col-form-label">اسم الأب</label>
                                    <input class="form-control {{($errors->first('father_name') ? " form-error" : "")}}" type="text"  value="{{$citizen["father_name"]}}" id="father_name" name="father_name">
                                    {!! $errors->first('father_name', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>

                            </div>
                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label for="grandfather_name"  class="col-sm-4 col-form-label">اسم الجد</label>
                                    <input class="form-control {{($errors->first('grandfather_name') ? " form-error" : "")}}" type="text"  value="{{$citizen["grandfather_name"]}}" id="grandfather_name" name="grandfather_name" autocomplete="off">
                                    {!! $errors->first('grandfather_name', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>
                                <div class="col-sm-6">
                                    <label for="last_name"  class="col-sm-4 col-form-label">اسم العائلة</label>
                                    <input class="form-control {{($errors->first('last_name') ? " form-error" : "")}}" type="text"  value="{{$citizen["last_name"]}}" id="last_name" name="last_name">
                                    {!! $errors->first('last_name', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>


                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="id_number"  class="col-sm-4 col-form-label">رقم الهوية/جواز السفر</label>
                                    <input class="form-control {{($errors->first('id_number') ? " form-error" : "")}}" readonly type="number"  value="{{$citizen["id_number"]}}" id="id_number" name="id_number" autocomplete="off">
                                    {!! $errors->first('id_number', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>

                                <div class="col-sm-6">
                                    <label for="mobile"  class="col-sm-4 col-form-label">رقم التواصل (1)</label>
                                    <input class="form-control {{($errors->first('mobile') ? " form-error" : "")}}"  type="tel" maxlength="10" onchange="phonenumber($('#mobile').val(),1)" value="{{$citizen["mobile"]}}" id="mobile" name="mobile">
                                    <span id="lblError1" style="color: red"></span>
                                    {!! $errors->first('mobile', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>




                            </div>
                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label for="mobile2"  class="col-sm-4 col-form-label">رقم التواصل (2)</label>
                                    <input class="form-control {{($errors->first('mobile2') ? " form-error" : "")}}" type="tel"
                                            value="{{$citizen["mobile2"]}}" maxlength="10" id="mobile2" name="mobile2" onchange="phonenumber($('#mobile2').val(),2)">
                                    <span id="lblError2" style="color: red"></span>
                                    {!! $errors->first('mobile2', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>

                                <div class="col-sm-6">
                                    <label for="governorate" class="col-sm-4 col-form-label">المحافظة</label>
                                    <select  class="form-control {{($errors->first('governorate') ? " form-error" : "")}}" id="sel1" name="governorate">
                                        <option value="">اختر</option>
                                        <option value="الشمال" {{$citizen['governorate']=='الشمال'?"selected":""}}>الشمال</option>
                                        <option value="غزة" {{$citizen['governorate']=='غزة'?"selected":""}}>غزة</option>
                                        <option value="الوسطى" {{$citizen['governorate']=='الوسطى'?"selected":""}}>الوسطى</option>
                                        <option value="خانيونس" {{$citizen['governorate']=='خانيونس'?"selected":""}}>خانيونس</option>
                                        <option value="رفح" {{$citizen['governorate']=='رفح'?"selected":""}}>رفح</option>
                                    </select>
                                    {!! $errors->first('governorate', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>

                            </div>
                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label for="city"  class="col-sm-4 col-form-label">المنطقة</label>
                                    <input class="form-control {{($errors->first('city') ? " form-error" : "")}}" type="text" value="{{$citizen["city"]}}"  id="city" name="city" autocomplete="off">
                                    {!! $errors->first('city', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>

                                <div class="col-sm-6">
                                    <label for="street"  class="col-sm-4 col-form-label">العنوان</label>
                                    <input class="form-control {{($errors->first('street') ? " form-error" : "")}}" type="text"  value="{{$citizen["street"]}}" id="street" name="street">
                                    {!! $errors->first('street', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>



                            </div>
                            <div class="form-group row">

                                <div class="col-sm-6">
                                    @if($type == 1)
                                        <label for="type_name"  class="col-sm-4 col-form-label">فئة مقدم الشكوى</label>
                                    @elseif($type == 2)
                                        <label for="type_name"  class="col-sm-4 col-form-label">فئة مقدم الاقتراح</label>
                                    @endif

                                    <?php
                                        $project_arr = array();
                                        foreach($citizen->projects as $project){
                                            array_push($project_arr,$project->id);
                                        }
                                    ?>

                                    <input name="type_name" value="@if(in_array($project_id,$project_arr)){{'مستفيد'}}@else{{'غير مستفيد'}}@endif" type="text" readonly class="form-control" >
                                </div>

                                <div class="col-sm-6">
                                    <label for="project_name"  class="col-sm-4 col-form-label">اسم المشروع</label>
                                    <input name="project_name" value="{{$project_code." ".$project_name}}" type="text" readonly class="form-control" >
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
            <h4>
                @if($type == 1)
                    ثانياً: تفاصيل الشكوى:
                @elseif($type == 2)
                   ثانياً: تفاصيل الاقتراح:
                @else
                @endif
            </h4>
            <div class="panel">
                <!--first row  -->
                <style>
                    .form-group.row {
                        display: flex;
                    }
                    .col-form-label{
                        float: right;
                    }
                </style>
                <?php
                if ($type != 1 && $type != 2)  // type compaint of suggestion ...
                    $type = 3;
                ?>
               <br>
                <div style="margin-top:-50px;line-height: 1.8;" class="row">
                    <h5 style="font-size:16px;">
                        @if($type==1)
                            نأسف للازعاج والمشاكل التي تم التسبب بها , الرجاء القيام بشرح المشكلة التي تواجهها , مع العلم أننا سوف
                            نقوم بأخذ مشكلتك على محمل الجد وسيتم الرد عليك في أسرع وقت
                        @elseif($type==2)
                            أخي المواطن ، يمكنك من هناك إرسال للاقتراحات لتحسين خدماتنا ، مع العلم أنه سيتم أخذ الاقتراحات على محمل
                            الجد ومراجعتها
                        @else
                            نفتخر بأننا كنا عند حسن ظنكم يمكنكم من خلال هذا النموذج ارسال رسائل الشكر للقائمين على خدمات المواطنين
                        @endif
                    </h5>

{{--                    @if(auth()->user())--}}
{{--                        <br>--}}
{{--                        <h4><B>المواطن : </B>{{$citizen_name}}</h4>--}}
{{--                        <h4><B>المشروع : </B>{{$project_name}}</h4>--}}
{{--                    @endif--}}

                </div>

                <div class="row">
                    <div class="col-sm-12">
                        @if(Session::get("msg"))
                            <?php
                            $msg = Session::get("msg");
                            $msgClass = "alert-info";
                            $first2letters = strtolower(substr($msg, 0, 2));
                            if ($first2letters == "s:") {
                                //قص اول حرفين
                                $msg = substr($msg, 2);
                                $msgClass = "alert-success";
                            } else if ($first2letters == "i:") {
                                $msg = substr($msg, 2);
                                $msgClass = "alert-info";
                            } else if ($first2letters == "w:") {
                                $msg = substr($msg, 2);
                                $msgClass = "alert-warning";
                            } else if ($first2letters == "e:") {
                                $msg = substr($msg, 2);
                                $msgClass = "alert-danger";
                            }
                            ?>
                            <div class="row">
                                <div class="col-sm-3"></div>

                                <div class="col-sm-6">
                                    <div class="alert alert-danger {{$msgClass}} alert-dismissible">
                                        <ul>
                                            <li>{{$msg}} </li>
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>

                            </div>
                        @endif
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <form  id="form2" action="/forms/formsavenew"  method="POST"
                              class="form-horizontal" enctype="multipart/form-data" id="addformid"> @csrf
                            <div class="col-sm-12"><br></div>
                            <input type="hidden" name="project_id" value="{{$project_id}}">
                            <input type="hidden" name="datee" value="<?php echo date("Y/m/d") ?>">
                            <input type="hidden" name="citizen_id" value="{{$citzen_id}}">
                            <input type="hidden" name="type" value="{{$type}}">

                            <!--  -->
                            @if(auth()->user())
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="sent_type"  class="col-sm-4 col-form-label">آلية الاستقبال</label>
                                        <select class="form-control {{($errors->first('sent_type') ? " form-error" : "")}}" id="sent_type_sel1" name="sent_type" onchange="getsent_type()">
                                            <option value=""> اختر آلية الاستقبال</option>
                                            @foreach($sent_typee as $sent_type)
                                                @if($sent_type->id != 1 && $sent_type->id != 6)
                                                    <option value="{{$sent_type->id}}"
                                                            @if(old("sent_type")==$sent_type->name)selected @endif>{{$sent_type->name}}</option>

                                                @endif
                                            @endforeach
                                        </select>
                                        {!! $errors->first('sent_type', '<p class="help-block" style="color:red;">:message</p>') !!}
                                    </div>
                                </div>

                                <div class="form-group row" id="type_of_box_div" style="display: none !important;">
                                    <div class="col-sm-4">
                                        <label for="box_place"  class="col-sm-6 col-form-label">مكان تواجد الصندوق</label>
                                        <input id="box_place" type="text" class="form-control {{($errors->first('box_place') ? " form-error" : "")}}" value="{{old("box_place")}}"
                                               name="box_place">
                                        {!! $errors->first('box_place', '<p class="help-block" style="color:red;">:message</p>') !!}
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="number_of_open_box"  class="col-sm-6 col-form-label">رقم اجتماع فتح الصندوق</label>
                                        <input id="number_of_open_box" type="text" class="form-control {{($errors->first('number_of_open_box') ? " form-error" : "")}}" value="{{old("number_of_open_box")}}"
                                               name="number_of_open_box">
                                        {!! $errors->first('number_of_open_box', '<p class="help-block" style="color:red;">:message</p>') !!}
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="box_place"  class="col-sm-6 col-form-label">تاريخ فتح الصندوق</label>
                                        <input type="text" class="form-control datepicker" name="date_open_box"  value="{{old('date_open_box')}}" />
                                        {!! $errors->first('box_place', '<p class="help-block" style="color:red;">:message</p>') !!}
                                    </div>
                                </div>

                                <div class="form-group row" id="type_of_followup_visit_div" style="display: none !important;">
                                    <div class="col-sm-6">
                                        <label for="type_of_followup_visit"  class="col-sm-4 col-form-label">نوع زيارة  المتابعة</label>
                                        <input id="type_of_followup_visit" type="text" class="form-control {{($errors->first('type_of_followup_visit') ? " form-error" : "")}}" value="{{old("type_of_followup_visit")}}"
                                               name="type_of_followup_visit">
                                        {!! $errors->first('type_of_followup_visit', '<p class="help-block" style="color:red;">:message</p>') !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="datee"  class="col-sm-4 col-form-label">تاريخ تقديم {{$form_type->find($type)->name}}</label>
                                        <input type="text" class="form-control datepicker" name="datee"  value="{{old('datee')}}" />
                                        {!! $errors->first('datee', '<p class="help-block" style="color:red;">:message</p>') !!}
                                    </div>
                                </div>

                            @else
                                <input type="hidden" name="sent_type" value="1">
                            @endif

                            @if($type==1)
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="category_id"  class="col-sm-4 col-form-label">فئة الشكوى</label>
                                        <select id="category" class="form-control {{($errors->first('category_id') ? " form-error" : "")}}" id="sel1" name="category_id">
                                            <option value="">اختر فئة الشكوى </option>
                                            {{$project_id}}
                                            @foreach($category as $cat)
                                                    @if($project_id>1)
                                                        @if($cat->benefic_show==0)
                                                            @continue
                                                        @endif
                                                        @if($cat->is_complaint != 0)
                                                            <option value="{{$cat->id}}"
                                                                    @if(old("category_id")==$cat->id)selected @endif>{{$cat->name}}</option>
                                                        @endif
                                                    @endif
                                                    @if($project_id==1)
                                                        @if($cat->citizen_show==0)
                                                            @continue
                                                        @endif
                                                        @if($cat->is_complaint != 0)
                                                            <option value="{{$cat->id}}"
                                                                    @if(old("category_id")==$cat->id)selected @endif>{{$cat->name}}</option>
                                                        @endif
                                                    @endif
                                            @endforeach
                                        </select>
                                        {!! $errors->first('category_id', '<p class="help-block" style="color:red;">:message</p>') !!}
                                    </div>
                                </div>

                            @elseif($type == 2)
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                            <label for="category_id" class="col-sm-4 col-form-label">فئة الاقتراح</label>
                                            <select id="category"
                                                    class="form-control {{($errors->first('category_id') ? " form-error" : "")}}"
                                                    id="sel1" name="category_id">
                                                <option value=""> اختر فئة الاقتراح</option>
                                                @foreach($category as $cat)

                                                        @if($project_id>1)
                                                            @if($cat->benefic_show==0)
                                                                @continue
                                                            @endif
                                                            @if($cat->is_complaint != 1)
                                                                <option value="{{$cat->id}}"
                                                                        @if(old("category_id")==$cat->id)selected @endif>{{$cat->name}}</option>
                                                            @endif
                                                        @endif
                                                        @if($project_id==1)
                                                            @if($cat->citizen_show==0)
                                                                @continue
                                                            @endif
                                                            @if($cat->is_complaint != 1)
                                                                <option value="{{$cat->id}}"
                                                                        @if(old("category_id")==$cat->id)selected @endif>{{$cat->name}}</option>
                                                            @endif
                                                        @endif
                                                @endforeach
                                            </select>
                                            {!! $errors->first('category_id', '<p class="help-block" style="color:red;">:message</p>') !!}

                                        </div>
                                </div>
                            @else
                                <div style="margin-right:-20px;" class="form-group">
                                    <input type="hidden" name="category_id" value="1">
                                </div>

                            @endif

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="title"  class="col-sm-4 col-form-label">موضوع {{$form_type->find($type)->name}}</label>
                                    <input id="title" type="text" class="form-control {{($errors->first('title') ? " form-error" : "")}}" value="{{old("title")}}"
                                           placeholder="الموضوع" name="title">
                                    {!! $errors->first('title', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="content"  class="col-sm-4 col-form-label">محتوى {{$form_type->find($type)->name}}</label>
                                    <textarea id="content" placeholder="@if($type == 1){{'الرجاء كتابة تفاصيل الشكوى بصورة واضحة في أقل من 300 كلمة'}}@elseif($type == 2){{'الرجاء كتابة تفاصيل الاقتراح بصورة واضحة في أقل من 300 كلمة'}}@endif" class="form-control {{($errors->first('content') ? " form-error" : "")}}"
                                              rows="6" id="comment" name="content">{{old("content")}}</textarea>

                                    {!! $errors->first('content', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>
                            </div>


                            <div class="form-group row" style="margin-top: 45px;">
                                <div class="col-sm-6">
                                    <label for="fileinput"  class="col-sm-4 col-form-label">تحميل المرفقات</label>
                                    <input style="margin-left:-20px;" type="file" class="form-control" name="fileinput">
                                    {!! $errors->first('fileinput', '<p class="help-block" style="color:red;">:message</p>') !!}
                                </div>
                            </div>

                            <br>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row" align="left">
            <div class="col-sm-12">
                <button type="submit" id="submitBtn" class="wow bounceIn btn btn-info btn-md" style="width: 20%; background-color:#BE2D45;border:0;">إرسال {{$form_type->find($type)->name}}</button>
            </div>
        </div>
    </div>
<!--****************************************************** start footer **************************************************************-->
@endsection

@section('js')
    <script>
        function phonenumber(inputtxt,id)
        {
            var regexPattern=new RegExp(/^(059|056)[0-9-+]+$/);    // regular expression pattern
            console.log(regexPattern.test(inputtxt));
            if(regexPattern.test(inputtxt))
            {
                $('#lblError'+id).html('');
                return true;

            }
            else
            {
                $('#lblError'+id).html('يرجى إدخال رقم تواصل صحيح');
                return false;
            }
        }
    </script>

 <script>
     $(document).ready(function(){

         $('#submitBtn').on('click',function(){
             $('#form1').submit();
             console.log("submitted 1");

             setTimeout( function () {
                 $('#form2').submit();
                 console.log("submitted 2");
             }, 100);


         });

     });
 </script>

 <script>
     function  getsent_type() {
         var xx = $('#sent_type_sel1').val();

         if(xx == 4){
             $('#type_of_followup_visit_div').show();
             $('#type_of_box_div').hide();
         }else if(xx == 5){
             $('#type_of_box_div').show();
             $('#type_of_followup_visit_div').hide();
         }else{
             $('#type_of_followup_visit_div').hide();
             $('#type_of_box_div').hide();
         }

     }
 </script>
@endsection
