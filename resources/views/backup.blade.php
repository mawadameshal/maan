 @extends("layouts._account_layout")
@section("content")
@section("title", "أخذ نسخة احتياطية لقاعدة البيانات")


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />-->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("p").click(function(){
       alert("mmm");

  });
});
</script>



    <div class="row " style="padding-right:15px">


    <form method="post" id="export_form" action="/back">
        @csrf
         <div class="checkbox">
            <label style="color:red;font-size:19px;">
            <input type="checkbox" id="checkall">تحديد و الغاء التحديد للجداول
            </label>
        </div>

    <?php
        $arr_tab = [];
    foreach($result as $table)
    {
    ?>
     <div class="checkbox ">
      <label><input type="checkbox" class="checkbox_table " name="table[]" value="<?php echo $table[0]; ?>" /> <?php echo $table[0]; ?></label>
     </div>
    <?php
        //$arr_tab =  $arr_tab.$table[0];
       $arr_tab = $table[0] ;

    }
    ?>



     <div class="form-group" style="padding-top:7px">
      <input type="submit" name="submit" id="submit" class="btn btn-info" value="Export" />
     </div>
    </form>
   </div>
       <script>
     $("#checkall").change(function(){

         $(".checkbox_table").prop("checked",$(this).prop("checked"))
     })
$(".checkbox_table").change(function(){
    if($(this).prop("checked")==false){
        $("#checkall").prop("checked",false)
    }
    if($(".checkbox_table:checked").length == $(".checkbox_table").length){
        $("#checkall").prop("checked",true)
    }

})

     </script>

<script>
$(document).ready(function(){
 $('#submit').click(function(){
  var count = 0;
  $('.checkbox_table').each(function(){
   if($(this).is(':checked'))
   {
    count = count + 1;
   }
  });
  if(count > 0)
  {
   $('#export_form').submit();
  }
  else
  {
   alert("Please Select Atleast one table for Export");
   return false;
  }
 });
});
</script>

@endsection
