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

                      <li class="@if(isset($activeLink) && $activeLink=='reinitiateInvestment') active-link @endif">
                          <a href="{{ route('premium.reinitiateInvestment') }}">
                              <i class="fa fa-naira"></i>
                              <span class="menu-title">
                                  <strong>Reinitiate Investment</strong>
                              </span>
                          </a>
                      </li>              
                      
                      <li class="@if(isset($activeLink) && $activeLink=='withdrawal') active-link @endif">
                          <a href="{{ route('user.withdrawals') }}">
                              <i class="fa fa-money"></i>
                              <span class="menu-title">
                                  <strong>Withdrawal Requests</strong>
                              </span>
                          </a>
                      </li>
                      
                     
                      <li class="@if(isset($activeLink) && $activeLink=='payment') active-link @endif">
                          <a href="{{ route('user.payments') }}">
                              <i class="fa fa-naira"></i>
                              <span class="menu-title">
                                  <strong>Make Payments</strong>
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

                      <li class="@if(isset($activeLink) && $activeLink=='bank') active-link @endif">
                          <a href="{{ route('user.bank') }}">
                              <i class="fa fa-money"></i>
                              <span class="menu-title">
                                  <strong>My Bank Details</strong>
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