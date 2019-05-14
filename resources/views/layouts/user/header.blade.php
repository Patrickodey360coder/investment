<header id="navbar">
  <div id="navbar-container" class="boxed">

      <!--Brand logo & name-->
      <!--================================-->
      <div class="navbar-header">
          <a href="{{ route('index') }}" class="navbar-brand">
            <!--  <img src="/images/invest.ico" alt="" class="brand-icon">-->
              <div class="brand-title">
                  <span class="brand-text">Leadway Invest</span>
              </div>
          </a>
      </div>
      <!--================================-->
      <!--End brand logo & name-->


      <!--Navbar Dropdown-->
      <!--================================-->
      <div class="navbar-content clearfix">
          <ul class="nav navbar-top-links pull-left">

              <!--Navigation toogle button-->
              <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
              <li class="tgl-menu-btn">
                  <a class="mainnav-toggle" href="#">
                      <i class="fa fa-navicon fa-lg"></i>
                  </a>
              </li>
              <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
              <!--End Navigation toogle button-->




          </ul>
          <ul class="nav navbar-top-links pull-right">



              <!--User dropdown-->
              <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
           
              <li id="dropdown-user" class="dropdown">
                  <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                      <span class="pull-right">
                          <img class="img-circle img-user media-object" src="/images/av1.png" alt="Profile Picture">
                      </span>
                      <div class="username hidden-xs">{{ Auth::user()->name }}</div>
                  </a>


                  <div class="dropdown-menu dropdown-menu-md dropdown-menu-right panel-default">

                      <!-- Dropdown heading  -->
                      <div class="pad-all bord-btm">
                        <script>var lifespan=3600;</script>
                          <p class="text-lg text-semibold mar-btm">Session Lifespan</p>
                               <div id="life_bar" class="progress"><div  style="width: 100%;" class="progress-bar progress-bar-info">100%</div></div>
                      </div>


                      <!-- User dropdown menu -->
                      <ul class="head-list">
                          
                          <li>
                              <a href="{{ route('profile') }}">
                                   <i class="fa fa-user fa-2x icon-lg icon-fw"></i> My Profile
                              </a>
                          </li>
                         
                      </ul>

                      <!-- Dropdown footer -->
                      <div class="pad-all text-right">
                        <a href="{{ route('logout') }}" class="btn btn-primary"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                      </div>
                  </div>
              </li>
              <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
              <!--End user dropdown-->

          </ul>
      </div>
      <!--================================-->
      <!--End Navbar Dropdown-->

  </div>
</header>