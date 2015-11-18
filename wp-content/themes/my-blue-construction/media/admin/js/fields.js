fields = new Object();

fields.initInputSearch = function(){
    jQuery(function(){
        jQuery('input.my-field-search').each(function(){
            var self = this;
            jQuery( self ).autocomplete({ 
                serviceUrl: ajaxurl + '?action=search&params=' + jQuery( self ).parent().children('input.my-field-params').val(), 
                minChars:1,
                delimiter: /(,|;)\s*/, 
                maxHeight:400, 
                width:300, 
                zIndex: 9999, 
                deferRequestBy: 0, 
                noCache: false, 
                onSelect: function( value , data){
                    jQuery(function(){
                        jQuery( self ).parent().children( 'input.my-field-search-postID' ).val( data );
                    });
                }
            });
        });
    });
}

fields.initInputDigit = function(){
    jQuery(function(){
        jQuery('input[type="text"].my-field-digit').bind( 'keyup' , function(){
            var value = jQuery( this ).val()
            jQuery( this ).val( value.replace( /[^\d|\.|\,]/g , '' ) );
        });    
    });
}

fields.initInputPickColor = function(){
    jQuery(function(){
        jQuery('input.my-field.my-field-pickColor').each(function( index ) {
            var farbtastic;
            var $obj = this;
            (function(jQuery){
                var pickColor = function( a ) {
                    farbtastic.setColor( a );
                    jQuery( '#my-field-' + jQuery( $obj ).attr( 'op_name' ) ).val( a );
                    jQuery( '#link-pick-' + jQuery( $obj ).attr( 'op_name' ) ).css( 'background-color' , a );
                };

                jQuery(document).ready( function() {

                    farbtastic = jQuery.farbtastic( '#color-panel-'  + jQuery( $obj ).attr( 'op_name' ) , pickColor );

                    pickColor( jQuery( '#my-field-' + jQuery( $obj ).attr( 'op_name' ) ).val() );

                    jQuery( '#link-pick-' + jQuery( $obj ).attr( 'op_name' ) ).click( function( e ) {
                        jQuery( '#color-panel-'  + jQuery( $obj ).attr( 'op_name' ) ).show();
                        e.preventDefault();
                    });

                    jQuery( '#my-field-' + jQuery( $obj ).attr( 'op_name' ) ).keyup( function() {
                        var a = jQuery( '#pick-' + jQuery($obj).attr('op_name') ).val(),
                            b = a;

                        a = a.replace( /[^a-fA-F0-9]/ , '');
                        if ( '#' + a !== b )
                            jQuery( '#my-field-' + jQuery($obj).attr( 'op_name' ) ).val( a );
                        if ( a.length === 3 || a.length === 6 )
                            pickColor( '#' + a );
                    });

                    jQuery(document).mousedown( function() {
                        jQuery('#color-panel-'  + jQuery( $obj ).attr( 'op_name' ) ).hide();
                    });
                });
            })(jQuery);
        });
    });
}

fields.upload = function( selector ){
    deleteUserSetting('uploader');
    setUserSetting('uploader', '1');

    jQuery(document).ready(function() {
        (function(){
            var tb_show_temp = window.tb_show;
            window.tb_show = function(){
                tb_show_temp.apply( null , arguments);
                jQuery('#TB_iframeContent').load(function(){
                    jQuery( this ).contents().find('p.upload-html-bypass').remove();
                    jQuery( this ).contents().find('div#html-upload-ui').show();
                    $container = jQuery( this ).contents().find('tr.submit td.savesend');
                    var sid = '';
                    $container.find('div.del-attachment').each(function(){
                        var $div = jQuery(this);
                        sid = $div.attr('id').toString();
                        if( typeof sid != "undefined" ){
                            sid = sid.replace(/del_attachment_/gi , "" );
                            jQuery(this).parent('td.savesend').html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                        }else{
                            var $submit = $container.find('input[type="submit"]');
                            sid = $submit.attr('name');
                            if( typeof sid != "undefined" ){
                                sid = sid.replace(/send\[/gi , "" );
                                sid = sid.replace(/\]/gi , "" );
                                $container.html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                            }
                        }
                    });

                    $container.find('input[type="submit"]').click(function(){
                        $my_submit = jQuery( this );
                        sid = $my_submit.attr('name');
                        if( typeof sid != "undefined" ){
                            sid = sid.replace(/send\[/gi , "" );
                            sid = sid.replace(/\]/gi , "" );
                        }else{
                            sid = 0;
                        }
                        var html = $my_submit.parent('td').parent('tr').parent('tbody').parent('table').html();
                        
                        window.send_to_editor = function() {
                            var attach_url = jQuery( 'input[name="attachments['+sid+'][url]"]' , html ).val();
                            jQuery( selector ).val( attach_url );
                            tb_remove();
                        }
                    });
                });

            }})()

            formfield = jQuery( selector ).attr('name');
            tb_show('', 'media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true');
            return false;
    });
}

