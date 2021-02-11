@extends("layouts._citizen_layout")

@section("title", "متابعة نموذج ")


@section("content")

        <div class="row" style="margin-top:150px;">
              <div class="col-sm-12 text-center wow bounceIn">
                      <h1 class="wow bounceIn" style="text-align:center;color:#af0922;margin-top:120px;">أهلا بك عزيزي المواطن<hr class="h1-hr"></h1>
              </div>
        </div>
        <div class="row">
              <div class="col-sm-12 text-center wow bounceIn text-center">
                <h5>الرجاء تحديد نوع الطريقة التي تريد البحث من خلالها</h5>   
              </div>
        </div>
      <div class="container" style="margin-bottom: 30px;">
          <div class="row">
              <div class="col-sm-4"></div>
              <div class="col-sm-4">
                  <div class="row">
                      <div class="col-sm-12 col-lg-12  col-md-12 col-xs-12" style="margin:auto;">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      @endif
                 </div>
              </div>
             </div>
             <div class="col-sm-4"></div>
          </div>
          <div class="row">
              <div class="col-sm-4"></div>
              <div class="col-sm-4">
                 <form class="" action="/citizen/form/getforms" method="get">
          <div class="row">
            <div class="col-sm-12 n">
              <label style="text-align: right;" class="control-label col-sm-12" for="email">البحث عن طريق</label>

              <select style="text-align: center; margin-bottom:20px;" class="form-control input" id="id" name="type">
                <option value="">اختر طريقة البحث</option>
                  <option class="input" value="2">رقم الهوية</option>
                <option class="input" value="1">رقم النموذج</option>
              </select>
            <!-- </div> -->
         </div>
</div>
<div class="row">
            <div id="body">
            <div class="col-sm-12" id="div1">
               <input type="text" name="id" class="form-control input" style="margin-bottom:20px;" placeholder="الرجاء ادخال الرقم">
            <input id="mo" style="display: none  ; width:345px;height:40px;margin-bottom:20px;"  placeholder="الرجاء ادخال الهواية " type="text" class="form-control input" >
             </div>
            </div>
</div>

            <script>
            $('#id').change(function() {

                if($(this).val() == '1'){
                    $("#mo").css("display", "block");
                }else{
                    $("#mo").css("display", "none");
                }
                
            });
            </script>


         <div class="form-group row" align="center">
           <label class="col-sm-4 col-form-label form-control-label"></label>

          <div class="col-lg-12">
            <input type="submit" style="width: 60%; background-color:#BE2D45;" class="btn btn-primary wow bounceIn" value="التالي ">
          </div>
         </div>
       </form>

              </div>
              <div class="col-sm-4"></div>
          </div>
      </div>
        <!--<div class="row">
          <div class="col-sm-4 col-lg-4  col-md-4  col-xs-4 " style="margin:auto;">
                      @if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
            </div>
        <div class="col-sm-2 col-lg-2 col-md-2 col-xs-2"></div>
        </div><br>
        <form class="" action="/citizen/form/getforms" method="get">
       
            <br>
            <div style="margin-left:324px" class="col-sm-4 n">
              <select style="text-align: center;" class="form-control input" id="id" name="type">
                <option value="">اختر طريقة البحث</option>
                  <option class="input" value="2">رقم الهوية</option>
                <option class="input" value="1">رقم النموذج</option>
              </select>
            <!-- </div> 
         </div>
         <label style="margin-left:-64px" class="control-label col-sm-2 " for="email">البحث عن طريق</label>

            <div id="body">
            <div class="col-sm-4" id="div1" style="width:805px;height:120px;margin-left:-105px;margin-top:30px">
               <input type="text" name="id" class="form-control input" style=" margin-bottom: 10px; width:345px;height:40px;" placeholder="الرجاء ادخال الرقم">
            <input id="mo"  style="display: none  ; width:345px;height:40px;"  placeholder="الرجاء ادخال الهواية " type="text" class="form-control input" >
             </div>
            </div>


            <script>
            $('#id').change(function() {

                if($(this).val() == '1'){
                    $("#mo").css("display", "block");
                }else{
                    $("#mo").css("display", "none");
                }
                
            });
            </script>


         <div class="form-group row" align="center">
           <label class="col-sm-4 col-form-label form-control-label"></label>

          <div class="col-lg-11">
            <input style="width:360px;margin-top:-200px;margin-left:-11px;background:#67647E;border:0;outline:none;margin-bottom:-180px;" type="submit" class="btn btn-primary wow bounceIn" value="التالي ">
          </div>
         </div>
       </form>
          <br><br><br>
      </div>-->

<!--****************************************************** start footer **************************************************************-->
@endsection
