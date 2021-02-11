@extends("layouts._account_layout")

@section("title", "اضافة مستفيد جديد")


@section("content")

    <div class="row">
        <div class="col-md-9">
            <h4>هذه الواجهة مخصصة لإضافة بيانات مستفيدي مشاريع المركز في النظام </h4>
            <br>
            <h4>يمكنك إضافة بيانات المستفيدين من خلال : </h4>
        </div>
    </div>
    <div id="dataListPanel" class="panel panel-default" style="margin-top:15px;">
        <div class="panel-body">

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <input id="dataListCheck" type="checkbox" name="dataListC" value="dataListC" onclick="dataList()">
            <label for="dataListC" style="vertical-align: middle;">تحميل قائمة بيانات المستفيدين </label>
            <form action="{{ route('save-citizen-data') }}" method="POST" enctype="multipart/form-data"
                  id="dataListForm" style="display:none; padding-top: 20px;border-top: 1px solid #e2e2e2;">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6">
                        <span> يجب رفع بيانات المستفيدين من المشروع حسب النموذج المرفق: </span>
                        <a href="{{ route('download-citizen-file') }}" class="btn btn-primary"
                           style="margin-top:10px;margin-right: 15%;"><i class="fa fa-download" style=""></i> تحميل
                            نموذج الملف المطلوب </a>
                    </div>

                    <div class="col-sm-4" style="display: inline-flex;margin-top: 2%;">
                        <input type="file" name="data_file" style="width: 200px;"/>
                        <input type="submit"
                               style="width:70px;padding: 0.4rem 2rem !important;font-size: 1.3rem !important;"
                               value="رفع" class="btn btn-primary"/>
                    </div>
                </div>

                <hr>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="project_id" class="col-form-label" style="margin-top: 5px;">حدد اسم المشروع المدرجة
                            ضمنها هذه القائمة: </label>
                    </div>
                    <div class="col-sm-4">

                        <select class="form-control {{($errors->first('project_id') ? " form-error" : "")}}" name="project_id">
                            <option value="">اختر</option>
                            @foreach ($projects as $project )
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('project_id', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div id="addNewPanel" class="panel panel-default" style="margin-top:15px;">
        <div class="panel-body">
            <input id="addNewCheck" type="checkbox" name="addNewC" value="addNewC" onclick="addNewCitizen()">
            <label for="addNewC" style="vertical-align: middle;">إضافة مستفيد جديد بشكل منفصل</label>

            <form id="addNewForm" method="post" action="/account/citizen"
                  style="display:none; padding-top: 20px;border-top: 1px solid #e2e2e2;">
                @csrf
                <span style="font-weight:600;">المعلومات المطلوبة</span>
                <br>
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label for="project_id" class="col-form-label" style="margin-top: 5px;">يرجى ادخال رقم الهوية لفحص معلومات المستفيد/ة:</label>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" onchange="gitCitizen()" autofocus class="form-control {{($errors->first('id_number') ? " form-error" : "")}}" value="{{old("id_number")}}" id="id_number" name="id_number">
                        {!! $errors->first('id_number', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>
                </div>


                <div class="form-group row">

                    <div class="col-sm-5">
                        <label for="first_name" class="col-form-label"> الاسم الأول</label>

                        <input type="text" autofocus class="form-control {{($errors->first('first_name') ? " form-error" : "")}}" value="{{old("first_name")}}" id="first_name"
                               name="first_name">
                        {!! $errors->first('first_name', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>
                    <div class="col-sm-5">
                        <label for="father_name" class="col-form-label">اسم الأب</label>

                        <input type="text" autofocus class="form-control {{($errors->first('father_name') ? " form-error" : "")}}" value="{{old("father_name")}}"
                               id="father_name" name="father_name">
                        {!! $errors->first('father_name', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-5">

                        <label for="grandfather_name" class="col-form-label">إسم الجد</label>
                        <input type="text" autofocus class="form-control {{($errors->first('grandfather_name') ? " form-error" : "")}}" value="{{old("grandfather_name")}}"
                               id="grandfather_name" name="grandfather_name">
                        {!! $errors->first('grandfather_name', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>

                    <div class="col-sm-5">
                        <label for="last_name" class="col-form-label">اسم العائلة</label>

                        <input type="text" autofocus class="form-control {{($errors->first('last_name') ? " form-error" : "")}}" value="{{old("last_name")}}" id="last_name"
                               name="last_name">
                        {!! $errors->first('last_name', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label for="id_number" class="col-form-label">رقم الهوية</label>

                        <input type="text" autofocus class="form-control {{($errors->first('id_number') ? " form-error" : "")}}" value="{{old("id_number")}}" id="id_number"
                               name="id_number">
                        {!! $errors->first('id_number', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>

                    <div class="col-sm-5">
                        <label for="mobile" class="col-form-label"> رقم التواصل(1)</label>
                        <input type="text" class="form-control {{($errors->first('mobile') ? " form-error" : "")}}" value="{{old("mobile")}}" id="mobile" name="mobile">
                        {!! $errors->first('mobile', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label for="mobile" class="col-form-label"> رقم التواصل(2)</label>
                        <input type="text" class="form-control {{($errors->first('mobile') ? " form-error" : "")}}" value="{{old("mobile")}}" id="mobile" name="mobile">
                        {!! $errors->first('mobile', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>
                    <div class="col-sm-5">
                        <label for="circle_id" class="col-form-label">المحافظة</label>

                        <select class="form-control {{($errors->first('governorate') ? " form-error" : "")}}" name="governorate">
                            <option value="">اختر</option>
                            <option value="الشمال" {{old('governorate')=='الشمال'?"selected":""}}>الشمال</option>
                            <option value="غزة" {{old('governorate')=='غزة'?"selected":""}}>غزة</option>
                            <option value="الوسطى" {{old('governorate')=='الوسطى'?"selected":""}}>الوسطى</option>
                            <option value="خانيونس" {{old('governorate')=='خانيونس'?"selected":""}}>خانيونس</option>
                            <option value="رفح" {{old('governorate')=='رفح'?"selected":""}}>رفح</option>
                        </select>
                        {!! $errors->first('governorate', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label for="city" class="col-form-label"> المنطقة</label>
                        <input type="text" class="form-control {{($errors->first('city') ? " form-error" : "")}}" value="{{old("city")}}" id="city" name="city">
                        {!! $errors->first('city', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>

                    <div class="col-sm-5">
                        <label for="street" class="col-form-label"> العنوان</label>
                        <input type="text" class="form-control {{($errors->first('street') ? " form-error" : "")}}" value="{{old("street")}}" id="street" name="street">
                        {!! $errors->first('street', '<p class="help-block" style="color:red;">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label class="col-form-label" style="font-weight:600;">أسماء المشاريع المدرج ضمنها المستفيد حالياً:</label>
                        <ul style="padding-right:15px;">
                            <li>لا يوجد مشاريع</li>
                        </ul>
                        <hr>

                        <label class="col-form-label" style="font-weight:600;"> إضافته ضمن مشروع آخر، حدد: </label>
                        <div class="form-group row">
                            <div class="col-sm-5">
                                <label for="project_id" class="col-form-label" style="margin-top: 5px;">حدد اسم المشروع المدرج ضمنها المستفيد حالياً:</label>
                            </div>
                            <div class="col-sm-5">

                                <select class="form-control {{($errors->first('project_id') ? " form-error" : "")}}" name="project_id">
                                    <option value="">اختر</option>
                                    @foreach ($projects as $project )
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>

                                    @endforeach

                                </select>
                                {!! $errors->first('project_id', '<p class="help-block" style="color:red;">:message</p>') !!}
                            </div>
                        </div>


                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-4 col-md-offset-4">
                        <input type="submit" class="btn btn-success" value="حفظ"/>
                        <a href="/account/citizen" class="btn btn-light">الغاء الامر</a>
                    </div>
                </div>
            </form>


        </div>

        <div id="mo"></div>


    </div>

@endsection
@section("js")
    <script>

        if($( "#first_name" ).hasClass( "form-error" )){
            $("#addNewCheck").prop('checked', true);
            $("#addNewForm").show();
        }

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

        function gitCitizen() {

            var id_number = document.getElementById("id_number").value;
            console.log(id_number);

            $.ajax({
                url: "{{ route('get-citizen-data') }}",
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    id_number,
                },
                success: function (data) {
                    console.log(data);
                    document.getElementById("addNewForm").style.display = "none";
                    $('#mo').html(data);
                }
            });


        }


    </script>

@endsection
