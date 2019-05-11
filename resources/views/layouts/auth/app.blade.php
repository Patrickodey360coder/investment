<!DOCTYPE html>
  <html lang="en">
  
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Leadway Invest | Login</title>
        <link rel="icon" type="image/x-icon" href="images/invest.ico" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!--STYLESHEET-->
      <!--=================================================-->
      
      <link rel='stylesheet' href='/css/bootstrap.min.css?v=1.1' type='text/css' media='all' />
  <link rel='stylesheet' href='/css/nifty.min.css?v=1.1' type='text/css' media='all' />
  <link rel='stylesheet' href='/css/demo/nifty-demo-icons.min.css?v=1.1' type='text/css' media='all' />
  
      <link rel='stylesheet' href='/plugins/font-awesome//css/font-awesome.min.css?v=1.1' type='text/css' media='all' />
  <link rel='stylesheet' href='/plugins/pace/pace.min.css?v=1.1' type='text/css' media='all' />
  
      <link rel='stylesheet' href='/css/demo/nifty-demo.min.css?v=1.1' type='text/css' media='all' />
   
      <script type='text/javascript' src='/plugins/pace/pace.min.js?v=1.1'></script>
          
  </head>
  
  <body>
      <div id="container" class="cls-container">
          
          <!-- BACKGROUND IMAGE -->
          <div id="bg-overlay" class="bg-img img-balloon"></div>
          
          
          <!-- HEADER -->
          <div class="cls-header cls-header-lg">
              <div class="cls-brand">
                  <a class="box-inline" href="{{ route('index') }}">
                      <span class="brand-title">Leadway Invest </span>
                  </a>
              </div>
          </div>
          
          
          <div class="cls-content">
            <div class="cls-content-sm panel">                  
                <div class="panel-body">
                  @yield('content')
                </div>
            </div>           
          </div>
          
          
      </div>
      <!--===================================================-->
      <!-- END OF CONTAINER -->
  
  
          
      <!--JAVASCRIPT-->
      <!--=================================================-->
      
      <script type='text/javascript' src='/js/jquery-2.2.1.min.js?v=1.1'></script>
  <script type='text/javascript' src='/js/bootstrap.min.js?v=1.1'></script>
      
      <script type='text/javascript' src='/plugins/fast-click/fastclick.min.js?v=1.1'></script>
      
      <script type='text/javascript' src='/js/nifty.min.js?v=1.1'></script>
  <script type='text/javascript' src='/js/sha512.js?v=1.1'></script>
  <script type='text/javascript' src='/js/demo/bg-images.js?v=1.1'></script>
  <script type='text/javascript' src='/js/login_admin.js?v=1.1'></script>
          
  
  </body>
  </html>
  