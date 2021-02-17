@extends("layouts._citizen_layout")
@section("title", " متابعة ال".$form_type->find($type)->name)
@section('css')
    <style>

        .importantRule {
            overflow: visible !important;
        }

        <?php if($item->show_data == 0){?>

                     .showdateciz {
            display: none;
        }

        <?php }?>

                    [v-cloak] {
            display: none;
        }

        body {
            overflow-x: hidden;
        }

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
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }

        .open {
            min-height: 250px !important;
            /*overflow: auto !important;*/

        }

        #first_panel.open {
            min-height: 120px !important;
        }

        #changecategorydiv.open {
            min-height: 150px !important;
        }


        #replies.open {
            min-height: 600px !important;
        }

        #explain_div.open,#rank_div.open {
            min-height: 420px !important;
        }
    </style>
@endsection


@if($auth_circle_users)
    @foreach($auth_circle_users as $AccountProjects_user)
        @if($AccountProjects_user == Auth::user()->id || Auth::user()->id == 1 )
           @section("content")
                <div class="row" style="" id="app">
                    <div>
                        <h2 class="col-sm-12" style="margin-top:120px;margin-bottom:20px;margin-left:0px;">
                            متابعة ال{{$item->form_type->name}}
                            <hr class="h1-hr" style="margin-right: 10px;">
                        </h2>

                        <hr>

            {{--            @if(Session::get("msg"))--}}

                            <div class="row" id="message_session" style="display: none;">
                                <div class="col-sm-12">
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 id="content_message"></h4>
                                    </div>
                                </div>
                            </div>
            {{--            @endif--}}
                        @if(Session::get("msg"))
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4>   {{Session::get("msg")}}</h4>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <button class="accordion">
                            أولاً: معلومات مقدم ال{{$form_type->find($type)->name}} الأساسية
                        </button>
                        <div class="panel" id="first_panel">
                            <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                <tr>
                                    <td>الرقم المرجعي:</td>
                                    <td colspan="3">{{$item->citizen->id}}</td>
                                </tr>

                                <tr class="showdateciz">
                                    <td>الاسم رباعي:</td>
                                    <td>{{$item->citizen->first_name ." ".$item->citizen->father_name." ".$item->citizen->last_name}}</td>
                                    <td>رقم الهوية/جواز السفر:</td>
                                    <td>{{$item->citizen->id_number}}</td>
                                </tr>

                                <tr class="showdateciz">
                                    <td>رقم التواصل (1):</td>
                                    <td>{{$item->citizen->mobile}}</td>
                                    <td>رقم التواصل (2):</td>
                                    <td>{{$item->citizen->mobile2}}</td>
                                </tr>

                                <tr class="showdateciz">
                                    <td>المحافظة:</td>
                                    <td>{{$item->citizen->governorate}}</td>
                                    <td>المنطقة :</td>
                                    <td>{{$item->citizen->city}}</td>
                                </tr>

                                <tr class="showdateciz">
                                    <td>العنوان:</td>
                                    <td colspan="3">{{$item->citizen->street}}</td>
                                </tr>

                                <tr>
                                    <td>فئة مقدم {{$form_type->find($type)->name}}:</td>
                                    <td colspan="3">@if($item->type == 1){{'غير مستفيد من مشاريع المركز'}}@else{{'مستفيد من مشاريع المركز '}}@endif</td>
                                </tr>

                                <tr>
                                    <td>اسم المشروع:</td>
                                    <td colspan="3">{{$item->project->name ." ".$item->project->code }}</td>
                                </tr>

                            </table>
                        </div>

                        {{-------------------------------------------------------}}

                        <button class="accordion">
                            ثانياً: تفاصيل ال{{$form_type->find($type)->name}}
                        </button>
                        <div class="panel">
                            <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                                <tr>
                                    <td class="mo" colspan="2">طريقة الاستقبال</td>
                                    <td colspan="2">{{$item->sent_typee->name}}</td>
                                </tr>
                                <tr>
                                    <td class="mo">تاريخ تقديم ال{{$form_type->find($type)->name}}</td>
                                    <td>{{date('d-m-Y', strtotime( $item->created_at))}}</td>
                                    <td class="mo">تاريخ تسجيل ال{{$form_type->find($type)->name}} علي النظام</td>
                                    <td>{{date('d-m-Y', strtotime( $item->created_at))}}</td>
                                </tr>

                                <tr>
                                    <td class="mo" colspan="2">فئة ال{{$form_type->find($type)->name}}</td>
                                    <td colspan="2">{{$item->category->name}}</td>
                                </tr>

                                @if($item->old_category_id)
                                <tr>
                                    <td class="mo">فئة ال{{$form_type->find($type)->name}} المعدلة </td>
                                    <td>{{$item->old_category->name}}</td>

                                    <td class="mo">اسم المستخدم الذي قام بالتعديل</td>
                                    <td>{{$item->user_change_category->name}}</td>
                                </tr>

                                @endif

                                <tr>
                                    <td class="mo" colspan="2">موضوع ال{{$form_type->find($type)->name}}</td>
                                    <td colspan="2">{{$item->form_type->name}} {{$item->title }}</td>
                                </tr>
                                <tr>
                                    <td class="mo" colspan="2">محتوى ال{{$form_type->find($type)->name}}</td>
                                    <td colspan="2">{{$item->content}}</td>
                                </tr>

                                @if($item->reformulate_content)
                                    <tr>
                                        <td class="mo">محتوى ال{{$form_type->find($type)->name}} المعدل بعد الاستيضاح </td>
                                        <td>{{$item->reformulate_content}}</td>

                                        <td class="mo">اسم المستخدم الذي قام بالاستيضاح</td>
                                        <td>{{$item->user_change_content->name}}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td class="mo" colspan="2">المرفقات</td>
                                    <td colspan="2"><?php
                                        $form_files = \App\Form_file::where('form_id', '=', $item->id)->get();

                                        if(!$form_files->isEmpty()){
                                        ?>
                                        <a class="btn btn-xs btn-primary" data-toggle="modal" id="smallButton"
                                           data-target="#smallModal"
                                           data-attr="{{ route('citizenshowfiles', $item->id) }}" title="اضغظ هنا">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <?php }else{?>
                                        <a class="btn btn-xs btn-primary" title="لايوجد مرفقات لعرضها" disabled="disabled">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <?php } ?></td>
                                </tr>

                            </table>
                        </div>
                        {{-------------------------------------------------------}}
                        <button class="accordion">
                            ثالثا: الحاجة للاستيضاح عن مضمون ال{{$form_type->find($type)->name}}
                        </button>
                        <div class="panel" id="explain_div">
                                <br>
                                <form id="update_clarification_form_modal">
                                    <input type="hidden" id="clarification_id" value="{{$item->id}}">
                                    <div class="form-group row">
                                    <div class="col-sm-6 col-sm-offset-6">
                                        <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة
                                            لاستيضاح عن مضمونه/ا؟</label>
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="optradio1" value="0"> لا
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="optradio1" value="1"> نعم
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <hr>
                                    <div id="explain_main_div" style="display: none;">

                                        @if($item->reformulate_content)
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>اسم المستخدم الذي قام بالاستيضاح</label>
                                                    <input class="form-control" value="{{$item->user_change_content->name}}" readonly />
                                                </div>
                                                <div class="col-sm-6"> <label>محتوى ال{{$form_type->find($type)->name}} المعدل بعد الاستيضاح </label>
                                                    <input class="form-control" value="{{$item->reformulate_content}}" readonly />
                                                </div>
                                            </div>
                                            <br>
                                        @elseif($item->reason_lack_clarification)
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <label>سبب عدم الاستيضاح</label>
                                                    <input class="form-control" value="{{$item->reason_lack_clarification}}" readonly />
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>اسم المستخدم الذي قام بالاستيضاح</label>
                                                    <input class="form-control" value="{{$item->user_change_content->name}}" readonly />
                                                </div>

                                            </div>
                                            <br>
                                        @else
                                            <div class="form-group row">
                                                <div class="col-sm-offset-6 col-sm-6">
                                                    <label for="sent_type" class="col-form-label">هل تم الاستيضاح عن المعلومات المطلوبة؟</label>
                                                    <div class="col-sm-2">
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" name="optradio2" value="0"> لا
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" name="optradio2" value="1"> نعم
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-8" id="reformulate_div" style="display: none;">
                                                    <label class="col-sm-12 col-form-label">إعادة صياغة محتوى
                                                        ال{{$form_type->find($type)->name}} بناءً على نتيجة الاستيضاح:</label>
                                                    <input class="form-control " type="text"  id="reformulate_content" name="reformulate_content" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                            <div class="col-sm-8" id="reason_lack_clarification_div" style="display: none">
                                                <label class="col-sm-4 col-form-label">سبب عدم الاستيضاح</label>
                                                <input class="form-control" type="text" id="reason_lack_clarification" name="reason_lack_clarification" autocomplete="off">
                                            </div>
                                        </div>
                                            <br>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-2">
                                            <button id="submit_update_clarification" class="btn btn-danger">حفظ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        {{-------------------------------------------------------}}

                        <button class="accordion hide_div">
                            رابعاً: الحاجة لإعادة تصنيف فئة ال{{$form_type->find($type)->name}}
                        </button>
                        <div class="panel hide_div" id="changecategorydiv">
                            <br>
                            @if($item->old_category_id)
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>اسم المستخدم الذي قام بالتعديل</label>
                                        <input class="form-control" value="{{$item->user_change_category->name}}" readonly />
                                    </div>
                                    <div class="col-sm-6">
                                        <label>فئة ال{{$form_type->find($type)->name}} المعدلة </label>
                                        <input class="form-control" value="{{$item->old_category->name}}" readonly />
                                    </div>
                                </div>
                            @else
                                <form id="update_category_form_modal">
                                        <input type="hidden" id="updated_category_id" value="{{$item->id}}">
                                        <div class="form-group row">
                                            <div class="col-sm-6 col-sm-offset-6">
                                                <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة لإعادة تصنيف فئته/ا؟</label>
                                                <div class="col-sm-2">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" name="optradio4" value="0" checked>لا
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input" id="post-format-gallery"
                                                                   name="optradio4" value="1"> نعم
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>

                                        <div class="form-group row" id="updated_category_div">
                                            <div class="col-sm-2">
                                                <button id="submit_update_categpry" class="btn btn-danger">تعديل الفئة</button>
                                            </div>
                                            <div class="col-sm-10">
                                                <label class="col-sm-4 col-form-label">فئة {{$form_type->find($type)->name}} (2)</label>
                                                @if($item->type == 1)
                                                    <select  class="form-control" id="updated_category_name" name="category_id" style="width: 60% !important;">
                                                        <option value="">اختر فئة الشكوى</option>
                                                        @foreach($categories as $cat)
                                                            @if($cat->is_complaint != 0)
                                                                <option value="{{$cat->id}}" @if($item->category_id==$cat->id)selected @endif>{{$cat->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>

                                                @elseif($item->type == 2)
                                                    <select  class="form-control" id="updated_category_name1" name="category_id" style="width: 60% !important;">
                                                        <option value=""> اختر فئة الاقتراح</option>
                                                        @foreach($categories as $cat)
                                                            @if($cat->is_complaint != 1)
                                                                <option value="{{$cat->id}}" @if($item->category_id==$cat->id)selected @endif>{{$cat->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                            @endif
                        </div>

                        {{-------------------------------------------------------}}
                        <button class="accordion hide_div">
                            خامساً: الردود والمتابعات
                        </button>
                        <div class="panel hide_div" id="replies">
                            <br>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="sent_type" class="col-sm-4 col-form-label">حالة الرد</label>
                                    <?php
                                    if($item->status == 1){
                                        $replay_status = "قيد الدراسة";
                                    }elseif($item->status == 2){
                                        $replay_status = "تم الرد";
                                    }else{
                                        $replay_status= "";
                                    }
                                    ?>
                                    <input style="width: 65% !important;" type="text" class="form-control" id="replay_status" name="replay_status" value="{{$replay_status}}" readonly>
                                </div>
                                <div class="col-sm-8">
                                    <label for="sent_type" class="col-sm-4 col-form-label">الجهة المختصة بالدراسة والمعالجة</label>
                                    <input type="hidden" class="form-control" name="replay_user_id" value="{{Auth::user()->id}}">
                                    <?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>

                                    <input style="width: 65% !important;" type="text" class="form-control" name="replay_user_name" readonly
                                           value="{{ Auth::user()->account->full_name }}">
                                </div>
                            </div>
                            {{--2--}}
                            <form action="{{route('change_response_and_update_form_data' , $item->id)}}"  method="POST">
                                @csrf
                                <hr>
                                <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="response_type" class="col-sm-4 col-form-label">التصنيف بناءً على الإجراءات المطلوبة:</label>
                                                <select  id="response_type_select"  name="response_type" class="form-control" style="width: 50% !important;">
                                                    <option value="">اختر نوع</option>
                                                    <option value="0"> يمكن الرد عليها مباشرة</option>
                                                    <option value="1">تتطلب إجراءات مطولة للرد عليه</option>
                                                </select>
                                            </div>
                                        </div>
                                <br>
                                <div id="replay_advanced" style="display: none">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="response_type" class="col-sm-4 col-form-label">طبيعة الإجراءات  المطولة المطلوبة</label>
                                            <select  name="required_respond" class="form-control" style=" width: 50%;">
                                                <option value="زيارة ميدانية / فنية"> زيارة ميدانية / فنية</option>
                                                <option value="نقاش من خلال لجنة الاقتراحات والشكاوى">نقاش من خلال لجنة الاقتراحات والشكاوى</option>
                                                <option value="نقاش مع الجهات الشريكة/ الممولة">نقاش مع الجهات الشريكة/ الممولة</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="response_type" class="col-sm-4 col-form-label">تحميل ملف توثيق الإجراء</label>
                                            <input type="file" name="form_file" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="response_type" class="col-sm-4 col-form-label">تاريخ تنفيذ الإجراء</label>
                                            <input type="date" name="form_data" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group row" align="left">
                                    <div class="col-sm-12">
                                        <button type="submit"  class="wow bounceIn btn btn-info btn-md"
                                                style="width: 15%; background-color:#BE2D45;border:0;">
                                           حفظ
                                        </button>
                                    </div>
                                </div>
                            </form>
                            {{--3--}}
                            <hr>
                            <div class="col-sm-12" style="text-align: center;">
                                @if($item->type=='1')
                                    @if($item->status!="3"
                                    &&
                                        Auth::user()->account->circle->circle_categories->where('category_id',$item->category->id)->where('to_replay',1)->first()
                                        &&
                                        Auth::user()->account->account_projects->where('project_id',$item->project->id)->where('to_replay',1)->first()
                                        )
                                        <form method="post" action="/account/form/addreplay/{{$item->id}}">
                                            @csrf
                                            <textarea name="response" rows="8" cols="105" style="border-radius: 10px;"></textarea><br>
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
                                        <textarea name="response" rows="8" cols="105" style="border-radius: 10px;"></textarea><br>
                                        <input type="submit" value="إرسال الرد">
                                    </form>
                                @endif


                            </div>
                            <br><br><br>

                            <hr>
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
                            <div class="form-group row">
                                <div class="col-sm-12">
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

                            </div>
                        </div>

                        {{-------------------------------------------------------}}

                        <button class="accordion hide_div" id="deleted">
                            سادساً : الحاجة لحذف ال{{$form_type->find($type)->name}}
                        </button>
                        <div class="panel hide_div" id="deleted_main_div">
                                <br>
                                <form id="delete_form_modal">
                                    <input type="hidden" id="deleted_id" value="{{$item->id}}">
                                    <div class="form-group row">
                                    <div class="col-sm-6 col-sm-offset-6">
                                        <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة
                                            للحذف؟</label>
                                        <div class="col-sm-2">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="optradio" value="0" checked>لا
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" id="post-format-gallery"
                                                           name="optradio" value="1"> نعم
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                    <hr>
                                    <div class="form-group row deleted_div">
                                    <div class="col-sm-6">
                                        <label for="sent_type" class="col-sm-4 col-form-label">تاريخ الحذف</label>
                                        <input type="text" class="form-control" name="deleted_at" readonly
                                               value="{{\Carbon\Carbon::now()}}">


                                    </div>
                                    <div class="col-sm-6">
                                        <label for="sent_type" class="col-sm-4 col-form-label">اسم موظف الذي قام بالحذف</label>
                                        <input type="hidden" class="form-control" name="deleted_by" value="{{Auth::user()->id}}">
                                        <?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>
                                        <input type="text" class="form-control" name="deleted_by_name" readonly
                                               value="{{ Auth::user()->account->full_name }}">

                                    </div>
                                </div>
                                    <div class="form-group row deleted_div">
                                        <div class="col-sm-2">
                                            <button id="submit_delete" class="btn btn-danger" style="margin-top: 25px;">تأكيد الحذف</button>
                                        </div>

                                        <div class="col-sm-10">
                                            <label for="sent_type" class="col-sm-4 col-form-label">سبب الحذف</label>
                                            <input type="text" class="form-control" id="deleting_reason" placeholder="سبب الحذف"
                                               required>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        {{-------------------------------------------------------}}
                        <button class="accordion hide_div">
                            سابعاً: التغذية الراجعة
                        </button>
                        <div class="panel hide_div" id="rank_div">
                            <br>
                            @if(!auth()->user() && $item->status!="3" )
                                <div class="col-sm-12" >
                                    <br>
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
                                                <div id="appear">
                                                    <textarea name="notes" rows="8" cols="80" style="margin-top:0;"
                                                          placeholder=" الرجاء وصف المشكلة مرة أخرى"></textarea><br><br>
                                                </div>
                                            </div>
                                            <div class="form-group row" align="left">
                                                <div class="col-sm-12">
                                                    <button type="submit"  class="wow bounceIn btn btn-info btn-md"
                                                            style="width: 15%; background-color:#BE2D45;border:0;">
                                                        أدخل تقييمك
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    @endif

                                </div>
                                <br>
                            @endif
                            @if(auth()->user())
                                <form>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="sent_type" class="col-sm-4 col-form-label">الجهة المسؤولة عن تبليغ الرد (موظف الاتصال)</label>
                                            <?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>

                                            <input style="width: 65% !important;" type="text" class="form-control" name="replay_user_name" readonly
                                                   value="{{ Auth::user()->account->full_name }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        @if($item->status == 1)
                                        <div class="col-sm-12">
                                            <label for="sent_type" class="col-sm-4 col-form-label">حالة تبليغ الرد</label>
                                            <input value="قيد تبليغ الرد" class="form-control" readonly>
                                        </div>

                                        @elseif($item->status  == 2)
                                            <div class="col-sm-6">
                                                <label for="sent_type" class="col-sm-4 col-form-label">تاريخ تبليغ الرد</label>
                                                <input value="{{$item->datee}}" class="form-control" readonly>
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="sent_type" class="col-sm-4 col-form-label">حالة تبليغ الرد</label>
                                                <input value="تم تبليغ الرد" class="form-control" readonly>
                                            </div>
                                        @else
                                            <div class="col-sm-6">
                                                <label for="sent_type" class="col-sm-4 col-form-label">سبب عدم تبليغ الرد</label>

                                                <select id="follow_reason_not" name="follow_reason_not" class="form-control">
                                                    <option value="">اختر السبب</option>
                                                    <option value="عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة.">عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة.</option>
                                                    <option value="أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.">أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.</option>
                                                    <option value="أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)">أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)</option>

                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="sent_type" class="col-sm-4 col-form-label">حالة تبليغ الرد</label>
                                                <input value="لم يتم تبليغ الرد" class="form-control" readonly>
                                            </div>

                                        @endif
                                    </div>

                                    <div class="form-group row">



                                            @if($item->evaluate)
                                                @if($item->evaluate == 1)
                                                <div class="col-sm-6">
                                                    <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>
                                                    <input value="راضي بشكل كبير" class="form-control" readonly>
                                                </div>
                                                    <br>
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
                                                @elseif($item->evaluate==2)
                                                <div class="col-sm-6">
                                                    <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>
                                                    <input value="راضي بشكل متوسط" class="form-control" readonly>
                                                </div>
                                                    <br>
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
                                                @elseif($item->evaluate == 3)
                                                <div class="col-sm-6">
                                                    <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>
                                                    <input value="راضي بشكل ضعيف" class="form-control" readonly>
                                                </div>
                                                    <br>
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
                                                @else
                                                <div class="col-sm-6">
                                                    <label class="col-sm-4 col-form-label">
                                                        سبب عدم الرضا عن الرد
                                                    </label>
                                                    <input id="evaluate_note" name="evaluate_note" class="form-control">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>
                                                    <input value="غير راضي عن الرد" class="form-control" readonly>
                                                </div>



                                                @endif
                                            @endif
                                        </div>
                                </form>
                            @endif
                        </div>
                        {{-------------------------------------------------------}}
                        <button class="accordion hide_div">
                            ثامناً: توصيات ذات العلاقة بمحتوى ال{{$form_type->find($type)->name}}
                        </button>
                        <div class="panel hide_div">

                                <br>
                                @if(!$recomendations)
                                    <h4>عزيزي الموظف يمكنك من هنا رفع التوصيات التي تستحق الدراسة من قبل المركز لاتخاذها بعين الاعتبار
                                        في تصميم مشاريع مستقبلية:</h4>
                                <form method="POST" class="form-horizontal" action="/citizen/saverecommendations">
                                    @csrf
                                    <input name="form_id" type="hidden" value="{{$item->id}}">
                                    <input name="user_id" type="hidden" value="{{Auth::user()->id}}">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                       <textarea id="content"
                                                 class="form-control {{($errors->first('content') ? " form-error" : "")}}"
                                                 rows="6" id="content" name="content">{{old("content")}}</textarea>

                                            {!! $errors->first('content', '<p class="help-block" style="color:red;">:message</p>') !!}
                                        </div>

                                    </div>

                                    <div class="form-group row" align="center">
                                        <div class="col-sm-12">
                                            <button type="submit" id="submitBtn" class="wow bounceIn btn btn-info btn-md"
                                                    style="width: 30%; background-color:#BE2D45;border:0;">
                                                رفع التوصيات
                                            </button>
                                        </div>
                                    </div>

                                </form>
                                @else
                                    <div class="content">
                                        <h5>{{$recomendations->content}}</h5>
                                        <h6>بواسطة {{$recomendations->user->name}}</h6>
                                    </div>
                                @endif
                            </div>

                        {{-------------------------------------------------------}}


                        <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
                             aria-hidden="true" style=" position: absolute;left: 42%;top: 40%;transform: translate(-50%, -50%);">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="smallBody">
                                        <div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                            <div class="col-sm-12 text-center">
                                <div style=" margin-bottom: 15px;padding: 5px">
                                    <form style="display:inline" action="/citizen/form/show/{{$item->citizen->id_number}}/{{$item->id}}">
                                        <button type="submit" target="_blank" name="theaction" title="طباعة" style="width:70px;"
                                                value="print"
                                                class="btn btn-success">
                                        طباعة
                                        </button>
                                    </form>
                                    <a href="/account/form" class="btn btn-danger ">الغاء الأمر &times; </a>
                                </div>
                            </div>
                        </div>
                </div>

                <!--****************************************************** start footer **************************************************************-->
            @endsection
        @endif
    @endforeach

@elseif($auth_circle_users2)
    @foreach($auth_circle_users2 as $AccountProjects_user)
        @if($AccountProjects_user == Auth::user()->id || Auth::user()->id == 1 )
            @section("content")
    <div class="row" style="" id="app">
        <div>
            <h2 class="col-sm-12" style="margin-top:120px;margin-bottom:20px;margin-left:0px;">
                متابعة ال{{$item->form_type->name}}
                <hr class="h1-hr" style="margin-right: 10px;">
            </h2>

            <hr>

            {{--            @if(Session::get("msg"))--}}

            <div class="row" id="message_session" style="display: none;">
                <div class="col-sm-12">
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 id="content_message"></h4>
                    </div>
                </div>
            </div>
            {{--            @endif--}}
            @if(Session::get("msg"))
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4>   {{Session::get("msg")}}</h4>
                        </div>
                    </div>
                </div>
            @endif
            <button class="accordion">
                أولاً: معلومات مقدم ال{{$form_type->find($type)->name}} الأساسية
            </button>
            <div class="panel" id="first_panel">
                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                    <tr>
                        <td>الرقم المرجعي:</td>
                        <td colspan="3">{{$item->citizen->id}}</td>
                    </tr>

                    <tr class="showdateciz">
                        <td>الاسم رباعي:</td>
                        <td>{{$item->citizen->first_name ." ".$item->citizen->father_name." ".$item->citizen->last_name}}</td>
                        <td>رقم الهوية/جواز السفر:</td>
                        <td>{{$item->citizen->id_number}}</td>
                    </tr>

                    <tr class="showdateciz">
                        <td>رقم التواصل (1):</td>
                        <td>{{$item->citizen->mobile}}</td>
                        <td>رقم التواصل (2):</td>
                        <td>{{$item->citizen->mobile2}}</td>
                    </tr>

                    <tr class="showdateciz">
                        <td>المحافظة:</td>
                        <td>{{$item->citizen->governorate}}</td>
                        <td>المنطقة :</td>
                        <td>{{$item->citizen->city}}</td>
                    </tr>

                    <tr class="showdateciz">
                        <td>العنوان:</td>
                        <td colspan="3">{{$item->citizen->street}}</td>
                    </tr>

                    <tr>
                        <td>فئة مقدم {{$form_type->find($type)->name}}:</td>
                        <td colspan="3">@if($item->type == 1){{'غير مستفيد من مشاريع المركز'}}@else{{'مستفيد من مشاريع المركز '}}@endif</td>
                    </tr>

                    <tr>
                        <td>اسم المشروع:</td>
                        <td colspan="3">{{$item->project->name ." ".$item->project->code }}</td>
                    </tr>

                </table>
            </div>

            {{-------------------------------------------------------}}

            <button class="accordion">
                ثانياً: تفاصيل ال{{$form_type->find($type)->name}}
            </button>
            <div class="panel">
                <table class="table table-hover table-striped table-bordered" style="width:100%;white-space:normal;">
                    <tr>
                        <td class="mo" colspan="2">طريقة الاستقبال</td>
                        <td colspan="2">{{$item->sent_typee->name}}</td>
                    </tr>
                    <tr>
                        <td class="mo">تاريخ تقديم ال{{$form_type->find($type)->name}}</td>
                        <td>{{date('d-m-Y', strtotime( $item->created_at))}}</td>
                        <td class="mo">تاريخ تسجيل ال{{$form_type->find($type)->name}} علي النظام</td>
                        <td>{{date('d-m-Y', strtotime( $item->created_at))}}</td>
                    </tr>

                    <tr>
                        <td class="mo" colspan="2">فئة ال{{$form_type->find($type)->name}}</td>
                        <td colspan="2">{{$item->category->name}}</td>
                    </tr>

                    @if($item->old_category_id)
                        <tr>
                            <td class="mo">فئة ال{{$form_type->find($type)->name}} المعدلة </td>
                            <td>{{$item->old_category->name}}</td>

                            <td class="mo">اسم المستخدم الذي قام بالتعديل</td>
                            <td>{{$item->user_change_category->name}}</td>
                        </tr>

                    @endif

                    <tr>
                        <td class="mo" colspan="2">موضوع ال{{$form_type->find($type)->name}}</td>
                        <td colspan="2">{{$item->form_type->name}} {{$item->title }}</td>
                    </tr>
                    <tr>
                        <td class="mo" colspan="2">محتوى ال{{$form_type->find($type)->name}}</td>
                        <td colspan="2">{{$item->content}}</td>
                    </tr>

                    @if($item->reformulate_content)
                        <tr>
                            <td class="mo">محتوى ال{{$form_type->find($type)->name}} المعدل بعد الاستيضاح </td>
                            <td>{{$item->reformulate_content}}</td>

                            <td class="mo">اسم المستخدم الذي قام بالاستيضاح</td>
                            <td>{{$item->user_change_content->name}}</td>
                        </tr>
                    @endif

                    <tr>
                        <td class="mo" colspan="2">المرفقات</td>
                        <td colspan="2"><?php
                            $form_files = \App\Form_file::where('form_id', '=', $item->id)->get();

                            if(!$form_files->isEmpty()){
                            ?>
                            <a class="btn btn-xs btn-primary" data-toggle="modal" id="smallButton"
                               data-target="#smallModal"
                               data-attr="{{ route('citizenshowfiles', $item->id) }}" title="اضغظ هنا">
                                <i class="fa fa-eye"></i>
                            </a>
                            <?php }else{?>
                            <a class="btn btn-xs btn-primary" title="لايوجد مرفقات لعرضها" disabled="disabled">
                                <i class="fa fa-eye"></i>
                            </a>
                            <?php } ?></td>
                    </tr>

                </table>
            </div>
            {{-------------------------------------------------------}}
            <button class="accordion">
                ثالثا: الحاجة للاستيضاح عن مضمون ال{{$form_type->find($type)->name}}
            </button>
            <div class="panel" id="explain_div">
                <br>
                <form id="update_clarification_form_modal">
                    <input type="hidden" id="clarification_id" value="{{$item->id}}">
                    <div class="form-group row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة
                                لاستيضاح عن مضمونه/ا؟</label>
                            <div class="col-sm-2">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio1" value="0"> لا
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio1" value="1"> نعم
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="explain_main_div" style="display: none;">

                        @if($item->reformulate_content)
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>اسم المستخدم الذي قام بالاستيضاح</label>
                                    <input class="form-control" value="{{$item->user_change_content->name}}" readonly />
                                </div>
                                <div class="col-sm-6"> <label>محتوى ال{{$form_type->find($type)->name}} المعدل بعد الاستيضاح </label>
                                    <input class="form-control" value="{{$item->reformulate_content}}" readonly />
                                </div>
                            </div>
                            <br>
                        @elseif($item->reason_lack_clarification)
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>سبب عدم الاستيضاح</label>
                                    <input class="form-control" value="{{$item->reason_lack_clarification}}" readonly />
                                </div>

                                <div class="col-sm-6">
                                    <label>اسم المستخدم الذي قام بالاستيضاح</label>
                                    <input class="form-control" value="{{$item->user_change_content->name}}" readonly />
                                </div>

                            </div>
                            <br>
                        @else
                            <div class="form-group row">
                                <div class="col-sm-offset-6 col-sm-6">
                                    <label for="sent_type" class="col-form-label">هل تم الاستيضاح عن المعلومات المطلوبة؟</label>
                                    <div class="col-sm-2">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio2" value="0"> لا
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio2" value="1"> نعم
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8" id="reformulate_div" style="display: none;">
                                    <label class="col-sm-12 col-form-label">إعادة صياغة محتوى
                                        ال{{$form_type->find($type)->name}} بناءً على نتيجة الاستيضاح:</label>
                                    <input class="form-control " type="text"  id="reformulate_content" name="reformulate_content" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8" id="reason_lack_clarification_div" style="display: none">
                                    <label class="col-sm-4 col-form-label">سبب عدم الاستيضاح</label>
                                    <input class="form-control" type="text" id="reason_lack_clarification" name="reason_lack_clarification" autocomplete="off">
                                </div>
                            </div>
                            <br>
                        @endif
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-6 col-sm-6">
                            <label class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة لإغلاق؟</label>
                            <div class="col-sm-2">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio3" value="0"> لا
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio3" value="1"> نعم
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="col-sm-8" id="reprocessing_div" style="display: none">
                                <p>إعادة معالجة ال{{$form_type->find($type)->name}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                            <div style="margin-bottom: 20px;" class="col-sm-12">
                                <div class="col-sm-8" id="stop_div" style="display: none">
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
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <button id="submit_update_clarification" class="btn btn-danger">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>

            {{-------------------------------------------------------}}

            <button class="accordion hide_div">
                رابعاً: الحاجة لإعادة تصنيف فئة ال{{$form_type->find($type)->name}}
            </button>
            <div class="panel hide_div" id="changecategorydiv">
                <br>
                @if($item->old_category_id)
                    <div class="row">
                        <div class="col-sm-6">
                            <label>اسم المستخدم الذي قام بالتعديل</label>
                            <input class="form-control" value="{{$item->user_change_category->name}}" readonly />
                        </div>
                        <div class="col-sm-6">
                            <label>فئة ال{{$form_type->find($type)->name}} المعدلة </label>
                            <input class="form-control" value="{{$item->old_category->name}}" readonly />
                        </div>
                    </div>
                @else
                    <form id="update_category_form_modal">
                        <input type="hidden" id="updated_category_id" value="{{$item->id}}">
                        <div class="form-group row">
                            <div class="col-sm-6 col-sm-offset-6">
                                <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة لإعادة تصنيف فئته/ا؟</label>
                                <div class="col-sm-2">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradio4" value="0" checked>لا
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="post-format-gallery"
                                                   name="optradio4" value="1"> نعم
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>

                        <div class="form-group row" id="updated_category_div">
                            <div class="col-sm-2">
                                <button id="submit_update_categpry" class="btn btn-danger">تعديل الفئة</button>
                            </div>
                            <div class="col-sm-10">
                                <label class="col-sm-4 col-form-label">فئة {{$form_type->find($type)->name}} (2)</label>
                                @if($item->type == 1)
                                    <select  class="form-control" id="updated_category_name" name="category_id" style="width: 60% !important;">
                                        <option value="">اختر فئة الشكوى</option>
                                        @foreach($categories as $cat)
                                            @if($cat->is_complaint != 0)
                                                <option value="{{$cat->id}}" @if($item->category_id==$cat->id)selected @endif>{{$cat->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                @elseif($item->type == 2)
                                    <select  class="form-control" id="updated_category_name1" name="category_id" style="width: 60% !important;">
                                        <option value=""> اختر فئة الاقتراح</option>
                                        @foreach($categories as $cat)
                                            @if($cat->is_complaint != 1)
                                                <option value="{{$cat->id}}" @if($item->category_id==$cat->id)selected @endif>{{$cat->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </form>
                @endif
            </div>

            {{-------------------------------------------------------}}
            <button class="accordion hide_div">
                خامساً: الردود والمتابعات
            </button>
            <div class="panel hide_div" id="replies">
                <br>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="sent_type" class="col-sm-4 col-form-label">حالة الرد</label>
                        <?php
                        if($item->status == 1){
                            $replay_status = "قيد الدراسة";
                        }elseif($item->status == 2){
                            $replay_status = "تم الرد";
                        }else{
                            $replay_status= "";
                        }
                        ?>
                        <input style="width: 65% !important;" type="text" class="form-control" id="replay_status" name="replay_status" value="{{$replay_status}}" readonly>
                    </div>
                    <div class="col-sm-8">
                        <label for="sent_type" class="col-sm-4 col-form-label">الجهة المختصة بالدراسة والمعالجة</label>
                        <input type="hidden" class="form-control" name="replay_user_id" value="{{Auth::user()->id}}">
                        <?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>

                        <input style="width: 65% !important;" type="text" class="form-control" name="replay_user_name" readonly
                               value="{{ Auth::user()->account->full_name }}">
                    </div>
                </div>
                {{--2--}}
                <form action="{{route('change_response_and_update_form_data' , $item->id)}}"  method="POST">
                    @csrf
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">التصنيف بناءً على الإجراءات المطلوبة:</label>
                            <select  id="response_type_select"  name="response_type" class="form-control" style="width: 50% !important;">
                                <option value="">اختر نوع</option>
                                <option value="0"> يمكن الرد عليها مباشرة</option>
                                <option value="1">تتطلب إجراءات مطولة للرد عليه</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div id="replay_advanced" style="display: none">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="response_type" class="col-sm-4 col-form-label">طبيعة الإجراءات  المطولة المطلوبة</label>
                                <select  name="required_respond" class="form-control" style=" width: 50%;">
                                    <option value="زيارة ميدانية / فنية"> زيارة ميدانية / فنية</option>
                                    <option value="نقاش من خلال لجنة الاقتراحات والشكاوى">نقاش من خلال لجنة الاقتراحات والشكاوى</option>
                                    <option value="نقاش مع الجهات الشريكة/ الممولة">نقاش مع الجهات الشريكة/ الممولة</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="response_type" class="col-sm-4 col-form-label">تحميل ملف توثيق الإجراء</label>
                                <input type="file" name="form_file" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="response_type" class="col-sm-4 col-form-label">تاريخ تنفيذ الإجراء</label>
                                <input type="date" name="form_data" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="form-group row" align="left">
                        <div class="col-sm-12">
                            <button type="submit"  class="wow bounceIn btn btn-info btn-md"
                                    style="width: 15%; background-color:#BE2D45;border:0;">
                                حفظ
                            </button>
                        </div>
                    </div>
                </form>
                {{--3--}}
                <hr>
                <div class="col-sm-12" style="text-align: center;">
                    @if($item->type=='1')
                        @if($item->status!="3"
                        &&
                            Auth::user()->account->circle->circle_categories->where('category_id',$item->category->id)->where('to_replay',1)->first()
                            &&
                            Auth::user()->account->account_projects->where('project_id',$item->project->id)->where('to_replay',1)->first()
                            )
                            <form method="post" action="/account/form/addreplay/{{$item->id}}">
                                @csrf
                                <textarea name="response" rows="8" cols="105" style="border-radius: 10px;"></textarea><br>
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
                            <textarea name="response" rows="8" cols="105" style="border-radius: 10px;"></textarea><br>
                            <input type="submit" value="إرسال الرد">
                        </form>
                    @endif


                </div>
                <br><br><br>

                <hr>
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
                <div class="form-group row">
                    <div class="col-sm-12">
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

                </div>
            </div>

            {{-------------------------------------------------------}}

            <button class="accordion hide_div" id="deleted">
                سادساً : الحاجة لحذف ال{{$form_type->find($type)->name}}
            </button>
            <div class="panel hide_div" id="deleted_main_div">
                <br>
                <form id="delete_form_modal">
                    <input type="hidden" id="deleted_id" value="{{$item->id}}">
                    <div class="form-group row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة
                                للحذف؟</label>
                            <div class="col-sm-2">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio" value="0" checked>لا
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" id="post-format-gallery"
                                               name="optradio" value="1"> نعم
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="form-group row deleted_div">
                        <div class="col-sm-6">
                            <label for="sent_type" class="col-sm-4 col-form-label">تاريخ الحذف</label>
                            <input type="text" class="form-control" name="deleted_at" readonly
                                   value="{{\Carbon\Carbon::now()}}">


                        </div>
                        <div class="col-sm-6">
                            <label for="sent_type" class="col-sm-4 col-form-label">اسم موظف الذي قام بالحذف</label>
                            <input type="hidden" class="form-control" name="deleted_by" value="{{Auth::user()->id}}">
                            <?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>
                            <input type="text" class="form-control" name="deleted_by_name" readonly
                                   value="{{ Auth::user()->account->full_name }}">

                        </div>
                    </div>
                    <div class="form-group row deleted_div">
                        <div class="col-sm-2">
                            <button id="submit_delete" class="btn btn-danger" style="margin-top: 25px;">تأكيد الحذف</button>
                        </div>

                        <div class="col-sm-10">
                            <label for="sent_type" class="col-sm-4 col-form-label">سبب الحذف</label>
                            <input type="text" class="form-control" id="deleting_reason" placeholder="سبب الحذف"
                                   required>
                        </div>
                    </div>
                </form>
            </div>
            {{-------------------------------------------------------}}
            <button class="accordion hide_div">
                سابعاً: التغذية الراجعة
            </button>
            <div class="panel hide_div" id="rank_div">
                <br>
                @if(!auth()->user() && $item->status!="3" )
                    <div class="col-sm-12" >
                        <br>
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
                                    <div id="appear">
                                                    <textarea name="notes" rows="8" cols="80" style="margin-top:0;"
                                                              placeholder=" الرجاء وصف المشكلة مرة أخرى"></textarea><br><br>
                                    </div>
                                </div>
                                <div class="form-group row" align="left">
                                    <div class="col-sm-12">
                                        <button type="submit"  class="wow bounceIn btn btn-info btn-md"
                                                style="width: 15%; background-color:#BE2D45;border:0;">
                                            أدخل تقييمك
                                        </button>
                                    </div>
                                </div>

                            </form>
                        @endif

                    </div>
                    <br>
                @endif
                @if(auth()->user())
                    <form>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="sent_type" class="col-sm-4 col-form-label">الجهة المسؤولة عن تبليغ الرد (موظف الاتصال)</label>
                                <?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>

                                <input style="width: 65% !important;" type="text" class="form-control" name="replay_user_name" readonly
                                       value="{{ Auth::user()->account->full_name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            @if($item->status == 1)
                                <div class="col-sm-12">
                                    <label for="sent_type" class="col-sm-4 col-form-label">حالة تبليغ الرد</label>
                                    <input value="قيد تبليغ الرد" class="form-control" readonly>
                                </div>

                            @elseif($item->status  == 2)
                                <div class="col-sm-6">
                                    <label for="sent_type" class="col-sm-4 col-form-label">تاريخ تبليغ الرد</label>
                                    <input value="{{$item->datee}}" class="form-control" readonly>
                                </div>

                                <div class="col-sm-6">
                                    <label for="sent_type" class="col-sm-4 col-form-label">حالة تبليغ الرد</label>
                                    <input value="تم تبليغ الرد" class="form-control" readonly>
                                </div>
                            @else
                                <div class="col-sm-6">
                                    <label for="sent_type" class="col-sm-4 col-form-label">سبب عدم تبليغ الرد</label>

                                    <select id="follow_reason_not" name="follow_reason_not" class="form-control">
                                        <option value="">اختر السبب</option>
                                        <option value="عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة.">عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة.</option>
                                        <option value="أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.">أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.</option>
                                        <option value="أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)">أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)</option>

                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="sent_type" class="col-sm-4 col-form-label">حالة تبليغ الرد</label>
                                    <input value="لم يتم تبليغ الرد" class="form-control" readonly>
                                </div>

                            @endif
                        </div>

                        <div class="form-group row">



                            @if($item->evaluate)
                                @if($item->evaluate == 1)
                                    <div class="col-sm-6">
                                        <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>
                                        <input value="راضي بشكل كبير" class="form-control" readonly>
                                    </div>
                                    <br>
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
                                @elseif($item->evaluate==2)
                                    <div class="col-sm-6">
                                        <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>
                                        <input value="راضي بشكل متوسط" class="form-control" readonly>
                                    </div>
                                    <br>
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
                                @elseif($item->evaluate == 3)
                                    <div class="col-sm-6">
                                        <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>
                                        <input value="راضي بشكل ضعيف" class="form-control" readonly>
                                    </div>
                                    <br>
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
                                @else
                                    <div class="col-sm-6">
                                        <label class="col-sm-4 col-form-label">
                                            سبب عدم الرضا عن الرد
                                        </label>
                                        <input id="evaluate_note" name="evaluate_note" class="form-control">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>
                                        <input value="غير راضي عن الرد" class="form-control" readonly>
                                    </div>



                                @endif
                            @endif
                        </div>
                    </form>
                @endif
            </div>
            {{-------------------------------------------------------}}
            <button class="accordion hide_div">
                ثامناً: توصيات ذات العلاقة بمحتوى ال{{$form_type->find($type)->name}}
            </button>
            <div class="panel hide_div">

                <br>
                @if(!$recomendations)
                    <h4>عزيزي الموظف يمكنك من هنا رفع التوصيات التي تستحق الدراسة من قبل المركز لاتخاذها بعين الاعتبار
                        في تصميم مشاريع مستقبلية:</h4>
                    <form method="POST" class="form-horizontal" action="/citizen/saverecommendations">
                        @csrf
                        <input name="form_id" type="hidden" value="{{$item->id}}">
                        <input name="user_id" type="hidden" value="{{Auth::user()->id}}">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                       <textarea id="content"
                                                 class="form-control {{($errors->first('content') ? " form-error" : "")}}"
                                                 rows="6" id="content" name="content">{{old("content")}}</textarea>

                                {!! $errors->first('content', '<p class="help-block" style="color:red;">:message</p>') !!}
                            </div>

                        </div>

                        <div class="form-group row" align="center">
                            <div class="col-sm-12">
                                <button type="submit" id="submitBtn" class="wow bounceIn btn btn-info btn-md"
                                        style="width: 30%; background-color:#BE2D45;border:0;">
                                    رفع التوصيات
                                </button>
                            </div>
                        </div>

                    </form>
                @else
                    <div class="content">
                        <h5>{{$recomendations->content}}</h5>
                        <h6>بواسطة {{$recomendations->user->name}}</h6>
                    </div>
                @endif
            </div>

            {{-------------------------------------------------------}}


            <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
                 aria-hidden="true" style=" position: absolute;left: 42%;top: 40%;transform: translate(-50%, -50%);">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="smallBody">
                            <div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12 text-center">
                <div style=" margin-bottom: 15px;padding: 5px">
                    <form style="display:inline" action="/citizen/form/show/{{$item->citizen->id_number}}/{{$item->id}}">
                        <button type="submit" target="_blank" name="theaction" title="طباعة" style="width:70px;"
                                value="print"
                                class="btn btn-success">
                            طباعة
                        </button>
                    </form>
                    <a href="/account/form" class="btn btn-danger ">الغاء الأمر &times; </a>
                </div>
            </div>
        </div>
    </div>

    <!--****************************************************** start footer **************************************************************-->
@endsection
        @endif
    @endforeach
@else
    @section("content")
    <div class="row" style="text-align:center;">
        <br>
        <br>
        <br>
        <br>
        <h2 class="col-sm-6" style="margin-top:120px;margin-bottom:30px;color:#af0922;margin-left:337px;">يرجى التأكد من صحة الرابط المراد الوصول له</h2>
    </div>
@endsection
@endif
@section('js')
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                panel.classList.toggle("open");
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";

                }
            });
        }
    </script>

    <script>
        $(document).on('click', '#smallButton', function (event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function () {
                    $('#loader').show();
                },
                // return the result
                success: function (result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                },
                complete: function () {
                    $('#loader').hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>

    <script>

        $(document).ready(function () {
            $('.deleted_div').hide();
            $('#updated_category_div').hide();
            $('input:radio[name="optradio"]').click(function () {
                var inputValue = $("input[name='optradio']:checked").val();
                if (inputValue == 1) {
                    $('.deleted_div').show();
                } else {
                    $('.deleted_div').hide();
                }
            });

            $('input:radio[name="optradio2"]').click(function () {
                var inputValue = $("input[name='optradio2']:checked").val();
                if (inputValue == 1) {
                    $('#reformulate_div').show();
                    $('#reason_lack_clarification_div').hide();
                    $('.hide_div').show();
                } else if (inputValue == 0) {
                    $('#reason_lack_clarification_div').show();
                    $('#reformulate_div').hide();
                    $('.hide_div').hide();
                }else{
                    $('#reason_lack_clarification_div').hide();
                    $('#reformulate_div').hide();
                    $('.hide_div').show();
                }
            });

            $('input:radio[name="optradio3"]').click(function () {
                var inputValue = $("input[name='optradio3']:checked").val();
                if (inputValue == 1) {
                    $('#stop_div').show();
                    $('#reprocessing_div').hide();
                } else if (inputValue == 0) {
                    $('#reprocessing_div').show();
                    $('#stop_div').hide();
                }else{
                    $('#reprocessing_div').hide();
                    $('#stop_div').hide();
                }
            });

            $('input:radio[name="optradio4"]').click(function () {
                var inputValue = $("input[name='optradio4']:checked").val();
                if (inputValue == 1) {
                    $('#updated_category_div').show();
                } else {
                    $('#updated_category_div').hide();
                }
            });

            $('input:radio[name="optradio1"]').click(function () {
                var inputValue = $("input[name='optradio1']:checked").val();
                if (inputValue == 1) {
                    $('#explain_main_div').show();
                } else {
                    $('#explain_main_div').hide();
                }
            });
        });

    </script>

    <script>
        $('#delete_form_modal').submit(function(e) {
            var id = $('#deleted_id').val();
            e.preventDefault();
            if (!id)
                return;
            var reason = $("#deleting_reason").val();
            console.log('Reason Before: ', reason);
            $.post("{{route('destroy_from_citizian')}}", {"_token": "{{csrf_token()}}", 'id': id, 'reason': reason}, function(data){
                $("#deleting_reason").val('');
                $('#message_session').show();
                $('#content_message').text(data.msg);
            });
        });

        $('#update_clarification_form_modal').submit(function(e) {
            var id = $('#clarification_id').val();
            e.preventDefault();
            if (!id)
                return;

            var need_clarification = $("input[name='optradio1']:checked").val();
            var have_clarified = $("input[name='optradio2']:checked").val();
            var reformulate_content =$('#reformulate_content').val();
            var reason_lack_clarification = $('#reason_lack_clarification').val();
            var reprocessing = $("input[name='optradio3']:checked").val();
            $.post("/account/form/clarification_from_citizian/"+id, {"_token": "{{csrf_token()}}", "method": "put",
                'need_clarification': need_clarification,'have_clarified':have_clarified,'reformulate_content':reformulate_content,
                'reason_lack_clarification':reason_lack_clarification,'reprocessing':reprocessing}, function(data){
                $('#message_session').show();
                $('#content_message').text(data.msg);
            });
        });


        $('#update_category_form_modal').submit(function(e) {
            var id = $('#updated_category_id').val();
            e.preventDefault();
            if (!id)
                return;
            var category_id = "";
            <?php if($type == 1){?>
                category_id = $("#updated_category_name").val();
            <?php } else{ ?>
                category_id = $("#updated_category_name1").val();
            <?php } ?>
            console.log('Reason Before1: ', category_id);
            $.post("/account/form/change-category/"+id, {"_token": "{{csrf_token()}}", "method": "put", 'category_id': category_id}, function(data){
                console.log(data.msg);
                <?php if($type == 1){?>
                $("#updated_category_name").val(category_id);
                <?php } else{ ?>
                $("#updated_category_name1").val(category_id);
                <?php } ?>
                $('#message_session').show();
                $('#content_message').text(data.msg);
            });
        });

        $('#response_type_select').change(function() {

            if($(this).val() == '1'){
                $("#replay_advanced").show();
            }else{
                $("#replay_advanced").hide();
            }

        });
    </script>
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

@endsection
