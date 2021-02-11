@extends("layouts._account_layout")

@section("title", "اضافة فئة اقتراح جديدة")
@section('css')
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
@endsection
@section("content")
<div class="row">
        <!--<div class="col-md-1"></div>-->
        <div class="col-md-6" id="app">
            <form action="/account/suggest" method="post">
                @csrf
                <input type="hidden" name="is_complaint" value="0">
                <div class="form-group">
                    <label>اسم فئة الاقتراح  </label>
                    <input type="text" class="form-control" placeholder="الاسم 50 حرف حد أقصى " name="name" value="{{old('name')}}">
                </div>

                <label>فئة الاقتراح الرئيسية</label>
                <div  class="form-group">
                    <select   class="form-control"  class="col-md-12"  name="main_suggest_id">
                        @foreach($mainCategories as $category)
                            <option value="{{$category->id}}" {{old('main_suggest_id') ==$category->id ? 'selected' : ''}}  >  {{$category->name}} </option>
                        @endforeach
                </div>

                <br>
                <div class="form-check">
                    <input class="form-check-input" name="citizen_show" type="hidden" value="0">
                    <input class="form-check-input" type="checkbox"  id="citizen_show" name="citizen_show" v-model="citizen_show">
                    <label class="form-check-label" for="citizen_show">
                        ظهور لغير المستفيد
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="benefic_show" type="hidden" value="0">
                    <input class="form-check-input" type="checkbox"  id="benefic_show" name="benefic_show" v-model="benefic_show">
                    <label class="form-check-label" for="citizen_show">

                        ظهور للمستفيد
                    </label>
                </div>
<br>
                <div  v-if="citizen_show">
                <div v-cloak class="form-group">
                    <label for="code">رسالة تأكيد الإرسال لغير المستفيد</label>
                <textarea class="form-control" id="details" name="citizen_msg">
                    {{old("citizen_msg")}}
                </textarea>
                </div>
                    <div class="form-group">
                        <label>اقصى مدة للرد على غير المستفيد</label>
                        <input type="number" class="form-control" placeholder="المدة" name="citizen_wait" value=" {{old("citizen_wait")}}">
                    </div>
                </div>
                <div v-if="benefic_show">
                    <div  v-cloak  class="form-group">
                        <label for="code" >رسالة تأكيد الإرسال للمستفيد</label>
                            <textarea class="form-control" id="details" name="benefic_msg">
                               {{old("benefic_msg")}}
                             </textarea>
                     </div>
                    <div class="form-group">
                        <label>اقصى مدة للرد على المستفيد</label>
                        <input type="number" class="form-control" placeholder="المدة" name="benefic_wait" value=" {{old("benefic_wait")}}">
                    </div>
                </div>
                  <br>
                <div class="form-actions">
                    <input type="submit" class="btn btn-success" value="اضافة">
                    <!--<a type="button" href="/account/category" class="btn default">إلغاء</a>-->
                    <a type="button" href="/account/category" class="btn btn-light">إلغاء</a>

                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                benefic_show: false,
                citizen_show: false,
            },
        });
    </script>
@endsection
