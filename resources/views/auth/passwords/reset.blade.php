<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <title>تعين كلمة المرور</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="" type="image/x-icon"/><!-- fav icon -->
    <link rel="stylesheet" href="/lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="/lib/css/bootstrap-rtl.css">
    <link rel="stylesheet" href="/lib/css/Animat.css">
    <link rel="stylesheet" type="text/css" href="/lib/css/font-awesome.min.css"><!-- font awesome-->
    <link rel="stylesheet" type="text/css" href="/lib/css/style.css"><!-- main style -->
    <link rel="stylesheet" type="text/css" href="/lib/css/responsive.css"><!-- responsive style -->
    <link href="https://fonts.googleapis.com/css?family=El+Messiri" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#hide").click(function () {
                $("p").hide();
            });
            $("#show").click(function () {
                $("p").show();
            });
        });
    </script>
</head>
<body>
<!-- start wrapper -->
<div id="wrapper">
    <!-- start content -->
    <div id="content">

        <!--********************************************* navBar start *********************************************************************-->
        <header>
            <nav style="background:#af0922;" class="navbar navbar-default navbar-inverse navbar-fixed-top">
                <div class=" container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#" data-toggle="modal" data-target="#myModal">تسجيل الدخول</a>
                    </div>
                    <!--****************************************************first Modal ***********************************************************************-->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <!--*** modal-dialog ****-->
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <!--*** modal-header ****-->
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                </div>
                                <!--*** modal-body****-->
                                <div class="modal-body">
                                    <!--**** form start ****-->
                                    <form>
                                        <div class="form-group">
                                            <label>الايميل</label>
                                            <input type="email" class="form-control" placeholder="الايميل">
                                        </div>
                                        <div class="form-group">
                                            <label>كلمة المروركلمة المرور</label>
                                            <input type="password" class="form-control" placeholder="كلمة المرور">
                                        </div>
                                        <a href="#" data-toggle="modal" data-target="#myModal2">نسيت كلمة المرور</a>
                                    </form>
                                    <!--**** form end ****-->
                                </div>
                                <!--**** modal-footer ****-->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                                    <button type="button" class="btn btn-primary">تسجيل</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--******************************************* first Modal end ***********************************************************************-->
                    <!--******************************************* second Modal start*********************************************************************-->
                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label>الايميل</label>
                                            <input type="email" class="form-control"
                                                   placeholder="الرجاء ادخال الايميل او رقم الهاتف">
                                        </div>
                                        <br><br>
                                        <p style="color:red;">ستصلك رسالة بعد قليل </p>
                                        <button type="button" class="btn btn-primary">ارسال</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                                    <button type="button" class="btn btn-primary">تسجيل</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul style="display:inline;" class="nav navbar-nav navbar-right">
                            <img style="width: 70px; height: 70px;padding:5px;" src="/lib/img/Group%20124.svg" alt="">
                            <span>مركز العمل التنموي معا</span>
                            <!-- <img style="width: 50px; height: 50px;" src="/lib/img/Group%20124.svg" alt="">
                              <p style="color:white;" class="lead">مركز العمل التنموي معا</p> -->
                        </ul>
                        <ul class="nav navbar-nav navbar-right center">
                            <li><a href="#اتصل بنا">
                                    اتصل بنا</a>
                            </li>
                            <li><a href="#من نحن">
                                    من نحن </a>
                            </li>
                            <li><a href="#البحث">
                                    البحث</a>
                            </li>
                            <li><a href="#تقديم الطلب">
                                    تقديم الطلب</a>
                            </li>
                            <li><a href="#الصفحة الرئيسية">
                                    الصفحة الرئيسية</a>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
            <!--*******************************  الصفحة الرئيسية ******************************************-->
            <div id="الصفحة الرئيسية"></div>
            <!--******************************  خدماتنا***************************************************-->
            <div id="تقديم الطلب"></div>
            <!--******************************  خدماتنا***************************************************-->
            <div id="البحث"></div>
    </div>
    <div id="recent"></div>
    <div class="section recent">
    </div>
    <div id="من نحن"></div>
    <div id="uwyo"></div>
    <div class="section uwyo">
    </div>
    <div id="اتصل بنا"></div>
    <div id="site"></div>
    <div class="section site">
    </div>
