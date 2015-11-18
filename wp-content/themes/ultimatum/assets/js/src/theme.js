function ultimatum_image_hover(elements) {
    if(!elements) elements = jQuery('a.overlayed_image');
    var overlay = "", isMobile 	= 'ontouchstart' in document.documentElement;
    if(isMobile) return;
    elements.on('mouseenter', function(e)
    {
        var link  		= jQuery(this),
            current	 	= link.find('img:first'),
            url		 	= link.attr('href'),
            span_class	= "overlay-type-"+link.attr('data-overlay'),
            opa			= 0.7;

        overlay = link.find('.image-overlay');
        if(!overlay.length)
        {
            if(current.outerHeight() > 50)
            {
                if(!link.css('position') || link.css('position') == 'static') { link.css({ overflow:'hidden',height:'auto',display:'inline'}); }
                overlay = jQuery("<span class='image-overlay "+span_class+"' style='opacity: 0;'><span class='image-overlay-inside'></span></span>").appendTo(link);
            }
        }
        if(current.outerHeight() > 50)
        {
            overlay.css({left:current.position().left + parseInt(current.css("margin-left"),10), top:current.position().top + parseInt(current.css("margin-top"),10)})
                .css({display:'block','height':current.outerHeight(),'width':current.outerWidth()}).stop().animate({opacity:opa}, 400);
        }
        else
        {
            overlay.css({display:"none"});
        }
    }).on('mouseleave', elements, function(){

        if(overlay.length)
        {
            overlay.stop().animate({opacity:0}, 400);
        }
    });
}

jQuery(".ult_button").hover(function() {
    var jQueryhoverBg = jQuery(this).attr('data-hoverBg');
    var jQueryhoverColor = jQuery(this).attr('data-hoverColor');

    if (jQueryhoverBg !== undefined) {
        jQuery(this).css('background-color', jQueryhoverBg);
    }
    if (jQueryhoverColor !== undefined) {
        jQuery('.btn-text', this).css('color', jQueryhoverColor);
    }
}, function() {
    var jQueryhoverBg = jQuery(this).attr('data-hoverBg');
    var jQueryhoverColor = jQuery(this).attr('data-hoverColor');
    var jQuerybg = jQuery(this).attr('data-bg');
    var jQuerycolor = jQuery(this).attr('data-color');

    if (jQueryhoverBg !== undefined) {
        if (jQuerybg !== undefined) {
            jQuery(this).css('background-color', jQuerybg);
        } else {
            jQuery(this).css('background-color', '');
        }
    }
    if (jQueryhoverColor !== undefined) {
        if (jQuerycolor !== undefined) {
            jQuery('.btn-text', this).css('color', jQuerycolor);
        } else {
            jQuery('.btn-text', this).css('color', '');
        }
    }
});

/*
PrettyPhoto initializer
 */
jQuery("a[rel^='prettyPhoto']").prettyPhoto({
    animation_speed: "normal",
    default_width: 900,
    default_height: 450,
    theme: pptheme,
    show_title: !1,
    deeplinking: !1,
    social_tools: ""
});
jQuery("a.prettyPhoto").prettyPhoto({
    animation_speed: "normal",
    default_width: 900,
    default_height: 450,
    theme: pptheme,
    show_title: !1,
    deeplinking: !1,
    social_tools: ""
});
/*
Mobile option based menu
 */
jQuery(".ultimatum-responsive-menu").each(function() {
    var form = jQuery(".responsive-nav-form select", this);
    jQuery(form).change(function() {
        window.location = jQuery(this).find("option:selected").val()
    })
});

/*
Menu show hide function
 */
var viewportWidth = jQuery(window).width();
jQuery(".ultimatum-menu-container").each(function() {
    var width = jQuery(this).attr("data-menureplacer");
    if(width >= viewportWidth){
        jQuery(".ultimatum-regular-menu", this).hide();
        jQuery(".ultimatum-responsive-menu", this).show();
        jQuery(".slicknav_menu", this).show();
    } else {
        jQuery(".ultimatum-regular-menu", this).show();
        jQuery(".ultimatum-responsive-menu", this).hide();
        jQuery(".slicknav_menu", this).hide();
    }
});
jQuery(window).resize(function() {
    viewportWidth = jQuery(window).width();
    jQuery(".ultimatum-menu-container").each(function() {
        var width = jQuery(this).attr("data-menureplacer");
       if(width >= viewportWidth){
           jQuery(".ultimatum-regular-menu", this).hide();
           jQuery(".ultimatum-responsive-menu", this).show();
           jQuery(".slicknav_menu", this).show();
       }else {
           jQuery(".ultimatum-regular-menu", this).show();
           jQuery(".ultimatum-responsive-menu", this).hide();
           jQuery(".slicknav_menu", this).hide();
       }
    })
});

jQuery(function() {
    jQuery(".accordion").on("show", function(e) {
        jQuery(e.target).prev(".accordion-heading").find(".accordion-toggle").addClass("active")
    });
    jQuery(".accordion").on("hide", function(e) {
        jQuery(this).find(".accordion-toggle").not(jQuery(e.target)).removeClass("active")
    });
    jQuery('.accordion .panel-heading a[data-toggle="collapse"]').on("click", function() {
        jQuery('.accordion .panel-heading a[data-toggle="collapse"]').removeClass("active"), jQuery(this).addClass("active")
    })
});

jQuery(document).ready(function() {
    ultimatum_image_hover();
    jQuery(".ui-tabs-nav li").click(function() {
        setTimeout(function() {
            jQuery(window).trigger("resize")
        }, 300)
    });
    jQuery.isFunction(jQuery.fn.fitVids) && jQuery(".fitVideo").fitVids()
});
jQuery(document).ready(function($) {

    var footer = 'footer.footwrapper';
    var header = 'header.headwrapper';
    var bodywrap = 'div.bodywrapper';
    if($('#wpadminbar').length) {
        var headht = $(header).outerHeight(true) + $('#wpadminbar').outerHeight(true);
    }
    else {
        var headht = $(header).outerHeight(true);
    }
    var bodyht = $(bodywrap).outerHeight(true);

    var footerht = $(footer).outerHeight(true);

    var pageht = headht + bodyht + footerht;

    var bodylast =  'div.bodywrapper .wrapper:last div[class*=ult-container]';
    var bodylastht = $(bodylast).height();

    function ult_stickyfooter () {
        var stickedfooterht = $(footer).outerHeight(true);
        $(footer).addClass('sticked-footer');
        $(bodywrap).css('margin-bottom',stickedfooterht);
    }
    function ult_stickyheader () {
        var stickedheaderht = $(header).outerHeight(true);
        $(header).addClass('sticked-header');
        if($('#wpadminbar').length) {
            $(header).css('top',$('#wpadminbar').outerHeight(true)+'px')
        }
        $(bodywrap).css('margin-top',stickedheaderht);
    }

    function ult_pushfooter () {
        var browserht = $(window).height();
        var bodyStretch = browserht - pageht;
        if (browserht > pageht) {
            $(bodylast).css('height', bodylastht + bodyStretch);
        }
        else {
            $(bodylast).css('height', bodylastht);
        }
    }
    if($('body.ut-sticky-footer').length) {
        ult_stickyfooter();
        $(window).resize(ult_stickyfooter);
    }
    if($('body.ut-sticky-header').length) {
        ult_stickyheader();
        $(window).resize(ult_stickyheader);
    }
    if($('body.ut-push-footer').length) {
        ult_pushfooter();
        $(window).resize(ult_pushfooter);
    }
});