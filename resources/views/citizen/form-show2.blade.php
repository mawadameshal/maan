@extends("layouts._citizen_layout")

@section("title", "متابعة اقتراح/شكوى ")

@section('css')
    <style>
        [v-cloak] {
            display: none;
        }
        body {
            overflow-x: hidden;
        }
    </style>
@endsection

@section("content")

    <div class="row" style="text-align:center;" id="app">
        <div v-cloak>
            <h2 class="col-sm-12" style="margin-top:120px;margin-bottom:20px;margin-left:0px;">
                متابعة {{$item->form_type->name}}<hr class="h1-hr"></h2>
            <div class="row">
               @if($item->citizen->mobile)
            <p style=" font-size:18px;margin-left:198px;text-align: left;margin-top:25px;margin-bottom:25px;position: relative;right: -190px;" class="col-sm-5 wow bounceIn">
                    <b>
                    جوال المواطن:
                    </b>
                    {{$item->citizen->mobile}}</p>
            @endif

                <p style=" font-size:18px;margin-top:25px;margin-bottom:25px;position: relative;left: -140px;" class="col-sm-4 wow bounceIn">
                    <b>
                        المواطن :
                    </b>
                     {{$item->citizen->first_name ." ".$item->citizen->father_name." ".$item->citizen->last_name}}</p>
            </div>
            <div class="row">
          <p style=" font-size:18px;" class="col wow bounceIn">
                    <b>
                    عنوان المواطن:
                    </b>
                    {{$item->citizen->governorate ." /".$item->citizen->city."/ ".$item->citizen->street}}</p>
              </div>

            <br>
            <div class="row" style="width: 77%; margin: auto;">
                <form style="margin-left: 120px;" action="{{route('change_response' , $item->id)}}"  method="POST" class="col-md-9">
                    @csrf
                    <div class="col-md-2"><button type="submit" class=" btn btn-primary" style="background-color:#BE2D45;margin-right: 0px;position: relative;right: -30px;"> Save </button></div>
                    <div class="col-md-7" style="">
                        <select  name="response_type" class="form-control" style="    display: inline; width: 90%; margin-left: -0%; margin-bottom: 2%;">
                            <option value="">اختر نوع</option>
                            <option value="0"> شكوي يمكن الرد عليها مباشرة</option>
                            <option value="1">شكوي تتطلب بعض الاجراءات</option>
                        </select>
                    </div>
                    <p style="font-size: 18px;margin-left: 0px;text-align: right;visibility: visible;animation-name: bounceIn;position: relative;left: -55px;" class="col-sm-3 wow bounceIn">
                        <b>
                            نوع الشكوي
                        </b>
                    </p>
                </form>



                @if($item->response_type == 1)

                    <form style=" margin-top: 20px;margin-bottom: 20px; margin-left: 120px;" action="{{route('update_form_data' , $item->id)}}"  method="POST" enctype="multipart/form-data" class="col-md-9">
                    @csrf
                    <div class="col-md-9" style="">
                        <select  name="required_respond" class="form-control" style="    display: inline; width: 90%; margin-left: -0%; margin-bottom: 2%;">
                            <option value="زيارة ميدانية / فنية"> زيارة ميدانية / فنية</option>
                            <option value="نقاش من خلال لجنة الاقتراحات والشكاوى">نقاش من خلال لجنة الاقتراحات والشكاوى</option>
                            <option value="نقاش مع الجهات الشريكة/ الممولة">نقاش مع الجهات الشريكة/ الممولة</option>
                        </select>
                    </div>
                    <p  class="col-sm-3 wow bounceIn">
                        <b>
                             الإجراءات المطولة المطلوبة للرد
                        </b>
                    </p>
                    <div class="col-md-9" style="">
                        <input type="date" name="form_data" class="form-control" style="    display: inline; width: 90%; margin-left: -0%; margin-bottom: 2%;">
                    </div>
                    <p style="font-size: 18px;margin-left: 0px;text-align: right;visibility: visible;animation-name: bounceIn;position: relative;left: -55px;" class="col-sm-3 wow bounceIn">
                        <b>
                            التاريخ
                        </b>
                    </p>
                    <div class="col-md-9" style="">
                        <input type="file" name="form_file" class="form-control" style="    display: inline; width: 90%; margin-left: -0%; margin-bottom: 2%;">
                    </div>
                    <p style="font-size: 18px;margin-left: 0px;text-align: right;visibility: visible;animation-name: bounceIn;position: relative;left: -55px;" class="col-sm-3 wow bounceIn">
                        <b>
                            الملف
                        </b>
                    </p>

                   <div class="col-md-2"><button type="submit" class=" btn btn-primary" style="margin-right: 360%;margin-top: 10px;"> Save </button></div>

                   </form>

                @endif




                <!--
                    <div class="col-md-4">
                        <p style=" font-size:18px;margin-left:198px;" class="col-sm-5 wow bounceIn">
                            <b>
                            نوع الشكوي
                            </b>
                            </p>

                    </div>
                <form  action="{{route('change_response' , $item->id)}}"  method="POST" >
                    @csrf
                    <div class="col-md-6">
                        <select  name="response_type" class="form-control" style="    display: inline; width: 80%; margin-left: -35%; margin-bottom: 2%;">
                            <option value="">اختر نوع</option>
                            <option value="0"> شكوي يمكن الرد عليها مباشرة</option>
                            <option value="1">شكوي تتطلب بعض الاجراءات</option>
                        </select>
                    </div>
                    <div class="col-md-2"><button type="submit" class=" btn btn-primary" style="margin-right: 260px;"> Save </button></div>
                </form>
                -->
            </div>
            <br>

            <div class="row">
                <p style=" font-size:18px; margin-bottom: 15px" class="col-sm-12 wow bounceIn">
                    <b>
                    الاستقبال:
                    </b>
                    {{$item->sent_typee->name}}

                </p>
                @if($item->type==1)
                    <p style=" font-size:18px;margin-left:0;" class="col-sm-12 wow bounceIn">
                        <b>
                        فئة الشكوى:
                        </b>
                        <span v-show="!toedit">@{{thecat}}</span>
                        <span v-show="toedit">
                <select v-model="cat_id" class="form-control" style="display: inline;width: 60%">
                        <option value="">اختر فئة</option>
                     @foreach($categories as $category)
                        @if($category->id != 1 && $category->id != 2)
                            <option
                                    @if($item->category->id==$category->id) selected="selected"
                                    @endif
                                    value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                    @endforeach
                </select>
                </span>
                        @if(auth()->user())
                            @if(auth()->user()->account->circle->circle_categories->where('category_id',$item->category->id)->where('to_edit',1)->first()
                        &&
                        auth()->user()->account->account_projects->where('project_id',$item->project->id)->where('to_edit',1)->first()
                        )
                                <a style="padding: 5px 6px 0px 8px;" v-show='!toedit' @click.prevent="toedit=1;" href="#"
                                   class='btn btn-sm btn-primary'><i
                                            class='fa fa-edit' ></i></a>

                                <a v-show='toedit' @click.prevent="editcat({{$item->id}})" href="#"
                                   class='btn btn-sm btn-info'><i
                                            class='fa fa-save'></i></a>

                                <a v-show='toedit' @click.prevent="toedit=!toedit" href="#"
                                   class='btn btn-sm btn-warning'><i class='fa fa-times'></i></a>
                            @endif
                        @endif
                    </p>
                @else
                    <p style=" font-size:18px;margin-left:198px;" class="col-sm-5 wow bounceIn" ></p>

                    <p style=" font-size:18px;margin-left:198px;" class="col-sm-5 wow bounceIn"></p>
                @endif
{{--                {{$item}}--}}
                @if($item->old_category)
                    <p style=" font-size:18px;float: right;margin-right: 0l margin-top: 25px; margin-bottom: 25px" class="col-sm-12 wow bounceIn">
                        <b>
                            الفئة القديمة:
                        </b>
                        {{\App\Category::whereId($item->old_category)->get()->first()->name}}
                    </p>
                @endif
                @if($item->change_by)
                    <p style=" font-size:18px;float: right;margin-right: 0l margin-top: 25px; margin-bottom: 25px" class="col-sm-12 wow bounceIn">
                        <b>
                             الموظف الذي قام بالتغير:
                        </b>
                            {{\App\Account::whereId($item->change_by)->get()->first()->full_name}}

                    </p>
                @endif
                @if($item->updated_at)
                    <p style=" font-size:18px;float: right;margin-right: 0l margin-top: 25px; margin-bottom: 25px" class="col-sm-12 wow bounceIn">
                        <b>
                            وقت التعديل:
                        </b>
                        {{$item->updated_at}}
                    </p>
                @endif

