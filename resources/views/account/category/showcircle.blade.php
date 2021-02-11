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
            <div class="table-responsive" id="editLevelTable2">
                <table style="width:185% !important;max-width:185% !important;white-space:normal;" class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th style="max-width: 100px;word-break: normal;">الفئة الرئيسية</th>
                        <th style="max-width: 100px;word-break: normal;">الفئة الفرعية</th>
                        <th style="max-width: 100px;word-break: normal;">نوع الإجراء</th>
                        @foreach($circles as $circle)
                            <th style="max-width: 100px;word-break: normal;">{{$circle->name}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td  colspan="1" rowspan="5" scope="col" style="word-break: normal;" id="maincat">{{$name}}</td>
                        <td  colspan="1" rowspan="5" scope="col" style="word-break: normal;" id="subcat">{{$item->name}}</td>
                    </tr>
                    @foreach($procedureTypes as $procedureType)
                        <tr>
                            <td style="word-break: normal;" id="{{$procedureType->id}}">{{$procedureType->name}}</td>
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
