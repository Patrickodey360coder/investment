(function($){
    $(document).bind('ready ajaxComplete',function(){
       $('.cms-grid-masonry').each(function(){
          $this = $(this);
          $filter = $this.parent().parent().parent().find('.cms-grid-filter');
          $this.imagesLoaded(function(){
            var $current = $this.parent().attr('data-current');
            $this.shuffle({
               itemSelector:'.cms-grid-item',
            });
            if($current != undefined){
              $this.shuffle('shuffle', $current );
            }
          });
          if($filter){
            $filter.find('a').click(function(e){
              e.preventDefault();
              // set active class
              $filter.find('a').removeClass('active');
              $(this).addClass('active');
                   
              // get group name from clicked item
              var groupName = $(this).attr('data-group');
              $this.parent().attr('data-current', groupName);
              if(groupName == undefined){
                $this.parent().attr('data-current', '');
              }
              // reshuffle grid
              $(this).parent().parent().parent().parent().find('.cms-grid-masonry').shuffle('shuffle', groupName );
              return false;
            });
          }
       });  
    });
})(jQuery);