{{--                <p style=" font-size:18px;margin-left:198px;" class="col-sm-5 wow bounceIn">{{\App\Category::whereId($item->old_category)->get()->first()->name}}</p>--}}
{{--                <p style=" font-size:18px;margin-left:198px;" class="col-sm-5 wow bounceIn">{{$item->updated_at}}</p>--}}
{{--                <p style=" font-size:18px;margin-left:198px;" class="col-sm-5 wow bounceIn">{{\App\User::whereId($item->change_by)->get()->first()->name}}</p>--}}
                <hr>
                @if($item->account)
                    <p style=" font-size:18px;float: right;margin-right: 0l margin-top: 25px; margin-bottom: 25px" class="col-sm-12 wow bounceIn">
                        <b>
                        موظف إدخال:
                        </b>
                        {{$item->account->full_name}}

                    </p>
                @endif
              <p style=" font-size:18px;margin-left:0;" class="col-sm-12 wow bounceIn">
                  <b>
                  إسم المشروع:
                  </b>
                  {{$item->project->name ." ".$item->project->code }}</p>
                <br>

            </div>
            <br>
        </div>
    </div>
    </div>
    <!--***** first tab *****-->
    <div class="row">

        <div class="tab tab col-sm-5" style="margin-left:322px;margin-bottom:20px; border-radius: 10px;box-shadow: -3px 3px 5px 1px #b3b3b3;background: #f7f7f7;">

            <h3 style="margin-bottom:40px;font-weight:900;color: #be2d45;">
                عنوان
                {{$item->form_type->name}} {{$item->title }}
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; رقم الاقتراح/شكوى : ({{$item->id}}) </h3>

            <div style="width: 95%; margin: auto;max-width: 5600px;word-wrap:break-word;white-space: normal;">
                <p style="text-align:right;font-size:16px "
                > {{$item->content}}</p>
            </div>
            <p style="direction:ltr;text-align:left;margin-top: 25px;color: #be2d45;">
                {{"تاريخ الإرسال ".$item->created_at}}

            </p>
        </div>
        <!--***** second tab *****-->
        @if ($errors->any())
            <div class="alert  col-sm-7 alert-danger alert-dismissible"
                 style="margin-left:322px;direction: rtl;text-align:right;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="tab col-sm-5" style="margin-left:320px;margin-bottom:20px; border-radius: 10px;box-shadow: -3px 3px 5px 1px #b3b3b3;background: #f7f7f7; padding: 20px 20px 10px 20px">
            <button class="tablinks" style="border: 2px solid #be2d45;border-radius: 5px;color: #be2d45;font-weight: 900;padding: 10px 10px 7px 10px;">المرفقات</button>
            <br> <br> <br>
            <?php
            $form_files = \App\Form_file::where('form_id', '=', $item->id)->get();
            ?>
            @foreach($form_files as $follow_file)
                <div style="direction:rtl;text-align:right;"><h4
                            style="direction:rtl;text-align:right;"><a target="_blank"
                                                                       href="{{asset('/uploads/'.$follow_file['name'])}}">
                            يمكنك تحميل : {{$follow_file->name}}</a>
                    </h4></div>
                <p style="direction:ltr;text-align:left;">
                    {{" ".$follow_file->created_at}}
                </p>
                <hr style="border:1px solid #CCC">
            @endforeach


        </div>
        <br><br><br>
        <!----->
        <!----->
        <div class="tab col-sm-5" style="margin-left:320px;margin-bottom:20px; border-radius: 10px;box-shadow: -3px 3px 5px 1px #b3b3b3;background: #f7f7f7;">
            <button class="tablinks x" style="padding-right: 0"><h3 style="color: #be2d45;margin-top: 0;font-weight: 900;padding: 0;">الردود والمتابعات</h3><br></button>
            <style>
                .tab button.x:hover {
                    background-color: transparent;
                }
            </style>
            <br> <br> <br> <br> <br>
            <?php
            $my_arrayy_of_opject = [];

            foreach ($item->form_response as $rseponse) {
                array_push($my_arrayy_of_opject, ["comment" => $rseponse, "date" => $rseponse->created_at, "type" => '1']);
            }
            foreach ($item->form_follow as $follow) {
                array_push($my_arrayy_of_opject, ["comment" => $follow, "date" => $follow->created_at, "type" => '2']);
            }
            usort($my_arrayy_of_opject, function ($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
            });
            //dd($my_arrayy_of_opject);
            ?>
            @foreach($my_arrayy_of_opject as $my_opject)
                @if($my_opject['type']==1)
                    <div style="direction:rtl;text-align:right;color:#0a84ad"><h4
                                style="direction:rtl;text-align:right;">{{$my_opject['comment']->response}}</h4>
                        <p style="direction:ltr;text-align:left; margin-bottom: -10px">
                            @if(\App\Account::find($my_opject['comment']->account_id)->account_projects->where('project_id','=',$item->project->id)->first())
                                {{$my_opject['comment']->form->project->account_projects->where('account_id',$my_opject['comment']->account_id)->first()->account_rate->name}}
                                مشروع
                            @else
                                موظف سابق
                            @endif
                            {{" ".\App\Account::find($my_opject['comment']->account_id)->full_name}}
                            {{" ".$my_opject['comment']->form->created_at}}
                        </p>
                    </div>
                    <hr style="border:1px solid ;color:#0a84ad">
                @elseif($my_opject['type']==2)
                    @if($my_opject['comment']->solve == null)
                        <div style="direction:rtl;text-align:right;#565656">
                            <h4 style="direction:rtl;text-align:right;">{{$my_opject['comment']->notes}}</h4>
                            <p style="direction:ltr;text-align:left;">
                                {{$my_opject['comment']->citizen->first_name}} {{$my_opject['comment']->citizen->last_name}}
                                {{" ".$my_opject['comment']->created_at}}
                            </p>

                        </div>
                        <hr style="border:1px solid #565656">
                    @elseif($my_opject['comment']->solve != null)
                        <div style="direction:rtl;text-align:right;#565656">
                            @if($my_opject['comment']->solve == "1")
                                <h4 style="direction:rtl;text-align:right;">التقييم : تم حل المشكلة </h4>
                                @if($my_opject['comment']->evaluate)
                                    نسبة الرضى : @if($my_opject['comment']->evaluate == 1) راضي بشكل
                                    كبير @elseif($my_opject['comment']->evaluate == 2) راضي بشكل متوسط @else راضي بشكل
                                    قليل @endif
                                @endif
                            @else
                                <h3 style="direction:rtl;text-align:right;">التقييم :لم يتم حل المشكلة </h3>
                            @endif

                            @if($my_opject['comment']->notes)
                                <h4 style="direction:rtl;text-align:right;">{{$my_opject['comment']->notes}}</h4>
                            @endif
                            <p style="direction:ltr;text-align:left;">
                                {{$my_opject['comment']->citizen->first_name}} {{$my_opject['comment']->citizen->last_name}}
                                {{" ".$my_opject['comment']->created_at}}
                            </p>

                        </div>
                        <hr style="border:1px solid #565656">
                    @endif
                @endif
            @endforeach

        </div>
        <br><br><br>
        <!----->


        @if(Auth::user())
            <div class="tab col-sm-5" style="margin-left:320px;margin-bottom:20px; border-radius: 10px;box-shadow: -3px 3px 5px 1px #b3b3b3;background: #f7f7f7;">
                <button class="tablinks" style="border: 2px solid #be2d45;border-radius: 5px;color: #be2d45;font-weight: 900;padding: 10px 10px 7px 10px;">إضافة رد</button>
                <!-- <div id="Paris" class="tabcontent"> -->
                <br><br><br>


                @if($item->type=='1')
                    @if($item->status!="3"
                    &&
                        Auth::user()->account->circle->circle_categories->where('category_id',$item->category->id)->where('to_replay',1)->first()
                        &&
                        Auth::user()->account->account_projects->where('project_id',$item->project->id)->where('to_replay',1)->first()
                        )
                        <form method="post" action="/account/form/addreplay/{{$item->id}}">
                            @csrf
                            <label>إضافة رد جديد</label><br><br>
                            <textarea name="response" rows="8" cols="80"></textarea><br>
                            <input type="submit" class="btn btn-info" style="width: 70%; background-color:#BE2D45; margin-bottom:10px;border:none;" value="إرسال الرد">
                        </form>
                    @endif
                @elseif($item->status!="3"
                    &&
                        Auth::user()->account->circle->circle_categories->where('category_id',$item->category->id)->where('to_replay',1)->first()
                        &&
                        Auth::user()->account->account_projects->where('project_id',$item->project->id)->where('to_replay',1)->first()
                        )
                    <form method="post" action="/account/form/addreplay/{{$item->id}}">
                        @csrf
                        <label>إضافة رد جديد</label><br><br>
                        <textarea name="response" rows="8" cols="80"></textarea><br>
                        <input type="submit" value="إرسال الرد">
                    </form>
                @endif


            </div>
            <br><br><br>
        @endif
    <!--***** third tab *****-->
        @if(!auth()->user() && $item->status!="3" )
            <div class="tab  col-sm-5" style="margin-left:322px;margin-top:5px; border-radius: 10px;box-shadow: -3px 3px 5px 1px #b3b3b3;background: #f7f7f7;">
                <button class="tablinks">إضافة متابعة</button>
                <br><br><br>
                <?php
                 if($item->project_id == 1)
                   $days = $item->category->citizen_wait;
                else
                   $days =$item->category->benefic_wait;

                ?>
                @if($item->status == 1 && (\Carbon\Carbon::now()) > $item->created_at->addDays($days) )
                    <a href="/citizen/form/delayform/{{$item->id}}" class="btn btn-danger">إرسال تذكير بتأخر
                        الرد </a>
                @endif
            <!--!(!(\App\Form::find($item->id)->form_follow->where('solve',"!=",null)->first())) ||-->
                <?php
                $z = false;
                if (\App\Form::find($item->id)->form_response->count() != 0 && \App\Form::find($item->id)->form_follow->count() != 0) {
                    $last_replay = strtotime(\App\Form::find($item->id)->form_response()->orderBy('id', 'DESC')->first()->created_at);
                    $last_follow = strtotime(\App\Form::find($item->id)->form_follow()->orderBy('id', 'DESC')->first()->created_at);
                    if ($last_follow > $last_replay)
                        $z = true;
                }
                ?>
                @if(($item->type == 2 || $item->type == 3)|| $z ||(\App\Form::find($item->id)->form_response->count()==0))
                    <h3>أضف متابعة على طلبك</h3>
                    <form action="/forms/addfollow" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="citizen_id" value="{{$item->citizen->id}}">
                        <input type="hidden" name="form_id" value="{{$item->id}}">
                        <div id="appear">
                            <textarea name="notes" rows="8" cols="80"
                                      placeholder=" الرجاء وصف المشكلة مرة أخرى"></textarea><br><br>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5">
                                <input style="margin-left:-20px;" type="file" class="form-control-file border"
                                       name="fileinput">
                            </div>
                            <label class="control-label col-sm-5" for="email">يمكنك تحميل المرفقات:</label>
                        </div>
                        <br><br>
                        <input style="margin-bottom:20px;" type="submit" value="أرسل متابعتك">
                    </form>
                @else

                    <h3>هل تم حل شكواك ؟</h3>
                    <form action="/forms/addevaluate" method="post">
                        @csrf
                        <input type="hidden" name="citizen_id" value="{{$item->citizen->id}}">
                        <input type="hidden" name="form_id" value="{{$item->id}}">
                        <input class="input" type="radio" name="solve" value="1">نعم
                        <div id="div1" style="width:805px;height:80px;display:none;">
                            <h4>مدى الرضا:</h4>
                            <input type="radio" name="evaluate" value="1">راضي بشكل كبير
                            <input type="radio" name="evaluate" value="2">راضي بشكل متوسط
                            <input type="radio" name="evaluate" value="3">راضي بشكل قليل
                        </div>
                        <br><br>
                        <input id="inp3" style="margin-top:0;" class="fadeOut " name="solve" type="radio" value="2">لا
                        <span class="checkmark"></span>
                        <br><br>
                        <div id="div3" style="width:805px;height:80px;display:none;">
                            <h4>يمكنك توضيح أسباب رفضك لرد الموظف</h4>
                        </div>
                        <div style="display:none;" id="appear">
                            <textarea name="notes" rows="8" cols="80" style="margin-top:0;"
                                      placeholder=" الرجاء وصف المشكلة مرة أخرى"></textarea><br><br>
                        </div>
                        <input style="margin-bottom:20px;" type="submit" value="أدخل تقييمك">
                    </form>
                @endif

            </div>
            <br>
        @endif
        <script>
            $(document).ready(function () {
                $(".input").click(function () {
                    $("#div1").fadeIn(1000);
                    $("#div3").fadeOut(1000);
                });
            });
            $(document).ready(function () {
                $("#inp3").click(function () {
                    $("#div3").fadeIn(1000);
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".fadeOut").click(function () {
                    $("#div1").fadeOut(1000);
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".input ").click(function () {
                    $("#appear").fadeIn(1000);
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".fadeOut ").click(function () {
                    $("#appear").fadeIn(1000);
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".input").click(function () {
                    $("hiddenDiv").fadeIn(1000);
                });
            });
        </script>
    </div>
    <br>

    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <div style=" margin-bottom: 15px;padding: 5px">
                <form style="display:inline" action="/citizen/form/show/{{$item->citizen->id_number}}/{{$item->id}}">
                    <button type="submit" target="_blank" name="theaction" title="طباعة" style="width:70px;"
                            value="print"
                            class="btn btn-success"/>
                    طباعة
                    </button>
                </form>
                <a href="/account/form" class="btn btn-danger ">الغاء الأمر &times; </a>
                @if(Auth::user())
                    @if(Auth::user()->account->circle->circle_categories->where('category_id',$item->category->id)->where('to_stop',1)->first()
                        &&
                        Auth::user()->account->account_projects->where('project_id',$item->project->id)->where('to_stop',1)->first()
                        )@if(($item->status == 1 || $item->status == 2 || $item->status == 4))

                        <a href="/account/form/terminateform/{{$item->id}}"
                           class="btn btn-success">إيقاف {{$item->form_type->name}}</a>
                    @elseif($item->deleted_at == null)
                        <a href="/account/form/allowform/{{$item->id}}"
                           class="btn btn-success">السماح لل{{$item->form_type->name}}</a>
                    @endif
                    @endif
                @endif
            </div>
        </div>
    </div>

    </div>

    <!--****************************************************** start footer **************************************************************-->
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                thecat: '{{$item->category->name  }}',
                theoldcat: '',
                toedit: 0,
                cat_id: '',
            },
            methods: {
                editcat: function (id) {
                    var mythis = this;
                    if (mythis.cat_id > 0) {
                        axios.post("/account/form/change-category/" + id, {
                            category_id: mythis.cat_id,
                            _token:'{{ csrf_token() }}',
                            method:'put'
                        }).then(function (response) {
                            console.log(response.data);
                            mythis.toedit = !mythis.toedit;
                            mythis.thecat = response.data.thecat;
                            mythis.theoldcat = response.data.theoldcat;
                        })
                            .catch(function (error) {
                                console.log(error);
                                mythis.toedit = !mythis.toedit;

                            });
                    } else {
                        mythis.toedit = !mythis.toedit;
                    }
                },

            },
        })
        ;
    </script>

@endsection
