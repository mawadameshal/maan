@extends("layouts._account_layout")

@section("title", "عرض رسائل الزوار")
@section('content')
    <span id="mybody">
        <h4>هذه الواجهة خاصة للمدراء في النظام تتيح عرض رسائل الزوار</h4><br>

        <div class="row">
              <form>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="q" value="{{request('q')}}"
                               placeholder="كلمة البحث"/>
                    </div>
					<div class="col-sm-1" style="    width: 81px;margin-top: 11px"> بحث في تاريخ</div>
            <div class="col-sm-2">
                <input type="date" class="form-control" name="datee" value="{{request('datee')}}"
                       placeholder="تاريخ الرسالة"/>
            </div>
                    <div class="col-sm-4">
                        <input type="submit" value="بحث" class="btn btn-primary"/>
                    </div>
             </form>
        </div>
        <div class="mt-3"></div>
    <br/>
        @if($items->count()>0)
<div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="8%"></th>
                        <th width="14%">المرسل</th>
						<th width="45%">المحتوى</th>
						<th width="15%">البريد</th>
						<th width="11%">الهاتف</th>
						<th width="16%">التاريخ</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $a)
                        <tr>
                        <td>{{$a->id}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->title}}</td>
						<td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" >{{$a->content}}</td>
						<td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->mail}}</td>
						<td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" >{{$a->mopile}}</td>
						<td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$a->datee}}</td>
                        <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><a target="_blank" title="عرض" class="btn btn-xs btn-primary" href="/account/message/{{$a->id}}">
                                <i class="glyphicon glyphicon-eye-open"></i>
								<a class="btn btn-xs Confirm btn-danger" title="حذف" href="/account/message/delete/{{$a->id}}"><i
                                            class="fa fa-trash"></i></a>
                                </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                {{$items->links()}}
            </table>
        </div>
    </span>

    @else
        <br><br>
        <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>
    @endif
@endsection
