<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

  <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template.">
  <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
  <meta name="author" content="PIXINVENT">
  <title>@yield('title', config('app.name', '@Master Layout'))</title>
  <link rel="apple-touch-icon" href="img/logo.png">
  <link rel="shortcut icon" type="image/x-icon" href="img/logo.png">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">
  <script type="text/javascript" src="{{ asset('dx/js/jquery.min.js') }}"></script>



  {!! Assets::renderHeader() !!}
</head>

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

  <!-- fixed-top-->
  @include('layout.top')
  <!-- ////////////////////////////////////////////////////////////////////////////-->

  <!-- leftmenu-->
  @include('layout.leftmenu')

  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
       <!-- Main view  -->
       @yield('content')
     </div>
   </div>
 </div>
 <!-- ////////////////////////////////////////////////////////////////////////////-->

 <input type="checkbox" id="collapsed-sidebar" style="display: none;">

 <!-- footer  -->
 @include('layout.footer')

 <!-- js  -->
 {!! Assets::renderFooter() !!}

 <!-- load active menu -->
 <script type="text/javascript">
  $(document).ready(function() { 
    //active menu
    var url = window.location.href;
    $(".navigation-main li a").each(function(){
      var $this = $(this);
      if($this.prop("href") == url) {
        $(this).parent().addClass("active");
      }
    });

    //collapsed menu
    setTimeout(function() {
      $('#collapsed-sidebar').trigger('click');
    },500);

  });
</script>

</body>

</html>