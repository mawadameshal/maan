@extends("layouts._account_layout")

@section("title", "   صلاحيات حساب $item->full_name")


@section("content")
@if(Auth::user()->account->links->contains(\App\Link::where('title','=','تعديل حسابات')->first()->id))
    <form method="post" action="/account/account/permission-post/{{$item->id}}">
        @csrf
        <div class="form-group row">

            <div class="col-sm-5">
                <label ><input style="-ms-transform: scale(1.1);  -moz-transform: scale(1.1);  -webkit-transform: scale(1.1);   -o-transform: scale(1.1);   padding: 10px;" type="checkbox" id="#checkAll" /><b style=" padding-right: 10px; font-size: 107%;  display: inline;"> تحيد الكل</b></label>

            <?php
                $links = \DB::table("links")->where("parent_id",0)->get();

                ?>

                    <ul class="list-unstyled">
                    @foreach($links as $link)
                        <li>
						@if($item->type!=1)
						  @if(($link->title !="الحسابات" && $link->title !="اعدادات الموقع"  ))
                            <label>
							<input {{$item->links->contains($link->id)?'checked':''}} type="checkbox"
                                          name="permission[]" value="{{$link->id}}" /> <b>{{$link->title}}</b></label>
				          <?php
                            $sublinks = \DB::table("links")->where("parent_id",$link->id)->get();
                            ?>
                            <ul class="list-unstyled">
                                @foreach($sublinks as $sublink)
                                    <li>
                                        <label><input {{$item->links->contains($sublink->id)?'checked':''}}
                                                      type="checkbox" name="permission[]" value="{{$sublink->id}}" /> {{$sublink->title}}</label>

									</li>
                                @endforeach
                            </ul>
                            @endif
						@else
							<label>
                                <input {{$item->links->contains($link->id)?'checked':''}} type="checkbox"
                                          name="permission[]" value="{{$link->id}}" /> <b>{{$link->title}}</b></label>

                            <?php
                            $sublinks = \DB::table("links")->where("parent_id",$link->id)->get();
                            ?>
                             <ul class="list-unstyled">
                                @foreach($sublinks as $sublink)
                                    @if($sublink->id!=9)
                                    <li>
                                        <label><input {{$item->links->contains($sublink->id)?'checked':''}}
                                                      type="checkbox" name="permission[]" value="{{$sublink->id}}" /> {{$sublink->title}}</label>

									</li>
                                     @endif
                                @endforeach
                            </ul>
                            @endif




                        </li>
                    @endforeach
                </ul>

            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-5">
                <input type="submit" class="btn btn-success" value="حفظ" />
                <a href="/account/account" class="btn btn-light">الغاء الامر</a>
            </div>
        </div>
    </form>
    @else
    <br><br>
    <div class="alert alert-warning">ليس من صلاحيتك هذه الصفحة</div>
    @endif

@endsection


@section("js")
    <script>
        $(function(){

            $(":checkbox").click(function(){
                $(this).parent().next().find(":checkbox").prop("checked",$(this).prop("checked"));
                $(this).parents("ul").each(function(){
                    $(this).prev().find(":checkbox").prop("checked",$(this).find(":checked").size()>0);
                });
            });
//
            //
        });

    </script>
@endsection
