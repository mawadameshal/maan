@extends("layouts._account_layout")
@section("title", "إرسال الرسائل النصية")
@section("content")
    <span id="mybody">
        <div class="row">
            <div class="col-md-12">
                <h4>هذه الواجهة مخصصة للتحكم في إرسال الرسائل النصية (SMS) من خلال النظام </h4>
            </div>
        </div>

        <br>

          <div class="row">
              <div class="col-md-12" id="app">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{--  start first choice --}}
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" name="citizen_show" type="hidden" value="0">
                                    <input class="form-check-input" type="checkbox" id="citizen_show"
                                           name="citizen_show" v-model="citizen_show">
                                    <label class="form-check-label" for="citizen_show">
                                        يمكنك تعريف الرسائل النصية التي يقوم النظام بإرسالها بشكل تلقائي أدناه:
                                    </label>
                                </div>
                            </div>
                             <form action="/account/message" method="post">
                                 @csrf
                                 <br><br>
                                 <div class="row">
                                     <div class="col-md-12"></div>
                                     <div class="col-md-12">
                                         <div v-if="citizen_show">
                                             <table class="table table-bordered">

                                                 <thead>
                                                     <tr>
                                                         <th style="width: 25%;">نوع الرسالة</th>
                                                         <th style="width: 65%;">نص الرسالة</th>
                                                     </tr>
                                                 </thead>
                                                 <tbody>
                                                 @foreach($messagesType as $messageType)
                                                     @if($messageType->id == 1 || $messageType->id == 2)
                                                     <tr>
                                                         <td>{{$messageType->name}}</td>
                                                         <td>
                                                             <input type="hidden" value="{{$messageType->id}}" name="update_id[]" />
                                                             <input class="form-control" type="text" value="{{$messageType->text}}" name="update_text[]" />
                                                         </td>
                                                     </tr>
                                                     @endif
                                                 @endforeach
                                                 </tbody>

                                             </table>

                                             <div class="row">
                                                 <div class="col-md-4">
                                                     <button class="btn btn-success" type="button" name="msg_show" onclick="$('#msg_show').show();">
                                                     <span class="glyphicon glyphicon-plus"></span>  إضافة نوع رسالة جديد
                                                 </button>
                                                 </div>
                                                 <div class="col-md-12"></div>

                                                 <div class="form-group row">
                                                     <div class="col-md-12">
                                                     <br><br>
                                                     <div style="display: none" id="msg_show">
                                                         <div class="col-md-8">
                                                             <label class="col-md-2 col-form-label">النوع</label>
                                                             <input class="col-md-6 form-control" type="text" value="{{old('name')}}" name="name" id="name" style="width: 80%">
                                                         </div>

                                                         <div class="col-md-12">
                                                             <br>
                                                         </div>

                                                         <div class="col-md-8">
                                                             <label class="col-md-2 col-form-label">نص الرسالة</label>
                                                             <input class="col-md-6 form-control" type="text" value="{{old('text')}}" name="text" id="text" style="width: 80%">
                                                         </div>
                                                     </div>
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="form-actions" style="text-align: left;">
                                                 <input type="submit" class="btn btn-success" value="حفظ">
                                                 <a type="button" href="/account/message" class="btn btn-light">إلغاء</a>
                                             </div>
                                             <hr>
                                         </div>
                                     </div>
                                 </div>
                             </form>
                            {{--  end first choice --}}
                            <div class="col-md-12"></div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" name="benefic_show" type="hidden" value="0">
                                    <input class="form-check-input" type="checkbox" id="benefic_show"
                                           name="benefic_show" v-model="benefic_show">
                                    <label class="form-check-label" for="benefic_show">
