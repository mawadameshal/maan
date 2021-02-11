@extends("layouts._account_layout")

@section("title", "توزيع المواطنين حسب المشاريع ")
@section('css')
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }

    </style>
@endsection
@section('content')
    <div class=" form-group row">
        <form>
            <div class="col-sm-2">
                <select name="accept" class="form-control">
                    <option value="">المرشح والغير مرشح</option>
                    <option {{request('accept')=="0"?"selected":""}} value="0">المرشحين</option>
                    <option {{request('accept')=="1"?"selected":""}} value="1">غير المرشحين</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select name="governorate" class="form-control">
                    <option value="">جميع المحافظات</option>
                    <option value="الشمال" {{request('governorate')=='الشمال'?"selected":""}}>الشمال</option>
                    <option value="غزة" {{request('governorate')=='غزة'?"selected":""}}>غزة</option>
                    <option value="الوسطى" {{request('governorate')=='الوسطى'?"selected":""}}>الوسطى</option>
                    <option value="خانيونس" {{request('governorate')=='خانيونس'?"selected":""}}>خانيونس</option>
                    <option value="رفح" {{request('governorate')=='رفح'?"selected":""}}>رفح</option>
                </select>
            </div>
            <div class="col-sm-12"><br></div>
            <div class="col-sm-4">
                <button type="submit" name="theaction" title ="بحث" style="width:70px;" value="search" class="btn btn-primary "/>
                بحث

            </div>
        </form>
        <div class="col-sm-12"><hr></div>
    </div>
    <div id="chartdiv"></div>
@endsection
@section('js')
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
        var chart = am4core.create("chartdiv", am4charts.XYChart);

        // Add data
        var mydata=JSON.parse('{!! $projects !!}');
        mydata = $.grep( mydata, function(e){
            return e.citizens_count != 0;
        });
        chart.data = mydata;
        /*[{
            "name": "USA",
            "citizens_count": 2025
        }, {
            "name": "China",
            "citizens_count": 1882
        },];*/

        // Create axes

        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());

        categoryAxis.dataFields.category = "name";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;
        categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
            if (target.dataItem && target.dataItem.index & 2 == 2) {
                return dy + 25;
            }
            return dy;
        });

        var  valueAxis= chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "citizens_count";
        series.dataFields.categoryX = "name";
        series.name = "Citizens_count";
        series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
        series.columns.template.fillOpacity = .8;

        var columnTemplate = series.columns.template;
        columnTemplate.strokeWidth = 2;
        columnTemplate.strokeOpacity = 1;

        // Enable export
        chart.exporting.menu = new am4core.ExportMenu();
    </script>
@endsection
