@extends("layouts._account_layout")
<?php
    $name = "";
    if($item->is_complaint == 1){
        $name =$item->parentCategory->name;
    }else{
        $name =$item->parentSuggest->name;
    }

    $Cat = array();
    foreach ($CategoryCircles as $CategoryCircle){
        array_push($Cat,$CategoryCircle->procedure_type.'_'.$CategoryCircle->circle);
    }
?>
@section("title","المستويات الإدارية لفئة  ". $name  )


@section("content")
    <div class="row" id="app">
        <div class="col-md-12">
            <br>
            <br>
            <div class="table-responsive" id="editLevelTable2">
            
                <table style="width:30% !important;max-width:80% !important;white-space:normal;" class="table table-hover table-striped">
                   
                    <tr>
                        <th style="max-width: 100px;word-break: normal; background:#ed6b75;color:#fff;">الفئة الرئيسية</th>
                        <td   style="word-break: normal;" id="maincat">{{$name}}</td>

               
                    </tr>
                    
                    <tbody>
                    <tr>
                        <th style="max-width: 100px;word-break: normal; background:#ed6b75;color:#fff;">الفئة الفرعية</th>
                        <td   style="word-break: normal;" id="subcat">{{$item->name}}</td>
                    </tr>
                  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            
         
           
            <div class="table-responsive" id="editLevelTable2">
                <table style="width:185% !important;max-width:185% !important;white-space:normal;" class="table table-hover table-striped">
                    <thead>
                    <tr>
                      
                        <th colspan="2" style="max-width: 100px;word-break: normal;">نوع الإجراء</th>
                        @foreach($circles as $circle)
                            <th style="max-width: 100px;word-break: normal;">{{$circle->name}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                   
                    @foreach($procedureTypes as $procedureType)
                        <tr>
                            @if($procedureType->id != 2 && $procedureType->id != 3)
                            <td colspan="2" style="word-break: normal;" id="{{$procedureType->id}}">{{$procedureType->name}}</td>
                            @else
                                <td  style="word-break: normal;">الجهات المختصة بمعالجة الشكوى</td>
                                <td  style="word-break: normal;" id="{{$procedureType->id}}">{{$procedureType->name}}</td>
                            @endif
                                @foreach($circles as $circle)
                                <td  style="text-align:center;max-width: 100px;word-break: normal;">
                                    <input  disabled="disabled" type="checkbox" name="category_circle[]" value="{{$procedureType->id.'_'.$circle->id}}" @if(in_array($procedureType->id.'_'.$circle->id,$Cat)) {{'checked'}} @endif>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const table = document.querySelector('table');

        let headerCell = null;

        for (let row of table.rows) {
            const firstCell = row.cells[0];

            if (headerCell === null || firstCell.innerText !== headerCell.innerText) {
                headerCell = firstCell;
            } else {
                headerCell.rowSpan++;
                headerCell.style = "vertical-align: middle";
                firstCell.remove();
            }
        }
    </script>
@endsection
