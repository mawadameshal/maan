@extends("layouts._account_layout")

@section("title", " عرض إشعارات النظام")
@section("content")
    <br>
    <br>
    <div class="form-group row filter-div">
        <div class="col-sm-12">
            <form>
                <div class="row">
{{--                    <div class="col-sm-4">--}}
{{--                        <input type="text" class="form-control" name="q" value="{{request('q')}}"--}}
{{--                               placeholder="ابحث في عنوان الاشعار"/>--}}
{{--                    </div>--}}

                    <div class="col-sm-4">
                        <button type="button" style="width:110px;" class="btn btn-primary adv-search-btn">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        بحث متقدم
                        </button>
                     </div>
                  </div>
                <br>
                <div class="row">
                    <div class="col-sm-3 adv-search">
                        <select name="category_name" class="form-control">
                            <option value="" >نوع الإشعار</option>
                            <option value="0" >1</option>
                            <option value="1">2</option>
                        </select>
                    </div>
                    <div class="col-sm-3 adv-search">
                        <select name="category_name" class="form-control">
                            <option value="" >نوع حساب مرسل الإشعار</option>
                            <option value="0" >1</option>
                            <option value="1">2</option>
                        </select>
                    </div>
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
                        <select name="category_name" class="form-control">
                            <option value="" >حالة الإشعار</option>
                            <option value="0" >1</option>
                            <option value="1">2</option>
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-3 adv-search">
                        <label for="from_date">تاريخ محدد:</label>
                        <input type="text" class="form-control datepicker" name="datee" value="{{request('datee')}}"
                               placeholder="يوم / شهر / سنة"/>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <label for="from_date">من تاريخ: </label>
                        <input type="text" class="form-control datepicker" name="from_date" value="{{request('from_date')}}"
                               placeholder="يوم / شهر / سنة"/>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <label for="to_date">إلى تاريخ:</label>
                        <input type="text" class="form-control datepicker" name="to_date" value="{{request('to_date')}}"
                               placeholder="يوم / شهر / سنة"/>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <button type="submit" name="theaction" title="بحث" style="margin-top: 23px;width:110px;" value="search"
                                class="btn btn-primary">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            بحث
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="mt-3"></div>
    @if($items)
    @if($items->count()>0)
        <br/>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th style="overflow: hidden;text-overflow: ellipsis;">#</th>
                        <th style="overflow: hidden;text-overflow: ellipsis;">نوع الإشعار</th>
                        <th style="overflow: hidden;text-overflow: ellipsis;">نوع حساب مرسل الإشعار</th>
                        <th style="overflow: hidden;text-overflow: ellipsis;">اسم مرسل الإشعار</th>
                        <th style="overflow: hidden;text-overflow: ellipsis;">اسم المشروع</th>
                        <th style="overflow: hidden;text-overflow: ellipsis;">تاريخ الإشعار</th>
                        <th style="text-align:center;overflow: hidden;text-overflow: ellipsis;">معاينة</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($items as $a)

                    @php


                        $array = explode('/',  $a->link);

                        $id = $array[ count($array) - 1 ];

                        $form = App\Form::find($id);

                    @endphp

                    <tr>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->id}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->title}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                            {{$a->type}}
                            @if($a->type == "مواطن" || $a->type == "من المواطن")
                                  (
                                {{ ($form and $form->citizen) ? $form->citizen->full_name  : ''}}
                                 )
                            @endif
                        </td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{ ($form and $form->account) ? $form->account->full_name .' ( '.$form->account->circle->name.' ) ' : '' }}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{ ($form and $form->project) ? $form->project->name  : '' }}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->created_at }}</td>
                        <td style="text-align:center;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                            <a class="btn btn-primary" title="انتقل" href="{{$a->link}}">
                                <i class="fa fa-eye"></i></a>
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
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th style="overflow: hidden;text-overflow: ellipsis;">#</th>
                <th style="overflow: hidden;text-overflow: ellipsis;">نوع الإشعار</th>
                <th style="overflow: hidden;text-overflow: ellipsis;">نوع حساب مرسل الإشعار</th>
                <th style="overflow: hidden;text-overflow: ellipsis;">اسم مرسل الإشعار</th>
                <th style="overflow: hidden;text-overflow: ellipsis;">اسم المشروع</th>
                <th style="overflow: hidden;text-overflow: ellipsis;">تاريخ الإشعار</th>
                <th style="text-align:center;overflow: hidden;text-overflow: ellipsis;">معاينة</th>
            </tr>
            </thead>
        </table>
    @endif
@endsection

@section("js")
    <script>
        $(function () {
            $('.adv-search').hide();
            $('.adv-search-btn').click(function(){
                $('.adv-search').slideToggle("fast");
            });

        });
    </script>
@endsection




