<!DOCTYPE html>
<!-- Created by pdf2htmlEX (https://github.com/coolwanglu/pdf2htmlex) -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8"/>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

<link rel="stylesheet" href="{{ asset('css/pdf') }}/base.min.css"/>
<link rel="stylesheet" href="{{ asset('css/pdf') }}/fancy.min.css"/>
<link rel="stylesheet" href="{{ asset('css/pdf') }}/main.css"/>

<script src="{{ asset('js/pdf') }}/compatibility.min.js"></script>
<script src="{{ asset('js/pdf') }}/theViewer.min.js"></script>
<script>
try{
theViewer.defaultViewer = new theViewer.Viewer({});
}catch(e){}
</script>
<title></title>
</head>
<body>
<div id="sidebar">
<div id="outline">
</div>
</div>
<div id="page-container">
<div id="pf1" class="pf w0 h0" data-page-no="1"><div class="pc pc1 w0 h0"><img class="bi x0 y0 w1 h1" alt="" src="{{ asset('css/pdf') }}/bg1.png"/><div class="c x1 y1 w0 h2"><div class="t m0 x2 h3 y2 ff1 fs0 fc0 sc0 ls0 ws0">D:\uploadedFiles\c8182e21e5c2dabbae8bed601c9d5bfd-fca5b584a19e5e\p1e1tica1i1uota5t7dmnn31jv4.doc<span class="_ _0"> </span>{{date('Y-m-d')}}</div></div>


<div class="t m0 x3 h4 y3 ff1 fs1 fc0 sc0 ls0 ws0">CUSTOMER COMPLAINT FORM                     </div>

<div class="t m0 x2 h5 y4 ff1 fs2 fc0 sc0 ls0 ws0">رقم
الطلب
 {{$item->id}}
</div>

<div class="t m0 x2 h5 y4 ff1 fs2 fc0 sc0 ls0 ws0">رقم

فئة الشكوى

@if($item->type=='1'){{$item->category->name}}@endif
</div>


<div class="t m0 x2 h5 y4 ff1 fs2 fc0 sc0 ls0 ws0">رقم

حالة المشروع

{{$item->project->project_status->name}}
</div>


<div class="t m0 x2 h5 y4 ff1 fs2 fc0 sc0 ls0 ws0">رقم

حالة
الطلب

{{$item->form_status->name}}

</div>


<div class="t m0 x2 h5 y4 ff1 fs2 fc0 sc0 ls0 ws0">رقم


نوع
الطلب

{{$item->form_type->name}}
</div>

<div class="t m0 x2 h5 y4 ff1 fs2 fc0 sc0 ls0 ws0">رقم

طريقة
الإستقبال

{{$item->sent_typee->name}}

</div>



<div class="t m0 x2 h5 y4 ff1 fs2 fc0 sc0 ls0 ws0">Received by {{$item->citizen->first_name." ".$item->citizen->father_name." ".$item->citizen->grandfather_name." ".$item->citizen->last_name}}
</div>


<div class="t m0 x2 h5 y5 ff1 fs2 fc0 sc0 ls0 ws0">تاريخ
الإرسال {{$item->datee}}</div>

<div class="t m0 x2 h5 y6 ff1 fs2 fc0 sc0 ls0 ws0">المشروع

{{ $item->project->name ." ".$item->project->code }}
</div>

<div class="t m0 x2 h5 y7 ff1 fs2 fc0 sc0 ls0 ws0">رقم الهوية  {{ $item->citizen->id_number }}</div>

<div class="t m0 x2 h5 y9 ff1 fs2 fc0 sc0 ls0 ws0">موضوع الطلب: </div>
<div class="t m0 x2 h5 ya ff1 fs2 fc0 sc0 ls0 ws0">{{$item->title}}</div>

<div class="t m0 x2 h5 y11 ff1 fs2 fc0 sc0 ls0 ws0">المحتوى:</div>

<div class="t m0 x2 h5 y18 ff1 fs2 fc0 sc0 ls0 ws0">{{$item->content}}</div>

</div><div class="pi" data-data='{"ctm":[1.000000,0.000000,0.000000,1.000000,0.000000,0.000000]}'></div></div>
</div>
<div class="loading-indicator">

</div>
</body>
</html>
