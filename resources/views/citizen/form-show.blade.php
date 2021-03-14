@extends("layouts._citizen_layout")
@section("title", " معالجة ال".$form_type->find($type)->name)
@section('css')
    <style>

        .importantRule {
            overflow: visible !important;
        }

        [v-cloak] {
            display: none;
        }

        body {
            overflow-x: hidden;
        }

        .accordion,.accordion1 {
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

        .accordion:after,.accordion1:after {
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

        #explain_div.open, #rank_div.open {
            min-height: 420px !important;
            max-height: 550px !important;
        }

        #deleted_main_div.open {
             min-height: 500px !important;
             max-height: 650px !important;
         }
    </style>
@endsection

@if($auth_circle_users)
    @foreach($auth_circle_users as $AccountProjects_user)
        @if($AccountProjects_user == auth()->user()->account->id)
            @section("content")
                <div class="row" style="" id="auth_circle_users">
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
                        <?php
                        $project_arr = array();
                        foreach ($item->citizen->projects as $project) {
                            array_push($project_arr, $project->id);
                        }
                        ?>
                        <td colspan="3">@if(!in_array($item->project->id,$project_arr)){{'غير مستفيد من مشاريع المركز'}}@else{{'مستفيد من مشاريع المركز '}}@endif</td>
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
                            <td class="mo">فئة ال{{$form_type->find($type)->name}} المعدلة بناءً على محتوى ال{{$form_type->find($type)->name}}:</td>
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
                            <td class="mo">محتوى  ال{{$form_type->find($type)->name}} المعدل بناءً على نتيجة الاستيضاح</td>
                            <td>{{$item->reformulate_content}}</td>

                            <td class="mo">اسم المستخدم الذي قام بالاستيضاح</td>
                            <td>{{$item->user_change_content->full_name}}</td>
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
                @if(!$item->need_clarification)
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
                                        <input type="radio" class="form-check-input" name="optradio1" value="1">
                                        نعم
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="explain_main_div" style="display: none;">

                            <div class="form-group row">
                                <div class="col-sm-offset-6 col-sm-6">
                                    <label for="sent_type" class="col-form-label">هل تم الاستيضاح عن المعلومات
                                        المطلوبة؟</label>
                                    <div class="col-sm-2">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio2" value="0">
                                                لا
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio2" value="1">
                                                نعم
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8" id="reformulate_div" style="display: none;">
                                    <label class="col-sm-12 col-form-label">إعادة صياغة محتوى
                                        ال{{$form_type->find($type)->name}} بناءً على نتيجة الاستيضاح:</label>
                                    <input class="form-control " type="text" id="reformulate_content"
                                           name="reformulate_content" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8" id="reason_lack_clarification_div" style="display: none">
                                    <label class="col-sm-4 col-form-label">سبب عدم الاستيضاح</label>
                                    <input class="form-control" type="text" id="reason_lack_clarification"
                                           name="reason_lack_clarification" autocomplete="off">
                                </div>
                            </div>
                            <br>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <button id="submit_update_clarification" class="btn btn-danger">حفظ</button>
                        </div>
                    </div>
            </form>
                @else

                    <div class="form-group row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة
                                لاستيضاح عن مضمونه/ا؟</label>
                            <div class="col-sm-2">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio1" value="0" @if($item->need_clarification && $item->need_clarification == 0) {{"checked disabled"}} @elseif($item->need_clarification && $item->need_clarification == 1){{"disabled"}} @endif> لا
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio1"
                                               value="1" @if($item->need_clarification && $item->need_clarification == 1) {{"checked disabled"}}@elseif($item->need_clarification && $item->need_clarification == 0){{"disabled"}} @endif>
                                        نعم
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
                                        <input class="form-control" value="{{$item->user_change_content->full_name}}"
                                               readonly/>
                                    </div>
                                    <div class="col-sm-6"><label>محتوى ال{{$form_type->find($type)->name}} المعدل بعد
                                            الاستيضاح </label>
                                        <input class="form-control" value="{{$item->reformulate_content}}" readonly/>
                                    </div>
                                </div>
                                <br>
                            @elseif($item->reason_lack_clarification)
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>اسم المستخدم الذي قام بالاستيضاح</label>
                                        <input class="form-control" value="{{$item->user_change_content->full_name}}" readonly/>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>سبب عدم الاستيضاح</label>
                                        <input class="form-control" value="{{$item->reason_lack_clarification}}" readonly/>
                                    </div>

                                </div>
                                <br>
                            @else
                                <div class="form-group row">
                                    <div class="col-sm-offset-6 col-sm-6">
                                        <label for="sent_type" class="col-form-label">هل تم الاستيضاح عن المعلومات
                                            المطلوبة؟</label>
                                        <div class="col-sm-2">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="optradio2" value="0">
                                                    لا
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="optradio2" value="1">
                                                    نعم
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-8" id="reformulate_div" style="display: none;">
                                        <label class="col-sm-12 col-form-label">إعادة صياغة محتوى
                                            ال{{$form_type->find($type)->name}} بناءً على نتيجة الاستيضاح:</label>
                                        <input class="form-control " type="text" id="reformulate_content"
                                               name="reformulate_content" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-8" id="reason_lack_clarification_div" style="display: none">
                                        <label class="col-sm-4 col-form-label">سبب عدم الاستيضاح</label>
                                        <input class="form-control" type="text" id="reason_lack_clarification"
                                               name="reason_lack_clarification" autocomplete="off">
                                    </div>
                                </div>
                                <br>
                            @endif

                                @if(!is_null($item->reprocessing))
                                    <hr>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <input class="form-control" value="{{$item->user_reprocessing_recommendations->full_name}}"
                                                   readonly/>
                                        </div>

                                        <div class="col-sm-6">
                                            <label>الجهة الإدارية المسؤولة عن متابعة الجهة المختصة بمعالجة ال{{$form_type->find($type)->name}}</label>
                                        </div>

                                        <br>
                                        <div class="col-sm-12">
                                            <label>التوصيات </label>
                                            @if( $item->reprocessing)
                                                <h4 style="color: red;">
                                                    يوصي بإغلاق ال{{$form_type->find($type)->name}}
                                                </h4>
                                            @else
                                                <h4 style="color: red;">
                                                    يوصي بإعادة معالجة ال{{$form_type->find($type)->name}}  مع أخذ بعين الاعتبار التوصيات التالية
                                                </h4>
                                                <input class="form-control" value="{{$item->reprocessing_recommendations}}" readonly/>
                                            @endif
                                        </div>

                                    </div>
                                    <br>
                                @endif
                        </div>
                @endif
        </div>

        {{-------------------------------------------------------}}

        <button class="accordion hide_div" id="deleted">
            رابعاً : الحاجة لحذف ال{{$form_type->find($type)->name}}
        </button>
        <div class="panel hide_div" id="deleted_main_div">
            <br>

            @if($item->confirm_deleting  || $item->deleted_at)
                <form id="delete_form_modal">
                    <input type="hidden" id="deleted_id" value="{{$item->id}}">
                    <div class="form-group row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة
                                للحذف؟</label>
                            <div class="col-sm-2">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio" value="0">لا
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" id="post-format-gallery"
                                               name="optradio" value="1" checked disabled> نعم
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="sent_type" class="col-sm-4 col-form-label">تاريخ الحذف</label>
                            <input type="text" class="form-control" name="deleted_at" readonly
                                   value="@if(!$item->deleted_at){{$item->confirm_deleting}}@else{{$item->deleted_at}}@endif">
                        </div>
                        <div class="col-sm-6">
                            <label for="sent_type" class="col-sm-4 col-form-label">اسم موظف الذي قام بالحذف</label>
                            <input type="text" class="form-control" name="deleted_by_name" readonly
                                   value="{{ $item->deleted_user->name }}" readonly>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="sent_type" class="col-sm-4 col-form-label">سبب الحذف</label>
                            <input type="text" class="form-control" id="deleting_reason" placeholder="سبب الحذف"
                                   value="{{$item->deleted_because}}" readonly>
                        </div>
                    </div>
                </form>
                @if($item->recommendations_for_deleting)
                   <hr>
                    <h4>وفيما يلي توصيات الجهة الإدارية المسؤولة بخصوص حذف {{$form_type->find($type)->name}}:</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td>الجهة الإدارية المسؤولة عن متابعة الجهة المختصة بمعالجة {{$form_type->find($type)->name}}:</td>
                            <td>{{$item->user_recommendations_for_deleting->full_name}}</td>
                        </tr>
                        <tr>
                            <td>التوصيات:</td>
                            <td>{{$item->recommendations_for_deleting}}</td>
                        </tr>
                    </table>
                @endif
            @else
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
                            <button id="submit_delete" class="btn btn-danger" style="margin-top: 25px;">تأكيد الحذف
                            </button>
                        </div>

                        <div class="col-sm-10">
                            <label for="sent_type" class="col-sm-4 col-form-label">سبب الحذف</label>
                            <input type="text" class="form-control" id="deleting_reason" placeholder="سبب الحذف"
                                   required>
                        </div>
                    </div>
                </form>
            @endif
        </div>

        {{-------------------------------------------------------}}

        <button class="accordion hide_div">
            خامساً: الحاجة لإعادة تصنيف فئة ال{{$form_type->find($type)->name}}
        </button>
        <div class="panel hide_div" id="changecategorydiv">
            <br>
            @if($item->old_category_id)
                <div class="row">
                    <div class="col-sm-6">
                        <label>اسم المستخدم الذي قام بالتعديل</label>
                        <input class="form-control" value="{{$item->user_change_category->name}}" readonly/>
                    </div>
                    <div class="col-sm-6">
                        <label>فئة ال{{$form_type->find($type)->name}} المعدلة </label>
                        <input class="form-control" value="{{$item->old_category->name}}" readonly/>
                    </div>
                </div>
            @else
                <form id="update_category_form_modal">
                    <input type="hidden" id="updated_category_id" value="{{$item->id}}">
                    <div class="form-group row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}}
                                بحاجة لإعادة تصنيف فئته/ا؟</label>
                            <div class="col-sm-2">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio4" value="0"
                                               checked>لا
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
                                <select class="form-control" id="updated_category_name" name="category_id"
                                        style="width: 60% !important;">
                                    <option value="">اختر فئة الشكوى</option>
                                    @foreach($categories as $cat)
                                        @if($cat->is_complaint != 0)
                                            <option value="{{$cat->id}}"
                                                    @if($item->category_id==$cat->id)selected @endif>{{$cat->name}}</option>
                                        @endif
                                    @endforeach
                                </select>

                            @elseif($item->type == 2)
                                <select class="form-control" id="updated_category_name1" name="category_id"
                                        style="width: 60% !important;">
                                    <option value=""> اختر فئة الاقتراح</option>
                                    @foreach($categories as $cat)
                                        @if($cat->is_complaint != 1)
                                            <option value="{{$cat->id}}"
                                                    @if($item->category_id==$cat->id)selected @endif>{{$cat->name}}</option>
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
              سادساً: إجراءات الرد على {{$form_type->find($type)->name}}
        </button>
        <div class="panel hide_div" id="replies">
            <br>

            @if(($item->response_type != 0 || $item->response_type != 1) && !$item->form_response)
            <form action="{{route('change_response_and_update_form_data' , $item->id)}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="response_type" class="col-sm-4 col-form-label">الإجراءات المطلوبة للرد</label>
                        <select id="response_type_select" name="response_type" class="form-control"
                                style="width: 50% !important;">
                            <option value="">اختر نوع</option>
                            <option value="0">يمكن الرد عليها مباشرة</option>
                            <option value="1">تتطلب إجراءات مطولة للرد عليها</option>
                        </select>
                    </div>
                </div>
                <br>
                <div id="replay_advanced" style="display: none">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">طبيعة الإجراءات المطولة
                                المطلوبة</label>
                            <select name="required_respond" class="form-control" style=" width: 50%;">
                                <option value="">اختر الإجراء المطلوب</option>
                                <option value="زيارة ميدانية / فنية"> زيارة ميدانية / فنية</option>
                                <option value="نقاش من خلال لجنة الاقتراحات والشكاوى">نقاش من خلال لجنة الاقتراحات
                                    والشكاوى
                                </option>
                                <option value="نقاش مع الجهات الشريكة/ الممولة">نقاش مع الجهات الشريكة/ الممولة
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="response_type" class="col-sm-4 col-form-label">تحميل ملف توثيق
                                الإجراء</label>
                            <input type="file"  class="form-control " value="" id="form_file" name="form_file">

                        </div>
                        <div class="col-sm-6">
                            <label for="response_type" class="col-sm-4 col-form-label">تاريخ تنفيذ الإجراء</label>
                            <input type="text" class="form-control datepicker" name="form_data"
                                   placeholder="يوم / شهر / سنة"/>
                        </div>
                    </div>

                </div>

                <br>

                <div class="form-group row">
                    <div class="col-sm-12">
                    <label for="sent_type" class="col-sm-4 col-form-label">الجهة المختصة بالدراسة والمعالجة</label>
                    <input type="hidden" class="form-control" name="replay_user_id" value="{{Auth::user()->id}}">
                    <?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>

                    <input style="width: 65% !important;" type="text" class="form-control" name="replay_user_name"
                           readonly
                           value="{{ Auth::user()->account->full_name }}">
                </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">صياغة الرد</label>
                        <textarea name="response" rows="2" cols="102" style="border-radius: 10px;"></textarea>
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-sm-6">
                        <label for="sent_type" class="col-sm-4 col-form-label">تاريخ تسجيل الرد</label>
                        <input style="width: 65% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{date('Y-m-d')}}" readonly>
                    </div>

                    <div class="col-sm-6">
                        <label for="sent_type" class="col-sm-4 col-form-label">حالة الرد</label>
                        <?php
                        if ($item->status == 1) {
                            $replay_status = "قيد الدراسة";
                        } elseif ($item->status == 2) {
                            $replay_status = "تم الرد";
                        } else {
                            $replay_status = "";
                        }
                        ?>
                        <input style="width: 65% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$replay_status}}" readonly>
                    </div>
                </div>
            {{--2--}}

                <hr>

                <div class="form-group row" align="left">
                    <div class="col-sm-12">
                        <button type="submit" class="wow bounceIn btn btn-info btn-md"
                                style="width: 15%; background-color:#BE2D45;border:0;">
                            إرسال الرد للمصادقة
                        </button>
                    </div>
                </div>
            </form>
            @else
                <br><br>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="response_type" class="col-sm-4 col-form-label">الإجراءات المطلوبة للرد</label>
                        <select id="response_type_select" name="response_type" class="form-control"
                                style="width: 50% !important;" readonly="">
                            <option value="">اختر نوع</option>
                            <option @if($item->response_type==0)selected @endif  value="0">يمكن الرد عليها مباشرة</option>
                            <option @if($item->response_type==1)selected @endif  value="1">تتطلب إجراءات مطولة للرد عليها</option>
                        </select>
                    </div>
                </div>
                <br>
                <div id="replay_advanced" style="@if(!$item->required_respond)display: none @endif">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">طبيعة الإجراءات المطولة
                                المطلوبة</label>
                            <select name="required_respond" class="form-control" style=" width: 50%;" readonly="">
                                <option value="">اختر الإجراء المطلوب</option>
                                <option @if($item->required_respond=="زيارة ميدانية / فنية")selected @endif  value="زيارة ميدانية / فنية"> زيارة ميدانية / فنية</option>
                                <option @if($item->required_respond=="نقاش من خلال لجنة الاقتراحات والشكاوى")selected @endif  value="نقاش من خلال لجنة الاقتراحات والشكاوى">نقاش من خلال لجنة الاقتراحات
                                    والشكاوى
                                </option>
                                <option @if($item->required_respond=="نقاش مع الجهات الشريكة/ الممولة")selected @endif value="نقاش مع الجهات الشريكة/ الممولة">نقاش مع الجهات الشريكة/ الممولة
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">تاريخ تنفيذ الإجراء</label>
                            <input style=" width: 50%;" type="text" value="{{$item->form_data}}" class="form-control datepicker" readonly name="form_data"
                                   placeholder="يوم / شهر / سنة"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">تحميل ملف توثيق الإجراء</label>

                            <a style="width: 50%;" target="_blank" class="btn btn-primary"  href="{{ route('downloadfiles', $item->id) }}" >تحميل ملف توثيق الإجراء</a>
                        </div>
                    </div>

                </div>

                <br>


                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">الجهة المختصة بالدراسة والمعالجة</label>
                        <input style="width: 50% !important;" type="text" class="form-control" name="replay_user_name"
                               readonly
                               value="{{ $item->form_response->account->full_name }}" width="50%">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">صياغة الرد</label>
                        <textarea name="response" rows="2" cols="78" style="border-radius: 10px;" readonly disabled>{{$item->form_response->response}}</textarea>
                    </div>
                </div>

                @if($item->form_response->old_response)
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="sent_type" class="col-sm-4 col-form-label">صياغة  الرد المعدل بناءً على نتائج إجراءات المصادقة</label>
                            <textarea name="response_after_confirmation" rows="2" cols="78" style="border-radius: 10px;" readonly disabled>{{$item->form_response->old_response}}</textarea>
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">تاريخ تسجيل الرد</label>
                        <input style="width: 50% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$item->form_response->datee}}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">حالة الرد</label>
                        <?php
                        if ($item->status == 1) {
                            $replay_status = "قيد الدراسة";
                        } elseif ($item->status == 2) {
                            $replay_status = "تم الرد";
                        } else {
                            $replay_status = "";
                        }
                        ?>
                        <input style="width: 50% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$replay_status}}" readonly>
                    </div>
                </div>
            @endif
            </div>
        </div>

        {{-------------------------------------------------------}}
        <button class="accordion hide_div">
            سابعاً: إجراءات المصادقة على الرد
        </button>
        <div class="panel hide_div" id="rank_div">
            <br>
            <br>
            @if($item->form_response)
                @if($item->form_response->objection_response)
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">الجهة المختصة بالمصادقة</label>
                        <input style="width: 65% !important;" type="text" class="form-control" name="confirm_replay_user_name" readonly value="{{ $item->form_response->confirm_account->full_name }}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-offset-6 col-sm-6">
                        <label for="sent_type" class="col-form-label">هل يوجد اعتراض على الرد</label>
                        <div class="col-sm-2">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio8" value="0" @if( $item->form_response->objection_response== 0) {{"checked disabled"}} @endif>
                                    لا
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio8" value="1" @if($item->form_response->objection_response== 1) {{"checked disabled"}} @endif>
                                    نعم
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8" id="objection_response_div" style="@if(!$item->form_response->objection_response == 1)display: none;@endif">
                        <label class="col-sm-12 col-form-label">يرجي إعادة صياغة الرد</label>
                        <textarea name="old_response" rows="2" cols="78" style="border-radius: 10px;">@if($item->form_response->old_response) {{$item->form_response->old_response}} @endif</textarea>

                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-sm-6">
                        <label for="sent_type" class="col-sm-4 col-form-label">تاريخ المصادقة</label>
                        <input style="width: 65% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$item->form_response->confirmation_date}}" readonly>
                    </div>

                    <div class="col-sm-6">
                        <label for="sent_type" class="col-sm-4 col-form-label">حالة المصادقة</label>
                        <?php
                        if ($item->form_response->confirmation_status == 1) {
                            $replay_status = "قيد المصادقة";
                        } elseif ($item->form_response->confirmation_status == 2) {
                            $replay_status = "تمت المصادقة";
                        } else {
                            $replay_status = "لم تتم المصادقة";
                        }
                        ?>
                        <input style="width: 65% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$replay_status}}" readonly>
                    </div>
                </div>
            @endif
            @endif
        </div>

        {{-------------------------------------------------------}}
        <button class="accordion hide_div">
            ثامناً: التغذية الراجعة
        </button>
        <div class="panel hide_div" id="rank_div">
            <br>
            <br>
            @if($item->form_follow)

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">الجهة المسؤولة عن تبليغ الرد
                            (موظف الاتصال)</label>
                        <input style="width: 65% !important;" type="text" class="form-control"
                               name="replay_user_name" readonly
                               value="{{ $item->form_follow->account->full_name }}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">حالة تبليغ الرد</label>
                        <select class="form-control" id="follow_form_status" name="follow_form_status" style="width: 65% !important;" disabled>
                            <option @if($item->form_follow->solve == 1){{"selected"}}@endif value="1">تم تبليغ الرد</option>
                            <option @if($item->form_follow->solve == 2){{"selected"}}@endif value="2">لم يتم تبليغ الرد</option>
                        </select>
                    </div>

                </div>

                <div class="form-group row" id="follow_reason_not_div" style="@if($item->form_follow->solve == 1){{"display: none"}}@endif">
                    <div class="col-md-12">

                        <label for="sent_type" class="col-sm-4 col-form-label">سبب عدم تبليغ الرد</label>
                        <select id="follow_reason_not" name="follow_reason_not" class="form-control" style="width: 65% !important;" disabled>
                            <option value="">اختر السبب</option>
                            <option @if($item->form_follow->follow_reason_not == "عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة."){{"selected"}}@endif
                                    value="عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة.">
                                عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من
                                مرة.
                            </option>
                            <option @if($item->form_follow->follow_reason_not == "أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة."){{"selected"}}@endif value="أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.">أرقام
                                التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.
                            </option>
                            <option @if($item->form_follow->follow_reason_not == "أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)"){{"selected"}}@endif
                                    value="أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)">
                                أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً،
                                الرقم المطلوب لا يستقبل مكالمات، ...)
                            </option>

                        </select>
                    </div>
                </div>

                <hr>
                <div class="form-group row" id="feedback_div" style="@if($item->form_follow->solve == 2){{"display: none;"}} @endif">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>

                        <div class="col-sm-12">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" name="evaluate" @if($item->form_follow->evaluate == 1){{"checked"}}@endif class="form-check-input" value="1">راضي بشكل كبير
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" name="evaluate" @if($item->form_follow->evaluate == 2){{"checked"}}@endif class="form-check-input" value="2">راضي بشكل متوسط
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" name="evaluate" class="form-check-input" @if($item->form_follow->evaluate == 3){{"checked"}}@endif value="3">راضي بشكل ضعيف
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" name="evaluate" class="form-check-input" value="4" @if($item->form_follow->evaluate == 4){{"checked"}}@endif id="inp3">غير راضي عن الرد
                                </label>
                            </div>
                        </div>

                        @if($item->form_follow->evaluate)
                            <script>
                                $('input[name=evaluate]').attr('disabled',true);
                            </script>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <div id="div3" style="@if($item->form_follow->evaluate != 4){{"display:none;"}}@endif">
                            <h4>سبب عدم الرضا عن الرد</h4>
                            <div id="appear">
                                <textarea name="notes" rows="2" cols="78" style="border-radius: 10px;" disabled>{{$item->form_follow->notes}}</textarea>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {{-------------------------------------------------------}}
        <button class="accordion hide_div">
            تاسعاً: توصيات ذات العلاقة بمحتوى ال{{$form_type->find($type)->name}}
        </button>
        <div class="panel hide_div">

            <br>
                <h4>عزيزي الموظف يمكنك من هنا رفع التوصيات التي تستحق الدراسة من قبل المركز لاتخاذها بعين الاعتبار
                    في تصميم مشاريع مستقبلية:</h4>
                <form method="POST" class="form-horizontal" action="/citizen/saverecommendations">
                    @csrf
                    <input name="form_id" type="hidden" value="{{$item->id}}">
                    <input name="user_id" type="hidden" value="{{Auth::user()->id}}">
                    <div class="form-group row">
                        <div class="col-sm-12">
                                   <textarea id="content"
                                             class="form-control {{($errors->first('recommendations_content') ? " form-error" : "")}}"
                                             rows="6" id="recommendations_content" name="recommendations_content">{{old("recommendations_content")}}</textarea>

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


            @if($recomendations)
                <br>
                <h4 style="color: red;">توصيات المستخدمين</h4>
                <hr>
                @foreach($recomendations as $recomendation)
                <div class="content">
                    <h5>{{$recomendation->recommendations_content}}</h5>
                    <h6>بواسطة {{$recomendation->user->name}}</h6>
                    <hr>
                </div>
                @endforeach
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
                <form style="display:inline"
                      action="/citizen/form/show/{{$item->citizen->id_number}}/{{$item->id}}">
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
        @endsection
    @endif
