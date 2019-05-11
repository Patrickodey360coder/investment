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
                    <p class="text-2x mar-no text-semibold">37</p>
                    <p class="text-muted mar-no">Investors</p>
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
                        <i class="fa fa-user fa-2x"></i>
                    </span>
                </div>
    
                <div class="media-body">
                    <p class="text-2x mar-no text-semibold">2</p>
                    <p class="text-muted mar-no">Administrators</p>
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
                        <i class=" fa fa-dollar fa-2x"></i>
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
    
            <!--Sales-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <div class="panel media pad-all">
                <div class="media-left">
                    <span class="icon-wrap  icon-circle  icon-wrap-md bg-danger">
                         <i class=" fa fa-dollar fa-2x"></i>
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
                    <h3 class="panel-title">New & Verified Investors (2019)</h3>
                </div>
                <div class="panel-body">
    
                    <!--Morris Area Chart placeholder-->
                    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                    <div id="demo-morris-area" style="height:215px"></div>
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
    
                    <!--Flot Donut Chart placeholder -->
                    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                    <div id="demo-flot-donut" style="height:215px"></div>
                    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    
                </div>
            </div>
        </div>
    
    </div>
  @endsection
  @section('scripts')
        <script type='text/javascript' src='/js/jquery-2.2.1.min.js?v=1.1'></script>
        <script type='text/javascript' src='/js/bootstrap.min.js?v=1.1'></script>
        <script type='text/javascript' src='/js/nifty.min.js?v=1.1'></script>
        
        <script type='text/javascript' src='/plugins/fast-click/fastclick.min.js?v=1.1'></script>
        <script type='text/javascript' src='/plugins/bootstrap-select/bootstrap-select.min.js?v=1.1'></script>
        <script type='text/javascript' src='/plugins/morris-js/morris.min.js?v=1.1'></script>
        <script type='text/javascript' src='/plugins/morris-js/raphael-js/raphael.min.js?v=1.1'></script>
        <script type='text/javascript' src='/plugins/flot-charts/jquery.flot.min.js?v=1.1'></script>
        <script type='text/javascript' src='/plugins/flot-charts/jquery.flot.resize.min.js?v=1.1'></script>
        <script type='text/javascript' src='/plugins/flot-charts/jquery.flot.pie.min.js?v=1.1'></script>
      
        <script>
      
        var dataSet = [];
        var dataSet = [
          { label: "Active", data: 14, color: "#177bbb" },
           { label: "Pending", data: 10, color: "#f84f9a" },
          { label: "Withdrawn", data: 3, color: "#a6c600" },
          { label: "Re-Invested", data: 0, color: "#8669CC" }
        ];
          
        var month=['January','February','March','April','May','June','July','August','September','October','November','December'];
        var graph_data=[
                        {
              period: ''+month[0],
              dl: 0,
              up: 0         } 
              
              ,           {
              period: ''+month[1],
              dl: 1,
              up: 0         } 
              
              ,           {
              period: ''+month[2],
              dl: 0,
              up: 0         } 
              
              ,           {
              period: ''+month[3],
              dl: 0,
              up: 0         } 
              
              ,           {
              period: ''+month[4],
              dl: 0,
              up: 0         } 
              
              ,           {
              period: ''+month[5],
              dl: 0,
              up: 0         } 
              
              ,           {
              period: ''+month[6],
              dl: 0,
              up: 0         } 
              
              ,           {
              period: ''+month[7],
              dl: 0,
              up: 0         } 
              
              ,           {
              period: ''+month[8],
              dl: 0,
              up: 0         } 
              
              ,           {
              period: ''+month[9],
              dl: 0,
              up: 0         } 
              
              ,           {
              period: ''+month[10],
              dl: 0,
              up: 0         } 
              
              ,           {
              period: ''+month[11],
              dl: 0,
              up: 0         } 
              
                          
              ];
    </script>
    <script type='text/javascript' src='/js/dashboard.js?v=1.1'></script>
  @endsection