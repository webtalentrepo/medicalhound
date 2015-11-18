<?php
function shortcode_ult_video($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'width'=>'600',
		'height'=>'400',
       	'uri'=>get_bloginfo('url'),
	), $atts));

$values = array (

//youtube.com
array('/youtube.*v=([^&]*)/i', '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/{ID_VIDEO}?&wmode=transparent&amp;rel=0" frameborder="0" allowfullscreen></iframe>'),
array('/youtube.*?p=(.*)/i', '<object width="'.$width.'" height="'.$height.'"><param name="wmode" value="transparent"></param><param name="movie" value="http://www.youtube.com/p/{ID_VIDEO}?hl=es_ES&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/p/{ID_VIDEO}?hl=es_ES&fs=1" wmode="transparent" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowscriptaccess="always" allowfullscreen="true"></embed></object>'),
array('/youtu\.be\/(.*)/i', '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/{ID_VIDEO}?&wmode=transparent&amp;rel=0" frameborder="0" allowfullscreen></iframe>'),

//video.google.com
array('/video.google.*docid=([^&]*)/i', '<embed id="VideoPlayback" style="width:'.$width.'px;height:'.$height.'px" allowFullScreen="true" flashvars="fs=true" wmode="transparent" src="http://video.google.com/googleplayer.swf?docid={ID_VIDEO}" type="application/x-shockwave-flash"></embed>'),

//dailymotion.com
array('/dailymotion\.com\/video\/([^_]*)/i', '<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/{ID_VIDEO}"></iframe>'),

//metacafe.com
array('/metacafe\.com\/watch\/(.*)/i', '<div style="background:#000000;width:'.$width.'px;height:'.$height.'px"><embed flashVars="playerVars=showStats=yes|autoPlay=no" src="http://www.metacafe.com/fplayer/{ID_VIDEO}.swf" width="'.$width.'" height="'.$height.'" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_5384657" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed></div>'),

//Myspace
//myspace.com
array('/myspace\.com.*?videoID=([^&]*)/i', '<object width="'.$width.'" height="'.$height.'" ><param name="allowFullScreen" value="true"/><param name="wmode" value="transparent"/><param name="movie" value="http://mediaservices.myspace.com/services/media/embed.aspx/m={ID_VIDEO},t=1,mt=video"/><embed src="http://mediaservices.myspace.com/services/media/embed.aspx/m={ID_VIDEO},t=1,mt=video" width="'.$width.'" height="'.$height.'" allowFullScreen="true" type="application/x-shockwave-flash" wmode="transparent"></embed></object>'),
//vids.myspace.com
array('/vids\.myspace\.com.*?videoID=([^&]*)/i', '<object width="'.$width.'" height="'.$height.'" ><param name="allowFullScreen" value="true"/><param name="wmode" value="transparent"/><param name="movie" value="http://mediaservices.myspace.com/services/media/embed.aspx/m={ID_VIDEO},t=1,mt=video"/><embed src="http://mediaservices.myspace.com/services/media/embed.aspx/m={ID_VIDEO},t=1,mt=video" width="'.$width.'" height="'.$height.'" allowFullScreen="true" type="application/x-shockwave-flash" wmode="transparent"></embed></object>'),
//myspacetv.com
array('/myspacetv\.com.*?videoID=([^&]*)/i', '<object width="'.$width.'" height="'.$height.'"><param name="wmode" value="transparent"/><param name="allowscriptaccess" value="always"/><param name="movie" value="http://lads.myspace.com/videos/vplayer.swf"/><param name="flashvars" value="m={ID_VIDEO}"/><embed src="http://lads.myspace.com/videos/vplayer.swf" width="'.$width.'" height="'.$height.'" flashvars="m={ID_VIDEO}" wmode="transparent" type="application/x-shockwave-flash" allowscriptaccess="always" /></object>'),

array('/myspace\.com.\/video\/([^\/]*)/i', '<object width="'.$width.'" height="'.$height.'" ><param name="allowFullScreen" value="true"/><param name="wmode" value="transparent"/><param name="movie" value="http://mediaservices.myspace.com/services/media/embed.aspx/m={ID_VIDEO},t=1,mt=video"/><embed src="http://mediaservices.myspace.com/services/media/embed.aspx/m={ID_VIDEO},t=1,mt=video" width="'.$width.'" height="'.$height.'" allowFullScreen="true" type="application/x-shockwave-flash" wmode="transparent"></embed></object>'),

//video.yahoo.com
array('/video\.yahoo.*v=([^&]*)/i','<object width="'.$width.'" height="'.$height.'"><param name="wmode" value="transparent"></param><param name="movie" value="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.2" /><param name="allowFullScreen" value="true" /><param name="flashVars" value="id={DOWNLOAD%/so\.addVariable\("id", "(.*?)"\);/%}&vid={ID_VIDEO}&thumbUrl={DOWNLOAD%/so\.addVariable\("thumbUrl", "(.*?)"\);/%}&embed=1" /><embed src="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.2" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" wmode="transparent" allowFullScreen="true" flashVars="id={DOWNLOAD%/so\.addVariable\("id", "(.*?)"\);/%}&vid={ID_VIDEO}&thumbUrl={DOWNLOAD%/so\.addVariable\("thumbUrl", "(.*?)"\);/%}&embed=1" ></embed></object>'),
//video.yahoo.com/watch/
array('/video\.yahoo\.com\/watch\/([^\/]*)/i','<object width="'.$width.'" height="'.$height.'"><param name="wmode" value="transparent"></param><param name="movie" value="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.2" /><param name="allowFullScreen" value="true" /><param name="flashVars" value="id={DOWNLOAD%/so\.addVariable\("id", "(.*?)"\);/%}&vid={ID_VIDEO}&thumbUrl={DOWNLOAD%/so\.addVariable\("thumbUrl", "(.*?)"\);/%}&embed=1" /><embed src="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.2" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" wmode="transparent" allowFullScreen="true" flashVars="id={DOWNLOAD%/so\.addVariable\("id", "(.*?)"\);/%}&vid={ID_VIDEO}&thumbUrl={DOWNLOAD%/so\.addVariable\("thumbUrl", "(.*?)"\);/%}&embed=1" ></embed></object>'),
//video.yahoo new
array ('/video\.yahoo.*-(.*).html/i', '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://d.yimg.com/nl/vyc/site/player.swf?lang=en-US"></param><param name="flashVars" value="browseCarouselUI=hide&repeat=0&vid={ID_VIDEO}&startScreenCarouselUI=hide&lang=en-US&"></param><param name="allowfullscreen" value="true"></param><param name="wmode" value="transparent"></param><embed width="'.$width.'" height="'.$height.'" allowFullScreen="true" src="http://d.yimg.com/nl/vyc/site/player.swf?lang=en-US" type="application/x-shockwave-flash" flashvars="browseCarouselUI=hide&repeat=0&vid={ID_VIDEO}&startScreenCarouselUI=hide&lang=en-US"></embed></object>'),

//megavideo.com
array ('/megavideo.*v=(.*)/i', '<object width="'.$width.'" height="'.$height.'"><param name="wmode" value="transparent"></param><param name="movie" value="http://www.megavideo.com/v/{ID_VIDEO}"></param><param name="allowFullScreen" value="true"></param><embed src="http://www.megavideo.com/v/{ID_VIDEO}" wmode="transparent" type="application/x-shockwave-flash" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>'),

//vimeo.com
array ('/vimeo\.com\/([^&]*)/i', '<iframe src="http://player.vimeo.com/video/{ID_VIDEO}?title=0&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0"></iframe>'),

//gamevideos.1up.com
array ('/gamevideos.1up.com\/video\/id\/(.*)/i', '<div style="width:'.$width.'px; text-align:center"><embed type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" src="http://gamevideos.1up.com/swf/gamevideos12.swf?embedded=1&amp;fullscreen=1&amp;autoplay=0&amp;src=http://gamevideos.1up.com/do/videoListXML%3Fid%3D{ID_VIDEO}%26adPlay%3Dtrue" wmode="transparent" align="middle"></embed></div>'),

//tu.tv
array ('/(tu\.tv)/i', '{DOWNLOAD%/<input name="html".*value=\'(.*?)\'/%}'),

//godtube.com
array ('/godtube\.com.*v=(.*)/i', '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://www.godtube.com/resource/mediaplayer/5.3/player.swf"><param name="movie" value="http://www.godtube.com/resource/mediaplayer/5.3/player.swf"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="always"><param name="wmode" value="opaque"><param name="flashvars" value="file=http://www.godtube.com/resource/mediaplayer/{ID_VIDEO}.file&image=http://www.godtube.com/resource/mediaplayer/{ID_VIDEO}.jpg&screencolor=000000&type=video&autostart=false&playonce=true&skin=http://www.godtube.com//resource/mediaplayer/skin/carbon/carbon.zip&logo.file=http://media.salemwebnetwork.com/godtube/theme/default/media/embed-logo.png&logo.link=http://www.godtube.com/watch/%3Fv%3D{ID_VIDEO}&logo.position=top-left&logo.hide=false&controlbar.position=over"></object>'),

//myvideo.de
array ('/myvideo\.de\/watch\/(.*)\//i', '<object style="width:'.$width.'px;height:'.$height.'px;" width="'.$width.'" height="'.$height.'" data="http://www.myvideo.de/movie/{ID_VIDEO}"><param name="wmode" value="transparent"></param><embed src="http://www.myvideo.de/movie/{ID_VIDEO}" width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" allowfullscreen="true"></embed><param name="movie" value="http://www.myvideo.de/movie/{ID_VIDEO}"/><param name="AllowFullscreen" value="true"></param><param name="AllowScriptAccess" value="always"></param></object>'),

//collegehumor.com/video:*
array ('/collegehumor\.com\/video:(.*)/i', '<object type="application/x-shockwave-flash" data="http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id={ID_VIDEO}&fullscreen=1" width="'.$width.'" height="'.$height.'" ><param name="wmode" wmode="transparent" value="transparent"></param><param name="allowfullscreen" value="true" /><param name="movie" quality="best" value="http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id={ID_VIDEO}&fullscreen=1" /></object>'),
//collegehumor.com/video/*/tittleofvideo
array ('/collegehumor\.com\/video\/(.*)\/*/i', '<object id="ch6478387" type="application/x-shockwave-flash" data="http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id={ID_VIDEO}&use_node_id=true&fullscreen=1" width="'.$width.'" height="'.$height.'"><param name="allowfullscreen" value="true"/><param name="wmode" value="transparent"/><param name="allowScriptAccess" value="always"/><param name="movie" quality="best" value="http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id={ID_VIDEO}&use_node_id=true&fullscreen=1"/><embed src="http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id={ID_VIDEO}&use_node_id=true&fullscreen=1" type="application/x-shockwave-flash" wmode="transparent" width="'.$width.'" height="'.$height.'" allowScriptAccess="always"></embed></object>'),

//comedycentral.com
array ('/comedycentral.*videoId=([^&]*)/i', '<embed style="display:block" src="http://media.mtvnservices.com/mgid:cms:item:comedycentral.com:{ID_VIDEO}" width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" wmode="window" allowFullscreen="true" flashvars="autoPlay=false" allowscriptaccess="always" allownetworking="all" bgcolor="#000000"></embed>'),

//revver.com
array ('/revver\.com\/video\/([^\/]*)/i', '<script src="http://flash.revver.com/player/1.0/player.js?mediaId:{ID_VIDEO};width:'.$width.';height:'.$height.';" type="text/javascript"></script>'),

//clipfish.de
array ('/clipfish\.de\/video\/([^\/]*)/i', '<object codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'.$width.'" height="'.$height.'" ><param name="wmode" value="transparent"></param><param name="allowScriptAccess" value="always" /><param name="movie" value="http://www.clipfish.de/cfng/flash/clipfish_player_3.swf?as=0&vid={ID_VIDEO}&r=1&area=e&c=990000" /> <param name="bgcolor" value="#ffffff" /> <param name="allowFullScreen" value="true" /> <embed src="http://www.clipfish.de/cfng/flash/clipfish_player_3.swf?as=0&vid={ID_VIDEO}&r=1&area=e&c=990000" quality="high" bgcolor="#990000" width="'.$width.'" height="'.$height.'" name="player" align="middle" allowFullScreen="true" allowScriptAccess="always" type="application/x-shockwave-flash" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed></object>'),

//aniboom.com
array ('/aniboom\.com\/animation-video\/([^\/]*)/i', '<object width="'.$width.'" height="'.$height.'"><param name="wmode" value="transparent"></param><param name="movie" value="http://api.aniboom.com/e/{ID_VIDEO}" /><param name="allowScriptAccess" value="sameDomain" /><param name="allowfullscreen" value="true" /><param name="quality" value="high" /><embed src="http://api.aniboom.com/e/{ID_VIDEO}" quality="high"  width="'.$width.'"  height="'.$height.'" wmode="transparent" allowscriptaccess="sameDomain" allowfullscreen="true" type="application/x-shockwave-flash"></embed></object>'),

//facebook.com
array ('/facebook.*v=([^&]*)/i', '<object type="application/x-shockwave-flash"
data="http://www.facebook.com/v/{ID_VIDEO}\" width="'.$width.'" height="'.$height.'"><param name="wmode" value="transparent"></param><param name="autostart" value="false" /><param
name="movie" value="http://www.facebook.com/v/{ID_VIDEO}" /></object>'),

//funnyordie.com
array ('/funnyordie\.com\/videos\/(.*)\//i', '<object width="'.$width.'" height="'.$height.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="ordie_player_ef76e75bcf"><param name="wmode" value="transparent"></param><param name="movie" value="http://player.ordienetworks.com/flash/fodplayer.swf" /><param name="flashvars" value="key={ID_VIDEO}" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always"></param><embed width="'.$width.'" height="'.$height.'" flashvars="key={ID_VIDEO}" wmode="transparent" allowfullscreen="true" allowscriptaccess="always" quality="high" src="http://player.ordienetworks.com/flash/fodplayer.swf" name="ordie_player_{ID_VIDEO}" type="application/x-shockwave-flash"></embed></object>'),

//dotsub.com
array ('/dotsub\.com\/view\/(.*)/i', '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" id="mpl" name="mpl" data="http://dotsub.com/static/players/portalplayer.swf?v=2886"><param name="wmode" value="transparent"></param><param name="swliveconnect" value="true"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="flashvars" value="uuid={ID_VIDEO}&amp;lang=spa&amp;type=flv&amp;plugins=dotsub&amp;tid=UA-3684979-1&amp;debug=none&amp;embedded=false"></object>'),

//dorkly.com
array ('/dorkly\.com\/video\/(.*)\//i', '<object type="application/x-shockwave-flash" data="http://www.dorkly.com/moogaloop/noobtube.swf?clip_id={ID_VIDEO}&fullscreen=1" width="'.$width.'" height="'.$height.'"><param name="allowfullscreen" value="true"/><param name="wmode" value="transparent"/><param name="allowScriptAccess" value="always"/><param name="movie" quality="best" value="http://www.dorkly.com/moogaloop/noobtube.swf?clip_id={ID_VIDEO}&fullscreen=1"/><embed src="http://www.dorkly.com/moogaloop/noobtube.swf?clip_id={ID_VIDEO}&fullscreen=1" type="application/x-shockwave-flash" wmode="transparent" width="'.$width.'" height="'.$height.'" allowScriptAccess="always"></embed></object>'),

//scribd.com
array ('/cribd\.com\/doc\/([^\/]*)/i', '<object height="'.$height.'" width="'.$width.'" type="application/x-shockwave-flash" data="http://d1.scribdassets.com/ScribdViewer.swf" style="outline:none;" ><param name="movie" value="http://d1.scribdassets.com/ScribdViewer.swf"><param name="wmode" value="opaque"> <param name="bgcolor" value="#ffffff"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="FlashVars" value="document_id={ID_VIDEO}&access_key=key-w2khk4pt761e0d60hb2&page=1&viewMode=slideshow"><embed src="http://d1.scribdassets.com/ScribdViewer.swf?document_id={ID_VIDEO}&access_key=key-w2khk4pt761e0d60hb2&page=1&viewMode=slideshow" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" height="'.$height.'" width="'.$width.'" wmode="opaque" bgcolor="#ffffff"></embed></object>'),

//justin.tv
array ('/justin\.tv\/(.*)/i', '<object type="application/x-shockwave-flash" height="'.$height.'" width="'.$width.'" id="live_embed_player_flash" data="http://www.justin.tv/widgets/live_embed_player.swf?channel={ID_VIDEO}" bgcolor="#000000"><param name="wmode" value="transparent"></param><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://www.justin.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="channel={ID_VIDEO}&auto_play=false&start_volume=25" /></object>'),

//citytv.com.co
array ('/citytv\.com\.co\/videos\/(.*)\//i', '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,115,0" id="videocom_{ID_VIDEO}" height="'.$height.'" width="'.$width.'"><param name="movie" value="http://www.citytv.com.co/media/swf/Videocom.swf"></param><param name="allowfullscreen" value="true"></param><param name="allowscriptaccess" value="always"></param><param name="flashvars" value="videoID={ID_VIDEO}&showTools=false&autoPlay=false"></param><param name=wmode value=transparent></param><embed wmode=transparent name="videocom_{ID_VIDEO}" src="http://www.citytv.com.co/media/swf/Videocom.swf"  flashvars= "videoID={ID_VIDEO}&showTools=false&autoPlay=false" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" height="'.$height.'" width="'.$width.'"/></embed></object>'),

array ('/citytv\.com\.co\/videos\/(.*)/i', '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,115,0" id="videocom_{ID_VIDEO}" height="'.$height.'" width="'.$width.'"><param name="movie" value="http://www.citytv.com.co/media/swf/Videocom.swf"></param><param name="allowfullscreen" value="true"></param><param name="allowscriptaccess" value="always"></param><param name="flashvars" value="videoID={ID_VIDEO}&showTools=false&autoPlay=false"></param><param name=wmode value=transparent></param><embed wmode=transparent name="videocom_{ID_VIDEO}" src="http://www.citytv.com.co/media/swf/Videocom.swf"  flashvars= "videoID={ID_VIDEO}&showTools=false&autoPlay=false" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" height="'.$height.'" width="'.$width.'"/></embed></object>'),

//snotr.com
array ('/snotr\.com\/video\/(.*)\//i', '<iframe src="http://www.snotr.com/embed/{ID_VIDEO}" width="'.$width.'" height="'.$height.'" frameborder="0"></iframe>'),

//videobb.com
array ('/videobb\.com\/watch_video.*v=(.*)/i', '<object id="player" width="'.$width.'" height="'.$height.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ><param name="movie" value="http://www.videobb.com/e/{ID_VIDEO}" ></param><param name="allowFullScreen" value="true" ></param><param name="allowscriptaccess" value="always"></param><param name=wmode value=transparent></param><embed src="http://www.videobb.com/e/{ID_VIDEO}" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>'),
array ('/videobb\.com\/video\/(.*)/i', '<object id="player" width="'.$width.'" height="'.$height.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ><param name="movie" value="http://www.videobb.com/e/{ID_VIDEO}" ></param><param name="allowFullScreen" value="true" ></param><param name="allowscriptaccess" value="always"></param><param name=wmode value=transparent></param><embed src="http://www.videobb.com/e/{ID_VIDEO}" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>'),
array ('/videobb\.com\/f\/([^.]*)/i', '<object id="player" width="'.$width.'" height="'.$height.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ><param name="movie" value="http://www.videobb.com/e/{ID_VIDEO}" ></param><param name="allowFullScreen" value="true" ></param><param name="allowscriptaccess" value="always"></param><param name=wmode value=transparent></param><embed src="http://www.videobb.com/e/{ID_VIDEO}" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>'),
// videobb.com /e/ (par Antoine)
array ('/videobb\.com\/e\/(.+)/i', '<object id="player" width="'.$width.'" height="'.$height.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ><param name="movie" value="http://www.videobb.com/e/{ID_VIDEO}" ></param><param name="allowFullScreen" value="true" ></param><param name="allowscriptaccess" value="always"></param><param name=wmode value=transparent></param><embed src="http://www.videobb.com/e/{ID_VIDEO}" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>'),
// videobb.com /f/ (par Antoine)
array ('/videobb\.com\/f\/(.+)(\.swf)?/Ui', '<object id="player" width="'.$width.'" height="'.$height.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ><param name="movie" value="http://www.videobb.com/e/{ID_VIDEO}" ></param><param name="allowFullScreen" value="true" ></param><param name="allowscriptaccess" value="always"></param><param name=wmode value=transparent></param><embed src="http://www.videobb.com/e/{ID_VIDEO}" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>'),
// videobb.com /player/player.swf (par Antoine)
array ('/(videobb\.com\/player.*)/si', '<object id="player" width="'.$width.'" height="'.$height.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ><param name="movie" value="http://www.{ID_VIDEO}" ></param><param name="allowFullScreen" value="true" ></param><param name="allowscriptaccess" value="always"></param><param name=wmode value=transparent></param><embed src="http://www.{ID_VIDEO}" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>'),

// wat.tv  (par Antoine)
array ('/wat\.tv\/swf2\/[0-9A-Za-z]{19}/si', ' <object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.wat.tv/swf2/{ID_VIDEO}" /><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="true" /><embed src="http://www.wat.tv/swf2/{ID_VIDEO}" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowScriptAccess="always" allowFullScreen="true"></embed></object> '),

//videozer.com
array ('/videozer\.com\/video\/(.*)/i', '<object id="player" width="'.$width.'" height="'.$height.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ><param name="movie" value="http://videozer.com/embed/{ID_VIDEO}" ></param><param name="allowFullScreen" value="true" ></param><param name="allowscriptaccess" value="always"></param><param name=wmode value=transparent></param><embed src="http://videozer.com/embed/{ID_VIDEO}" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>'),

//novamov.com
array ('/novamov\.com\/video\/(.*)/i', '<iframe style="overflow: hidden; border: 0; width: '.$width.'px; height: '.$height.'px" src="http://embed.novamov.com/embed.php?width='.$width.'&height='.$height.'&v={ID_VIDEO}&px=1" scrolling="no"></iframe>'),

//youku.com
array ('/v\.youku\.com\/v_show\/id_(.*)\.html/i', '<embed src="http://player.youku.com/player.php/sid/{ID_VIDEO}/v.swf" quality="high" width="'.$width.'" height="'.$height.'" align="middle" allowScriptAccess="sameDomain" wmode="transparent" type="application/x-shockwave-flash"></embed>'),

//vxv.com
array ('/vxv\.com\/video\/(.*)\//i', '<object height="'.$height.'" width="'.$width.'" name="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="player"> <param value="http://www.vxv.com/e/{ID_VIDEO}" name="movie"><param value="true" name="allowfullscreen"><param value="always" name="allowscriptaccess"><embed height="'.$height.'" width="'.$width.'" allowfullscreen="true" wmode="transparent" allowscriptaccess="always" src="http://www.vxv.com/e/{ID_VIDEO}" name="player2" id="player2" type="application/x-shockwave-flash"></object>'),
      
//clipshack.com
array ('/clipshack\.com\/Clip.aspx(.*)/i', '<embed src="http://www.clipshack.com/player.swf{ID_VIDEO}" width="'.$width.'" height="'.$height.'" wmode="transparent"></embed>'),

//putlocker.com
array ('/putlocker\.com\/file\/(.*)/i', '<iframe src="http://www.putlocker.com/embed/{ID_VIDEO}" width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no"></iframe>'),

//userporn.com
array ('/userporn\.com\/video\/(.*)/i', '<object id="player" width="'.$width.'" height="'.$height.'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ><param name="movie" value="http://www.userporn.com/e/{ID_VIDEO}" ></param><param name="allowFullScreen" value="true" ></param><param name="allowscriptaccess" value="always"></param><param name="wmode" value="transparent"></param><embed src="http://www.userporn.com/e/{ID_VIDEO}" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>'),

//megaporn.com
array ('/megaporn.*v=(.*)/i', '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.megaporn.com/e/{ID_VIDEO}"></param><param name="allowFullScreen" value="true"></param><param name="wmode" value="transparent"></param><embed src="http://www.megaporn.com/e/{ID_VIDEO}" type="application/x-shockwave-flash" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>'),

//uploadc.com
array ('/uploadc\.com\/([^\/]*)/i', '<IFRAME SRC="http://www.uploadc.com/embed-{ID_VIDEO}.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO width='.$width.' height='.$height.'></IFRAME>'),

//ovfile.com
array ('/ovfile\.com\/(.*)/i', '<IFRAME SRC="http://ovfile.com/embed-{ID_VIDEO}.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO width='.$width.' height='.$height.'></IFRAME>'),

//veevr.com
array ('/veevr\.com\/videos\/(.*)/i', '<iframe src="http://veevr.com/embed/{ID_VIDEO}?w='.$width.'&h='.$height.'" width="'.$width.'" height="'.$height.'" scrolling="no" frameborder="0"></iframe>'),

//divxstage.eu
array ('/divxstage\.eu\/video\/(.*)/i', '<iframe style="overflow: hidden; border: 0; width: '.$width.'px; height: '.$height.'px" src="http://embed.divxstage.eu/embed.php?v={ID_VIDEO}&width='.$width.'&height='.$height.'" scrolling="no"></iframe>'),

//usershare.net
array ('/usershare\.net\/(.*)\//i', '<IFRAME SRC="http://www.usershare.net/embedmp4-{ID_VIDEO}.html" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO WIDTH='.$width.' HEIGHT='.$height.'></IFRAME>'),

//sockshare.com
array ('/sockshare\.com\/file\/(.*)/i', '<iframe src="http://www.sockshare.com/embed/{ID_VIDEO}" width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no"></iframe>'),

//blip.tv
array ('/blip.*-(.*)/i', '<object id="player" width="'.$width.'" height="'.$height.'"><param name="movie" value="http://blip.tv/scripts/flash/showplayer.swf?file=http://blip.tv/rss/flash/{ID_VIDEO}" ></param><param name="allowFullScreen" value="true" ></param><param name="allowscriptaccess" value="always"></param><param name=wmode value=transparent></param><embed src="http://blip.tv/scripts/flash/showplayer.swf?file=http://blip.tv/rss/flash/{ID_VIDEO}" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowscriptaccess="always" allowfullscreen="true" /></embed></object>'),

//veoh.com
array ('/veoh\.com\/watch\/(.*)/i', '<object width="410" height="341" id="veohFlashPlayer" name="veohFlashPlayer"><param name="movie" value="http://www.veoh.com/swf/webplayer/WebPlayer.swf?version=AFrontend.5.7.0.1144&permalinkId={ID_VIDEO}&player=videodetailsembedded&videoAutoPlay=0&id=anonymous"></param><param name="allowFullScreen" value="true"></param><param name="wmode" value="transparent"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.veoh.com/swf/webplayer/WebPlayer.swf?version=AFrontend.5.7.0.1144&permalinkId={ID_VIDEO}&player=videodetailsembedded&videoAutoPlay=0&id=anonymous" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$width.'" height="'.$height.'" id="veohFlashPlayerEmbed" name="veohFlashPlayerEmbed"></embed></object>'),

//zappinternet.com
array ('/zappinternet\.com\/video\/([^\/]*)/i', '<object type="application/x-shockwave-flash" data="http://zappinternet.com/v/{ID_VIDEO}" height="'.$height.'" width="'.$width.'"><param name="movie" value="http://zappinternet.com/v/KaZxBojJov" /><param name="wmode" value="transparent"></param><param name="allowFullScreen" value="true" /></object>'),
//zappin.me
array ('/zappin\.me\/([^\/]*)/i', '<object type="application/x-shockwave-flash" data="http://zappinternet.com/v/{ID_VIDEO}" height="'.$height.'" width="'.$width.'"><param name="wmode" value="transparent"></param><param name="movie" value="http://zappinternet.com/v/KaZxBojJov" /><param name="allowFullScreen" value="true" /></object>'),

//liveleak.com
array ('/liveleak.*=(.*)/i', '<object width="'.$width.'" height="'.$height.'"><param name="movie" value="http://www.liveleak.com/e/{ID_VIDEO}"></param><param name="wmode" value="transparent"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.liveleak.com/e/{ID_VIDEO}" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" width="'.$width.'" height="'.$height.'"></embed></object>'),

//dalealplay.com
array ('/dalealplay.*=(.*)/i', '<object width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://c.brightcove.com/services/viewer/federated_f9?&amp;width='.$width.'&amp;height='.$height.'&amp;flashID=reproductor&amp;wmode=transparent&amp;playerID=81909921001&amp;publisherID=35140843001&amp;isVid=true&amp;isUI=true&amp;experienceID=reproductor&amp;videoSmoothing=true&amp;sct=sports&amp;pb=ZOO%3A100&amp;optimizedContentLoad=true&amp;%40videoPlayer=ref%3ADAP-{ID_VIDEO}&amp;autoStart=0" seamlesstabbing="false"><param name="allowScriptAccess" value="always"></param><param name="allowFullScreen" value="true"></param><param name="seamlessTabbing" value="false"></param><param name="swliveconnect" value="true"></param><param name="wmode" value="transparent"></param><param name="quality" value="high"></param></object>'),

//stagevu.com
array ('/stagevu\.com\/video\/(.*)/i', '<iframe src="http://stagevu.com/embed?width='.$width.'&amp;height='.$height.'&amp;background=000&amp;uid={ID_VIDEO}" width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no"></iframe>'),

//flickr.com
array ('/flickr\.com\/photos\/.*?\/([^\/]*)\//i', '<object type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" data="http://www.flickr.com/apps/video/stewart.swf?v=71377" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"> <param name="flashvars" value="photo_id={ID_VIDEO}"></param> <param name="movie" value="http://www.flickr.com/apps/video/stewart.swf?v=71377"></param> <param name="bgcolor" value="#000000"></param> <param name="allowFullScreen" value="true"></param><embed type="application/x-shockwave-flash" src="http://www.flickr.com/apps/video/stewart.swf?v=71377" bgcolor="#000000" allowfullscreen="true" flashvars="photo_id={ID_VIDEO}" height="'.$height.'" width="'.$width.'"></embed></object>'),


);

	foreach ($values as $value){
	if (preg_match($value[0], $content, $matches)){
	$id_video=$matches[1];
	return preg_replace_callback('/{.*?}/', create_function('$matches', 'switch (true){
	case preg_match("/\{ID_VIDEO\}/", $matches[0]):
	return "'.$id_video.'";
	break;
	case preg_match("/\{LINK\}/", $matches[0]):
	return "'.$content.'";
	break;
	case preg_match("/\{DOWNLOAD(.*?)%(.*?)%(.*?)\}/", $matches[0], $matches2):
	if (empty($matches2[1])) $matches2[1]="'.$content.'";
	preg_match($matches2[2], file_get_contents(str_replace(" ","+",$matches2[1])), $matches3);
	if (empty($matches2[3])){
	return $matches3[1];
	}else{
	$t=$matches3[1];
	foreach(explode("|", $matches2[3]) as $e){
	eval(\'$t=\'.$e.\'($t);\');
	}
	return $t;
	}
	break;
	}
	return $matches[0];'), $value[1]);
	}
	}
	if(preg_match('/.swf/i',$content)){
		return <<<HTML
<div class="video">
<object classs="flash" width="{$width}" height="{$height}" type="application/x-shockwave-flash" data="{$content}">
	<param name="movie" value="{$content}" />
	<param name="allowFullScreen" value="true" />
	<param name="allowscriptaccess" value="always" />
	<param name="expressInstaller" value="{$uri}/swf/expressInstall.swf"/>
	<param name="play" value="false"/>
	<param name="wmode" value="opaque" />
	<embed src="$content" type="application/x-shockwave-flash" wmode="opaque" allowscriptaccess="always" allowfullscreen="true" width="{$width}" height="{$height}" />
</object>
</div>
HTML;
	}
	
	return '<div id="mvtalert">Sorry, site not recognized</div>';
}
add_shortcode('ult_video', 'shortcode_ult_video');
?>