@endforeach
@endif

@if($auth_circle_users2)
@foreach($auth_circle_users2 as $AccountProjects_user)
    @if($AccountProjects_user == auth()->user()->account->id)
        @section("content")
            <div class="row" style="" id="auth_circle_users2">
                <div>
                    <h2 class="col-sm-12" style="margin-top:120px;margin-bottom:20px;margin-left:0px;">
                        متابعة ال{{$item->form_type->name}}
                        <hr class="h1-hr" style="margin-right: 10px;">
                    </h2>
                    <hr>


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
                    <?php
                    $project_arr = array();
                    foreach ($item->citizen->projects as $project) {
                        array_push($project_arr, $project->id);
                    }
                    ?>
                    <td colspan="3">@if(!in_array($item->project->id,$project_arr)){{'غير مستفيد من مشاريع المركز'}}@else{{'مستفيد من مشاريع المركز '}}@endif</td>
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
                        <td class="mo">فئة ال{{$form_type->find($type)->name}} المعدلة بناءً على محتوى ال{{$form_type->find($type)->name}}:</td>
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
                        <td class="mo">محتوى  ال{{$form_type->find($type)->name}} المعدل بناءً على نتيجة الاستيضاح</td>
                        <td>{{$item->reformulate_content}}</td>

                        <td class="mo">اسم المستخدم الذي قام بالاستيضاح</td>
                        <td>{{$item->user_change_content->full_name}}</td>
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
            @if($item->need_clarification)
            <form id="update_clarification_form_modal">
                <input type="hidden" id="clarification_id" value="{{$item->id}}">
                <div class="form-group row">
                    <div class="col-sm-6 col-sm-offset-6">
                        <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة
                            لاستيضاح عن مضمونه/ا؟</label>
                        <div class="col-sm-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio1" value="0" @if($item->need_clarification && $item->need_clarification == 0) {{"checked disabled"}} @elseif($item->need_clarification && $item->need_clarification == 1){{"disabled"}} @endif> لا
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio1"
                                           value="1" @if($item->need_clarification && $item->need_clarification == 1) {{"checked disabled"}}@elseif($item->need_clarification && $item->need_clarification == 0){{"disabled"}} @endif>
                                    نعم
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
                                <input class="form-control" value="{{$item->user_change_content->full_name}}"
                                       readonly/>
                            </div>
                            <div class="col-sm-6"><label>محتوى ال{{$form_type->find($type)->name}} المعدل بعد
                                    الاستيضاح </label>
                                <input class="form-control" value="{{$item->reformulate_content}}" readonly/>
                            </div>
                        </div>
                        <br>
                    @elseif($item->reason_lack_clarification)
                        <div class="row">
                            <div class="col-sm-6">
                                <label>اسم المستخدم الذي قام بالاستيضاح</label>
                                <input class="form-control" value="{{$item->user_change_content->full_name}}" readonly/>
                            </div>

                            <div class="col-sm-6">
                                <label>سبب عدم الاستيضاح</label>
                                <input class="form-control" value="{{$item->reason_lack_clarification}}" readonly/>
                            </div>
                        </div>
                        <br>
                    @endif
                </div>

                <hr>

                @if(!is_null($item->reprocessing))
                    <hr>
                    <div class="row">

                        <div class="col-sm-6">
                            <input class="form-control" value="{{$item->user_reprocessing_recommendations->full_name}}"
                                   readonly/>
                        </div>

                        <div class="col-sm-6">
                            <label>الجهة الإدارية المسؤولة عن متابعة الجهة المختصة بمعالجة ال{{$form_type->find($type)->name}}</label>
                        </div>

                        <br>
                        <div class="col-sm-12">
                            <label>التوصيات </label>
                            @if( $item->reprocessing)
                                <h4 style="color: red;">
                                    يوصي بإغلاق ال{{$form_type->find($type)->name}}
                                </h4>
                            @else
                                <h4 style="color: red;">
                                    يوصي بإعادة معالجة ال{{$form_type->find($type)->name}}  مع أخذ بعين الاعتبار التوصيات التالية
                                </h4>
                                <input class="form-control" value="{{$item->reprocessing_recommendations}}" readonly/>
                            @endif
                        </div>

                    </div>
                    <br>

                @else

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة لإغلاق؟</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <div class="col-sm-12" id="stop_div" style="display: none">
                                    @if(Auth::user())
                                        @if(($item->status == 1 || $item->status == 2 || $item->status == 4))

                                            <a href="/account/form/terminateform/{{$item->id}}"
                                               class="btn btn-success">إيقاف {{$item->form_type->name}}</a>
                                        @elseif($item->deleted_at == null)
                                            <a href="/account/form/allowform/{{$item->id}}"
                                               class="btn btn-success">السماح لل{{$item->form_type->name}}</a>
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio3" value="1"> نعم
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-8">
                            <div class="form-group row">
                                <div id="reprocessing_div" style="display: none">
                                    <h4>إعادة معالجة ال{{$form_type->find($type)->name}}</h4>
                                    <h4>التوصيات</h4>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="3" id="reprocessing_recommendations" name="reprocessing_recommendations"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio3" value="0"> لا
                                </label>
                            </div>
                        </div>
                    </div>


                @endif

                <div class="form-group row">
                    <div style="float:left; margin-left: 50px;">
                        <button id="submit_update_clarification" class="btn btn-danger">حفظ</button>
                    </div>
                </div>
            </form>
            @endif
        </div>

        {{-------------------------------------------------------}}

        <button class="accordion hide_div" id="deleted">
             رابعاً: الحاجة لحذف ال{{$form_type->find($type)->name}}
        </button>
        <div class="panel hide_div" id="deleted_main_div">
            <br>
            @if($item->deleted_at || $item->confirm_deleting)
                <form id="confirm_delete_form_modal">
                    <input type="hidden" id="deleted_id" value="{{$item->id}}">
                    <div class="form-group row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة
                                للحذف؟</label>
                            <div class="col-sm-2">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio" value="0">لا
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" id="post-format-gallery"
                                               name="optradio" value="1" checked disabled> نعم
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="sent_type" class="col-sm-4 col-form-label">تاريخ الحذف</label>
                            <input type="text" class="form-control" name="deleted_at" readonly
                                   value="@if(!$item->deleted_at){{$item->confirm_deleting}}@else{{$item->deleted_at}}@endif">


                        </div>
                        <div class="col-sm-6">
                            <label for="sent_type" class="col-sm-4 col-form-label">اسم موظف الذي قام بالحذف</label>
                            <input type="text" class="form-control" name="deleted_by_name" readonly
                                   value="{{ $item->deleted_user->name }}" readonly>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="sent_type" class="col-sm-4 col-form-label">سبب الحذف</label>
                            <input type="text" class="form-control" id="deleting_reason" placeholder="سبب الحذف"
                                   value="{{$item->deleted_because}}" readonly>
                        </div>
                    </div>

                    <hr>
                @if($item->confirm_deleting && !$item->recommendations_for_deleting)
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label class="col-form-label">هل ال{{$form_type->find($type)->name}} بحاجة لحذف؟</label>
                        </div>
                    </div>

                    <div class="form-group row">
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <div id="confirm_deleting_div" style="display: none">
                                        <h4 style="color: red">إتمام عملية الحذف</h4>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio6" value="1"> نعم
                                    </label>
                                </div>
                            </div>
                        </div>

                    <div class="form-group row">
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <div id="reprocessing_deleteing_div" style="display: none">
                                        <h4>إعادة معالجة ال{{$form_type->find($type)->name}}</h4>
                                        <h4>التوصيات</h4>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <textarea class="form-control" rows="3" id="deleting_reprocessing_recommendations" name="deleting_reprocessing_recommendations"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio6" value="0"> لا
                                    </label>
                                </div>
                            </div>
                        </div>

                    <div class="form-group row">
                        <div style="float:left; margin-left: 50px;">
                            <button id="submit_delete" class="btn btn-danger">حفظ</button>
                        </div>
                    </div>
                    @elseif($item->recommendations_for_deleting)
                    <h4>وفيما يلي توصيات الجهة الإدارية المسؤولة بخصوص حذف {{$form_type->find($type)->name}}:</h4>
                        <table class="table table-bordered">
                            <tr>
                                <td>الجهة الإدارية المسؤولة عن متابعة الجهة المختصة بمعالجة {{$form_type->find($type)->name}}:</td>
                                <td>{{$item->user_recommendations_for_deleting->full_name}}</td>
                            </tr>
                            <tr>
                                <td>التوصيات:</td>
                                <td>{{$item->recommendations_for_deleting}}</td>
                            </tr>
                        </table>
                    @endif
                </form>
            @endif
        </div>

        {{-------------------------------------------------------}}

        <button class="accordion hide_div">
            خامساً : الحاجة لإعادة تصنيف فئة ال{{$form_type->find($type)->name}}
        </button>
        <div class="panel hide_div" id="changecategorydiv">
            <br>
            @if($item->old_category_id)
                <div class="row">
                    <div class="col-sm-6">
                        <label>اسم المستخدم الذي قام بالتعديل</label>
                        <input class="form-control" value="{{$item->user_change_category->name}}" readonly/>
                    </div>
                    <div class="col-sm-6">
                        <label>فئة ال{{$form_type->find($type)->name}} المعدلة </label>
                        <input class="form-control" value="{{$item->old_category->name}}" readonly/>
                    </div>
                </div>
            @else
                <form id="update_category_form_modal">
                    <input type="hidden" id="updated_category_id" value="{{$item->id}}">
                    <div class="form-group row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <label for="sent_type" class="col-form-label">هل ال{{$form_type->find($type)->name}}
                                بحاجة لإعادة تصنيف فئته/ا؟</label>
                            <div class="col-sm-2">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optradio4" value="0"
                                               checked>لا
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
                                <select class="form-control" id="updated_category_name" name="category_id"
                                        style="width: 60% !important;">
                                    <option value="">اختر فئة الشكوى</option>
                                    @foreach($categories as $cat)
                                        @if($cat->is_complaint != 0)
                                            <option value="{{$cat->id}}"
                                                    @if($item->category_id==$cat->id)selected @endif>{{$cat->name}}</option>
                                        @endif
                                    @endforeach
                                </select>

                            @elseif($item->type == 2)
                                <select class="form-control" id="updated_category_name1" name="category_id"
                                        style="width: 60% !important;">
                                    <option value=""> اختر فئة الاقتراح</option>
                                    @foreach($categories as $cat)
                                        @if($cat->is_complaint != 1)
                                            <option value="{{$cat->id}}"
                                                    @if($item->category_id==$cat->id)selected @endif>{{$cat->name}}</option>
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
            سادساً: إجراءات الرد على {{$form_type->find($type)->name}}
        </button>
        <div class="panel hide_div" id="replies">
                <br>
                @if(($item->response_type == 0 || $item->response_type == 1) && $item->form_response)
                <br><br>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="response_type" class="col-sm-4 col-form-label">الإجراءات المطلوبة للرد</label>
                        <select id="response_type_select" name="response_type" class="form-control"
                                style="width: 50% !important;" readonly="">
                            <option value="">اختر نوع</option>
                            <option @if($item->response_type==0)selected @endif  value="0">يمكن الرد عليها مباشرة</option>
                            <option @if($item->response_type==1)selected @endif  value="1">تتطلب إجراءات مطولة للرد عليها</option>
                        </select>
                    </div>
                </div>
                <br>
                <div id="replay_advanced" style="@if(!$item->required_respond)display: none @endif">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">طبيعة الإجراءات المطولة
                                المطلوبة</label>
                            <select name="required_respond" class="form-control" style=" width: 50%;" readonly="">
                                <option value="">اختر الإجراء المطلوب</option>
                                <option @if($item->required_respond=="زيارة ميدانية / فنية")selected @endif  value="زيارة ميدانية / فنية"> زيارة ميدانية / فنية</option>
                                <option @if($item->required_respond=="نقاش من خلال لجنة الاقتراحات والشكاوى")selected @endif  value="نقاش من خلال لجنة الاقتراحات والشكاوى">نقاش من خلال لجنة الاقتراحات
                                    والشكاوى
                                </option>
                                <option @if($item->required_respond=="نقاش مع الجهات الشريكة/ الممولة")selected @endif value="نقاش مع الجهات الشريكة/ الممولة">نقاش مع الجهات الشريكة/ الممولة
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">تاريخ تنفيذ الإجراء</label>
                            <input style=" width: 50%;" type="text" value="{{$item->form_data}}" class="form-control datepicker" readonly name="form_data"
                                   placeholder="يوم / شهر / سنة"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">تحميل ملف توثيق الإجراء</label>

                            <a style="width: 50%;" target="_blank" class="btn btn-primary"  href="{{ route('downloadfiles', $item->id) }}" >تحميل ملف توثيق الإجراء</a>
                        </div>
                    </div>

                </div>

                <br>


                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">الجهة المختصة بالدراسة والمعالجة</label>
                        <input style="width: 50% !important;" type="text" class="form-control" name="replay_user_name"
                               readonly
                               value="{{ $item->form_response->account->full_name }}" width="50%">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">صياغة الرد</label>
                        <textarea name="response" rows="2" cols="78" style="border-radius: 10px;" readonly disabled>{{$item->form_response->response}}</textarea>
                    </div>
                </div>

                @if($item->form_response->old_response)
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="sent_type" class="col-sm-4 col-form-label">صياغة  الرد المعدل بناءً على نتائج إجراءات المصادقة</label>
                            <textarea name="response_after_confirmation" rows="2" cols="78" style="border-radius: 10px;" readonly disabled>{{$item->form_response->old_response}}</textarea>
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">تاريخ تسجيل الرد</label>
                        <input style="width: 50% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$item->form_response->datee}}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">حالة الرد</label>
                        <?php
                        if ($item->status == 1) {
                            $replay_status = "قيد الدراسة";
                        } elseif ($item->status == 2) {
                            $replay_status = "تم الرد";
                        } else {
                            $replay_status = "";
                        }
                        ?>
                        <input style="width: 50% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$replay_status}}" readonly>
                    </div>
                </div>
                @endif
            </div>

        {{-------------------------------------------------------}}

            <button class="accordion hide_div">
                سابعاً: إجراءات المصادقة على الرد
            </button>
            <div class="panel hide_div" id="rank_div">
                <br>
                <br>
                @if($item->form_response)
                    @if($item->form_response->objection_response)
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="sent_type" class="col-sm-4 col-form-label">الجهة المختصة بالمصادقة</label>
                                    <input style="width: 65% !important;" type="text" class="form-control" name="confirm_replay_user_name" readonly value="{{ $item->form_response->confirm_account->full_name }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-6 col-sm-6">
                                    <label for="sent_type" class="col-form-label">هل يوجد اعتراض على الرد</label>
                                    <div class="col-sm-2">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio8" value="0" @if( $item->form_response->objection_response== 0) {{"checked disabled"}} @endif>
                                                لا
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="optradio8" value="1" @if($item->form_response->objection_response== 1) {{"checked disabled"}} @endif>
                                                نعم
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8" id="objection_response_div" style="@if(!$item->form_response->objection_response == 1)display: none;@endif">
                                    <label class="col-sm-12 col-form-label">يرجي إعادة صياغة الرد</label>
                                    <textarea name="old_response" rows="2" cols="78" style="border-radius: 10px;">@if($item->form_response->old_response) {{$item->form_response->old_response}} @endif</textarea>

                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label for="sent_type" class="col-sm-4 col-form-label">تاريخ المصادقة</label>
                                    <input style="width: 65% !important;" type="text" class="form-control" id="replay_status"
                                           name="replay_status" value="{{$item->form_response->confirmation_date}}" readonly>
                                </div>

                                <div class="col-sm-6">
                                    <label for="sent_type" class="col-sm-4 col-form-label">حالة المصادقة</label>
                                    <?php
                                    if ($item->form_response->confirmation_status == 1) {
                                        $replay_status = "قيد المصادقة";
                                    } elseif ($item->form_response->confirmation_status == 2) {
                                        $replay_status = "تمت المصادقة";
                                    } else {
                                        $replay_status = "لم تتم المصادقة";
                                    }
                                    ?>
                                    <input style="width: 65% !important;" type="text" class="form-control" id="replay_status"
                                           name="replay_status" value="{{$replay_status}}" readonly>
                                </div>
                            </div>
                        @endif
                @endif
            </div>

        {{-------------------------------------------------------}}
        <button class="accordion hide_div">
            ثامناً: التغذية الراجعة
        </button>
         <div class="panel hide_div" id="rank_div">
             <br>
             <br>
             @if($item->form_follow)

                 <div class="form-group row">
                     <div class="col-sm-12">
                         <label for="sent_type" class="col-sm-4 col-form-label">الجهة المسؤولة عن تبليغ الرد
                             (موظف الاتصال)</label>
                         <input style="width: 65% !important;" type="text" class="form-control"
                                name="replay_user_name" readonly
                                value="{{ $item->form_follow->account->full_name }}">
                     </div>
                 </div>

                 <div class="form-group row">
                     <div class="col-md-12">
                         <label for="sent_type" class="col-sm-4 col-form-label">حالة تبليغ الرد</label>
                         <select class="form-control" id="follow_form_status" name="follow_form_status" style="width: 65% !important;" disabled>
                             <option @if($item->form_follow->solve == 1){{"selected"}}@endif value="1">تم تبليغ الرد</option>
                             <option @if($item->form_follow->solve == 2){{"selected"}}@endif value="2">لم يتم تبليغ الرد</option>
                         </select>
                     </div>

                 </div>

                 <div class="form-group row" id="follow_reason_not_div" style="@if($item->form_follow->solve == 1){{"display: none"}}@endif">
                     <div class="col-md-12">

                         <label for="sent_type" class="col-sm-4 col-form-label">سبب عدم تبليغ الرد</label>
                         <select id="follow_reason_not" name="follow_reason_not" class="form-control" style="width: 65% !important;" disabled>
                             <option value="">اختر السبب</option>
                             <option @if($item->form_follow->follow_reason_not == "عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة."){{"selected"}}@endif
                                     value="عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة.">
                                 عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من
                                 مرة.
                             </option>
                             <option @if($item->form_follow->follow_reason_not == "أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة."){{"selected"}}@endif value="أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.">أرقام
                                 التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.
                             </option>
                             <option @if($item->form_follow->follow_reason_not == "أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)"){{"selected"}}@endif
                                     value="أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)">
                                 أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً،
                                 الرقم المطلوب لا يستقبل مكالمات، ...)
                             </option>

                         </select>
                     </div>
                 </div>

                 <hr>
                 <div class="form-group row" id="feedback_div" style="@if($item->form_follow->solve == 2){{"display: none;"}} @endif">
                     <div class="col-sm-12">
                         <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>

                         <div class="col-sm-12">
                             <div class="form-check">
                                 <label class="form-check-label">
                                     <input type="radio" name="evaluate" @if($item->form_follow->evaluate == 1){{"checked"}}@endif class="form-check-input" value="1">راضي بشكل كبير
                                 </label>
                             </div>
                         </div>

                         <div class="col-sm-12">
                             <div class="form-check">
                                 <label class="form-check-label">
                                     <input type="radio" name="evaluate" @if($item->form_follow->evaluate == 2){{"checked"}}@endif class="form-check-input" value="2">راضي بشكل متوسط
                                 </label>
                             </div>
                         </div>

                         <div class="col-sm-12">
                             <div class="form-check">
                                 <label class="form-check-label">
                                     <input type="radio" name="evaluate" class="form-check-input" @if($item->form_follow->evaluate == 3){{"checked"}}@endif value="3">راضي بشكل ضعيف
                                 </label>
                             </div>
                         </div>

                         <div class="col-sm-12">
                             <div class="form-check">
                                 <label class="form-check-label">
                                     <input type="radio" name="evaluate" class="form-check-input" value="4" @if($item->form_follow->evaluate == 4){{"checked"}}@endif id="inp3">غير راضي عن الرد
                                 </label>
                             </div>
                         </div>

                         @if($item->form_follow->evaluate)
                             <script>
                                 $('input[name=evaluate]').attr('disabled',true);
                             </script>
                         @endif
                     </div>
                 </div>
                 <div class="form-group row">
                     <div class="col-sm-12">
                         <div id="div3" style="@if($item->form_follow->evaluate != 4){{"display:none;"}}@endif">
                             <h4>سبب عدم الرضا عن الرد</h4>
                             <div id="appear">
                                 <textarea name="notes" rows="2" cols="78" style="border-radius: 10px;" disabled>{{$item->form_follow->notes}}</textarea>

                             </div>
                         </div>
                     </div>
                 </div>
             @endif
         </div>
        {{-------------------------------------------------------}}
        <button class="accordion hide_div">
            تاسعاً: توصيات ذات العلاقة بمحتوى ال{{$form_type->find($type)->name}}
        </button>
        <div class="panel hide_div">

            <br>

                <h4>عزيزي الموظف يمكنك من هنا رفع التوصيات التي تستحق الدراسة من قبل المركز لاتخاذها بعين الاعتبار
                    في تصميم مشاريع مستقبلية:</h4>
                <form method="POST" class="form-horizontal" action="/citizen/saverecommendations">
                    @csrf
                    <input name="form_id" type="hidden" value="{{$item->id}}">
                    <input name="user_id" type="hidden" value="{{Auth::user()->id}}">
                    <div class="form-group row">
                        <div class="col-sm-12">
                                   <textarea id="content"
                                             class="form-control {{($errors->first('recommendations_content') ? " form-error" : "")}}"
                                             rows="6" id="recommendations_content" name="recommendations_content">{{old("recommendations_content")}}</textarea>

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

            @if($recomendations)
                <br>
                <h4 style="color: red;">توصيات المستخدمين</h4>
                <hr>
                @foreach($recomendations as $recomendation)
                    <div class="content">
                        <h5>{{$recomendation->recommendations_content}}</h5>
                        <h6>بواسطة {{$recomendation->user->name}}</h6>
                        <hr>
                    </div>
                @endforeach
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
                <form style="display:inline"
                      action="/citizen/form/show/{{$item->citizen->id_number}}/{{$item->id}}">
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
        @endsection
    @endif
