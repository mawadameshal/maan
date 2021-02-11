<style>
    table, th, td {
        border: 1px solid black;
    }
</style>
<table style="padding: 10px;border: 1px solid black;border-collapse: collapse;" border="1">
    <thead>
    <tr>
        <td colspan="9" style="font-weight:bold;text-align: center;vertical-align:center;background-color: #d8d8ec;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">
            نظام مركز معاً لإدارة الاقتراحات والشكاوى- ملحق رقم (6): بيانات مشاريع المركز المسجلة على النظام.
        </td>
    </tr>
    <tr>
        <th  style="font-weight:bold;text-align: center;vertical-align:center;background-color: #b4c6e7;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">#</th>
        <th style="font-weight:bold;text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">رمز المشروع</th>
        <th style="font-weight:bold;text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">اسم المشروع باللغة العربية</th>
        <th style="font-weight:bold;text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">منسق المشروع</th>
        <th style="font-weight:bold;text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">ممثل قسم  المتابعة والتقييم</th>
        <th style="font-weight:bold;text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">مدير البرنامج</th>
        <th style="font-weight:bold;text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">تاريخ بداية المشروع</th>
        <th style="font-weight:bold;text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">تاريخ نهاية المشروع</th>
        <th style="font-weight:bold;text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">حالة المشروع</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)

        <tr>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->id}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->code}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->name}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->coordinator}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->supervisor}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->manager}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->start_date}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->end_date}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">@if($item->end_date < now() )  منتهي@elseمستمر@endif</td>

        </tr>
    @endforeach

    </tbody>
</table>
