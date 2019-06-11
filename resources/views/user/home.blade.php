@extends('layouts.user.app')
  @section('title')
    Dashboard
  @endsection
  @section('page-content')
    <div class="row">
        <div class="col-sm-6 col-lg-3">
    
            <!--Registered User-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <div class="panel media pad-all">
                <div class="media-left">
                    <span class="icon-wrap icon-circle  icon-wrap-md bg-success">
                       <i class="fa fa-user fa-2x"></i>
                    </span>
                </div>
    
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">{{ $investments }}</p>
                    <p class="text-muted mar-no">Investments</p>
                </div>
            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    
        </div>
        <div class="col-sm-6 col-lg-3">
    
            <!--New Order-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <div class="panel media pad-all">
                <div class="media-left">
                    <span class="icon-wrap icon-circle icon-wrap-md bg-info">
                        <i class="fa fa-naira fa-2x"></i>
                    </span>
                </div>
    
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">{{ $wallet['total_earnings'] }}</p>
                    <p class="text-muted mar-no">Total Earnings</p>
                </div>
            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    
        </div>
        <div class="col-sm-6 col-lg-3">
    
            <!--Comments-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <div class="panel media pad-all">
                <div class="media-left">
                    <span class="icon-wrap icon-circle  icon-wrap-md bg-warning">
                        <i class=" fa fa-naira fa-2x"></i>
                    </span>
                </div>
    
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">{{ $wallet['bonus'] }}</p>
                    <p class="text-muted mar-no">Total Bonus</p>
                </div>
            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    
        </div>
        <div class="col-sm-6 col-lg-3">
    
            <!--Sales-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <div class="panel media pad-all">
                <div class="media-left">
                    <span class="icon-wrap  icon-circle  icon-wrap-md bg-danger">
                         <i class=" fa fa-naira fa-2x"></i>
                    </span>
                </div>
    
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">{{ $wallet['withdrawable'] }}</p>
                    <p class="text-muted mar-no">Wallet</p>
                </div>
            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    
        </div>
    </div>
    
    <!--End Tiles - Bright Version-->
    

   <div class="row">
        
        <div class="col-lg-6">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Withdrawals</h3>
                </div>
                <div class="panel-body">
                    <?php
                      if(empty($paidWithdrawal) && empty($pendingWithdrawal)){
                        echo '<div style="height:215px">';
                        echo "<h3>You have not made any withdrawals</h3>";
                        echo "</div>";
                      } else {
                        echo '<div id="demo-morris-area" style="height:215px"></div>';
                      }
                    ?>
                    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    
                </div>
            </div>
        </div>
    
       
       <div class="col-lg-6">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Investments</h3>
                </div>
                <div class="panel-body">
                    <?php
                      if(empty($investments)){
                        echo '<div style="height:215px">';
                        echo "<h3>You have not made any investments</h3>";
                        echo "</div>";
                      } else if(empty($activeInvestment) && empty($closedInvestment) && empty($pendingInvestment)){
                        echo '<div style="height:215px">';
                        echo "<h3>You have ".$investments." running investment</h3>";
                        echo "</div>";
                      } else {
                        echo '<div id="demo-flot-donut" style="height:215px"></div>';
                      }
                    ?>
                </div>
            </div>
        </div>
    
    </div>
  @endsection
  @section('scripts')
        <script type='text/javascript' src="{{ asset('/js/jquery-2.2.1.min.js?v=1.1') }}"></script>
        <script type='text/javascript' src="{{ asset('/js/bootstrap.min.js?v=1.1') }}"></script>
        <script type='text/javascript' src="{{ asset('/js/nifty.min.js?v=1.1') }}"></script>
        
        <script type='text/javascript' src="{{ asset('/plugins/fast-click/fastclick.min.js?v=1.1') }}"></script>
        <script type='text/javascript' src="{{ asset('/plugins/bootstrap-select/bootstrap-select.min.js?v=1.1') }}"></script>
        <script type='text/javascript' src="{{ asset('/plugins/morris-js/morris.min.js?v=1.1') }}"></script>
        <script type='text/javascript' src="{{ asset('/plugins/morris-js/raphael-js/raphael.min.js?v=1.1') }}"></script>
        <script type='text/javascript' src="{{ asset('/plugins/flot-charts/jquery.flot.min.js?v=1.1') }}"></script>
        <script type='text/javascript' src="{{ asset('/plugins/flot-charts/jquery.flot.resize.min.js?v=1.1') }}"></script>
        <script type='text/javascript' src="{{ asset('/plugins/flot-charts/jquery.flot.pie.min.js?v=1.1') }}"></script>
      
        <script>
      
        var investmentDataSet = [
          { label: "Active", data: {{ $activeInvestment }}, color: "#177bbb" },
           { label: "Pending", data: {{ $pendingInvestment }}, color: "#f84f9a" },
          { label: "Closed", data: {{ $closedInvestment }}, color: "#a6c600" },
        ];

        var withdrawalDataSet = [
          { label: "Paid", data: {{ $paidWithdrawal }}, color: "#177bbb" },
           { label: "Pending", data: {{ $pendingWithdrawal }}, color: "#f84f9a" },
        ];
          
        $.plot('#demo-flot-donut', investmentDataSet, {
          series: {
            pie: {
              show: true,
              combine: {
              color: '#999',
              threshold: 0.1
              }
            }
          },
          legend: {
          show: false
          }
        });

        $.plot('#demo-morris-area', withdrawalDataSet, {
          series: {
            pie: {
              show: true,
              combine: {
              color: '#999',
              threshold: 0.1
              }
            }
          },
          legend: {
          show: false
          }
        });
    </script>
  @endsection