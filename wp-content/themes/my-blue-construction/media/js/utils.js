
var utils = new Object();

utils.feedburner = function( uri ){
    window.open( 'http://feedburner.google.com/fb/a/mailverify?uri=' + uri , 'popupwindow' , 'scrollbars=yes,width=550,height=520' );
    return true;
}

utils.focusEvent = function( obj , text ){
    if( jQuery( obj ).val() == text ) {
        jQuery( obj ).val( '' );
    }
}

utils.blurEvent = function( obj , text ){
    if( jQuery( obj ).val() == '' ) {
        jQuery( obj ).val( text ); 
    }
}

utils.show_comments = function(){
    jQuery(function(){
        jQuery('#pings-list').hide(); 
        jQuery('#paginate-pings').hide();
        jQuery('#comments-list').show(); 
        jQuery('#paginate-comments').show();
        jQuery('#comments-reply').css({'height':25}); 
        jQuery('#pings-reply').css({'height':24}); 
    });
}
utils.show_pings = function(){
    jQuery(function(){
        jQuery('#pings-list').show(); 
        jQuery('#paginate-pings').show(); 
        jQuery('#comments-list').hide();
        jQuery('#paginate-comments').hide();
        jQuery('#comments-reply').css({'height':24}); 
        jQuery('#pings-reply').css({'height':25});
    });
}