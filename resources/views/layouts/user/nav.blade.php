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
          
                      <!--Category name-->
                      <li class="list-header">Navigation</li>
          
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
                      
                      <li class="@if(isset($activeLink) && $activeLink='trustway') active-link @endif">
                          <a href="{{ route('user.investments') }}">
                              <i class="fa fa-bar-chart"></i>
                              <span class="menu-title">
                                  <strong>My Investments</strong>
                              </span>
                          </a>
                      </li>
                      
                      <li  >
                          <a href="https://mytuitionaid.com/leadwayinvest/admin/Investors">
                              <i class="fa fa-users"></i>
                              <span class="menu-title">
                                  <strong>Investors</strong>
                              </span>
                          </a>
                      </li>
                      
                      
                      <li >
                          <a href="https://mytuitionaid.com/leadwayinvest/admin/Payment">
                              <i class="fa fa-dollar"></i>
                              <span class="menu-title">
                                  <strong>Payments</strong>
                              </span>
                          </a>
                      </li>
                      
                      
                      <li >
                          <a href="https://mytuitionaid.com/leadwayinvest/admin/WithdrawalRequest">
                              <i class="fa fa-money"></i>
                              <span class="menu-title">
                                  <strong>Withdrawal Requests</strong>
                              </span>
                          </a>
                      </li>
                      
                     
                      <li >
                          <a href="https://mytuitionaid.com/leadwayinvest/admin/PendingPayment">
                              <i class="fa fa-money"></i>
                              <span class="menu-title">
                                  <strong>Pending Payments</strong>
                              </span>
                          </a>
                      </li>
                    
                        <li >
                          <a href="https://mytuitionaid.com/leadwayinvest/admin/ApprovedPayment">
                              <i class="fa fa-check"></i>
                              <span class="menu-title">
                                  <strong>Approved Payment</strong>
                              </span>
                          </a>
                      </li>
                        
                      
                       <li class="list-divider"></li>
                      
                     
                      
                      <li >
                          <a href="https://mytuitionaid.com/leadwayinvest/admin/AdminAccount">
                              <i class="fa fa-users"></i>
                              <span class="menu-title">
                                  <strong>Admin Accounts</strong>
                              </span>
                          </a>
                      </li>
                      
                       <li >
                          <a href="https://mytuitionaid.com/leadwayinvest/admin/AdminActivity">
                              <i class="fa fa-folder"></i>
                              <span class="menu-title">
                                  <strong>Admin Activity</strong>
                              </span>
                          </a>
                      </li>
                      
                  <!--    
                      <li class="list-divider"></li>
                         
                         <li >
                              <a href="https://mytuitionaid.com/leadwayinvest/admin/Report">
                                  <i class="fa fa-files-o"></i>
                                  <span class="menu-title">
                                      <strong>Reports</strong>
                                  </span>
                              </a>
                          </li>
                      
                       <li class="list-divider"></li>
                 -->
              </div>
          </div>
      </div>                    <!--================================-->
      <!--End menu-->
  </div>
</nav>