fields.uploadID = function( selector , uploadURL ){
	if( uploadURL == "" ){
        tb_show_url = 'media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true&amp;flash=0';
	}else{
        tb_show_url = uploadURL;
	}

    deleteUserSetting('uploader');
    setUserSetting('uploader', '1');
	
    jQuery(document).ready(function() {
        (function(){
            var tb_show_temp = window.tb_show;
            window.tb_show = function(){
                tb_show_temp.apply(null, arguments);
                jQuery('#TB_iframeContent').load(function(){
                    
                    if( jQuery( this ).contents().find('p.upload-html-bypass').length ){
                        jQuery( this ).contents().find('p.upload-html-bypass').remove();
                    }
                    
                    jQuery( this ).contents().find('div#html-upload-ui').show();

                    $container = jQuery( this ).contents().find('tr.submit td.savesend');
                    var sid = '';
                    $container.find('div.del-attachment').each(function(){
                        var $div = jQuery(this);
                        sid = $div.attr('id').toString();
                        if( typeof sid != "undefined" ){
                            sid = sid.replace(/del_attachment_/gi , "" );
                            jQuery(this).parent('td.savesend').html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                        }else{
                            var $submit = $container.find('input[type="submit"]');
                            sid = $submit.attr('name');
                            if( typeof sid != "undefined" ){
                                sid = sid.replace(/send\[/gi , "" );
                                sid = sid.replace(/\]/gi , "" );
                                $container.html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                            }
                        }
                    });

                    $container.find('input[type="submit"]').click(function(){
                        $my_submit = jQuery( this );
                        sid = $my_submit.attr('name');
                        if( typeof sid != "undefined" ){
                                sid = sid.replace(/send\[/gi , "" );
                                sid = sid.replace(/\]/gi , "" );
                        }else{
                            sid = 0;
                        }
                        var html = $my_submit.parent('td').parent('tr').parent('tbody').parent('table').html();
                        window.send_to_editor = function() {
                            var attach_url = jQuery('input[name="attachments['+sid+'][url]"]',html).val();
                            jQuery( selector ).val(  attach_url  );
                            jQuery( selector + '-ID' ).val( sid );

                            if( jQuery( 'img' + selector ).lengt > 0 ){
                                jQuery( 'img' + selector ).attr( "src" ,  attach_url  );
                            }

                            tb_remove();
                        }
                    });
                });

            }})()

        formfield = jQuery( selector ).attr('name');
        tb_show('', tb_show_url);
        return false;
    });
}

fields.clean = function( selector ){
    jQuery(function(){
        jQuery( selector + ' input[type="text"]' ).each(function(){
            jQuery( this ).val('');
        });
        jQuery( selector + ' input[type="hidden"]' ).each(function(){
            jQuery( this ).val('');
        });
        jQuery( selector + ' input[type="checkbox"]' ).each(function(){
            jQuery( this ).removeAttr('checked');
        });
        jQuery( selector + ' select' ).each(function(){
            jQuery( this ).removeAttr('selected');
        });
        jQuery( selector + ' textarea' ).each(function(){
            jQuery( this ).val('');
        });
    });
}

fields.limitString = function( obj , nr ){
    jQuery(function(){
        jQuery( obj ).val( jQuery( obj ).val().substr( 0 , nr ) );
    });
}

fields.limitWords = function( obj , nr ){
    jQuery(function(){
        jQuery( obj ).val( jQuery( obj ).val().split( ',' , nr ) );
    });
} 

fields.check = function( obj , params ){
    jQuery(function(){
        if( jQuery( obj ).is(':checked') ){
            jQuery( obj ).parent().children('input[type="hidden"]').val( 1 );
            jQuery( params.t ).show();
            jQuery( params.f ).hide();
        }else{
            jQuery( obj ).parent().children('input[type="hidden"]').val( 0 );
            jQuery( params.t ).hide();
            jQuery( params.f ).show();
        }
    });
}
/* INIT ALL FIELDS */ 
/* INIT INPUT TYPE DIGIT */
fields.initInputDigit();
fields.initInputSearch();
fields.initInputPickColor();
