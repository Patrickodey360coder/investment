<header id="masthead" class="site-header" >
        <div id="cshero-header" class="cshero-main-header sticky-desktop">
    <div class="container">
        <div id="cshero-header-logo" class="cshero-header-logo pull-left">
            <a href="{{ route('index') }}"><img alt="Logo" src="/wp-content/uploads/2016/08/logo.png"></a>        </div><!-- #site-logo -->
        <div id="cshero-menu-mobile" class=" navbar-collapse visible-xs visible-sm ">
            <button class="navbar-toggle btn-navbar collapsed" data-toggle="collapse" data-target="#cshero-header-navigation">
                <span class="icon-bar"></span>
            </button>
        </div><!-- #menu-mobile -->
        <div id="cshero-header-navigation" class="cshero-header-navigation collapse pull-right">
            <nav id="site-navigation" class="main-navigation clearfix" >
                <div class="menu-main-menu-container"><ul id="menu-main-menu" class="nav-menu menu-main-menu clearfix"><li id="menu-item-810" class="@if(isset($activeLink) && $activeLink=='index') current-menu-item page_item page-item-6  current_page_item @endif menu-item menu-item-type-post_type menu-item-object-page menu-item-home no_group menu-item-810" data-depth="0"><a href="{{ route('index') }}" class=""><span class="menu-title">Home</span></a>
</li>
<li id="menu-item-26" class="@if(isset($activeLink) && $activeLink=='about-us') current-menu-item page_item page-item-6  current_page_item @endif menu-item menu-item-type-post_type menu-item-object-page no_group menu-item-26" data-depth="0"><a href="{{ route('about-us') }}" class=""><span class="menu-title">About Us</span></a></li>
<li id="menu-item-25" class="@if(isset($activeLink) && $activeLink=='services') current-menu-item page_item page-item-6  current_page_item @endif menu-item menu-item-type-post_type menu-item-object-page no_group menu-item-25" data-depth="0"><a href="{{ route('services') }}" class=""><span class="menu-title">Services</span></a></li>
<li id="menu-item-24" class="@if(isset($activeLink) && $activeLink=='investment') current-menu-item page_item page-item-6  current_page_item @endif menu-item menu-item-type-post_type menu-item-object-page no_group menu-item-24" data-depth="0"><a href="{{ route('investment') }}" class=""><span class="menu-title">Investment Plans</span></a></li>
<!-- <li id="menu-item-23" class="@if(isset($activeLink) && $activeLink=='about-us') current-menu-item page_item page-item-6  current_page_item @endif menu-item menu-item-type-post_type menu-item-object-page no_group menu-item-23" data-depth="0"><a href="/blog/" class=""><span class="menu-title">Blog</span></a></li>
<li id="menu-item-21" class="@if(isset($activeLink) && $activeLink=='about-us') current-menu-item page_item page-item-6  current_page_item @endif menu-item menu-item-type-post_type menu-item-object-page no_group menu-item-21" data-depth="0"><a href="/contact/" class=""><span class="menu-title">Contact</span></a></li>
<li id="menu-item-1248" class="@if(isset($activeLink) && $activeLink=='about-us') current-menu-item page_item page-item-6  current_page_item @endif menu-item menu-item-type-post_type menu-item-object-page no_group menu-item-1248" data-depth="0"><a href="/shop/" class=""><span class="menu-title">Shop</span></a></li> -->
@if (Route::has('login'))
    @auth
        <li id="menu-item-1248" class="menu-item menu-item-type-post_type menu-item-object-page no_group menu-item-1248" data-depth="0"><a href="/home" class=""><span class="menu-title">My Dashboard</span></a></li>
        <li id="menu-item-1248" class="menu-item menu-item-type-post_type menu-item-object-page no_group menu-item-1248" data-depth="0">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <span class="menu-title">
                  Logout
                </span>
            </a>
        </li>
    @else
        <li id="menu-item-1248" class="menu-item menu-item-type-post_type menu-item-object-page no_group menu-item-1248" data-depth="0"><a href="{{ route('login') }}" class=""><span class="menu-title">Login</span></a></li>
        <li id="menu-item-1248" class="menu-item menu-item-type-post_type menu-item-object-page no_group menu-item-1248" data-depth="0"><a href="{{ route('register') }}" class=""><span class="menu-title">Register</span></a></li>
    @endauth
@endif
</ul></div>            </nav><!-- #site-navigation -->
                    </div>
        
    </div>
</div><!-- #site-navigation --> </header><!-- #masthead -->