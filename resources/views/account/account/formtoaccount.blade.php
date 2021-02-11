@extends("layouts._account_layout")

@section("title", " النماذج التي رد عليها الموظف $item->full_name  ")


@section("content")
    <div class="form-group row">
        <form>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="q" value="{{request('q')}}"
                       placeholder="ابحث في عنوان أو رقم النموذج أو اسم وهوية المواطن أو المشروع"/>
            </div>
            <div class="col-sm-12"><br></div>
            <div class="col-sm-1" style="    width: 81px;margin-top: 11px"> طريقة الفرز</div>
            <div class="col-sm-2">
                <select name="read" class="form-control">
                    <option value="">المقروءة والغير مقروءة</option>
                    <option {{request('read')=="1"?"selected":""}} value="1">المقروءة</option>
                    <option {{request('read')=="2"?"selected":""}} value="2">الغير مقروءة</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select name="status" class="form-control">
                    <option value="">جميع حالات الطلب</option>
                    @foreach($form_status as $fstatus)
                        <option {{request('status')==$fstatus->id?"selected":""}} value="{{$fstatus->id}}">{{$fstatus->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <select name="type" class="form-control">
                    <option value="">جميع أنواع الطلب</option>
                    @foreach($form_type as $ftype)
                        <option {{request('type')==$ftype->id?"selected":""}} value="{{$ftype->id}}">{{$ftype->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <select name="project_id" class="form-control">
                    <option value="" selected>المستفيدين وغير المستفيدين</option>
                    <option value="-1" @if(request('project_id')==='-1')selected
                            @endif>جميع المشاريع</option>
                    @foreach($projects as $project)
                        <option
                                @if(request('project_id')===''.$project->id)selected
                                @endif
                                value="{{$project->id}}">{{$project->code." ".$project->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <select name="sent_type" class="form-control">
                    <option value="">جميع طرق الإستقبال</option>
                    <option {{request('sent_type')=="1"?"selected":""}} value="1">عبر الإنترنت</option>
                    <option {{request('sent_type')=="2"?"selected":""}} value="2">زيارة مقر الشركة</option>
                    <option {{request('sent_type')=="3"?"selected":""}} value="3">عبر الهاتف</option>
                    <option {{request('sent_type')=="4"?"selected":""}} value="4">زيارة ميدانية</option>
                </select>
            </div>
            <div class="col-sm-12"><br></div>
            <div class="col-sm-1"  style="    width: 81px;margin-top: 11px">طريقة الفرز</div>
            <div class="col-sm-2">
                <select name="evaluate" class="form-control">

                    <option value="">المقيمة والغير مقيمة</option>
                    <option {{request('evaluate')=="1"?"selected":""}} value="1">المقيمة</option>
                    <option {{request('evaluate')=="2"?"selected":""}} value="2">المقيمة بنعم</option>
                    <option {{request('evaluate')=="3"?"selected":""}} value="3">المقيمة بلا</option>
                    <option {{request('evaluate')=="4"?"selected":""}} value="4">الغير مقيمة</option>
                </select>
            </div>
            @if($type==1)
     <div class="col-sm-2">
    <select name="category_id" class="form-control">
                    <option value="" selected>جميع الفئات</option>
                    @foreach($categories as $category)
        @if($category->id != 1)
                        <option
                                @if(request('category_id')===''.$category->id)selected
                                @endif
                                value="{{$category->id}}">{{$category->name}}</option>
        @endif
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-sm-12"><br></div>
            <div class="col-sm-1" style="    width: 81px;margin-top: 11px"> تاريخ محدد</div>
            <div class="col-sm-2">
                <input type="date" class="form-control" name="datee" value="{{request('datee')}}"
                       placeholder="تاريخ النموذج"/>
            </div>

            <div class="col-sm-1" style="    width: 20px;margin-top: 11px"><label>من</label></div>
            <div class="col-sm-2">
                <input type="date" class="form-control" name="from_date" value="{{request('from_date')}}"
                       placeholder="من تاريخ"/>
            </div>
            <div class="col-sm-1" style="    width: 20px;margin-top: 11px"> إلى</div>
            <div class="col-sm-2">
                <input type="date" class="form-control" name="to_date" value="{{request('to_date')}}"
                       placeholder="إلى تاريخ"/>
            </div>
            <div class="col-sm-4">
                <button type="submit" name="theaction" title ="بحث" style="width:70px;" value="search" class="btn btn-primary "/>
                بحث
                </button>
                <button type="submit" target="_blank" name="theaction" title ="طباعة" style="width:70px;" value="print" class="btn btn-primary "/>
                <i class="glyphicon glyphicon-print icon-white"></i>
                </button>
                <button type="submit" target="_blank" name="theaction" title ="تصدير إكسل" style="width:70px;" value="excel" class="btn btn-primary "/>
                تصدير
                </button>
            </div>
        </form>
    </div>
    @if($items->count()>0)
<div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">#</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">اسم المواطن</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">هوية مواطن</th>
                @if($type!=2 && $type!=3)<th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">فئة النموذج</th>@endif
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">موضوع النموذج</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">المشروع</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">حالة المشروع</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">التاريخ</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">الحالة</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">النوع</th>
                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">الإستقبال</th>
                <th style="white-space:normal;"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $a)
                @if(Auth::user()->account->projects->contains($a->project->id))
                    <tr>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->id}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->citizen->first_name." ".$a->citizen->father_name." ".$a->citizen->grandfather_name." ".$a->citizen->last_name}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->citizen->id_number}}</td>
                        @if($a->category_id)
                            <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{\App\Category::find($a->category_id)->name}}</td>
                        @else
                            <td></td>
                        @endif
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->title}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->project->name}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->project->project_status->name}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->datee}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->form_status->name}}</td>

                        <td style="white-space:nowrap;">{{$a->form_type->name}}</td>
                        <td style="white-space:nowrap;">{{$a->sent_typee->name}}</td>
                        <td><a target="_blank" class="btn btn-xs btn-primary" title="عرض" href="/citizen/form/show/{{$a->citizen->id_number}}/{{$a->id}}"><i class="glyphicon glyphicon-eye-open"></i></a>

                        </td>


                    </tr>
                @endif
            @endforeach
            </tbody>
            {{$items->links()}}
        </table>
</div>
    @else
        <br><br>
        <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
    @endif
    <div class="form-group row">
        <div class="col-sm-5 col-md-offset-1">
            <a href="/account/account"  class="btn btn-success">الغاء الامر</a>
        </div>
    </div>
@endsection
