<footer class="entry-meta">
            </footer><!-- .entry-meta -->
</article><!-- #post -->

            </main><!-- .site-main -->
        </div>
    </div>
</div><!-- .content-area -->

    </div><!-- .site-content -->
    <footer id="colophon" class="site-footer">
                        <div class="footer-cta-wrap">
                    <div class="container">
                        <div class="footer-cta-inner row">
                            <div class="cms-callout-wrap">
                                
                                <div class="callout-heading pull-left">If you have any query for related investment ... We are Available</div>  
                                
                                <div class="callout-act pull-right">
                                    <a class="cms-button large" href="#" title="Contact Now" target="_blank">Contact Now</a>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        <div id="footer-bottom-wrap" class="footer-bottom-wrap">
            <div class="container">
                <div class="row">
                    <div class=" col-lg-4 col-md-4 col-xs-12">  
                        
                    <aside id="newsletterwidget-2" class="widget widget_newsletterwidget"><h3 class="wg-title">newsletter</h3><form class="cms-newsletter cms-newsletter-1" method="post" onsubmit="return newsletter_check(this)" action="http://demo.farost.net/fcgroup/?na=s">
<input type="hidden" value="widget" name="nr">
<input type="email" name="email" required="" class="newsletter-email" placeholder="Enter your email">
<button type="submit" class="newsletter-submit">Go</button>
</form>

<ul class="address-wrap">
            <li><i class="fa fa-map-marker"></i> No 4a, Volta Crescent, Maitama, FCT Abuja. Nigeria</li>
            <li><i class="fa fa-phone"></i>+2348023616359</li>
            <!--<li><i class="fa fa-envelope"></i> <a href="mailto:info@fcgroup.com">info@fcgroup.com</a></li>-->
          </ul></aside></div><div class=" col-lg-2 col-md-3 col-xs-12"><aside id="nav_menu-2" class="widget widget_nav_menu"><h3 class="wg-title"></h3><div class="menu-our-services-container"><ul id="menu-our-services" class="menu"><li id="menu-item-61" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-61"><a href="{{ route('index') }}" class="">Home</a></li>
<li id="menu-item-62" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-62"><a href="{{ route('about-us') }}" class="">About Us</a></li>
<li id="menu-item-63" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-63"><a href="{{ route('services') }}" class="">Services</a></li>
<li id="menu-item-64" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-64"><a href="{{ route('investment') }}" class="">Investment Plans</a></li>
<!-- <li id="menu-item-65" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-65"><a href="{{ route('index') }}" class="">Home</a></li> -->
</ul></div></aside></div><div class=" col-lg-3 col-md-3 col-xs-12"><aside id="znews-twitter-widget-2" class="widget widget_znews-twitter-widget"><h3 class="wg-title"></h3><div class="news-twitter bxslider nt-layout-default" data-mode="vertical" data-speed="5000" data-auto="0" data-ticker="0" data-minslides="1" data-maxslides="1" data-slidewidth="0" data-controls="0" data-pager="0">

    <div class="news-twitter-item">
        <a href="{{ route('disclaimer') }}">Disclaimer</a><br>  
        <a href="{{ route('privacy') }}">Privacy Policy</a>   
    </div>
</div></aside></div><div class=" col-lg-3 col-md-2 col-xs-12">                                          <div class="copyright-wrap">
                            <div class="logo-footer-wrap">
                                <a href="{{ route('index') }}"><img src="/wp-content/themes/wp-fcgroup/assets/images/footer-logo.png" alt="" /></a>
                            </div>
                            <div class="copyright-inner">
                                Copyright © Trustway Capital {{ strftime("%Y", time()) }}.<br>
All rights reserved.<br></div>
                        </div>
                        <div class="social-indiv-wrap layout-footer"><ul class="social-indiv-inner"><li class="facebook"><a href="http://facebook"><i class="fa fa-facebook"></i></a></li><li class="twitter"><a href="http://twitter" target="_blank"><i class="fa fa-twitter"></i></a></li><li class="linkedin"><a href="http://linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li><li class="google"><a href="http://google" target="_blank"><i class="fa fa-google-plus"></i></a></li></ul></div>                                 </div>                </div>
            </div>
        </div><!-- #footer-bottom -->
    </footer><!-- .site-footer -->

    <style type="text/css">
        .vc_row.wpb_row.vc_row-fluid.vc_custom_1468485865940, .vc_row.wpb_row.vc_row-fluid.vc_row-no-padding.vc_hidden { display: none; }
    </style>
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
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