@endforeach
@endif

@if($auth_circle_users3)
@foreach($auth_circle_users3 as $AccountProjects_user)
    @if($AccountProjects_user == auth()->user()->account->id)
        @section("content")
<div class="row" style="" id="auth_circle_users3">
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
        <button class="accordion1">
            أولاً: معلومات مقدم ال{{$form_type->find($type)->name}} الأساسية
        </button>
        <div class="panel"></div>

        {{-------------------------------------------------------}}

        <button class="accordion1">
            ثانياً: تفاصيل ال{{$form_type->find($type)->name}}
        </button>
        <div class="panel"></div>
        {{-------------------------------------------------------}}
        <button class="accordion1">
            ثالثا: الحاجة للاستيضاح عن مضمون ال{{$form_type->find($type)->name}}
        </button>
        <div class="panel"></div>
        {{-------------------------------------------------------}}

        <button class="accordion1">
            رابعاً : الحاجة لحذف ال{{$form_type->find($type)->name}}
        </button>
        <div class="panel"></div>
        {{-------------------------------------------------------}}

        <button class="accordion1">
            خامساً: الحاجة لإعادة تصنيف فئة ال{{$form_type->find($type)->name}}
        </button>
        <div class="panel"></div>
        {{-------------------------------------------------------}}

        <button class="accordion hide_div">
            سادساً: إجراءات الرد على {{$form_type->find($type)->name}}
        </button>
        <div class="panel hide_div" id="replies">
            <br>

            @if(($item->response_type == 0 || $item->response_type == 1) && $item->form_response)
                <br><br>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="response_type" class="col-sm-4 col-form-label">الإجراءات المطلوبة للرد</label>
                        <select id="response_type_select" name="response_type" class="form-control"
                                style="width: 50% !important;" readonly="">
                            <option value="">اختر نوع</option>
                            <option @if($item->response_type==0)selected @endif  value="0">يمكن الرد عليها مباشرة</option>
                            <option @if($item->response_type==1)selected @endif  value="1">تتطلب إجراءات مطولة للرد عليها</option>
                        </select>
                    </div>
                </div>
                <br>
                <div id="replay_advanced" style="@if(!$item->required_respond)display: none @endif">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">طبيعة الإجراءات المطولة
                                المطلوبة</label>
                            <select name="required_respond" class="form-control" style=" width: 50%;" readonly="">
                                <option value="">اختر الإجراء المطلوب</option>
                                <option @if($item->required_respond=="زيارة ميدانية / فنية")selected @endif  value="زيارة ميدانية / فنية"> زيارة ميدانية / فنية</option>
                                <option @if($item->required_respond=="نقاش من خلال لجنة الاقتراحات والشكاوى")selected @endif  value="نقاش من خلال لجنة الاقتراحات والشكاوى">نقاش من خلال لجنة الاقتراحات
                                    والشكاوى
                                </option>
                                <option @if($item->required_respond=="نقاش مع الجهات الشريكة/ الممولة")selected @endif value="نقاش مع الجهات الشريكة/ الممولة">نقاش مع الجهات الشريكة/ الممولة
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">تاريخ تنفيذ الإجراء</label>
                            <input style=" width: 50%;" type="text" value="{{$item->form_data}}" class="form-control datepicker" readonly name="form_data"
                                   placeholder="يوم / شهر / سنة"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="response_type" class="col-sm-4 col-form-label">تحميل ملف توثيق الإجراء</label>

                            <a style="width: 50%;" target="_blank" class="btn btn-primary"  href="{{ route('downloadfiles', $item->id) }}" >تحميل ملف توثيق الإجراء</a>
                        </div>
                    </div>

                </div>

                <br>


                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">الجهة المختصة بالدراسة والمعالجة</label>
                        <input style="width: 50% !important;" type="text" class="form-control" name="replay_user_name"
                               readonly
                               value="{{ $item->form_response->account->full_name }}" width="50%">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">صياغة الرد</label>
                        <textarea name="response" rows="2" cols="78" style="border-radius: 10px;" readonly disabled>{{$item->form_response->response}}</textarea>
                    </div>
                </div>

                @if($item->form_response->old_response)
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="sent_type" class="col-sm-4 col-form-label">صياغة  الرد المعدل بناءً على نتائج إجراءات المصادقة</label>
                            <textarea name="response_after_confirmation" rows="2" cols="78" style="border-radius: 10px;" readonly disabled>{{$item->form_response->old_response}}</textarea>
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">تاريخ تسجيل الرد</label>
                        <input style="width: 50% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$item->form_response->datee}}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">حالة الرد</label>
                        <?php
                        if ($item->status == 1) {
                            $replay_status = "قيد الدراسة";
                        } elseif ($item->status == 2) {
                            $replay_status = "تم الرد";
                        } else {
                            $replay_status = "";
                        }
                        ?>
                        <input style="width: 50% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$replay_status}}" readonly>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-------------------------------------------------------}}
    <button class="accordion hide_div">
        سابعاً: إجراءات المصادقة على الرد
    </button>
    <div class="panel hide_div" id="rank_div">
        <br>
        <br>
        @if($item->form_response)
            @if(!$item->form_response->objection_response)
            <form action="{{route('change_confirm_and_update_form_data' , $item->id)}}" method="POST">
                @csrf

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">الجهة المختصة بالمصادقة</label>
                        <input type="hidden" class="form-control" name="confirm_account_id" value="{{Auth::user()->id}}">
                        <input style="width: 65% !important;" type="text" class="form-control" name="confirm_replay_user_name" readonly value="{{ Auth::user()->account->full_name }}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-offset-6 col-sm-6">
                        <label for="sent_type" class="col-form-label">هل يوجد اعتراض على الرد</label>
                        <div class="col-sm-2">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio8" value="0">
                                    لا
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio8" value="1">
                                    نعم
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8" id="objection_response_div" style="display: none;">
                        <label class="col-sm-12 col-form-label">يرجي إعادة صياغة الرد</label>
                        <textarea name="old_response" rows="2" cols="78" style="border-radius: 10px;"></textarea>

                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-sm-6">
                        <label for="sent_type" class="col-sm-4 col-form-label">تاريخ المصادقة</label>
                        <input style="width: 65% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{date('Y-m-d')}}" readonly>
                    </div>

                    <div class="col-sm-6">
                        <label for="sent_type" class="col-sm-4 col-form-label">حالة المصادقة</label>
                        <?php
                        if ($item->form_response->confirmation_status == 1) {
                            $replay_status = "قيد المصادقة";
                        } elseif ($item->form_response->confirmation_status == 2) {
                            $replay_status = "تمت المصادقة";
                        } else {
                            $replay_status = "لم تتم المصادقة";
                        }
                        ?>
                        <input style="width: 65% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$replay_status}}" readonly>
                    </div>
                </div>
                <hr>
                <div class="form-group row" align="left">
                    <div class="col-sm-12">
                        <button type="submit" class="wow bounceIn btn btn-info btn-md"
                                style="width: 15%; background-color:#BE2D45;border:0;">
                            إرسال الرد للمصادقة
                        </button>
                    </div>
                </div>
            </form>
            @else
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="sent_type" class="col-sm-4 col-form-label">الجهة المختصة بالمصادقة</label>
                        <input style="width: 65% !important;" type="text" class="form-control" name="confirm_replay_user_name" readonly value="{{ $item->form_response->confirm_account->full_name }}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-offset-6 col-sm-6">
                        <label for="sent_type" class="col-form-label">هل يوجد اعتراض على الرد</label>
                        <div class="col-sm-2">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio8" value="0" @if( $item->form_response->objection_response== 0) {{"checked disabled"}} @endif>
                                    لا
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="optradio8" value="1" @if($item->form_response->objection_response== 1) {{"checked disabled"}} @endif>
                                    نعم
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8" id="objection_response_div" style="@if(!$item->form_response->objection_response == 1)display: none;@endif">
                        <label class="col-sm-12 col-form-label">يرجي إعادة صياغة الرد</label>
                        <textarea name="old_response" rows="2" cols="78" style="border-radius: 10px;">@if($item->form_response->old_response) {{$item->form_response->old_response}} @endif</textarea>

                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-sm-6">
                        <label for="sent_type" class="col-sm-4 col-form-label">تاريخ المصادقة</label>
                        <input style="width: 65% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$item->form_response->confirmation_date}}" readonly>
                    </div>

                    <div class="col-sm-6">
                        <label for="sent_type" class="col-sm-4 col-form-label">حالة المصادقة</label>
                        <?php
                        if ($item->form_response->confirmation_status == 1) {
                            $replay_status = "قيد المصادقة";
                        } elseif ($item->form_response->confirmation_status == 2) {
                            $replay_status = "تمت المصادقة";
                        } else {
                            $replay_status = "لم تتم المصادقة";
                        }
                        ?>
                        <input style="width: 65% !important;" type="text" class="form-control" id="replay_status"
                               name="replay_status" value="{{$replay_status}}" readonly>
                    </div>
                </div>
            @endif
        @endif
    </div>

    {{-------------------------------------------------------}}
    <button class="accordion1">
        ثامناً: التغذية الراجعة
    </button>
    <div class="panel"></div>
    {{-------------------------------------------------------}}
    <button class="accordion hide_div">
        تاسعاً: توصيات ذات العلاقة بمحتوى ال{{$form_type->find($type)->name}}
    </button>
    <div class="panel hide_div">

        <br>
        <h4>عزيزي الموظف يمكنك من هنا رفع التوصيات التي تستحق الدراسة من قبل المركز لاتخاذها بعين الاعتبار
            في تصميم مشاريع مستقبلية:</h4>
        <form method="POST" class="form-horizontal" action="/citizen/saverecommendations">
            @csrf
            <input name="form_id" type="hidden" value="{{$item->id}}">
            <input name="user_id" type="hidden" value="{{Auth::user()->id}}">
            <div class="form-group row">
                <div class="col-sm-12">
                                   <textarea id="content"
                                             class="form-control {{($errors->first('recommendations_content') ? " form-error" : "")}}"
                                             rows="6" id="recommendations_content" name="recommendations_content">{{old("recommendations_content")}}</textarea>

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


        @if($recomendations)
            <br>
            <h4 style="color: red;">توصيات المستخدمين</h4>
            <hr>
            @foreach($recomendations as $recomendation)
                <div class="content">
                    <h5>{{$recomendation->recommendations_content}}</h5>
                    <h6>بواسطة {{$recomendation->user->name}}</h6>
                    <hr>
                </div>
            @endforeach
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
            <form style="display:inline"
                  action="/citizen/form/show/{{$item->citizen->id_number}}/{{$item->id}}">
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
@endsection
    @endif
