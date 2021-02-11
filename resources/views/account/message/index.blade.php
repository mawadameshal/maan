@extends("layouts._account_layout")
@section("title", "إدارة الرسائل النصية")
@section("content")
    <span id="mybody">
        <div class="row">
            <div class="col-md-12">
                <h4>هذه الواجهة مخصصة لعرض الرسائل النصية (SMS) المرسلة من خلال النظام </h4>
            </div>
        </div>

        <br>

         <div class="row">
             <div class="col-md-12">
              <div class="col-md-3" style="border:1px; solid;background-color: #4276a4;">
                  <h4 style="font-weight: bold;color: white;">عدد الرسائل المرسلة:</h4>
              </div>
             <div class="col-md-1" style="border:1px solid;text-align: center;">
                 <h4 id="sending_sms" name="sending_sms">88</h4>
             </div>

             <div class="col-md-3" style="border:1px solid;background-color: #4276a4;">
                 <h4 style="font-weight: bold;color: white;">عدد الرسائل المتبقية:</h4>
             </div>
             <div class="col-md-1" style="border:1px solid;text-align: center;">
                 <h4 id="remain_sms" name="remain_sms">100</h4>
             </div>
             </div>
         </div>

        <br>
    <div class="form-group row filter-div">
        <div class="col-sm-12">
            <form>
                <div class="row">
                    <div class="col-sm-4">
                        <button type="button" style="width:100px;" class="btn btn-primary adv-search-btn">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        بحث متقدم
                        </button>
                        <button type="submit" target="_blank" name="theaction" title="تصدير إكسل" style="width:100px;"
                                value="excel" class="btn btn-primary">
                            <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                        تصدير
                        </button>

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3 adv-search">
                        <input type="text" class="form-control" name="id" placeholder="الرقم المرجعي" >
                    </div>

                    <div class="col-sm-3 adv-search">
                        <input type="text" class="form-control" name="citizen_id" placeholder="اسم مقدم الاقتراح / الشكوي" >
                    </div>

                    <div class="col-sm-3 adv-search">
                        <input type="text" class="form-control" name="id_number" placeholder="رقم الهوية" >
                    </div>

                    <div class="col-sm-3 adv-search">
                        <input type="text" class="form-control" name="mobile" placeholder="رقم التواصل" >
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-3 adv-search">
                        <select name="project_id" class="form-control">
                            <option value="" selected>اسم المشروع</option>
                            <option value="-1" @if(request('project_id')==='-1')selected
                                @endif>جميع المشاريع
                            </option>
                            @foreach($projects as $project)
                                <option
                                    @if(request('project_id')===''.$project->id)selected
                                    @endif
                                    value="{{$project->id}}">{{$project->code." ".$project->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <select name="active" class="form-control">
                            <option value=""> نوع الرسالة </option>
                            @foreach($messagesType as $messageType)
                                <option {{request('active')==$messageType->id?"selected":""}} value="{{$messageType->id}}">{{$messageType->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <select name="sent_type" class="form-control">

                            <option value="">حالة الارسال</option>
                            <option value="1">تم الإرسال</option>
                            <option value="2">عالقة</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3 adv-search">
                        <label for="from_date">تاريخ إرسال محدد</label>
                        <input type="text" class="form-control datepicker" name="datee"  value="{{request('datee')}}"
                               placeholder="يوم / شهر / سنة"/>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <label for="from_date">من تاريخ إرسال </label>
                        <input type="text" class="form-control datepicker" name="from_date" value="{{request('from_date')}}"
                               placeholder="يوم / شهر / سنة"/>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <label for="to_date">إلى تاريخ إرسال</label>
                        <input type="text" class="form-control datepicker" name="to_date" value="{{request('to_date')}}"
                               placeholder="يوم / شهر / سنة"/>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <button type="submit" name="theaction" title="بحث" style="width:70px;margin-top:25px" value="search"
                                class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        بحث
                        </button>
                </div>

                </div>

                <div class="row" style="margin-top:15px;">
                </div>
            </form>
        </div>

    </div>
    <div class="mt-3"></div>
    @if($items)
            @if($items->count()>0)
                <div class="table-responsive">

            <table class="table table-hover table-striped" style="width:170% !important;max-width:170% !important;white-space:normal;">
                <thead>
                <tr>
                    <th style="word-break: normal;">الرقم المرجعي</th>
                    <th style="max-width: 250px;word-break: normal;">الاسم رباعي</th>
                    <th style="max-width: 100px;word-break: normal;">رقم الهوية</th>
                    <th style="max-width: 100px;word-break: normal;">اسم المشروع</th>
                    <th style="max-width: 100px;word-break: normal;">رقم التواصل</th>
                    <th style="max-width: 100px;word-break: normal;">نوع الرسالة</th>
                    <th style="max-width: 100px;word-break: normal;">حالة الإرسال</th>
                    <th style="max-width: 100px;word-break: normal;">تاريخ الإرسال</th>
                    <th style="max-width: 100px;word-break: normal;">توقيت الإرسال</th>

                </tr>
                </thead>
                <tbody>
                    @foreach($items as $a)
                        <tr class="tr-id-{{$a->id}}">
                            <td style="word-break: normal;">{{$a->id}}</td>
                            <td style="max-width: 250px;word-break: normal;">{{$a->citizen->first_name." ".$a->citizen->father_name." ".$a->citizen->grandfather_name." ".$a->citizen->last_name}}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$a->citizen->id_number}}</td>
                            <td style="max-width: 150px;word-break: normal;;">{{$a->project->id == 1 ? 'غير مستفيد' : ' مستفيد' }}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$a->project->name}}</td>
                            <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->project->end_date <= now() ?  'منتهي' : 'مستمر'}}</td>
                            <td style="max-width: 100px;word-break: normal;"> {{$a->sent_typee->name}}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$a->form_type->name}}</td>
                            <td style="max-width: 100px;word-break: normal;">{{$a->datee}}</td>

                            @if($a->form_status->id == 2)
                                <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">تم الرد </td>
                            @else
                                <td style="max-width: 100px;word-break: normal;">قيد الدراسة</td>
                            @endif

                            @if($a->form_status->id == 1)
                                <td style="max-width: 100px;word-break: normal;"> قيد التبليغ </td>
                            @elseif($a->form_status->id == 2)
                                <td style="max-width: 100px;word-break: normal;"> تم التبليغ </td>
                            @else
                                <td style="max-width: 100px;word-break: normal;"> لم يتم التبليغ </td>
                            @endif

                            @if($a->evaluate)
                                @if($a->evaluate == 1)
                                    <td style="max-width: 100px;word-break: normal;"> راضي بشكل كبير </td>
                                @elseif($a->evaluate==2)
                                    <td style="max-width: 100px;word-break: normal;"> راضي بشكل متوسط </td>
                                @elseif($a->evaluate == 3)
                                    <td style="max-width: 100px;word-break: normal;"> راضي بشكل ضعيف </td>
                                @else
                                    <td style="max-width: 100px;word-break: normal;"> غير راضي عن الرد </td>
                                @endif
                            @else
                                <td style="max-width: 100px;word-break: normal;">لا يوجد رد</td>
                            @endif

                            <td style="max-width: 100px;word-break: normal;">
                                <?php
                                $form_files = \App\Form_file::where('form_id', '=', $a->id)->get();

                                if(!$form_files->isEmpty()){
                                ?>
                                <a class="btn btn-xs btn-primary" data-toggle="modal" id="smallButton" data-target="#smallModal"
                                   data-attr="{{ route('showfiles', $a->id) }}" title="اضغظ هنا">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                                <?php }else{?>
                                    <a class="btn btn-xs btn-primary" title="لايوجد مرفقات لعرضها" disabled="disabled">
                                        <i class="glyphicon glyphicon-eye-close"></i>
                                    </a>
                                <?php } ?>
                            </td>


                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
                <br>
                <div style="float:left" >{{$items->links()}} </div>
                <br> <br><br>
            @else
                <br><br>
                <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>


            @endif

        @else

            <div class="table-responsive">

            <table class="table table-hover table-striped" style="white-space:normal;">
                <thead>
                <tr>
                    <th style="word-break: normal;">الرقم المرجعي</th>
                    <th style="max-width: 250px;word-break: normal;">الاسم رباعي</th>
                    <th style="max-width: 100px;word-break: normal;">رقم الهوية</th>
                    <th style="max-width: 100px;word-break: normal;">اسم المشروع</th>
                    <th style="max-width: 100px;word-break: normal;">رقم التواصل</th>
                    <th style="max-width: 100px;word-break: normal;">نوع الرسالة</th>
                    <th style="max-width: 100px;word-break: normal;">حالة الإرسال</th>
                    <th style="max-width: 100px;word-break: normal;">تاريخ الإرسال</th>
                    <th style="max-width: 100px;word-break: normal;">توقيت الإرسال</th>

                </tr>
                </thead>
                <tbody>
                </tbody>
                </table>

            </div>
        @endif
@endsection
@section('css')
    <script src="https://unpkg.com/vue"></script>

@endsection
@section('js')
    <script>
        $('.adv-search').hide();
        $('.adv-search-btn').click(function () {

            $('.adv-search').slideToggle("fast", function() {
                if ($('.adv-search').is(':hidden'))
                {
                    $('#searchonly').show();
                }
                else
                {
                    $('#searchonly').hide();
                }
            });
        });


    </script>
@endsection

