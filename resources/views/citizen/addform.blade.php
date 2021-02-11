@extends("layouts._citizen_layout")

@section("title", "اضافة نموذج ")


@section("content")
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
    <div class="row">
        <h1 style="margin-top:120px;margin-bottom:20px;">تقديم
            {{$form_type->find($type)->name}}<hr class="h1-hr" style="margin-right: 10px;"></h1>

    </div><br>
    <div class="row">
        <div class="col-md-12">
            @if($type == 1)
                <h4>ثانياً: تفاصيل الشكوى: </h4>
            @elseif($type == 2)
                <h4>ثانياً: تفاصيل الاقتراح: </h4>
            @else
                <h4></h4>
            @endif
        </div>
    </div>
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
        <br>
        <h4><B>المواطن : </B>{{$citizen_name}}</h4>
        <h4><B>المشروع : </B>{{$project_name}}</h4>

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
            <form action="/forms/formsavenew"  method="POST"
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
                    <label for="sent_type"  class="col-sm-4 col-form-label">قنوات الاستقبال</label>
                    <select class="form-control {{($errors->first('sent_type') ? " form-error" : "")}}" id="sent_type_sel1" name="sent_type" onchange="getsent_type()">
                        <option value=""> اختر نوع الاستقبال</option>
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
                    <label for="category_id"  class="col-sm-4 col-form-label">فئات الشكوى</label>
                    <select id="category" class="form-control {{($errors->first('category_id') ? " form-error" : "")}}" id="sel1" name="category_id">
                        <option value="">اختر فئة الشكوى </option>
                        @foreach($category as $cat)
                            @if($cat->id != 1 && $cat->id != 2)
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
                            @endif
                        @endforeach
                    </select>
                    {!! $errors->first('category_id', '<p class="help-block" style="color:red;">:message</p>') !!}
                </div>
            </div>

        @elseif($type == 2)
        <div class="form-group row">
            <div class="col-sm-6">
                <label for="category_id"  class="col-sm-4 col-form-label">فئة الاقتراح</label>
                <select id="category" class="form-control {{($errors->first('category_id') ? " form-error" : "")}}" id="sel1" name="category_id">
                    <option value=""> اختر فئة الاقتراح</option>
                    @foreach($category as $cat)
                        @if($cat->id != 1 && $cat->id != 2)
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
        <hr>
        @if($type == 1 && !auth()->user())
            <div class="form-group row">
            <div class="col-sm-6">
                <label for="show_data" style="text-align: justify;"  class="col-form-label">هل ترغب في مشاركة معلوماتك الأساسية (الاسم، رقم الهوية، معلومات التواصل) مع الجهات المختصة بالنظر في شكواك داخل المركز مع العلم أنه سيتم التعامل مع معلوماتك بسرية تامة وسوف يسهل على المركز الرجوع لك وإبلاغك بنتيجة معالجة الشكوى؟</label>
            </div>
            <div class="col-sm-2">
                <select class="form-control {{($errors->first('show_data') ? " form-error" : "")}}" id="show_data" name="show_data">
                    <option value="">اختر</option>
                    <option value="1">نعم</option>
                    <option value="0">لا</option>

                </select>
            </div>
        </div>
        @endif

        <br>
        <div class="form-group row" align="right">
            <div class="col-sm-4">
                <input type="button" name="btn"
                       value="    إرسال {{$form_type->find($type)->name}}
                           " id="submitBtn" data-toggle="modal" data-target="#confirm-submit"
                       style="border:0;width: 100%; background-color:#BE2D45;"
                       class="wow bounceIn btn btn-info btn-md"/>
            </div>
        </div>

    </form>
        </div>
    </div>
    <div class="modal" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="confirm-submitLabel" aria-hidden="true">
    <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                       <span style="color:#4cae4c;">&#10003;</span>
                        تأكيد إرسال نموذج
                    </div>
                    <div class="modal-body">
                        <p><B>فئة {{$form_type->find($type)->name}}: </B>
                            <span id="category2"> </span></p>
                        <p><B>عنوان {{$form_type->find($type)->name}}: </B>
                            <span id="title2"> </span></p>
                        <p><B>المحتوى:<p id="content2"></p>


                        <!-- We display the details entered by the user here -->
                          <p class="text-center text-justify">
                                     <b style="color:red;">تأكيد:</b>
                                     لا مانع لدي من مشاركة معلوماتي لدى الجهة المخولة في معالجة الشكاوى والاقتراحات (ستبقى معلوماتك سرية أثناء معالجتها)
                          </p>
                        <!-- We display the details entered by the user here -->

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">رجوع</button>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#check-submit">لا أوافق</button>
                        <button  type="submit" id="submit" class="btn btn-success success">تأكيد</button>
                    </div>
                </div>
            </div>
        </div>
       <div class="modal fade" id="check-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                       <span style="color:#4cae4c;">&#10003;</span>
                        تأكيد إرسال نموذج
                    </div>
                    <div class="modal-body">


                        <!-- We display the details entered by the user here -->
                        <p class="text-center text-justify">  سوف تبقى معلوماتك سرية أثناء مراجعة النموذج ولن تظهر إلا للتواصل معك وإعطائك الرد </p>

                        <!-- We display the details entered by the user here -->

                    </div>

                    <div class="modal-footer">
                        <button href="#" id="submit" class="btn btn-default" data-dismiss="modal">حسناً</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('js')
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
