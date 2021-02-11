@extends("layouts._account_layout")

@section("title", "إدارة إعدادات الموقع")
@section("title2")
<div class="row">
    <div style="margin-left: 50px;float:left;margin-top:-20px">
<i class="fa fa-download" aria-hidden="true"></i>تحميل نسخة احتياطية من قاعدة البيانات
</div>
</div>

@endsection


@section("content")
    <div class="row">
        <div class="col-md-6">
            <form action="/account/company/{{$item['id']}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label>عنوان النافذة</label>
                    <input type="text" class="form-control" placeholder="عنوان النافذة" name="title" value="{{$item['title']}}">
                </div>
                <div class="form-group">
                    <label>عبارة الترحيب الرئيسية</label>
                    <input type="text" class="form-control" placeholder="عبارة الترحيب الرئيسية" name="welcom_word" value="{{$item['welcom_word']}}">
                </div>
                <div class="form-group">
                    <label>نص الترحيب الرئيسي</label>
                    <textarea type="text" class="form-control" placeholder="نص الترحيب الرئيسي" name="welcom_clouse" >{{$item['welcom_clouse']}}</textarea>
                </div>
                <div class="form-group">
                    <label>نص تقديم الشكوى</label>
                    <textarea type="text" class="form-control" placeholder="نص تقديم الشكوى" name="add_compline_clouse" >{{$item['add_compline_clouse']}}</textarea>
                </div>
                {{-- <div class="form-group">
                    <label>نص تقديم الشكر</label>
                    <textarea type="text" class="form-control" placeholder="نص تقديم الشكر" name="add_propusel_clouse" >{{$item['add_thanks_clouse']}}</textarea>
                </div> --}}
                <div class="form-group">
                    <label>نص متابعة الاقتراحات</label>
                    <textarea type="text" class="form-control" placeholder="نص تقديم الاقتراح" name="add_thanks_clouse" >{{$item['add_propusel_clouse']}}</textarea>
                </div>
                <div class="form-group">
                    <label>متابعة الاقتراحات والشكاوى</label>
                    <textarea type="text" class="form-control" placeholder="نص متابعة الشكوى" name="follw_compline_clouse" >{{$item['follw_compline_clouse']}}</textarea>
                </div>
                <div class="form-group">
                    <label>نص من نحن</label>
                    <textarea type="text" class="form-control" rows="8" placeholder="نص من نحن" name="how_we" >{{$item['how_we']}}</textarea>
                </div>
                <div class="form-group">
                    <label>رقم الهاتف المحمول</label>
                    <input type="text" class="form-control" placeholder="رقم الهاتف المحمول" name="mopile" value="{{$item['mopile']}}">
                </div>
                <div class="form-group">
                    <label>رقم التواصل</label>
                    <input type="text" class="form-control" placeholder="رقم التواصل" name="phone" value="{{$item['phone']}}">
                </div>
                <div class="form-group">
                    <label>الرقم المجاني</label>
                    <input type="text" class="form-control" placeholder="الرقم المجاني" name="free_number" value="{{$item['free_number']}}">
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="text" class="form-control" placeholder="البريد الإلكتروني" name="mail" value="{{$item['mail']}}">
                </div>
                <div class="form-group">
                    <label>العنوان</label>
                    <input type="text" class="form-control" placeholder="العنوان" name="address" value="{{$item['address']}}">
                </div>
                <div class="form-group">
                    <label>الفاكس</label>
                    <input type="text" class="form-control" placeholder="الفاكس" name="fax" value="{{$item['fax']}}">
                </div>

                <div class="form-group">
                    <label>رسالة تأكيد إرسال الاقتراح</label>
                    <input type="text" class="form-control" placeholder="" name="fax" value="">
                </div>
                <div class="form-group">
                    <label>أقصى مدة للرد على الاقتراح</label>
                    <input type="text" class="form-control" placeholder="" name="fax" value="">
                </div>
                <div class="form-group">
                    <label>رسالة تأكيد إرسال الشكوى</label>
                    <input type="text" class="form-control" placeholder="" name="fax" value="">
                </div>
                <div class="form-group">
                    <label>أقصى مدة للرد على الشكوى</label>
                    <input type="text" class="form-control" placeholder="" name="fax" value="">
                </div>

<hr>
                <div class="form-group row">
                    <div class="col-md-12">
                        <a class="btn btn-primary" style="background-color: #00b0f0;border-color: #00b0f0" target="_blank" href="{{url('uploads/'.$item->steps_file)}}">ملف الإرشادات العامة الحالي</a>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>يمكنك تحديث ملف الإرشادات العامة بالضغط أدناه:</label>
                        <br>
                        <br>
                        <input type="file"  name="file_home">
                    </div>
                </div>
                <br>
                <div class="form-actions">
                    <input type="submit" class="btn btn-success" value="تعديل">
                    <a type="button" href="/account" class="btn btn-light">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection
