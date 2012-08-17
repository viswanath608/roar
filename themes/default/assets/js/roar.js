//  Roar
//  @roarforum
//
//  Main JavaScript file
window.jQuery && jQuery(document).ready(function($) {
    //  Store our main objects here
    var $body = $(document.body).addClass('js-enabled');
    var $search = $('.search-link');
    
    //  Handle the crazy full-screen search
    var searchID = 'searching';
    var $searchHTML = '<div id="' + searchID + '" style="display: none"><input></div>';
    $search.click(function() {
        if(!$body.children('#' + searchID).length) {
            $body.append($searchHTML).children('#' + searchID).fadeIn(function() {
                var me = $(this);
                var $input = me.children('input');
                
                $input.focus().blur(function() {
                    me.fadeOut(function() {
                        me.remove();
                    });
                });
            });
        }
        
        return false;
    });
});