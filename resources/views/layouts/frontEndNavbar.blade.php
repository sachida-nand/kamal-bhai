  
   <nav>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
        <div class="top-nav">
            <div class="logo">
                <a href="{{ url('/') }}" class="logo"><img src="img/logo-removebg-preview.png" alt=""></a>
            </div>
            <form action="" class="nav-form">
                <input type="text" name="" id="" placeholder="Search...">
                <button type="search"><i class="fas fa-search"></i> <span class="search"> search</span></button>
            </form>
            <div class="top-nav-items">
                <div class="item">
                    @auth
                      <span id="sign">{{ Auth::user()->name }} <i class="fas fa-caret-down"></i>
                        <ul class="submenu">
                            <li><a href="{{ url('your-account')}}">Your Account</a></li>
                            <li><a href="{{ url('order-history') }}">Your Order</a> </li>
                            <li>
                                <a href="{{ route('logout') }}" class="text-sm text-gray-700 underline"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                                </form>
                            </li>
                            
                        </ul>
                    </span>
                    @else
                        <a class="item" href="{{ route('login') }}">Signin</a>
                    @endauth
                </div>
                <div class="chart item">
                    <a class="" href="{{ url('cart/nav_cart') }}"><i class="fas fa-cart-plus"></i> Chart</a>
                    <small class="chart_number"></small>
                </div>
            </div>
        </div>
    </nav>
    <nav class="second-nav">
        <ul>
            <li class="nav-items"><a href="{{ url('/') }}">Home</a></li>
            <li class="nav-items"><a href="">All Catagorie</a></li>
            <li class="nav-items"><a href="">All Brands</a></li>
            <li class="nav-items"><a href="">Coupons</a></li>
        </ul>
    </nav>
  
  
  
  
  
  
  
  
  
  {{-- <nav>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
        <div class="top-nav">
            <div class="logo">
                <a href="{{ url('/') }}" class="logo"><img src="img/logo-removebg-preview.png" alt=""></a>
            </div>
            <form action="" class="nav-form">
                <input type="text" name="" id="" placeholder="Search...">
                <button type="search"><i class="fas fa-search"></i> <span class="search"> search</span></button>
            </form>
            <div class="top-nav-items d-flex">
                 @auth
                        <a href="{{ route('logout') }}" class="text-sm text-gray-700 underline"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">{{ Auth::user()->name }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                  </form>
                    @else
                        <a class="item" href="{{ route('login') }}">Signin</a>
                    @endauth
                <div class="chart">
                    <a class="item" href="{{ url('cart/nav_cart') }}"><i class="fas fa-cart-plus"></i> Chart</a>
                    <small class="chart_number"></small>
                </div>
            </div>
        </div>
    </nav>
    <nav class="second-nav">
        <ul>
            <li class="nav-items"><a href="{{ url('/') }}">Home</a></li>
            <li class="nav-items"><a href="">About</a></li>
            <li class="nav-items"><a href="">Contact Us</a></li>
            <li class="nav-items"><a href="{{ url('order-history') }}">Your order</a></li>
        </ul>
    </nav> --}}