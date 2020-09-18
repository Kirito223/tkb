<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
<!-- Original URL: https://pixinvent.com/bootstrap-admin-template/robust/html/ltr/vertical-menu-template/login-simple.html
    Date Downloaded: 11/30/2018 4:05:42 PM !-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template." />
    <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard" />
    <meta name="author" content="PIXINVENT" />
    <title>Thời khóa biểu LIHANET</title>
    <link rel="apple-touch-icon" href="theme/app-assets/images/ico/apple-icon-120.png" />
    <link rel="shortcut icon" type="image/x-icon" href="img/logo.png" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet" />
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="theme/app-assets/css/vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="theme/app-assets/vendors/css/forms/icheck/icheck.css" />
    <link rel="stylesheet" type="text/css" href="theme/app-assets/vendors/css/forms/icheck/custom.css" />
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="theme/app-assets/css/app.min.css" />
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="theme/app-assets/css/core/menu/menu-types/vertical-menu.min.css" />
    <link rel="stylesheet" type="text/css" href="theme/app-assets/css/core/colors/palette-gradient.min.css" />
    <link rel="stylesheet" type="text/css" href="theme/app-assets/css/pages/login-register.min.css" />
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="theme/assets/css/style.css" />
    <!-- END Custom CSS-->
</head>
<body class="vertical-layout vertical-menu 1-column   menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body"><section class="flexbox-container">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="col-md-4 col-10 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 m-0">
                        <div class="card-header border-0">
                            <div class="card-title text-center">
                                <div class="p-1"><img src="img/logo.png" alt="branding logo" /></div>
                            </div>
                            <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Đăng nhập</span></h6>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                @include('errors.note')

                                <form class="form-horizontal form-simple" role="form" action="{{ url('postlogin') }}" method="POST">
                                    {!! csrf_field() !!}

                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                        <input type="text" name="tentaikhoan" class="form-control form-control-lg input-lg" placeholder="Tài khoản" value="{{ old('tentaikhoan') }}" required autofocus>
                                        <div class="form-control-position">
                                            <i class="ft-user"></i>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="password" class="form-control form-control-lg input-lg" placeholder="Mật khẩu" name="password" required    >
                                        <div class="form-control-position">
                                            <i class="fa fa-key"></i>
                                        </div>
                                    </fieldset>
<!--                                     <div class="form-group row">
                                        <div class="col-md-6 col-12 text-center text-md-left">
                                            <fieldset class="checkboxsas">
                                              <label>
                                               <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ghi nhớ mật khẩu
                                           </label>
                                       </fieldset>
                                   </div>
                               </div> -->
                               <button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i> Đăng nhập</button>
                           </form>
                           <br>
                           <p class="card-subtitle line-on-side text-muted text-center font-small-3 mx-2 my-1"><span>Liên hệ </span></p>
                           <div class="card-body pb-0">
                               <div class="row px-3">
                                <div class="col-12 row m-0 p-0">
                                    <p class="mb-1"><b>Hỗ trợ trực tuyến</b>
                                    </p>
                                </div>
                                <div class="col-12  row m-0 p-0">
                                    <p class="ml-3 mb-1"><b>Phòng CSKH</b></p>
                                </div>
                                <div class="col-12 row m-0 p-0">
                                    <p class="ml-3 mb-1">Điện thoại: (0256) 6.555.678
                                    </p>
                                </div>
                                <div class="col-12 row m-0 p-0">
                                    <p class="ml-3 mb-1">Email: trunghauqn2008@gmail.com
                                    </p>
                                </div>
                            </div>
                        </div>






                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<!-- BEGIN VENDOR JS-->
<script src="theme/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script src="theme/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
<script src="theme/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN ROBUST JS-->
<script src="theme/app-assets/js/core/app-menu.min.js"></script>
<script src="theme/app-assets/js/core/app.min.js"></script>
<!-- END ROBUST JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script src="theme/app-assets/js/scripts/forms/form-login-register.min.js"></script>
<!-- END PAGE LEVEL JS-->
</body>
</html>