يمكنك إرسال رسائل نصية بشكل يدوي من خلال:
                                    </label>
                                </div>
                            </div>

                            <br><br>
                             <div class="row">
                                 <div v-if="benefic_show">
                                     <div class="col-md-12"></div>
                                     <div class="col-md-6">
                                         <br>
                                         <div class="form-group">
                                                <select id="message_type_id_selection" class="form-control" onchange="gettype()">
                                                    <option value="" selected>حدد نوع الرسالة</option>
                                                    @foreach($messagesType as $messageType)
                                                        <option
                                                            @if(request('messagetype_id')===''.$messageType->id)selected
                                                            @endif
                                                            value="{{$messageType->id}}">{{$messageType->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                     </div>
                                     <div class="col-md-12"></div>
                                     <div class="col-md-12">
                                        <div id="dataListPanel" class="panel panel-default" style="margin-top:15px;">
                                         <div class="panel-body">
                                             <input id="dataListCheck" type="checkbox" name="dataListC" value="dataListC" onclick="dataList()">
                                                <label for="dataListC" style="vertical-align: middle;">إرسال رسائل نصية لمجموعة من الأسماء:</label>
                                                    {{-- action=""--}}
                                                <form action="{{ route('send_group_messages') }}" method="POST" enctype="multipart/form-data" id="dataListForm" style="display:none; padding-top: 20px;border-top: 1px solid #e2e2e2;">
                                                    @csrf
                                                    <input type="hidden" id="message_type_id" name="message_type_id">
                                                    <div class="form-group row">
                                                        <div class="col-sm-6">
                                                            <span> يجب رفع بيانات ارسال الرسائل حسب النموذج المرفق:  </span>
                                                            <a href="{{ route('download-sample-file') }}" class="btn btn-primary"
                                                               style="margin-top:10px;margin-right: 15%;"><i class="fa fa-download" style=""></i> تحميل
                                                                نموذج الملف المطلوب </a>
                                                        </div>

                                                        <div class="col-sm-4" style="display: inline-flex;margin-top: 2%;">
                                                            <input type="file" name="data_file" style="width: 200px;"/>
                                                            <input type="submit" style="width:70px;padding: 0.4rem 2rem !important;font-size: 1.3rem !important;" value="رفع" class="btn btn-primary"/>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </form>
                                         </div>
                                     </div>
                                     </div>
                                     <div class="col-md-12">
                                        <div id="addNewPanel" class="panel panel-default" style="margin-top:15px;">
                                     <div class="panel-body">
                                         <input id="addNewCheck" type="checkbox" name="addNewC" value="addNewC" onclick="addNewCitizen()">
                                         <label for="addNewC" style="vertical-align: middle;">إرسال رسائل نصية بشكل فردي:</label>

                                         <form id="addNewForm" method="post" action="{{ route('send_single_message') }}"
                                               style="display:none; padding-top: 20px;border-top: 1px solid #e2e2e2;">
                                             @csrf
                                             <input type="hidden" id="message_type_id_1" name="message_type_id_1">

                                             <div class="form-group row">
                                                 <div class="col-md-2">
                                                     <label class="form-check-label">رقم التواصل</label>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <input class="form-control {{($errors->first('mobile') ? " form-error" : "")}}" type="number" value="{{old('mobile')}}" name="mobile" id="mobile" style="width: 80%">
                                                    {!! $errors->first('mobile', '<p class="help-block" style="color:red;">:message</p>') !!}


                                                 </div>
                                             </div>

                                              <div class="form-group row">
                                                 <div class="col-md-2">
                                                     <label class="form-check-label">نص الرسالة النصية</label>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <input class="form-control" type="text" value="{{old('message_text')}}" name="message_text" id="message_text" style="width: 80%">
                                                     <div style="margin-top: 5px;">
                                                         عدد الاحرف يساوي
                                                         <span id="count_of_letters" style="color:red;">0</span>
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="form-actions" style="text-align: left;">
                                                 <input type="submit" class="btn btn-success" value="إرسال">
                                                 <a type="button" href="/account/message" class="btn btn-light">إلغاء</a>
                                             </div>

                                         </form>
                                     </div>


                                 </div>
                                     </div>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
@endsection

        @section('js')
            <script>
                $('body').on("keyup",'#message_text', function(){
                    doneTyping();
                });

                function doneTyping () {
                    let str = $('#message_text').val();
                    let letterCount = str.replace(/\s/g,'').length;
                    $('#count_of_letters').text(letterCount);
                }

                function gettype(){
                    console.log( "ready!" );
                    $('#message_type_id').val($('#message_type_id_selection').val());
                    $('#message_type_id_1').val($('#message_type_id_selection').val());
                }

            </script>
            <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
            <script>
        new Vue({
            el: '#app',
            data: {
                benefic_show: false,
                citizen_show: false,
                group_show: false,
                single_show: false,
            },
        });

        function dataList() {
            // Get the checkbox
            var checkBox = document.getElementById("dataListCheck");
            // Get the output text
            var text = document.getElementById("dataListForm");

            // If the checkbox is checked, display the output text
            if (checkBox.checked == true) {
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }

        function addNewCitizen() {
            // Get the checkbox
            var checkBox = document.getElementById("addNewCheck");
            // Get the output text
            var text = document.getElementById("addNewForm");

            // If the checkbox is checked, display the output text
            if (checkBox.checked == true) {
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }


    </script>
@endsection

