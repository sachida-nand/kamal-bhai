<div class="col-md-3 left_col">
   <div class="left_col scroll-view">
      <div class="navbar nav_title" style="border: 0;">
         <a href="index.html" class="site_title">
            {{-- <i class="fa fa-paw"></i>  --}}
            <span>Sachida Nand</span></a>
      </div>
      <div class="clearfix"></div>
      <br />
      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
         <div class="menu_section">
            <h3 style="border-bottom: 1px solid #fff;"></h3>
            <ul class="nav side-menu">
               <li>
                  <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
               </li>
               <li>
                  <a href="{{ url('catagorie') }}"><i class="fas fa-box-tissue"></i> Catagories</a>
               </li>
               <li>
                  <a href="{{ url('brand') }}"><i class="fas fa-clipboard-check"></i> Brand</a>
               </li>
               <li>
                  <a href="{{ url('product') }}"><i class="fas fa-cart-plus"></i> Product</a>
               </li>
               <li>
                  <a href="{{ url('Orders-received') }}"><i class="fas fa-truck"></i> Order List</a>
               </li>
               <li>
                  <a href="user"><i class="fas fa-users"></i> Users</a>
               </li>
               <li>
                  <a href="product-review"><i class="fas fa-comments"></i> Product Review</a>
               </li>
               <li>
                  <a href="user-enquiry"><i class="fas fa-comment-alt"></i> User Message</a>
               </li>
            </ul>
         </div>
      </div>
      <!-- /sidebar menu -->
      <!-- /menu footer buttons -->
      <div class="sidebar-footer hidden-small">
         <a data-toggle="tooltip" data-placement="top" title="Settings">
         <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
         </a>
         <a data-toggle="tooltip" data-placement="top" title="FullScreen">
         <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
         </a>
         <a data-toggle="tooltip" data-placement="top" title="Lock">
         <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
         </a>
         <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}" 
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();">
           <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
            </form>
      </div>
      <!-- /menu footer buttons -->
   </div>
</div>
<!-- top navigation -->
<div class="top_nav">
   <div class="nav_menu">
      <div class="nav toggle">
         <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>
      <nav class="nav navbar-nav">
         <ul class=" navbar-right">
            <li class="nav-item dropdown open" style="padding-left: 15px;">
               <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
                  id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
               <img src="images/img.jpg" alt="">{{ Auth::user()->name }}
               </a>
               <div class="dropdown-menu dropdown-usermenu pull-right"
                  aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="javascript:;"> Profile</a>
                  <a class="dropdown-item" href="{{ route('logout') }}" 
                     onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out pull-right"></i>
                  Log Out</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                  </form>
               </div>
            </li>
         </ul>
         </li>
         </ul>
      </nav>
   </div>
</div>
<!-- /top navigation -->
