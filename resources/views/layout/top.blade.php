<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                        class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                            class="ft-menu font-large-1"></i></a>
                </li>
                <li class="nav-item">
                    <a class="navbar-brand" href="/"><img class="brand-logo" alt="robust admin logo" src="img/logo.png">
                        <h3 class="brand-text">Thời khóa biểu</h3>
                    </a>
                </li>
                <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                        data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                            href="#"><i class="ft-menu"> </i></a>
                    </li>
                    <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i
                                class="ficon ft-search"></i></a>
                        <div class="search-input">
                            <input class="input" type="text" placeholder="Tìm kiếm...">
                        </div>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-right">


                    @if( Auth::user()->level == 2)
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                            <i class="ficon ft-bell"></i>
                            <span
                                class="badge badge-pill badge-default badge-danger badge-default badge-up">{{ $thongbaocount ?? '' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span class="grey darken-2">Thông báo</span></h6>

                                <span
                                    class="notification-tag badge badge-default badge-danger float-right m-0">{{ $thongbaocount ?? '' }}</span>
                            </li>
                            <li class="scrollable-container media-list w-100">
                                @if (isset($thongbao))
                                @foreach($thongbao as $row)
                                <a href="thongbaotruong">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="media-heading">{{$row->tieude}}</h6>
                                            <p class="notification-text font-small-3 text-muted">{{$row->noidung}}</p>
                                            <small>
                                                <time class="media-meta text-muted"
                                                    datetime="2015-06-11T18:29:20+08:00">{{$row->ngaytao}}</time>
                                            </small>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                                @endif

                            </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                    href="thongbaotruong">Xem tất cả thông báo</a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @if( Auth::user()->level == 3)
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                            <i class="ficon ft-bell"></i>
                            <span
                                class="badge badge-pill badge-default badge-danger badge-default badge-up">{{ $baocaocount ??'' }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span class="grey darken-2">Báo Cáo</span></h6>

                                <span
                                    class="notification-tag badge badge-default badge-danger float-right m-0">{{ $baocaocount }}</span>
                            </li>
                            <li class="scrollable-container media-list w-100">
                                @foreach($baocao as $row)
                                <a href="thongbaotruong">
                                    <div class="media">
                                        <div class="media-body">
                                            <h6 class="media-heading">{{$row->tieude}}</h6>
                                            <p class="notification-text font-small-3 text-muted">{{$row->noidung}}</p>
                                            <small>
                                                <time class="media-meta text-muted"
                                                    datetime="2015-06-11T18:29:20+08:00">{{$row->ngaytao}}</time>
                                            </small>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                    href="thongbaotruong">Xem tất cả thông báo</a>
                            </li>
                        </ul>
                    </li>
                    @endif




                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="avatar avatar-online">
                                <img src="img/logo.png" alt="avatar">
                            </span>
                            <span class="user-name">{{Auth::user()->tentaikhoan}}</span> @if( Auth::user()->level == 2)
                            <span class="user-name">({{Session::get('schoolName')}})</span>
                            <span class="user-name">({{Session::get('mahuyens')}})</span> @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            @if( Auth::user()->level == 1)
                            <a class="dropdown-item" href="taikhoan"><i class="ft-user"></i> Tài khoản</a> @endif

                            <div class="dropdown-divider">

                            </div>
                            <a class="dropdown-item" href="getlogout"><i class="ft-power"></i> Đăng xuất</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>