</div>
<style>
    @import url(https://fonts.googleapis.com/css?family=Oswald:400,300,700|Montserrat:400,700|Roboto:400,300italic,100italic,100,300,400italic,500,500italic,700,700italic,900,900italic);
</style>
</header>
<!--************************************************************ navb end*****************************************************************-->
<!--************************************************************* form start **************************************************************-->
<div class="container"><br>
    <div class="row">
        <h1 class="col-sm-7 wow bounceIn" style="color:#af0922;margin-top:120px;margin-left:23px;">إعادة تعيين كلمة
            المرور</h1><br><br><br><br>
    </div>
    <br>
    <div class="row">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible col-sm-3" style="margin-left:160px;margin-bottom: 43px;width: 57.666667%;direction: rtl;text-align:right;">
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
    <div class="row">
    <form method="POST" action="{{ route('password.request') }}"
          style="width:600px;margin-top:-30px;text-align:center;margin-left:20px;">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <!--email  -->

        <div class="form-group row">
            <div class="col-sm-6" style="margin-left:-225px;">
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                       value="{{ $email ?? old('email') }}" required autofocus id="email">
            </div>
            <label for="inputPassword3" class="col-sm-3 col-form-label"> عنوان الإيميل</label>
        </div>
        <!--password -->
        <div class="form-group row">
            <div class="col-sm-6" style="margin-left:-225px;">
                <input id="password" type="password"
                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            </div>
            <label for="inputPassword3" class="col-sm-3 col-form-label">كلمة المرور</label>
        </div>
        <!--re-password -->
        <div class="form-group row">
            <div class="col-sm-6" style="margin-left:-225px;">
                <input tid="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
            <label for="inputPassword3" class="col-sm-3 col-form-label">تأكيد كلمة المرور{</label>
        </div>
        <button style="width:282px;margin-top:-130px;margin-left:-760px;background:#67647E;border:0;outline:none;margin-bottom:-180px;"
                type="submit" class="btn btn-primary wow bounceIn" >  تأكيد كلمة المرور</button>
    </form>
    </div>
</div>
<!--****************************************************** form end **************************************************************-->
<!--****************************************************** start footer **************************************************************-->
<footer style="margin-top:130px;padding-bottom:40px;margin-bottom:-50px;;" class="container-fluid">
    <div class="row top-footer">
        <!--first side  -->
        <div class="col-lg-3 address">
            <p>العنوان غزة - شارع الثلاثيني</p>
            <p> hamms@mail.com البريد الالكتروني</p>
            <p>23907387 (02) الفاكس</p>
        </div>
        <!--second side  -->
        <div class="col-lg-6 col-md-6 info">
            <p> الهاتف 2558658 </p>
            <p> رقم الجوال 059874689</p>
            <p>الرقم المجاني 1800700500</p>
        </div>
        <div class="col-lg-3  img-logo">
            <span>مركز العمل التنموي معا</span>
            <img src="/lib/img/Group%20124.svg" alt="">
        </div>
    </div>
    <div class="row bottom-footer">
        <div class="col-12">
            <p>جميع الحقوق محفوظة &copy; 2018</p>
        </div>
    </div>
</footer>
<!-- *********************************************** End footer ********************************************************************-->
<script>
    $(document).ready(function () {
        $(".input").click(function () {
            $("#div1").fadeIn(1000);
        });
    });
</script>

<!--************************************************ function for tab ************************************************************* -->
<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>

<!--  -->
<script src="js/jquery3.3.1.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="/lib/js/main.js"></script>

</body>
</html>
