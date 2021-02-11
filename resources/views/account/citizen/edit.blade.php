@extends("layouts._account_layout")

@section("title", " تعديل بيانات مستفيدي المشاريع ")


@section("content")
<br>
    <form method="post" enctype="multipart/form-data" action="/account/citizen/{{$item['id']}}">
        {{csrf_field()}}
        @method('patch')
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="id_number" class="col-form-label" style="vertical-align: sub;">رقم الهوية لفحص معلومات المستفيد/ة:</label>
	    </div>
	    <div class="col-sm-5">
                <input type="text"  autofocus class="form-control {{($errors->first('id_number') ? " form-error" : "")}}" value="{{$item["id_number"]}}" id="id_number"
                       name="id_number">
            {!! $errors->first('id_number', '<p class="help-block" style="color:red;">:message</p>') !!}

        </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                @if(count($item->projects) > 0)
                    <div class="alert alert-info">
                        <strong>المواطن مستفيد من مشروع: </strong>
                        <ul style="padding-right:15px;">
                            @foreach($item->projects as $project )
                                <li>{{ $project->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="alert alert-info">
                        <strong>المواطن غير مستفيد من مشاريع المركز.</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-5">
               <label for="first_name" class="col-form-label">الإسم الأول</label>
               <input type="text" autofocus class="form-control {{($errors->first('first_name') ? " form-error" : "")}}" value="{{$item["first_name"]}}" id="first_name"
                       name="first_name">
                {!! $errors->first('first_name', '<p class="help-block" style="color:red;">:message</p>') !!}

            </div>

            <div class="col-sm-5">
               <label for="father_name" class="col-form-label">إسم الأب</label>
               <input type="text" autofocus class="form-control {{($errors->first('father_name') ? " form-error" : "")}}" value="{{$item["father_name"]}}" id="father_name"
                       name="father_name">
                {!! $errors->first('father_name', '<p class="help-block" style="color:red;">:message</p>') !!}

            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-5">
                <label for="grandfather_name" class="col-form-label">إسم الجد</label>
                <input type="text" autofocus class="form-control {{($errors->first('grandfather_name') ? " form-error" : "")}}" value="{{$item["grandfather_name"]}}" id="grandfather_name"
                       name="grandfather_name">
                {!! $errors->first('grandfather_name', '<p class="help-block" style="color:red;">:message</p>') !!}

            </div>

            <div class="col-sm-5">
                <label for="last_name" class="col-form-label">إسم العائلة</label>
                <input type="text" autofocus class="form-control {{($errors->first('last_name') ? " form-error" : "")}}" value="{{$item["last_name"]}}" id="last_name"
                       name="last_name">
                {!! $errors->first('last_name', '<p class="help-block" style="color:red;">:message</p>') !!}

            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-5">
                <label for="id_number" class=" col-form-label">رقم الهوية</label>

                <input type="text" autofocus class="form-control {{($errors->first('id_number') ? " form-error" : "")}}" value="{{$item["id_number"]}}" id="id_number"
                       name="id_number">
                {!! $errors->first('id_number', '<p class="help-block" style="color:red;">:message</p>') !!}

            </div>

            <div class="col-sm-5">
                <label for="mobile" class="col-form-label">رقم التواصل(1)</label>

                <input type="text" class="form-control {{($errors->first('mobile') ? " form-error" : "")}}" value="{{$item["mobile"]}}" id="mobile" name="mobile">
                {!! $errors->first('mobile', '<p class="help-block" style="color:red;">:message</p>') !!}

            </div>
        </div>
        <div class="form-group row">
        <div class="col-sm-5">
                <label for="mobile" class="col-form-label">رقم التواصل(2)</label>

                <input type="text" class="form-control {{($errors->first('mobile') ? " form-error" : "")}}" value="{{$item["mobile"]}}" id="mobile" name="mobile">
            {!! $errors->first('mobile', '<p class="help-block" style="color:red;">:message</p>') !!}

        </div>
            <div class="col-sm-5">
                <label for="circle_id" class="col-form-label">المحافظة</label>
                <select class="form-control {{($errors->first('governorate') ? " form-error" : "")}}" name="governorate">
                    <option value="">اختر</option>
                    <option value="الشمال" {{($item['governorate']=='الشمال'||$item['governorate']=='شمال غزة')?"selected":""}}>الشمال</option>
                    <option value="غزة" {{$item['governorate']=='غزة'?"selected":""}}>غزة</option>
                    <option value="الوسطى" {{($item['governorate']=='دير البلح'||$item['governorate']=='الوسطى')?"selected":""}}>الوسطى</option>
                    <option value="خانيونس" {{($item['governorate']=='خان يونس'||$item['governorate']=='خانيونس')?"selected":""}}>خانيونس</option>
                    <option value="رفح" {{$item['governorate']=='رفح'?"selected":""}}>رفح</option>
                </select>
                {!! $errors->first('governorate', '<p class="help-block" style="color:red;">:message</p>') !!}

            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-5">
                <label for="city" class="col-form-label"> المنطقة</label>

                <input type="text" class="form-control {{($errors->first('city') ? " form-error" : "")}}" value="{{$item["city"]}}" id="city" name="city">
                {!! $errors->first('city', '<p class="help-block" style="color:red;">:message</p>') !!}

            </div>

            <div class="col-sm-5">
                <label for="street" class="col-form-label"> العنوان</label>

                <input type="text" class="form-control {{($errors->first('street') ? " form-error" : "")}}" value="{{$item["street"]}}" id="street" name="street">
                {!! $errors->first('street', '<p class="help-block" style="color:red;">:message</p>') !!}

            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
               <label class="col-form-label" style="font-weight:600;"> أسماء المشاريع المدرج ضمنها المستفيد حالياً:</label>
               <ul style="padding-right:15px;">
                @forelse ($item->projects as $project)
                <option value="{{$project->id  }}">{{ $project->name }}</option>

                @empty
                    لا يوجد مشاريع
                @endforelse
               	 {{--  <li>مشروع XX </li>  --}}
               </ul>
               <hr>

               <label class="col-form-label" style="font-weight:600;">  إضافته ضمن مشروع آخر، حدد: </label>
		<div class="form-group row">
           	 <div class="col-sm-4">
             		<label for="project_id" class="col-form-label" style="margin-top: 5px;">حدد اسم المشروع المراد دمج المستفيد ضمنه حالياً:</label>
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
            <div class="col-sm-5 col-md-offset-2">
                <input type="submit" class="btn btn-success" value="حفظ"/>
                <a href="/account/citizen" class="btn btn-light">الغاء الامر</a>
            </div>
        </div>
    </form>
@endsection

@section("js")
    <script>
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