@endforeach
@endif

@if($auth_circle_users4)
    @foreach($auth_circle_users4 as $AccountProjects_user)
        @if($AccountProjects_user == auth()->user()->account->id)
            @section("content")
                <div class="row" style="" id="auth_circle_users4">
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
                            <?php
                            $project_arr = array();
                            foreach ($item->citizen->projects as $project) {
                                array_push($project_arr, $project->id);
                            }
                            ?>
                            <td colspan="3">@if(!in_array($item->project->id,$project_arr)){{'غير مستفيد من مشاريع المركز'}}@else{{'مستفيد من مشاريع المركز '}}@endif</td>
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
                                <td class="mo">فئة ال{{$form_type->find($type)->name}} المعدلة بناءً على محتوى ال{{$form_type->find($type)->name}}:</td>
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
                                <td class="mo">محتوى  ال{{$form_type->find($type)->name}} المعدل بناءً على نتيجة الاستيضاح</td>
                                <td>{{$item->reformulate_content}}</td>

                                <td class="mo">اسم المستخدم الذي قام بالاستيضاح</td>
                                <td>{{$item->user_change_content->full_name}}</td>
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
                <button class="accordion1">
                    ثالثا: الحاجة للاستيضاح عن مضمون ال{{$form_type->find($type)->name}}
                </button>
                <div class="panel">
                </div>

                {{-------------------------------------------------------}}

                <button class="accordion1">
                    رابعاً : الحاجة لحذف ال{{$form_type->find($type)->name}}
                </button>
                <div class="panel"></div>

                {{-------------------------------------------------------}}

                <button class="accordion1">
                    خامساً: الحاجة لإعادة تصنيف فئة ال{{$form_type->find($type)->name}}
                </button>
                <div class="panel"></div>
                {{-------------------------------------------------------}}

                <button class="accordion1">
                    سادساً: إجراءات الرد على {{$form_type->find($type)->name}}
                </button>
                <div class="panel"></div>


            {{-------------------------------------------------------}}
            <button class="accordion1">
                سابعاً: إجراءات المصادقة على الرد
            </button>
                <div class="panel"></div>

            {{-------------------------------------------------------}}
            <button class="accordion hide_div">
                ثامناً: التغذية الراجعة
            </button>
            <div class="panel hide_div" id="rank_div">
                <br>
                <div class="col-sm-12">
                        <br>
                    @if(!$item->form_follow)
                    <form action="{{route('change_replay_status_feedback' , $item->id)}}" method="POST">
                        @csrf
                            <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="sent_type" class="col-sm-4 col-form-label">الجهة المسؤولة عن تبليغ الرد
                                    (موظف الاتصال)</label>
                                <?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>

                                <input style="width: 65% !important;" type="text" class="form-control"
                                       name="replay_user_name" readonly
                                       value="{{ Auth::user()->account->full_name }}">
                            </div>
                        </div>

                            <div class="form-group row">
                            <div class="col-md-12">
                                <label for="sent_type" class="col-sm-4 col-form-label">حالة تبليغ الرد</label>
                                <select class="form-control" id="follow_form_status" name="follow_form_status" style="width: 65% !important;">
                                    <option value="">حالة تبليغ الرد</option>
                                    <option value="1">تم تبليغ الرد</option>
                                    <option value="2">لم يتم تبليغ الرد</option>
                                </select>
                            </div>

                        </div>

                            <div class="form-group row" id="follow_reason_not_div" style="display: none">
                            <div class="col-md-12">

                                <label for="sent_type" class="col-sm-4 col-form-label">سبب عدم تبليغ الرد</label>
                                <select id="follow_reason_not" name="follow_reason_not" class="form-control" style="width: 65% !important;">
                                        <option value="">اختر السبب</option>
                                        <option
                                            value="عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة.">
                                            عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من
                                            مرة.
                                        </option>
                                        <option value="أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.">أرقام
                                            التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.
                                        </option>
                                        <option
                                            value="أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)">
                                            أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً،
                                            الرقم المطلوب لا يستقبل مكالمات، ...)
                                        </option>

                                    </select>
                            </div>
                        </div>

                            <hr>
                            <div class="form-group row" id="feedback_div" style="display: none;">
                                <div class="col-sm-12">
                                    <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>
                                    <div class="col-sm-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" name="evaluate" class="form-check-input" value="1">راضي بشكل كبير
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" name="evaluate" class="form-check-input" value="2">راضي بشكل متوسط
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" name="evaluate" class="form-check-input" value="3">راضي بشكل ضعيف
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" name="evaluate" class="form-check-input" value="4" id="inp3">غير راضي عن الرد
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <div id="div3" style="display:none;">
                                        <h4>سبب عدم الرضا عن الرد</h4>
                                        <div id="appear">
                                            <textarea name="notes" rows="2" cols="78" style="border-radius: 10px;"></textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row" align="left">
                                <div class="col-sm-12">
                                    <button type="submit" class="wow bounceIn btn btn-info btn-md"
                                            style="width: 15%; background-color:#BE2D45;border:0;">
                                        حفظ
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="sent_type" class="col-sm-4 col-form-label">الجهة المسؤولة عن تبليغ الرد
                                    (موظف الاتصال)</label>
                                <input style="width: 65% !important;" type="text" class="form-control"
                                       name="replay_user_name" readonly
                                       value="{{ $item->form_follow->account->full_name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="sent_type" class="col-sm-4 col-form-label">حالة تبليغ الرد</label>
                                <select class="form-control" id="follow_form_status" name="follow_form_status" style="width: 65% !important;" disabled>
                                    <option @if($item->form_follow->solve == 1){{"selected"}}@endif value="1">تم تبليغ الرد</option>
                                    <option @if($item->form_follow->solve == 2){{"selected"}}@endif value="2">لم يتم تبليغ الرد</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group row" id="follow_reason_not_div" style="@if($item->form_follow->solve == 1){{"display: none"}}@endif">
                            <div class="col-md-12">

                                <label for="sent_type" class="col-sm-4 col-form-label">سبب عدم تبليغ الرد</label>
                                <select id="follow_reason_not" name="follow_reason_not" class="form-control" style="width: 65% !important;" disabled>
                                    <option value="">اختر السبب</option>
                                    <option @if($item->form_follow->follow_reason_not == "عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة."){{"selected"}}@endif
                                        value="عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من مرة.">
                                        عدم وجود استجابة من مقدم الاقتراح/الشكوى على الاتصال بعد التواصل أكثر من
                                        مرة.
                                    </option>
                                    <option @if($item->form_follow->follow_reason_not == "أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة."){{"selected"}}@endif value="أرقام التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.">أرقام
                                        التواصل الخاصة بمقدم الاقتراح/الشكوى غير صحيحة.
                                    </option>
                                    <option @if($item->form_follow->follow_reason_not == "أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)"){{"selected"}}@endif
                                        value="أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً، الرقم المطلوب لا يستقبل مكالمات، ...)">
                                        أرقام التواصل المتواجدة غير فعالة لوجود خدمة ما مثل:( لا يمكن الوصول حالياً،
                                        الرقم المطلوب لا يستقبل مكالمات، ...)
                                    </option>

                                </select>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group row" id="feedback_div" style="@if($item->form_follow->solve == 2){{"display: none;"}} @endif">
                            <div class="col-sm-12">
                                <label for="sent_type" class="col-sm-4 col-form-label">التغذية الراجعة</label>

                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" name="evaluate" @if($item->form_follow->evaluate == 1){{"checked"}}@endif class="form-check-input" value="1">راضي بشكل كبير
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" name="evaluate" @if($item->form_follow->evaluate == 2){{"checked"}}@endif class="form-check-input" value="2">راضي بشكل متوسط
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" name="evaluate" class="form-check-input" @if($item->form_follow->evaluate == 3){{"checked"}}@endif value="3">راضي بشكل ضعيف
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" name="evaluate" class="form-check-input" value="4" @if($item->form_follow->evaluate == 4){{"checked"}}@endif id="inp3">غير راضي عن الرد
                                        </label>
                                    </div>
                                </div>

                                @if($item->form_follow->evaluate)
                                    <script>
                                        $('input[name=evaluate]').attr('disabled',true);
                                    </script>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div id="div3" style="@if($item->form_follow->evaluate != 4){{"display:none;"}}@endif">
                                    <h4>سبب عدم الرضا عن الرد</h4>
                                    <div id="appear">
                                        <textarea name="notes" rows="2" cols="78" style="border-radius: 10px;" disabled>{{$item->form_follow->notes}}</textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            {{-------------------------------------------------------}}
            <button class="accordion hide_div">
                تاسعاً: توصيات ذات العلاقة بمحتوى ال{{$form_type->find($type)->name}}
            </button>
            <div class="panel hide_div">

                <br>
                <h4>عزيزي الموظف يمكنك من هنا رفع التوصيات التي تستحق الدراسة من قبل المركز لاتخاذها بعين الاعتبار
                    في تصميم مشاريع مستقبلية:</h4>
                <form method="POST" class="form-horizontal" action="/citizen/saverecommendations">
                    @csrf
                    <input name="form_id" type="hidden" value="{{$item->id}}">
                    <input name="user_id" type="hidden" value="{{Auth::user()->id}}">
                    <div class="form-group row">
                        <div class="col-sm-12">
                                           <textarea id="content"
                                                     class="form-control {{($errors->first('recommendations_content') ? " form-error" : "")}}"
                                                     rows="6" id="recommendations_content" name="recommendations_content">{{old("recommendations_content")}}</textarea>

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


                @if($recomendations)
                    <br>
                    <h4 style="color: red;">توصيات المستخدمين</h4>
                    <hr>
                    @foreach($recomendations as $recomendation)
                        <div class="content">
                            <h5>{{$recomendation->recommendations_content}}</h5>
                            <h6>بواسطة {{$recomendation->user->name}}</h6>
                            <hr>
                        </div>
                    @endforeach
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
                    <form style="display:inline"
                          action="/citizen/form/show/{{$item->citizen->id_number}}/{{$item->id}}">
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
            @endsection
        @endif
    @endforeach
