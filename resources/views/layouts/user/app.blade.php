
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Trustway Capital | @yield('title')</title>
        <link rel="icon" type="image/x-icon" href="/images/invest.ico" />
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">
  
      <!--STYLESHEET-->
      <!--=================================================-->
      <link rel='stylesheet' href="{{ asset('css/bootstrap.min.css?v=1.1') }}" type='text/css' media='all' />
  <link rel='stylesheet' href="{{ asset('css/nifty.min.css?v=1.1') }}" type='text/css' media='all' />
  <link rel='stylesheet' href="{{ asset('css/demo/nifty-demo-icons.min.css?v=1.1') }}" type='text/css' media='all' />
  
      <link rel='stylesheet' href="{{ asset('plugins/font-awesome/css/font-awesome.min.css?v=1.1') }}" type='text/css' media='all' />
  <link rel='stylesheet' href="{{ asset('plugins/animate-css/animate.min.css?v=1.1') }}" type='text/css' media='all' />
  <link rel='stylesheet' href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css?v=1.1') }}" type='text/css' media='all' />
      
        
      <link rel='stylesheet' href="{{ asset('plugins/pace/pace.min.css?v=1.1') }}" type='text/css' media='all' />
  <link rel='stylesheet' href="{{ asset('plugins/morris-js/morris.min.css?v=1.1') }}" type='text/css' media='all' />
  <link rel='stylesheet' href="{{ asset('plugins/switchery/switchery.min.css?v=1.1') }}" type='text/css' media='all' />
  <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
  <style type="text/css">
    #mainnav-container {
      min-height: 100vh;
    }
    #mainnav-menu i {
      transition: .5s;
      display: inline-block!important;
    }
    #mainnav-menu li:hover i, #mainnav-menu .active-link i {
      transform: scale(1.5);
    }
    .fa-naira:before {
      content: "\0020A6";
    }

    @media (max-width: 992px) {
      #container.mainnav-out #content-container, #container.mainnav-in #mainnav-container {
        left: -220px;  
      }
    }
  </style>
  
      <script type='text/javascript' src='/plugins/pace/pace.min.js?v=1.1'></script>
          
  </head>
  
   
  <body>
      <div id="container" class="effect mainnav-lg">
          @include('layouts.user.header')  
          <div class="boxed">
  
              <!--CONTENT CONTAINER-->
              
              <div id="content-container">
                  
                  <!--Page Title-->
                  <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                  <div id="page-title">
                      <h1 class="page-header text-overflow">@yield('title')</h1>
                  </div>
                  <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                  <!--End page title-->
  
                  <!--Page content-->
                  
                  <div id="page-content">
                      @yield('page-content')
              </div>
              
              <!--END CONTENT CONTAINER-->
              @if(Auth::user()->role == 'admin')
                @include('layouts.admin.nav')  
              @elseif(Auth::user()->role == 'premium')
                @include('layouts.premium.nav') 
              @else
                @include('layouts.user.nav')  
              @endif
          </div>
          @include('layouts.user.footer')
      </div>
      
      <!-- END OF CONTAINER -->
      @yield('scripts')      
      <script src="{{ asset('js/toastr.min.js') }}"></script>
      <script>
          @if(Session::has('success'))
              toastr.success("{{ Session::get('success') }}")
          @endif

          @if(Session::has('error'))
              toastr.error("{{ Session::get('error') }}")
          @endif
          
          @if(Session::has('info'))
              toastr.info("{{ Session::get('info') }}")
          @endif
      </script>
  </body>
  </html>
  