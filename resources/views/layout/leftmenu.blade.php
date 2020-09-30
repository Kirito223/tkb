    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow " data-scroll-to-active="true">
    	<div class="main-menu-content">            
    		<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
              
               @if( Auth::user()->level == 1)
               <li class="nav-item has-sub open"><a href="index.html"><i class="icon-home"></i><span class="menu-title" data-i18n="nav.dash.main">Quản lý tài khoản</span></a>
                  <ul class="menu-content" style="">
                    <li class="active is-shown"><a class="menu-item" href="taikhoan" data-i18n="nav.dash.ecommerce">Tài khoản</a>
                    </li>
                    <li class="is-shown"><a class="menu-item" href="phanquyen" data-i18n="nav.dash.project">Phân quyền</a>
                    </li>
                    <li class="is-shown"><a class="menu-item" href="huyen" data-i18n="nav.dash.project">Huyện</a>
                    </li>
                    <li class="is-shown"><a class="menu-item" href="xa" data-i18n="nav.dash.project">Xã</a>
                    </li>
                    <li class="is-shown"><a class="menu-item" href="truong" data-i18n="nav.dash.project">Trường</a>
                    </li>
                </ul>
            </li>
            @endif

            @if( Auth::user()->level == 2)
            <li ><a href="khaibao"><i class="fa fa-exclamation-circle"></i><span class="menu-title" data-i18n="nav.icons.main">Khai báo</span></a>
               <li ><a href="rangbuoc"><i class="fa fa-compress"></i><span class="menu-title" data-i18n="nav.icons.main">Ràng buộc</span></a>
               </li>
               <li ><a href="xeptkb"><i class="fa fa-calendar-o"></i><span class="menu-title" data-i18n="nav.icons.main">Xếp TKB</span></a>
               </li>
               <!-- <li ><a href="tinhchinh"><i class="fa fa-cog"></i><span class="menu-title" data-i18n="nav.icons.main">Tinh chỉnh </span></a>
               </li>
               <li ><a href="xemtkb"><i class="fa fa-calendar-plus-o"></i><span class="menu-title" data-i18n="nav.icons.main">Xem TKB</span></a>
               </li>-->
               <li ><a href="exportkb"><i class="fa fa-download"></i><span class="menu-title" data-i18n="nav.icons.main">Lưu - Tải TKB</span></a>
               </li>
           </li>
           @endif
			
			            <!-- tài khoản tổng hợp -->
            @if(Auth::user()->level == 3)
                <li><a href="xemthoikhoabieu"><i class="fa fa-calendar"></i><span class="menu-title" data-i18n="nav.icons.main">Thời khóa biểu</span></a>
                <li><a href="thongke"><i class="fa fa-bar-chart"></i><span class="menu-title" data-i18n="nav.icons.main">Thống kê</span></a>
                <li class="nav-item has-sub open"><a href="#"><i class="fa fa-search"></i><span class="menu-title" data-i18n="nav.dash.main">Theo dõi</span></a>
                    <ul class="menu-content" style="">
                        <li class="is-shown"><a class="menu-item" href="theodoibiendongtkb" data-i18n="nav.dash.project">Biến động TKB</a>
                        </li>
                        <li class="is-shown"><a class="menu-item" href="theodoibaocaodonvi" data-i18n="nav.dash.project">Báo cáo đơn vị</a>
                        </li>
                    </ul>
                </li>
                <li><a href="thongbao"><i class="fa fa-bell"></i><span class="menu-title" data-i18n="nav.icons.main">Thông báo</span></a>
            @endif
					
					
           <li ><a href="getlogout"><i class="fa fa-times-circle"></i><span class="menu-title" data-i18n="nav.icons.main">Đăng xuất</span></a>
           </li>
       </ul>
   </div>
</div>