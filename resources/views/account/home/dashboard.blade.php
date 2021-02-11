@extends("layouts._account_layout")
<?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>

@section("title", "الصفحة الرئيسية :  $item->full_name")

@section("content")
<div class="row">
                <div class="col-md-9"><h4>هذه الواجهة مخصصة لعرض المشاريع التي تقع ضمن مسؤوليتك.</h4> </div>

        </div>
        <br>
    <div class="profile">
                    <div class="row">
                       <!-- <div class="col-md-3">
                            <ul class="list-unstyled profile-nav">
                                <li>
                                    <?php
                                    if (!Auth::guest()) {
                                        Auth::user()->account->image;
                                        if (Auth::user()->account->image == null) {
                                            $image = "http://placehold.it/300/300";
                                        } else {
                                            if (file_exists(public_path() . '/images/' . Auth::user()->account->id . '/' . Auth::user()->account->image) && Auth::user()->account->image != null)
                                                $image = asset('/images/' . Auth::user()->account->id . '/' . Auth::user()->account->image);
                                            else
                                                $image = "http://placehold.it/300/300";
                                        }
                                    } else
                                        $image = "http://placehold.it/300/300";
                                    ?>

                            </ul>
                        </div>-->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 profile-info">
                                <h4 class="font-green sbold uppercase">معلومات الحساب الأساسية</h4>
                                <div class="table-responsive">
	                                <table class="table table-striped table-bordered table-advance table-hover" style="width: 40%;">
					  <tr>
					    <th style="width: 30%;">الاسم:</th>
					    <td style="width: 100px;">{{ Auth::user()->account->full_name }}</th>

					  </tr>
					  <tr>
					    <th style="width: 30%;">المستوى الإداري:</th>
					    <td style="width: 100px;">قسم المتابعة والتقييم</td>
					  </tr>
					  <tr>
					    <th style="width: 30%;;">الايميل:</th>
					    <td style="width: 100px;"><a href="javascript:;"> {{auth()->user()->email}} </a></td>

					  </tr>
					  <tr>
					    <th style="width: 30%;">رقم الجوال:</th>
					    <td style="width: 100px;">0599000122233</td>

					  </tr>

				</table>
				</div>
				<br>
				<h4 class="font-green sbold uppercase">ويمكنك رؤية المشاريع التي تعمل بها من خلال الجدول أدناه:</h4>
                          <br>  <!--
                                    <h2 class="font-green sbold uppercase">
                                        {{ Auth::user()->account->full_name }}</h2>
                                    <p>
                                        يمكن من خلال لوحة التحكم الخاصة بك ، تنفيذ المهام الخاصة بك في المشاريع التي
                                        تعمل بها، </p>
                                    يمكنك رؤية المشاريع التي تعمل بها في الجدول أدناه.

                                        <br><br>
                                            <div class="col-sm-3" style="padding-right: 0px;">
                        <button type="button"  style="width:110px;"  class="btn btn-primary adv-search-btnn"/>
                      معلومات الحساب
                        </button>
                    </div>
                    <br><br>

                                    <p class="adv-searchh">
                                        <a href="javascript:;"> {{auth()->user()->email}} </a>
                                    </p>

                                    <ul class="list-inline">
                                        <li>

                                             <span class="username username-hide-on-mobile adv-searchh">
                            <?php $test = Auth::user()->account->account_projects->where('project_id', "!=", "1")->groupBy('rate')?>

                             {{ Auth::user()->account->full_name }} </span>  </li>

                                          {{auth()->user()->account->job_name}} </li>
                                        <li class="adv-searchh">

                                             {{auth()->user()->account->circle->name}} </li>
                                    </ul>
                                </div>
                            </div>-->
                                <!--end col-mdclass="adv-searchh-8-->


                                <!--end row-->
                                @if($items->count()>0)

                                                <div class="portlet-body">
                                                    <div class="table-responsive">

                                                    <table class="table table-striped table-advance table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th>
                                                               #
                                                            </th>
                                                            <th>
                                                              رمز المشروع
                                                            </th>
                                                            <th>
                                                               اسم المشروع باللغة العربية
                                                            </th>
                                                            <th class="hidden-xs">
                                                              منسق المشروع
                                                            </th>


                                                            <th class="hidden-xs">
                                                                ممثل قسم المتابعة والتقييم
                                                            </th>
                                                            <th class="hidden-xs">
                                                                مدير البرنامج
                                                            </th>
                                                            <th class="hidden-xs">
                                                               حالة المشروع
                                                            </th>
                                                            <th>
                                                                التفاصيل ذات العلاقة بالحساب
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($items as $a)
                                                            <tr>
                                                                <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                                                                     {{$loop->iteration}}
                                                                </td>
                                                                <td class="hidden-xs"> {{$a->code}} </td>

                                                                <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                                                                    <a href="/account/project/{{$a->id}}"> {{$a->name}} </a>
                                                                </td>
                                                                <td class="hidden-xs"> @if($a->account_projects->where('rate','=','3')->first())
                                                                    {{$a->account_projects->where('rate','=','3')->first()->account->full_name}}
                                                                @endif </td>

                                                                <td class="hidden-xs"> @if($a->account_projects->where('rate','=','2')->first())<!-- المشرف مسبقا , ممثل المتابعة والتقييم حاليا  -->
                                                                        {{$a->account_projects->where('rate','=','2')->first()->account->full_name}}
                                                                    @endif </td>
                                                                    <td class="hidden-xs"> @if($a->account_projects->where('rate','=','1')->first())
                                                                        {{$a->account_projects->where('rate','=','1')->first()->account->full_name}}
                                                                    @endif </td>
                                                                    <td style="max-width: 100px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                                                                        @if($a->end_date < now() )  منتهي@else  غيرمنتهي@endif
                                                                   </td>

                                                                <td>
                                                                    <a class="btn btn-sm"
                                                                    href="/account/project/forminproject/{{$a->id}}" style="border-color: unset;
                                                                        color: #ffffff;
                                                                        border: none;
                                                                        background: #32c5d2!important;"> الاقتراحات والشكاوى </a>

                                                                    @if($a->id != 1)
                                                                    <a class="btn btn-sm"
                                                                    href="/account/project/citizeninproject/{{$a->id}}" style="border-color: unset;
                                                                         color: #ffffff;
                                                                         border: none;
                                                                         background: #32c5d2!important;"> المستفيدين </a>
                                                                            @endif


                                                                    {{-- <a class="btn btn-sm"
                                                                       href="/account/project/{{$a->id}}" style="border-color: unset;
                                                                            color: #ffffff;
                                                                            border: none;
                                                                            background: #32c5d2!important;"> عرض </a> --}}
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                    </div>
                                                    <br>
                                                    <div style="float:left">  {{$items->links()}}
                                                    </div>
                                                    <br> <br><br>
                                                </div>
                                            </div>
                                            <!--tab-pane-->

                            @else
                                <br><br>
                                <div class="alert alert-warning">أنت غير عامل في أي من المشاريع</div>
                            @endif
                        </div>

                        <!--end tab-pane-->
                    </div>
                </div>


@endsection
@section('js')
<script>
    $('.adv-searchh').hide();
    $('.adv-search-btnn').click(function(){
        $('.adv-searchh').slideToggle("fast");
    });
</script>
@endsection
