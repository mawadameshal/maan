@extends("layouts._account_layout")

@section("title", "حسابات الموظفين ضمن المشروع  $item->name $item->code ")

@section("content")
        <br>

        <div class="form-group" style="margin-left: 10px;margin-bottom: 10px;">
            <button type="button"  style="width:110px;"  class="btn btn-primary adv-search-btnn">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                بحث متقدم
            </button>
        </div>
        <div class="row">

        <div class="col-md-12">
              <form class="form-inline">

                  <div class="form-group adv-searchh" style="margin-left: 10px; margin-bottom: 10px;">
                      <select name="account_id" class="form-control" style="width: 270px;">
                          <option value="" selected>اسم المستخدم </option>
                          @foreach($accounts as $account)
                              <option
                                  @if(request('account_id')===''.$account->id)selected
                                  @endif
                                  value="{{$account->full_name}}">{{$account->full_name}}</option>
                          @endforeach
                      </select>
                   </div>
                  <div class="form-group adv-searchh" style="margin-left: 10px; margin-bottom: 10px;">
               		<input type="email" class="form-control" name="email" id="email" value="{{old('email')}}"
                       placeholder="البريد الالكتروني" style="width: 230px;"/>
                 </div>
                  <div class="form-group adv-searchh" style="margin-left: 10px; margin-bottom: 10px;">
               		<input type="text" class="form-control" name="mobile" value="{{old('mobile')}}"
                       placeholder="رقم التواصل" style="width: 230px;"/>
                 </div>
                  <div class="form-group adv-searchh" style="margin-left: 10px; margin-bottom: 10px;">
	                <select class="form-control" id="circles" name="circles" value="{{old('circles')}}" style="width: 230px;">
                        <option value="">المستويات الإدارية</option>
                        @foreach($circles as $circle)
                            <option value="{{$circle->id}}"
                                    @if(request('circles')== $circle->id)selected @endif>{{$circle->name}}</option>
                        @endforeach
	                </select>
	            </div>
            	<button type="submit"  name="theaction"  value="search" class="btn btn-primary adv-searchh"  style="margin-top: -10px;">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>   بحث
            	</button>

             </form>
             </div>
        </div>

        <br>
        <br>
    <div class="mt-3"></div>
        @if($items)
            @if($items->count()>0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">#</th>
                                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">اسم المستخدم</th>
                                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">المستوى الاداري</th>
                                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رقم التواصل</th>
                                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">البريد الالكتروني</th>
                                {{--
                                <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">نوع الحساب</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $a)
                        @if($rate)
                            @if($a->account_projects->where('project_id','=',$item->id)->first()->rate==$rate)
                                <tr>
                                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$loop->iteration}}</td>
                                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->full_name}}</td>
                                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->circle->name}}</td>
                                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" class="text-center" dir="ltr">{{$a->mobile}}</td>
                                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->user->email}}</td>
                                    {{-- <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-align: center !important;">
                                        {{$a->account_projects->where('project_id','=',$item->id)->first()->account_rate->name}}
                                        </td> --}}

                                </tr>
                            @endif
                        @else
                            <tr>
                                <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$loop->iteration}}</td>
                                <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->full_name}}</td>
                                <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->circle->name}}</td>
                                <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" class="text-center" dir="ltr">{{$a->mobile}}</td>
                                <td style="text-align:center !important;max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->user->email}}</td>
                                {{-- <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-align:center !important;">
                                    {{$a->account_projects->where('project_id','=',$item->id)->first()->account_rate->name}}
                                </td> --}}
                            </tr>
                        @endif
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
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">#</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">اسم المستخدم</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">المستوى الاداري</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">رقم التواصل</th>
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">البريد الالكتروني</th>
                        {{--
                        <th style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">نوع الحساب</th> --}}
                    </tr>
                    </thead>
                </table>
            </div>
        @endif

        <br> <br><br>
    <div class="form-group row">
        <div class="col-sm-2 col-md-offset-10">
            <a href="/account/project" class="btn btn-success">
                <span class="glyphicon glyphicon-arrow-left"></span>
                رجوع للخلف </a>
        </div>
    </div>
@endsection
@section("js")
        <script>
            $('.adv-searchh').hide();
            $('.adv-search-btnn').click(function(){
                $('.adv-searchh').slideToggle("fast");
            });
        </script>
@endsection
