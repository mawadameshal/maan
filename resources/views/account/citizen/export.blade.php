<style>
    table, th, td {
        border: 1px solid black;
    }
</style>
<table style="padding: 10px;border: 1px solid black;border-collapse: collapse;" border="1">
    <thead>
    <tr>
        <td colspan="14" style="font-weight:bold;text-align: center;vertical-align:center;background-color: #d8d8ec;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">
            نظام مركز معاً لإدارة الاقتراحات والشكاوى- ملحق رقم (3): بيانات مستفيدي المشاريع المسجلة على النظام.
        </td>
    </tr>
    <tr>
        <th  style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">الاسم الأول</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">اسم الأب</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">اسم الجد</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">اسم العائلة</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">رقم الهوية</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">رقم التواصل (1)</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">رقم التواصل (2)</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">المحافظة</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">المنطقة</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">العنوان</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">اسم المشروع</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">رقم الطلب</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">عدد الاقتراحات</th>
        <th style="text-align: center;vertical-align:center;background-color: #b4c6e7;;height: 20px;padding: 10px;border: 1px solid black;border-collapse: collapse;">عدد الشكاوى</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)

        <?php
        $r = 0;
        $t= 0;
        if(!empty($item->forms) && !empty($item->forms->first())){
            foreach ($item->forms as $f){
                if($f->type == 2){
                    $r +=1;
                }elseif ($f->type == 1){
                    $t +=1;
                }
            }

        }
        ?>
        <tr>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->first_name}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->father_name}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->grandfather_name}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->last_name}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->id_number}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->mobile}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->mobile2}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->governorate}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->city}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->street}}</td>

            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->projects->first()->name}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$item->id}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$r}}</td>
            <td style="text-align: center;padding: 10px;border: 1px solid black;border-collapse: collapse;">{{$t}}</td>

        </tr>
    @endforeach

    </tbody>
</table>
