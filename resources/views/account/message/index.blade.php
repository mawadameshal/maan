@extends("layouts._account_layout")
@section("title", "إدارة الرسائل النصية (SMS)")
@section('content')
    <span id="mybody">
        <div class="row">
            <div class="col-md-12">
                <h4>هذه الواجهة مخصصة للتحكم في إدارة الرسائل النصية (SMS) المرسلة من خلال النظام.</h4>
            </div>
        </div>
        <br>
        <table class="table table-hover " style="width:80% !important; white-space:normal;">
                <thead>
                <tr>
                    <th style="max-width: 25%; word-break: normal;">للحصول على معلومات بخصوص الرسائل المتبقية و المرسلة و قيد الارسال و المتوفر من الرصيد و تاريخ انتهاء رصيد الرسائل</th>
                    <th style="background-color: white;"><a target="_blank" href="https://www.hotsms.ps/portal/user/dashboard"
                                                            class="btn btn-xs btn-primary">اضغظ هنا</a></th>
                </tr>
                </thead>
            </table>
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
                        <input type="text" class="form-control" name="citizen_id" placeholder="الاسم رباعي" >
                    </div>
                    <div class="col-sm-3 adv-search">
                        <input type="text" class="form-control" name="id_number" placeholder="رقم الهوية" >
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select name="project_id" class="form-control">
                            <option value="" selected>اسم المشروع</option>
                            @foreach($projects as $project)
                                <option
                                    @if(request('project_id')===''.$project->id)selected
                                    @endif
                                    value="{{$project->id}}">{{$project->code." ".$project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select name="messageType" class="form-control">
                            <option value=""> نوع الرسالة </option>
                            @foreach($messagesType as $messageType)
                                <option
                                    {{request('active')==$messageType->id?"selected":""}} value="{{$messageType->id}}">{{$messageType->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                         <select name="sent_type" class="form-control">
                            <option value="">آلية  الارسال</option>
                            <option value="تلقائي">تلقائي</option>
                            <option value="يدوي">يدوي</option>
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select name="account_id" class="form-control">
                            <option value="" selected>حساب المرسل </option>
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}">{{$account->full_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select name="send_status" class="form-control">
                            <option value="">حالة الارسال</option>
                            <option value="تم الإرسال">تم الإرسال</option>
                            <option value="قيد الإرسال">قيد الإرسال</option>
                            <option value="عالقة">عالقة</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3 adv-search">
                        <label for="from_date">تاريخ إرسال محدد</label>
                        <input type="text" class="form-control datepicker" name="datee" value=""
                               placeholder="يوم / شهر / سنة"/>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <label for="from_date">من تاريخ إرسال </label>
                        <input type="text" class="form-control datepicker" name="from_date"
                               value=""
                               placeholder="يوم / شهر / سنة"/>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <label for="to_date">إلى تاريخ إرسال</label>
                        <input type="text" class="form-control datepicker" name="to_date" value=""
                               placeholder="يوم / شهر / سنة"/>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <button type="submit" name="theaction" title="بحث" style="width:70px;margin-top:25px"
                                value="search"
                                class="btn btn-primary"><span class="glyphicon glyphicon-search"
                                                              aria-hidden="true"></span>
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
                <table class="table table-hover table-striped" style="width:100% !important;max-width:170% !important;white-space:normal;">
                <thead>
                <tr>
                    <th style="word-break: normal;"># </th>
                    <th style="max-width: 250px;word-break: normal;">الاسم رباعي</th>
                    <th style="max-width: 100px;word-break: normal;">رقم الهوية</th>
                    <th style="max-width: 100px;word-break: normal;">رقم التواصل</th>
                    <th style="max-width: 100px;word-break: normal;">اسم المشروع</th>
                    <th style="max-width: 100px;word-break: normal;">نوع الرسالة</th>
                    <th style="max-width: 100px;word-break: normal;">حالة الإرسال</th>
                    <th style="max-width: 100px;word-break: normal;">تاريخ الإرسال</th>
                    <th style="max-width: 100px;word-break: normal;">توقيت الإرسال</th>
                    <th style="max-width: 100px;word-break: normal;">حساب المرسل</th>
                    <th style="max-width: 100px;word-break: normal;"> آلية الإرسال</th>

                </tr>
                </thead>
                <tbody>
                @foreach($items as $a)
                    <tr class="tr-id-{{$a->id}}">
                        <td style="word-break: normal;">{{$a->id}}</td>
                        <td style="max-width: 250px;word-break: normal;">{{$a->first_name." ".$a->father_name." ".$a->grandfather_name." ".$a->last_name}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->id_number}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->mobile}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->binfit}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->message_type}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->send_status}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->datee}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->timee}}</td>
                        <td style="max-width: 100px;word-break: normal;">{{$a->employee_name}}</td>
                        <td style="max-width: 100px;word-break: normal;text-align: center;">{{$a->send_procedure}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

                <br>
                <div style="float:left">{{$items->links()}} </div>
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
                    <th style="word-break: normal;"># </th>
                    <th style="max-width: 250px;word-break: normal;">الاسم رباعي</th>
                    <th style="max-width: 100px;word-break: normal;">رقم الهوية</th>
                    <th style="max-width: 100px;word-break: normal;">رقم التواصل</th>
                    <th style="max-width: 100px;word-break: normal;">اسم المشروع</th>
                    <th style="max-width: 100px;word-break: normal;">نوع الرسالة</th>
                    <th style="max-width: 100px;word-break: normal;">حالة الإرسال</th>
                    <th style="max-width: 100px;word-break: normal;">تاريخ الإرسال</th>
                    <th style="max-width: 100px;word-break: normal;">توقيت الإرسال</th>
                    <th style="max-width: 100px;word-break: normal;">حساب المرسل</th>
                    <th style="max-width: 100px;word-break: normal;"> آلية الإرسال</th>

                </tr>
                </thead>
                <tbody>
                </tbody>
                </table>

            </div>
        @endif
        @endsection
        @section('js')
            <script src="https://unpkg.com/vue"></script>
            <script>
        $('.adv-search').hide();
        $('.adv-search-btn').click(function () {

            $('.adv-search').slideToggle("fast", function () {
                if ($('.adv-search').is(':hidden')) {
                    $('#searchonly').show();
                } else {
                    $('#searchonly').hide();
                }
            });
        });


    </script>
@endsection
