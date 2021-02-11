
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>@yield("title")</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/sticky-footer-navbar.css" rel="stylesheet">
      @yield("css")
  </head>

  <body>

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Fixed navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/products">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/products/about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/products/contact">Contact</a>
            </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Send To View
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/sendtoview/with">Using With</a>
                  <a class="dropdown-item" href="/sendtoview/with-param">Using With Param</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/sendtoview/compact">Using Compact</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Database
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/account">Accounts Basic</a>
                  <a class="dropdown-item" href="/accountrs">Accounts Resource</a>
                  <a class="dropdown-item" href="/accountrq">Accounts Request</a>
                  <a class="dropdown-item" href="/accounteq">Accounts Elequent</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="/accountrq/paging">Accounts Paging</a>
                  <a class="dropdown-item" href="/accounteq/search">Accounts Search</a>
                  <a class="dropdown-item" href="/accounteq/search-paging">Accounts Search Paging</a>
                  <a class="dropdown-item" href="/accounteq/search-paging-advanced">Accounts Search Paging Advanced</a>
                </div>
              </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
        <h1 class="mt-5">@yield("title")</h1>
        @include("_msg")
        @yield("content")
    </main>

    <footer class="footer">
      <div class="container">
        <span class="text-muted">Place sticky footer content here.</span>
      </div>
    </footer>
    <div class="modal fade" id="Confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Confirmation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to continue?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <a href="#" class="btn btn-danger">Yes, sure</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>

    <script src="/bootstrap/js/popper.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
      @yield("js")
      <script>
            $(function(){
                //$("#Confirm").modal("show");
                $(".Confirm").click(function(){
                    $("#Confirm").modal("show");
                    $("#Confirm .btn-danger").attr("href", $(this).attr("href"));
                    return false;
                });
            });
      </script>

  </body>
</html>
