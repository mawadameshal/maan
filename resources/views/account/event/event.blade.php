@extends("layouts._account_layout")

@section("title", "إدارة الإجازات السنوية ")

@section("content")



<div class="row">
    <div class="col-md-8">
        <h4>يمكنك من خلال هذه الواجهة تعريف الإجازات السنوية الخاصة بالمركز</h4>
<br>

    </div>
    

</div>
     <br>

     <div class="row">
        <div class="col-sm-12">

                <form method="post" action="/account/events">
            @csrf

            <div class="form-group row">
                <div class="col-sm-2">
                    <label for="event_name" class="col-form-label">طبيعة الاجازة: </label>
                </div>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" value="" id="event_name" name="event_name">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                            <label for="start_date" class="col-form-label"> من تاريخ:</label>
                        </div>
                        <div class="col-sm-4">
                    <input type="date"  class="form-control " value="" id="start_date" name="start_date">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">
                            <label for="end_date" class="col-form-label"> الي تاريخ:</label>
                        </div>
                        <div class="col-sm-4">
                    <input type="date"  class="form-control " value="" id="end_date" name="end_date">
                </div>
            </div>

            <div class="form-group row" style="margin-right:400px;margin-bottom: 10px;">
                <div class="col-sm-5 col-md-offset-5">
                    <input type="submit" class="btn btn-success" value="إضافة"/>
                    <a href="events" class="btn btn-light">الغاء الامر</a>
                </div>
            </div>
        </form>
        </div>
    </div>
<br>

       
         

        

       <div class="form-group" style="margin-left: 10px;margin-bottom: 10px;">
        <button type="button"  style="width:110px;"  class="btn btn-primary adv-search-btnn"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            بحث متقدم
             </button>
</div>

<div class="row" style="margin-bottom: 10px;margin-top: 30px;margin-right: 0px;">
    
      

            <div class="col-sm-3 adv-searchh" style="margin-bottom: 10px;margin-top:26px;">
             
                <input type="text" class="form-control" value="{{old("event_name")}}" id="event_name" name="event_name" placeholder="طبيعة الإجازة">
     
            </div>
   
            <div class="col-sm-3 adv-searchh">
                        <label for="start_date" class="col-form-label"> من تاريخ</label>

                <input type="text" class="form-control datepicker" value="{{old("start_date")}}" id="start_date" name="start_date" placeholder="يوم / شهر / سنة">
            </div>
        
            <div class="col-sm-3 adv-searchh">
                        <label for="end_date" class="col-form-label"> الى تاريخ</label>

                <input type="text" class="form-control datepicker" value="{{old("end_date")}}" id="end_date" name="end_date" placeholder="يوم / شهر / سنة">
            </div>
     
      
        <button type="submit"  name="theaction"  value="search" style="width:70px;margin-left: 12px;margin-top:24px;" class="btn btn-primary adv-searchh">
                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>بحث
              </button>
              
              
    
</div>
<br>

<div class="mt-3"></div>
@if($items)
@if($items->count()>0)
    <div class="table-responsive">
        <table class="table table-hover table-striped">
        <thead>
            <hr>

            <tr>
                <th style="max-width: 30px;word-break: normal;"># </th>
                <th style="max-width: 100px;word-break: normal;">طبيعة الاجازة</th>
                <th style="max-width: 100px;word-break: normal;">من تاريخ</th>
                <th style="max-width: 100px;word-break: normal;">الى تاريخ </th>
                <th style="word-break: normal;">التفاصيل ذات العلاقةبالاجازة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $a)

            @if($a->id !=1)
                <tr>
                    <td style="word-break: normal;">{{$a->id}}</td>
                    <td style="word-break: normal;">{{$a->event_name }}</td>
                    <td style="word-break: normal;">{{$a->start_date}}</td>
                    <td style="max-width: 60px;word-break: normal;">{{$a->end_date }}</td>
                    <td>

                        <a class="btn btn-xs btn-primary" title="تعديل" href="/account/events/edit/{{$a->id}}/edit"><i
                            class="fa fa-edit"></i></a>

                            <a class="btn btn-xs Confirm btn-danger"
                            href="/account/events/delete/{{$a->id}}"><i
                                 class="fa fa-trash"></i></a>

                                 
                    </td>

                
                </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    </div>
    <br>
    <div style="float:left" >  {{$items->links()}} </div>
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
            <th style="max-width: 30px;word-break: normal;"># </th>
            <th style="max-width: 100px;word-break: normal;">طبيعة الاجازة</th>
            <th style="max-width: 100px;word-break: normal;">من تاريخ</th>
            <th style="max-width: 100px;word-break: normal;">الى تاريخ </th>
            <th style="word-break: normal;">التفاصيل ذات العلاقةبالاجازة</th>
        </tr>
        </thead>
    </table>
</div>
@endif



@endsection
@section('js')
<script>
    $('.adv-searchh').hide();
    $('.adv-search-btnn').click(function(){
        $('.adv-searchh').slideToggle("fast");
    });
</script>

           
    
@endsection