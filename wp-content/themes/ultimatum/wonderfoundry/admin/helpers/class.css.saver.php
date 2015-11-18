<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
 */

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @package  Ultimatum
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.50
 */
class WonderWorksCSS {
	static public function saveCSS($id,$type= null) {
		$content='';
		if(!$type) {
			$type='layout';
			$setter='_'.$id.'_css';
			$css_disabler = getLayoutInfo($id);
		} else {
			$setter='_template_'.$id.'_css';
			$css_disabler = getTemplateInfo($id);
		}
		$option = THEME_SLUG.$setter;
		$data = get_option($option);
		if($css_disabler->dcss == 'yes'){
			unset($data);
		}
		if (is_writable(THEME_CACHE_DIR)) {
			$file = THEME_CACHE_DIR.'/'.$type.'_'.$id.'.css';
			if($data && is_array($data) && count($data)!=0):
                foreach($data as $el=>$values){
                    $cssvar = array(
                        "cssvar1" => "body",
                        "cssvar2" => "#logo-container",
                        "cssvar3" => "h1, h1 a, h1 a:hover, h1 a:visited",
                        "cssvar4" => "h2, h2 a, h2 a:hover, h2 a:visited",
                        "cssvar5" => "h3, h3 a, h3 a:hover, h3 a:visited",
                        "cssvar6" => "h4, h4 a, h4 a:hover, h4 a:visited",
                        "cssvar7" => "h5, h5 a, h5 a:hover, h5 a:visited",
                        "cssvar8" => "h6, h6 a, h6 a:hover, h6 a:visited",
                        "cssvar9" => "a",
                        "cssvar10" => "a:hover",
                        "cssvar11" => ".multi-post-title, .multi-post-title a, .multi-post-title a:hover, .multi-post-title a:visited",
                        "cssvar12" => ".multi-post-title",
                        "cssvar13" => ".post-inner, .post-inner-single",
                        "cssvar14" => ".post-inner, .post-inner-single",
                        "cssvar15" => ".post-header",
                        "cssvar16" => "div.post-meta",
                        "cssvar17" => ".post-meta",
                        "cssvar18" => ".post-header, .post-header a, .post-header a:hover, .post-header a:visited",
                        "cssvar19" => "div.post-meta, div.post-meta a",
                        "cssvar20" => "div.post-taxonomy span",
                        "cssvar21" => "div.post-taxonomy a",
                        "cssvar22" => "a.readmorecontent",
                        "cssvar23" => "#comments h3, #comments h3 a, #comments h3 a:hover, #comments h3 a:visited",
                        "cssvar24" => ".comment-author, .comment-author a, .comment-author a:hover, .comment-author a:visited",
                        "cssvar25" => ".comment-meta a",
                        "cssvar26" => ".comment-content",
                        "cssvar27" => "a.comment-reply-link, a.cancel-comment-reply-link",
                        "cssvar28" => "h3.respond, h3.respond a, h3.respond a:hover, h3.respond a:visited",
                        "cssvar29" => "form#commentform label",
                        "cssvar30" => "div.breadcrumbs-plus p span, div.breadcrumbs-plus p, div.breadcrumbs-plus p a",
                        "cssvar31" => "div.breadcrumbs-plus p span.breadcrumbs-title",
                        "cssvar32" => "div.breadcrumbs-plus p strong",
                        "cssvar33" => ".wp-pagenavi a, .wp-pagenavi span",
                        "cssvar34" => ".wp-pagenavi span.current",
                        "cssvar35" => "div.wp-pagenavi a, div.wp-pagenavi span",
                        "cssvar36" => "div.wp-pagenavi span.current",
                        "cssvar37" => ".wfm-mega-menu",
                        "cssvar38" => ".wfm-mega-menu ul li:hover, .wfm-mega-menu ul li .sub-container",
                        "cssvar39" => ".wfm-mega-menu ul li .sub li.mega-hdr a.mega-hdr-a",
                        "cssvar40" => ".wfm-mega-menu ul li .sub-container.non-mega li a:hover, .wfm-mega-menu ul li .sub ul.sub-menu li a:hover",
                        "cssvar41" => ".wfm-mega-menu ul.menu li a",
                        "cssvar42" => ".wfm-mega-menu ul.menu li:hover a",
                        "cssvar43" => ".wfm-mega-menu ul li .sub li.mega-hdr a.mega-hdr-a:hover",
                        "cssvar44" => ".wfm-mega-menu ul li .sub ul.sub-menu li a",
                        "cssvar45" => ".wfm-mega-menu ul li .sub ul.sub-menu li a:hover",
                        "cssvar46" => ".wfm-mega-menu ul li .sub-container.non-mega li a",
                        "cssvar47" => ".wfm-mega-menu ul li .sub-container.non-mega li a:hover",
                        "cssvar48" => ".ddsmoothmenuh",
                        "cssvar49" => ".ddsmoothmenuh ul li ul",
                        "cssvar50" => ".ddsmoothmenuh ul li a",
                        "cssvar51" => ".ddsmoothmenuh ul li:hover,.ddsmoothmenuh ul li a.selected,.ddsmoothmenuh ul li a:hover,.ddsmoothmenuh ul li ul.sub-menu li, .ddsmoothmenuh ul li ul.sub-menu li a",
                        "cssvar52" => ".ddsmoothmenuh ul li ul li:hover, .ddsmoothmenuh ul li ul li a:hover",
                        "cssvar53" => ".ddsmoothmenuh ul li a:link,.ddsmoothmenuh ul li a:visited",
                        "cssvar54" => ".ddsmoothmenuh ul li a:hover",
                        "cssvar55" => ".ddsmoothmenuh ul li  ul li a:link,.ddsmoothmenuh ul li  ul li a:visited",
                        "cssvar56" => ".ddsmoothmenuh ul li  ul li a:hover",
                        "cssvar57" => "div.horizontal-menu",
                        "cssvar58" => "div.horizontal-menu ul li a",
                        "cssvar59" => "div.horizontal-menu ul li:hover",
                        "cssvar60" => "div.horizontal-menu ul li",
                        "cssvar61" => "div.horizontal-menu ul li, div.horizontal-menu ul li a:link,div.horizontal-menu ul li a:visited",
                        "cssvar62" => "div.horizontal-menu ul li:hover a",
                        "cssvar63" => ".wfm-vertical-mega-menu",
                        "cssvar64" => ".wfm-vertical-mega-menu ul li:hover, .wfm-vertical-mega-menu ul li .sub-container",
                        "cssvar65" => ".wfm-vertical-mega-menu ul li .sub li.mega-hdr a.mega-hdr-a",
                        "cssvar66" => ".wfm-vertical-mega-menu ul li .sub-container.non-mega li a:hover, .wfm-vertical-mega-menu ul li .sub ul.sub-menu li a:hover",
                        "cssvar67" => ".wfm-vertical-mega-menu ul li a",
                        "cssvar68" => ".wfm-vertical-mega-menu ul li a:hover",
                        "cssvar69" => ".wfm-vertical-mega-menu ul li .sub li.mega-hdr a.mega-hdr-a:hover",
                        "cssvar70" => ".wfm-vertical-mega-menu ul li .sub ul.sub-menu li a",
                        "cssvar71" => ".wfm-vertical-mega-menu ul li .sub ul.sub-menu li a:hover",
                        "cssvar72" => ".wfm-vertical-mega-menu ul li .sub-container.non-mega li a",
                        "cssvar73" => ".wfm-vertical-mega-menu ul li .sub-container.non-mega li a:hover",
                        "cssvar74" => ".ddsmoothmenuv",
                        "cssvar75" => ".ddsmoothmenuv ul li a:link,.ddsmoothmenuv ul li a:visited,.ddsmoothmenuv ul li a:active",
                        "cssvar76" => ".ddsmoothmenuv ul li:hover,.ddsmoothmenuv ul li a.selected,.ddsmoothmenuv ul li a:hover,.ddsmoothmenuv ul li ul.sub-menu li, .ddsmoothmenuv ul li ul.sub-menu li a",
                        "cssvar77" => ".ddsmoothmenuv ul li ul li:hover, .ddsmoothmenuv ul li ul li a:hover",
                        "cssvar78" => ".ddsmoothmenuv ul li a:link,.ddsmoothmenuv ul li a:visited",
                        "cssvar79" => ".ddsmoothmenuv ul li a:hover",
                        "cssvar80" => ".ddsmoothmenuv ul li  ul li a:link,.ddsmoothmenuv ul li  ul li a:visited",
                        "cssvar81" => ".ddsmoothmenuv ul li  ul li a:hover",
                        "cssvar82" => ".vertical-menu a",
                        "cssvar83" => "div.vertical-menu a:hover",
                        "cssvar84" => ".vertical-menu a:link,.vertical-menu a:visited",
                        "cssvar85" => ".vertical-menu a:hover",
                        "cssvar86" => ".ult_tabs ul.ult_tablinks li a",
                        "cssvar87" => ".ult_tabs ul.ult_tablinks li a:hover",
                        "cssvar88" => ".ult_tabs ul.ult_tablinks li.active a",
                        "cssvar89" => "div.tabs-wrapper.ult_tabs",
                        "cssvar90" => ".ult_accordion .accordion-toggle",
                        "cssvar91" => ".ult_accordion .accordion-toggle.active",
                        "cssvar92" => ".ult_accordion .accordion-inner",
                        "cssvar93" => ".ult_accordion .accordion-toggle",
                        "cssvar94" => ".toggler .accordion-toggle.collapsed",
                        "cssvar95" => ".toggler .accordion-toggle",
                        "cssvar96" => ".toggler .accordion-inner",
                        "cssvar97" => ".toggler .accordion-toggle",
                        "cssvar98" => ".toggler .accordion-inner",
                        "cssvar99" => ".slidertitle, .slidertitle a, .slidertitle a:hover, .slidertitle a:visited",
                        "cssvar100" => "p.slidertext",
                        "cssvar101" => ".slidedeck > dt",
                        "cssvar102" => "h1.super-title, h1.super-title a, h1.super-title a:hover, h1.super-title a:visited",
                        "cssvar103" => ".element-title, .element-title a, .element-title a:hover, .element-title a:visited",
                        "cssvar104" => ".element-title",
                        "cssvar105" => "h3.slidertitle, h3.slidertitle a, h3.slidertitle a:hover, h3.slidertitle a:visited",
                        "cssvar106" => ".anyCaption h3.slidertitle, .s3caption h3.slidertitle, .anyCaption h3.slidertitle, .s3caption h3.slidertitle a, .anyCaption h3.slidertitle, .s3caption h3.slidertitle a:hover, .anyCaption h3.slidertitle, .s3caption h3.slidertitle a:visited",
                        "cssvar107" => ".anyCaption p.slidertext, .s3caption p.slidertext",
                        "cssvar108" => "#logo,#logo a",
                        "cssvar109" => "span#tagline",
                        "cssvar110" => "blockquote *",
                        "cssvar111" => ".wfm-mega-menu ul li.current-menu-ancestor, .wfm-mega-menu ul li.current-menu-item",
                        "cssvar112" => ".wfm-mega-menu ul li.current-menu-ancestor a, .wfm-mega-menu ul li.current-menu-item a",
                        "cssvar113" => ".wfm-vertical-mega-menu ul li.current-menu-ancestor, .wfm-vertical-mega-menu ul li.current-menu-item",
                        "cssvar114" => ".wfm-vertical-mega-menu ul li.current-menu-ancestor a, .wfm-vertical-mega-menu ul li.current-menu-item a",
                        "cssvar115" => ".ddsmoothmenuh ul li.current-menu-ancestor a, .ddsmoothmenuh ul li.current-menu-item a",
                        "cssvar116" => ".ddsmoothmenuh ul li.current-menu-ancestor a, .ddsmoothmenuh ul li.current-menu-item a",
                        "cssvar117" => ".ddsmoothmenuv ul li.current-menu-ancestor a, .ddsmoothmenuv ul li.current-menu-item a",
                        "cssvar118" => ".ddsmoothmenuv ul li.current-menu-ancestor a, .ddsmoothmenuv ul li.current-menu-item a",
                        "cssvar119" => "div.horizontal-menu ul li.current-menu-ancestor , div.horizontal-menu ul li.current-menu-item  ",
                        "cssvar120" => "div.horizontal-menu ul li.current-menu-ancestor a, div.horizontal-menu ul li.current-menu-item a ",
                        "cssvar121" => ".vertical-menu ul li.current-menu-item>a",
                        "cssvar122" => ".vertical-menu ul li.current-menu-item>a",
                        "cssvar123" => ".ultimatum-menu",
                        "cssvar127" => ".ultimatum-menu .nav-holder .ultimatum-megamenu-wrapper .ultimatum-megamenu-title ,.ultimatum-menu .nav-holder h3.widget-title.element-title",
                        'cssvar128' => ".ultimatum-menu .nav-holder .navigation > li >a",
                        'cssvar129' => ".ultimatum-menu .nav-holder .navigation > li:hover >a,.ultimatum-menu .nav-holder .navigation > li.current-menu-ancestor > a,.ultimatum-menu .nav-holder .navigation > li.current_page_item > a,.ultimatum-menu .nav-holder .navigation > li.current-menu-item > a,.ultimatum-menu .nav-holder .navigation > li.current-menu-parent > a",
                        "cssvar130" => '.ultimatum-menu .nav-holder ul li ul li > a',
                        "cssvar131" => '.ultimatum-menu .nav-holder ul li ul li > a:hover',
                        "cssvar132" => '.ultimatum-menu .nav-holder ul ul,.ultimatum-menu .nav-holder .ultimatum-megamenu-wrapper .ultimatum-megamenu-holder,.ultimatum-menu .nav-holder ul .login-box,.ultimatum-menu .nav-holder ul .cart-contents,.ultimatum-menu .nav-holder .nav-search-form',
                        "cssvar133" => '.ultimatum-menu .nav-holder ul li ul li > a:hover, .ultimatum-menu .nav-holder ul li ul li.current-menu-item > a,.ultimatum-menu .nav-holder .ultimatum-menu-nav > li .sub-menu .current-menu-ancestor',
                        "cssvar134" => '.ultimatum-menu .nav-holder .ultimatum-megamenu-wrapper .ultimatum-megamenu-submenu,.ultimatum-menu .nav-holder .ultimatum-megamenu-wrapper .ultimatum-megamenu-border,.ultimatum-menu .nav-holder .ultimatum-menu-nav .ultimatum-megamenu-wrapper ul ul,.ultimatum-menu .nav-holder .ultimatum-menu-nav .ultimatum-megamenu-wrapper ul ul li',
                        'cssvar135' => 'a.sidr-toggler, a.sidr-toggler:hover',
                        'cssvar136' => '.slicknav_menu .slicknav_menutxt',
                        'cssvar137' => 'a.slicknav_btn',
                        'cssvar138' => 'ul.slicknav_nav a',
                        'cssvar139' => 'ul.slicknav_nav a:hover,ul.slicknav_nav li:hover,ul.slicknav_nav .slicknav_row:hover',
                        'cssvar140' => '#content article.hentry',
                        'cssvar141' => 'header.headwrapper',
                        'cssvar142' => 'footer.footwrapper',
                    );
                    if($el!='save_options' && $el!='bg_pattern'){
                        $umm_fix = $el;
                        $el = $cssvar[$el];
                        foreach ($values as $property=>$value){
                            // add px and #
                            if($umm_fix == 'cssvar124' && strlen($value)!=0 && $value !='inherit'){
                                $content .= '.ultimatum-menu .nav-holder .navigation > li > a{height:'.$value.'px;line-height:'.$value.'px;}';
                            } elseif($umm_fix == 'cssvar125' && strlen($value)!=0 && $value !='inherit'){
                                $content .= '.ultimatum-menu .nav-holder  > .ultimatum-menu-nav > li{ padding-right: '.$value.'px; }.rtl .ultimatum-menu .nav-holder  > .ultimatum-menu-nav > li{ padding-left: '.$value.'px; }';
                            } elseif($umm_fix == 'cssvar126' && strlen($value)!=0 && $value !='inherit'){
                                $content .= '.ultimatum-menu .nav-holder ul ul.sub-menu{width:'.$value.'px;}.ultimatum-menu .nav-holder ul ul.sub-menu li ul{left:'.$value.'px;}     ul.navigation > li:last-child ul.sub-menu ul{left:-'.$value.'px;}.ultimatum-menu .nav-holder .ultimatum-megamenu-wrapper ul{left:auto;}.rtl .ultimatum-menu .nav-holder ul ul.sub-menu li:hover ul {right:'.$value.'px;left: auto;}.rtl ul.navigation > li:last-child ul.sub-menu ul{right:-'.$value.'px;left: auto;}';
                            } else {
                            if(strlen($value)!=0 && $value !='inherit'){
                                if($umm_fix == 'cssvar134'){
                                    $content .= ".ultimatum-menu .nav-holder ul li ul li > a,.ultimatum-menu .nav-holder .nav-search-form{border-bottom:1px solid #".str_replace('#', '',$value).";}";
                                }  elseif ($umm_fix=='cssvar136') {
                                    $content .= '.slicknav_menu .slicknav_icon-bar{background-color:#'.str_replace('#','',$value).'}';
                                }
                                if(preg_match('/color/i',$property)){
                                    //empty # fix
                                    if(stripslashes(str_replace('#', '',$value))!=""){
                                        if(preg_match('/rgba/i',$value)){
                                            $element[]=$property.': '.stripslashes(str_replace('#', '',$value));
                                        } else {
                                            $element[]=$property.': #'.stripslashes(str_replace('#', '',$value));
                                        }
                                    }
                                } elseif (preg_match('/letter-spacing/i',$property) || preg_match('/width/i',$property) || preg_match('/word-spacing/i',$property) || preg_match('/size/i',$property) || preg_match('/height/i',$property) || preg_match('/margin/i',$property) || preg_match('/padding/i',$property )){
                                    if($property != 'background-size') {
                                        $element[]=$property.': '.stripslashes($value).'px';
                                    }
                                } elseif (preg_match('/image/i',$property)){
                                    $element[]=$property.': url('.stripslashes($value).')';
                                } elseif (preg_match('/family/i',$property)){
                                    // cufon fontface google
                                    if(preg_match('/cufon-/i',$value)){ //cufon
                                        $cf = str_replace('cufon-', '', $value);
                                        $cfonts = explode('-js-',$cf);
                                        $cufonjs[]=$cfonts[1];
                                        $cufonreplace[$cfonts[0]][]=$el;
                                        unset($cfonts);
                                        $element[]=$property.': Arial,sans-serif';
                                    }elseif(preg_match('/google-/i',$value)){ //google
                                        $gfont=explode('-css-',str_replace('google-','',$value));
                                        $font = $gfont[0];
                                        $googlecss[] = $gfont[1];
                                        unset($gfont);
                                        $element[]=$property.': "'.stripslashes($font).'", Arial, sans-serif';
                                    }elseif(preg_match('/fontface-/i',$value)){ //fontface
                                        $ffont=explode('-css-',str_replace('fontface-','',$value));
                                        $font = $ffont[0];
                                        $fontfacer[] = $ffont[1];
                                        unset($ffont);
                                        $element[]=$property.': "'.stripslashes($font).'", Arial, sans-serif';
                                    } else {
                                        $element[]=$property.': '.stripslashes($value);
                                    }
                                } else {
                                    $element[]=$property.': '.stripslashes($value);
                                }
                            }
                           }//ummfix end
                        }
                        $linebreak=';'."\n";
                        if(isset($element) && is_array($element)){
                            $content.= $el.' {'."\n".@implode($linebreak, $element).';'."\n".'}'."\n\n";
                        }
                        unset($element);
                    }
                }
                // Intelligent Google
                $googleCss = false;
                if(isset($googlecss)){
                    $gcss = array_unique($googlecss);
                    if(count($gcss)>=1){
                        foreach($gcss as $google_css){
                            $google_css=str_replace(' ', '+', $google_css);
                            $charsets = get_ultimatum_option('scripts','google_charset');
                            if(is_array($charsets) && ($charsets)!=0){
                                $subset="&subset=".implode(',',$charsets);
                                $google_css .=$subset;
                            }
                            $googleCss .= '@import url(//fonts.googleapis.com/css?family='.$google_css.');'."\n";
                        }
                    }
                }

                //Intelligent @font-face
                $fontfacecss=false;
                if(isset($fontfacer)){
                    $fcss = array_unique($fontfacer);
                    if(count($fcss)!=0){
                        $url = str_replace('http:','',ULTIMATUM_LIBRARY_URI.'/fonts/fontface');
                        $url = str_replace('https:','',$url);
                        foreach ($fcss as $font_str){
                            $font_info = explode("|", $font_str);
                            $stylesheet = THEME_FONTFACE_DIR.'/'.$font_info[0].'/stylesheet.css';
                            if(file_exists($stylesheet)){
                                $file_content = file_get_contents($stylesheet);
                                if( preg_match("/@font-face\s*{[^}]*?font-family\s*:\s*('|\")$font_info[1]\\1.*?}/is", $file_content, $match) ){
                                    $fontfacecss .= preg_replace("/url\s*\(\s*['|\"]\s*/is","\\0$url/$font_info[0]/",$match[0])."\n";
                                }
                            }
                        }
                    }
                }
			endif;
			if($type == "layout"){
				$fffile = THEME_CACHE_DIR.'/fontface'.$setter.'.css';
				if(file_exists($fffile)){
					unlink($fffile);
				}
				if($fontfacecss){
					$ffhandle2 = @fopen($fffile, 'w+');
					if ($ffhandle2) fwrite($ffhandle2, $fontfacecss, strlen($fontfacecss));
					$ffinclude = "@import url('".THEME_CACHE_URL.'/fontface'.$setter.".css');"."\n";
					$content = $ffinclude.$content;
				}
				if(isset($googleCss)){
					$content = $googleCss.$content;
				}
				
				$content .= WonderWorksCSS::partCSS($id);// the original row
				// add the included layouts as well
				$includedLayouts = WonderWorksCSS::getLayoutsIncluded($id);
				foreach ($includedLayouts as $includedLayout){
					$content .= WonderWorksCSS::partCSS($includedLayout);
				}
				
				if(strlen($content)!=0){
                    $content = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content );
                    $content = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content );
					$fhandle = @fopen($file, 'w+');
					if ($fhandle) fwrite($fhandle, $content, strlen($content));
				}
				$custom_css= stripslashes(get_option(THEME_SLUG.'_custom_css_'.$id));
				if(strlen($custom_css)){
					$file2 = THEME_CACHE_DIR.'/layout_custom_'.$id.'.css';
					$fhandle2 = @fopen($file2, 'w+');
					if ($fhandle2) fwrite($fhandle2, $custom_css, strlen($custom_css));
				}
			} elseif($type!='layout'){
				
				
				// do the grid
				$grid = WonderWorksCSS::gridParser($id);
				
				$content = $grid.$content;
				if(strlen($googleCss)!=0){
					$content = $googleCss.$content;
				}
				// do the fontface inclusion
				$fffile = THEME_CACHE_DIR.'/fontface'.$setter.'.css';
				if(file_exists($fffile)){
					unlink($fffile);
				}
				if($fontfacecss){
					$ffhandle2 = @fopen($fffile, 'w+');
					if ($ffhandle2) fwrite($ffhandle2, $fontfacecss, strlen($fontfacecss));
					$ffinclude = "@import url('".THEME_CACHE_URL.'/fontface'.$setter.".css');"."\n";
					$content = $ffinclude.$content;
				}
				if(strlen($content)!=0){
                    $content = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content );
                    $content = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content );
                    $fhandle = @fopen($file, 'w+');
                    if ($fhandle) fwrite($fhandle, $content, strlen($content));
				}
				$custom_css= stripslashes(get_option(THEME_SLUG.'_custom_template_css_'.$id));
				if(strlen($custom_css)){
					$file2 = THEME_CACHE_DIR.'/template_custom_'.$id.'.css';
					$fhandle2 = @fopen($file2, 'w+');
					if ($fhandle2) fwrite($fhandle2, $custom_css, strlen($custom_css));
				}
			}
			$cfile = THEME_CACHE_DIR.'/cufon'.$setter.'.php';
			if(file_exists($cfile)){
				unlink($cfile);
			}
			if(isset($cufonjs)){
				$cufjs = array_unique($cufonjs);
				if(count($cufjs)>=1){
					$phpcontent = '<script type="text/javascript" src="'.ULTIMATUM_URL.'/assets/js/plugins/cufon-yui.js"></script>'."\n";
					foreach ($cufjs as $cjsi){
						$phpcontent.='<script type="text/javascript" src="'.ULTIMATUM_LIBRARY_URI.'/fonts/cufon/'.$cjsi.'"></script>'."\n";
					}
					$phpcontent.='<script type="text/javascript">'."\n";
					foreach($cufonreplace as $font=>$item){
						$phpcontent .= 'Cufon.replace("'.implode(', ',$item).'", {fontFamily : "'.$font.'",hover:true});'."\n";
					}
					$phpcontent .= '</script>';
					$fhandler = @fopen($cfile, 'w+');
					if ($fhandler){ 
						fwrite($fhandler, $phpcontent, strlen($phpcontent));
					}
				}
	
			}
	}
	    return false;
	}
	
	static public function partCSS($layoutid){
		global $wpdb;
		$csstable = $wpdb->prefix.ULTIMATUM_PREFIX.'_css';
		$query = "SELECT * FROM $csstable WHERE layout_id='$layoutid'";
		
		$res = $wpdb->get_results($query,ARRAY_A);
		$css='';
		
		foreach($res as $fetch){
			if($fetch["element"]=='general'){
				if($fetch["container"]!='body'){
					if(preg_match('/col-/i',$fetch["container"])){
						$el = '#'.$fetch["container"].' .colwrapper';
					} else {
						$el = '#'.$fetch["container"];
					}
				}else{
					$el = $fetch["container"];
				}
			} elseif($fetch["container"]=='body'){
				if($fetch["element"]=='h1' || $fetch["element"]=='h2' || $fetch["element"]=='h3' || $fetch["element"]=='h4' || $fetch["element"]=='h5' || $fetch["element"]=='h6'){
					$fetch["element"]=$fetch["element"].', '.$fetch["element"].' a,'.$fetch["element"].' a:hover';
				}
				$el = $fetch["element"];
				if($el=='ahover'){$el = 'a:hover'; }
		
			} else {
				if($fetch["element"]=='ahover'){$fetch["element"] = 'a:hover'; }
				if($fetch["element"]=='h1' || $fetch["element"]=='h2' || $fetch["element"]=='h3' || $fetch["element"]=='h4' || $fetch["element"]=='h5' || $fetch["element"]=='h6'){
					//$fetch["element"]=$fetch["element"].', '.$fetch["element"].' a,'.$fetch["element"].' a:hover';
					$el = '#'.$fetch["container"].' '.$fetch["element"].', #'.$fetch["container"].' '.$fetch["element"].' a, #'.$fetch["container"].' '.$fetch["element"].' a:hover';
				} else {
					$el = '#'.$fetch["container"].' '.$fetch["element"];
				}
			}
			$proprties =WonderWorksCSS::parseCSS($fetch["properties"]);
				
				
			if(count($proprties)!=0){
				//print_r($proprties);
				$css .= $el.'{'.@implode(';',$proprties).'}';
			}
		}
		return $css;
	}
	
	static public function parseCSS($properties){
		if(strlen($properties)>5):
		$property = unserialize($properties);
		foreach($property as $key=>$value){
			if(strlen($value)!=0){
				if($key=='color' || $key=='background-color' || $key=='border-top-color' || $key=='border-bottom-color' || $key=='border-left-color' || $key=='border-right-color'){
					if(stripslashes(str_replace('#', '',$value))!=""){
                        if(preg_match('/rgba/i',$value)){
                            $css[] = $key . ': ' . str_replace('#', '', $value);
                        } else {
                            $css[] = $key . ': #' . str_replace('#', '', $value);
                        }
					}
				} elseif (preg_match('/margin/i',$key) || preg_match('/padding/i',$key) || preg_match('/height/i',$key) || preg_match('/size/i',$key)) {
				 $css[]=$key.': '.$value.'px';
				}elseif ($key=='background-image') {
					$css[]=$key.': url('.$value.')';
				} else {
					$css[]=$key.':'.$value;
				}
			}
		}
		return $css;
		endif;
	}
	
	static public function getLayoutsIncluded($id){
		global $wpdb;
		$resultant= array();
		$query = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `id`='".$id."'";
		$result = $wpdb->get_row($query);
		$rows = $result->before.','.$result->rows.','.$result->after;
		$rowsarray = explode(',',$rows);
		array_unique($rowsarray);
		foreach($rowsarray as $row){
			$rowinfo = explode('-',$row);
			if($rowinfo[0]!="row"){
				if(isset($rowinfo[1])) { $resultant[]=$rowinfo[1];}
			}
		}
		return $resultant;		
	}
	
	static public function gridParser($id){
		//include less compiler
		$template = getTemplateInfo($id);
        if ( ! class_exists( 'ultimatum_less' ) ) include_once(ULTIMATUM_ADMIN_HELPERS . DS . 'less.inc.php');
        $less = new ultimatum_less;
        $gridwork = $template->gridwork;
        $responsive = true;
        if($template->type==0) $responsive = false;

        switch ($gridwork){
            case 'tbs':
                $width		= 	$template->width;
                $rawmargin	=	$template->margin;
                $grid_width =	($width-(11*$rawmargin))/12;
                $less_file = 'tbs2/swatchmaker.less';
                if($responsive){
                    $responsive_less_file = 'tbs2/swatchmaker-responsive.less';
                }
                if($template->cdn=='yes'){
                   // $responsive_less_file = false;
                    $less_file = 'tbs2/swatchmaker-cdn.less';
                }
                $lessarray = array(
                    "um-width-md" => ($width)."px",
                    "um-width-lg" => ($template->mwidth)."px",
                    "um-width-sm" => ($template->swidth)."px",
                    "gridColumnWidth"=>$grid_width."px",
                    "gridGutterWidth"=>$rawmargin."px",
                    "gridColumnWidth1200" => (($template->mwidth-(11*$template->mmargin))/12).'px',
                    "gridGutterWidth1200" => $template->mmargin.'px',
                    "gridColumnWidth768" => (($template->swidth-(11*$template->smargin))/12).'px',
                    "gridGutterWidth768" => $template->smargin.'px',
                    "swatch" => strtolower($template->swatch),
                );
                break;
            case 'tbs3':
                $responsive_less_file = false;
                $width		= 	$template->width;
                $rawmargin	=	$template->margin;
                $lessarray = array(
                    "grid-gutter-width" => $template->margin."px",
                    "container-tablet" => ($template->swidth)."px",
                    "container-desktop" => ($width)."px",
                    "container-large-desktop" =>($template->mwidth)."px",
                    "um-width-md" => ($width-$rawmargin)."px",
                    "um-width-lg" => ($template->mwidth-$rawmargin)."px",
                    "um-width-sm" => ($template->swidth-$rawmargin)."px",
                    "swatch" => strtolower($template->swatch),
                );
                if(!$responsive){
                    $less_file = 'tbs3/swatchmaker.less';
                } else {
                    $less_file = 'tbs3/swatchmaker-responsive.less';
                }
                if($template->cdn=='yes' && strtolower($template->swatch)!='amelia'){
                    $less_file = 'tbs3/swatchmaker-cdn.less';
                }
                break;
            default:
                $less_file = '960/960gs.less';
                if($responsive) $responsive_less_file = '960/960gs-responsive.less';
                $width		= 	$template->width;
        		$rawmargin	=	$template->margin;
        		$grid_width =	($width-(12*$rawmargin))/12;
                $lessarray = array(
                    "um-width-md" => ($width-$rawmargin)."px",
                    "um-width-lg" => ($template->mwidth-$template->mmargin)."px",
                    "um-width-sm" => ($template->swidth-$template->smargin)."px",
                    "gridColumnWidth"=>$grid_width."px",
                    "gridGutterWidth"=>$rawmargin."px",
                    "gridColumnWidth1200" => (($template->mwidth-(12*$template->mmargin))/12).'px',
                    "gridGutterWidth1200" => $template->mmargin.'px',
                    "gridColumnWidth768" => (($template->swidth-(12*$template->smargin))/12).'px',
                    "gridGutterWidth768" => $template->smargin.'px',
                );
                break;
        }

        $less->setVariables($lessarray);
        if(file_exists(THEME_DIR.DS.'less'.DS.$less_file)){ // this means user wants to make changes to less files
            $content = $less->compilefile(THEME_DIR.DS.'less'.DS.$less_file);
            if($responsive_less_file) $content .= $less->compilefile(THEME_DIR.DS.'less'.DS.$responsive_less_file);

        } else {
            $content = $less->compilefile(ULTIMATUM_DIR.DS.'assets'.DS.'less'.DS.$less_file);
            if($responsive_less_file) $content .= $less->compilefile(ULTIMATUM_DIR.DS.'assets'.DS.'less'.DS.$responsive_less_file);
        }

        return $content;
	}
	
}