	<div class="container">
		<form  method="post" action="/account/citizen/select-project-post/{{$citizen->id}}"  style=" padding-top: 20px;border-top: 1px solid #e2e2e2;">
            {{csrf_field()}}
             <span style="font-weight:600;">المعلومات المطلوبة</span>
            <div class="form-group row">
                 <div class="col-sm-5">
                     <label for="project_id" class="col-form-label" style="margin-top: 5px;">يرجى ادخال رقم الهوية لفحص معلومات المستفيد/ة:</label>

                </div>
                 <div class="col-sm-5">
                    <input type="text" onchange="gitCitizen()" autofocus class="form-control {{($errors->first('id_number') ? " form-error" : "")}}" value="{{$citizen->id_number}}" id="id_number" name="id_number">
                    {!! $errors->first('id_number', '<p class="help-block" style="color:red;">:message</p>') !!}
                 </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    @if(count($citizen->projects) > 0)
                        <div class="alert alert-info">
                            <strong>المواطن مستفيد من مشروع: </strong>
                            <ul style="padding-right:15px;">
                                @foreach($citizen->projects as $project )
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
              <label for="first_name" class="col-form-label"> الاسم الأول</label>

            <input type="text" disabled autofocus class="form-control" value="{{$citizen->first_name}}" id="first_name" name="first_name">
       </div>
        <div class="col-sm-5">
             <label for="father_name" class="col-form-label">اسم الأب</label>

            <input type="text" disabled autofocus class="form-control" value="{{$citizen->father_name}}" id="father_name" name="father_name">
        </div>
    </div>
     <div class="form-group row">
        <div class="col-sm-5">

            <label for="grandfather_name" class="col-form-label">إسم الجد</label>
            <input type="text" disabled disabled autofocus class="form-control" value="{{$citizen->grandfather_name}}" id="grandfather_name" name="grandfather_name">
        </div>

        <div class="col-sm-5">
           <label for="last_name" class="col-form-label">اسم العائلة</label>

            <input type="text" disabled autofocus class="form-control"value="{{$citizen->last_name}}" id="last_name" name="last_name">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
            <label for="id_number" class="col-form-label">رقم الهوية</label>

            <input type="text" disabled autofocus class="form-control" value="{{$citizen->id_number}}" id="id_number" name="id_number">
        </div>

        <div class="col-sm-5">
            <label for="mobile" class="col-form-label"> رقم التواصل(1)</label>

            <input type="text" disabled class="form-control" value="{{$citizen->mobile}}"  id="mobile" name="mobile">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
                <label for="mobile" class="col-form-label"> رقم التواصل(2)</label>

            <input type="text" disabled class="form-control" value="{{$citizen->mobile2}}"  id="mobile" name="mobile2">
        </div>
        <div class="col-sm-5">
         <label for="circle_id" class="col-form-label">المحافظة</label>

            <select class="form-control" disabled name="governorate">
                <option value="">اختر</option>
                <option value="الشمال" {{$citizen->governorate =='الشمال'?"selected":""}}>الشمال</option>
                <option value="غزة" {{$citizen->governorate =='غزة'?"selected":""}}>غزة</option>
                <option value="الوسطى" {{$citizen->governorate =='الوسطى'?"selected":""}}>الوسطى</option>
                <option value="خانيونس" {{ $citizen->governorate =='خانيونس'?"selected":""}}>خانيونس</option>
                <option value="رفح" {{ $citizen->governorate =='رفح'?"selected":""}}>رفح</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-5">
           <label for="city" class="col-form-label"> المنطقة</label>

            <input type="text" disabled class="form-control" value="{{$citizen->city}}"  id="city" name="city">
        </div>

        <div class="col-sm-5">
            <label for="street" class="col-form-label"> العنوان</label>

            <input type="text" disabled class="form-control" value="{{$citizen->street}}"  id="street" name="street">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
           <label class="col-form-label" style="font-weight:600;"> أسماء المشاريع المدرج ضمنها المستفيد حالياً:</label>
           <ul style="padding-right:15px;">
               @forelse  ($citizen->projects as $project )
               <li>{{ $project->name }}</li>
               @empty
               <p>لا يوجد مشاريع</p>
              @endforelse
           </ul>
           <hr>

           <label class="col-form-label" style="font-weight:600;">  إضافته ضمن مشروع آخر، حدد: </label>
    <div class="form-group row">
            <div class="col-sm-5">
                 <label for="project_id" class="col-form-label" style="margin-top: 5px;">حدد اسم المشروع المدرج ضمنها المستفيد حالياً:</label>
    </div>
     <div class="col-sm-5">


        <?php
        $projects = \DB::table("projects")->get();
        ?>
        <ul disabled class="list-unstyled">
            @foreach($projects as $project)
                @if($project->id!="1")
                <li>
                    <label><input  {{$citizen->projects->contains($project->id)?'checked':''}} type="checkbox" name="projects[]"

                                   value="{{$project->id}}" /> <b>{{$project->name}} - {{$project->code}}</b></label>
                </li>
                @endif
            @endforeach
        </ul>
            </div>

        </div>


    </div>


    <div class="col-md-2">
        <button type="submit" class="btn btn-success">حفظ</button>
    </div>

   </div>
</form>

</div>