@endif

@if(!$auth_circle_users && !$auth_circle_users2 && !$auth_circle_users3 && !$auth_circle_users4 )
    @section("content")
        <div class="row" style="text-align:center;">
            <br><br><br><br>
            <h2 class="col-sm-6" style="margin-top:120px;margin-bottom:30px;color:#af0922;margin-left:337px;">يرجى التأكد من
            صحة الرابط المراد الوصول له</h2>
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

        $('input:radio[name="optradio8"]').click(function () {
            var inputValue = $("input[name='optradio8']:checked").val();
            if(inputValue == 1){
                $('#objection_response_div').show();
            }else{
                $('#objection_response_div').hide()
            }
        });

        $('#follow_form_status').change(function () {
            var inputValue = $("#follow_form_status").val();
            if(inputValue == 1){
                $('#feedback_div').show();
                $('#follow_reason_not_div').hide();
            } else if(inputValue == 2){
                $('#follow_reason_not_div').show();
                $('#feedback_div').hide();
            }else{
                $('#follow_reason_not_div').hide();
                $('#feedback_div').hide();
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
            } else {
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
            } else {
                $('#reprocessing_div').hide();
                $('#stop_div').hide();
            }
        });

        $('input:radio[name="optradio6"]').click(function () {
            var inputValue = $("input[name='optradio6']:checked").val();
            if (inputValue == 1) {
                $('#confirm_deleting_div').show();
                $('#reprocessing_deleteing_div').hide();
            } else if (inputValue == 0) {
                $('#reprocessing_deleteing_div').show();
                $('#confirm_deleting_div').hide();
            } else {
                $('#confirm_deleting_div').hide();
                $('#reprocessing_deleteing_div').hide();
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

        var inputValue = $("#auth_circle_users input[name='optradio1']:checked").val();
        if (inputValue == 1) {
            $('#auth_circle_users #explain_main_div').show();
        } else {
            $('#auth_circle_users #explain_main_div').hide();
        }

        var inputValue1 = $("#auth_circle_users2 input[name='optradio1']:checked").val();
        if (inputValue1 == 1) {
            $('#auth_circle_users2 #explain_main_div').show();
        } else {
            $('#auth_circle_users2 #explain_main_div').hide();
        }

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
    $('#delete_form_modal').submit(function (e) {
        var id = $('#deleted_id').val();
        e.preventDefault();
        if (!id)
            return;
        var reason = $("#deleting_reason").val();
        console.log('Reason Before: ', reason);
        $.post("{{route('destroy_from_citizian')}}", {
            "_token": "{{csrf_token()}}",
            'id': id,
            'reason': reason
        }, function (data) {
            $("#deleting_reason").val('');
            $('#message_session').show();
            $('#content_message').text(data.msg);
        });
    });

    $('#confirm_delete_form_modal').submit(function (e) {
        var id = $('#deleted_id').val();
        e.preventDefault();
        if (!id)
            return;

        var inputValue = $("input[name='optradio6']:checked").val();
        if (inputValue == 1) {
            $.post("{{route('confirm_destroy_from_citizian')}}", {
                "_token": "{{csrf_token()}}",
                'id': id,
            }, function (data) {
                $('#message_session').show();
                $('#content_message').text(data.msg);
            });
        }else if(inputValue == 0){
            var deleting_reprocessing_recommendations = $('#deleting_reprocessing_recommendations').val();
            $.post("{{route('confirm_detory_reprocessing_recommendations_from_citizian')}}", {
                "_token": "{{csrf_token()}}",
                'id': id,
                'recommendations_for_deleting': deleting_reprocessing_recommendations,
            }, function (data) {
                $('#message_session').show();
                $('#content_message').text(data.msg);
            });
        }
    });

    $('#update_clarification_form_modal').submit(function (e) {
        var id = $('#clarification_id').val();
        e.preventDefault();
        if (!id)
            return;

        var need_clarification = $("input[name='optradio1']:checked").val();
        var have_clarified = $("input[name='optradio2']:checked").val();
        var reformulate_content = $('#reformulate_content').val();
        var reason_lack_clarification = $('#reason_lack_clarification').val();
        var reprocessing_recommendations = $('#reprocessing_recommendations').val();
        var reprocessing = $("input[name='optradio3']:checked").val();
        $.post("/account/form/clarification_from_citizian/" + id, {
            "_token": "{{csrf_token()}}",
            "method": "put",
            'need_clarification': need_clarification,
            'have_clarified': have_clarified,
            'reformulate_content': reformulate_content,
            'reason_lack_clarification': reason_lack_clarification,
            'reprocessing': reprocessing,
            'reprocessing_recommendations': reprocessing_recommendations,
        }, function (data) {
            $('#message_session').show();
            $('#content_message').text(data.msg);
        });
    });


    $('#update_category_form_modal').submit(function (e) {
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
        $.post("/account/form/change-category/" + id, {
            "_token": "{{csrf_token()}}",
            "method": "put",
            'category_id': category_id
        }, function (data) {
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

    $('#response_type_select').change(function () {

        if ($(this).val() == '1') {
            $("#replay_advanced").show();
        } else {
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
