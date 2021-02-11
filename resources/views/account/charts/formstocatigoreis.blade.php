@extends("layouts._account_layout")

@section("title", "توزيع النماذج حسب الفئات ")
@section('css')
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }

    </style>
@endsection
@section('content')
    <div class="form-group row">
        <form>
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
                <select name="sent_type" class="form-control">
                    <option value="">جميع طرق الإرسال</option>
                    @foreach($sent_typee as $sent_type)
                        <option {{request('sent_type')==$sent_type->id?"selected":""}} value="{{$sent_type->id}}">{{$sent_type->name}}</option>
                    @endforeach
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
            </div>
        </form>
    </div>
    <div id="chartdiv"></div>
@endsection
@section('js')
    <!-- Resources -->
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

    <!-- Chart code -->
    <script>
        // Themes begin
        am4core.useTheme(am4themes_dataviz);
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv", am4charts.PieChart);

        // Add data
        var mydata=JSON.parse('{!! $categories !!}');
        mydata = $.grep( mydata, function(e){
            return e.form_count != 0;
        });
        chart.data =mydata;

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "form_count";
        pieSeries.dataFields.category = "name";
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;

        // This creates initial animation
        pieSeries.hiddenState.properties.opacity = 1;
        pieSeries.hiddenState.properties.endAngle = -90;
        pieSeries.hiddenState.properties.startAngle = -90;

        // Enable export
        chart.exporting.menu = new am4core.ExportMenu();
    </script>

@endsection
