<nav id="mainnav-container">
  <div id="mainnav">
  
     <!--Shortcut buttons-->
      <!--================================-->
      <div id="mainnav-shortcut">
          
      </div>
      <!--================================-->
      <!--End shortcut buttons-->
      <!--Menu-->
      <!--================================-->
       <div id="mainnav-menu-wrap">
          <div class="nano">
              <div class="nano-content">
                  <ul id="mainnav-menu" class="list-group">
          
                      <!--Menu list item-->
                      <li class="@if(!isset($activeLink)) active-link @endif">
                          <a href="{{ route('home') }}">
                              <i class="fa fa-home"></i>
                              <span class="menu-title">
                                  <strong>Dashboard</strong>
                              </span>
                          </a>
                      </li>
          
                      <li class="list-divider"></li>

                      <li class="@if(isset($activeLink) && $activeLink=='investor') active-link @endif">
                          <a href="{{ route('admin.investors') }}">
                              <i class="fa fa-user"></i>
                              <span class="menu-title">
                                  <strong>All Investors</strong>
                              </span>
                          </a>
                      </li>

                      <li class="@if(isset($activeLink) && $activeLink=='premium') active-link @endif">
                          <a href="{{ route('admin.premium.users') }}">
                              <i class="fa fa-user"></i>
                              <span class="menu-title">
                                  <strong>All Premium Investors</strong>
                              </span>
                          </a>
                      </li>

                      <li class="@if(isset($activeLink) && $activeLink=='reinitiatePremiumInvestment') active-link @endif">
                          <a href="{{ route('admin.premium.reinitiatePremiumInvestment') }}">
                              <i class="fa fa-money"></i>
                              <span class="menu-title">
                                  <strong>All Premium Investment Reinitiation Requests</strong>
                              </span>
                          </a>
                      </li> 
                      
                      <li class="@if(isset($activeLink) && $activeLink=='trustway') active-link @endif">
                          <a href="{{ route('admin.investments') }}">
                              <i class="fa fa-bar-chart"></i>
                              <span class="menu-title">
                                  <strong>All Investments</strong>
                              </span>
                          </a>
                      </li>                      
                      
                      <li class="@if(isset($activeLink) && $activeLink=='withdrawal') active-link @endif">
                          <a href="{{ route('admin.withdrawals') }}">
                              <i class="fa fa-money"></i>
                              <span class="menu-title">
                                  <strong>All Withdrawal Requests</strong>
                              </span>
                          </a>
                      </li>                       
                      
                       <li class="list-divider"></li>
                      
                      <li class="@if(isset($activeLink) && $activeLink=='activities') active-link @endif">
                          <a href="{{ route('user.activities') }}">
                              <i class="fa fa-folder"></i>
                              <span class="menu-title">
                                  <strong>My Activities</strong>
                              </span>
                          </a>
                      </li>

                      <li class="@if(isset($activeLink) && $activeLink=='profile') active-link @endif">
                          <a href="{{ route('profile') }}">
                              <i class="fa fa-user"></i>
                              <span class="menu-title">
                                  <strong>My Profile</strong>
                              </span>
                          </a>
                      </li>

                      <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fa fa-users"></i>
                            <span class="menu-title">
                              <strong>Logout</strong>
                            </span>
                        </a>
                      </li>
              </div>
          </div>
      </div>
  </div>
</nav>