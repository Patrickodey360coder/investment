(function ($) {
    "use strict";
    $(document).ready(function(){
        var $menu = $('.nav-menu');
        $menu.find('ul.sub-menu > li').each(function(){
            var $submenu = $(this).find('>ul');
            if($submenu.length == 1){
                $(this).hover(function(){
                    if($submenu.offset().left + $submenu.width() > $(window).width()){
                        $submenu.addClass('back');
                    }else if($submenu.offset().left < 0){
                        $submenu.addClass('back');
                    }
                }, function(){
                    $submenu.removeClass('back');
                });
            }
        });
        /* Menu drop down*/
        $('.nav-menu li.menu-item-has-children > a').after('<span class="cs-menu-toggle"><i class="fa fa-angle-down"></i></span>').parent().addClass('has-title');
        $('.nav-menu ul li.page_item_has_children > a').after('<span class="cs-menu-toggle"><i class="fa fa-angle-down"></i></span>').parent().addClass('has-title');
        $('.cs-menu-toggle').on('click', function(){
            // add class to next ul
            $(this).next().toggleClass('submenu-open');
        });
        // Add class active to nav clicked
        $('.navbar-toggle').on('click', function(){
            $(this).toggleClass('active');
        });
    });

})(jQuery);
