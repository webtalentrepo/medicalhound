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

function post_gallery($width,$height,$instance){
	global $post;
	$link = false;
	if(!is_singular()){
		$link = get_permalink();
	}
	wp_enqueue_script('slider-flex');
	$image_ids_str = get_post_meta($post->ID,'_image_ids',true);
	$image_ids = explode(',',str_replace('image-','',$image_ids_str));
	foreach($image_ids as $image_id){
		$images[] = array(
					'image_id'=>$image_id,
					'title' => get_post_field('post_title', $image_id),
					'link' => $link,
					'target' => '_self',
					'video' =>get_post_meta(get_the_ID(),'ultimatum_video',true),
		);
	}
	?>
	<div class="flex-container">
	<div class="flexslider" id="<?php echo $post->ID.'-post-flex'; ?>" >
	<ul class="slides">
	
	<?php
	foreach($images as $image){
	$imgsrc = UltimatumImageResizer($image['image_id'], null,$width, $height, true ); 
	?>
	<li>
	<?php if(isset($image["link"]) && strlen($image['link'])!=0){?>
	<a href="<?php echo $image["link"]; ?>"><img src="<?php echo $imgsrc; ?>" style="float:right" alt="<?php echo $image["title"]; ?>" title="<?php echo $image["title"]; ?>" /></a>
	<?php } else { ?>
	<img src="<?php echo $imgsrc; ?>" style="float:right" alt="<?php echo $image["title"]; ?>" title="<?php echo $image["title"]; ?>" />
	<?php  } ?>
	</li>
	<?php }	?>
	</ul>
	</div>
	</div>
	<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function() {
	jQuery('#<?php echo $post->ID.'-post-flex'; ?>').flexslider({
		 animation: "slide",
		 maxItems:1,
		 itemWidth:<?php echo $width;?>
	
	});
	});
	//]]>
</script>
	<?php 
	}


function ultimatum_content_item_image($args,$instance,$imgw,$rel=null,$align=null,$gallery=null){
	global $post;
	extract( $args );
	$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large') ;
	$imgsrc = false;
	
	if(is_singular()){
		if(!$img && $instance["noimage"]=='true'){
			$img[0]= null;
			if(get_ultimatum_option('general', 'noimage')){
				$img[0] =get_ultimatum_option('general', 'noimage');
			} 
			$imgsrc = UltimatumImageResizer( null, $img[0],$imgw, $instance["singleh"], true );
		} elseif(is_array($img)) {
			$imgsrc = UltimatumImageResizer( get_post_thumbnail_id(), null,$imgw, $instance["singleh"], true );
		} 
		if($imgsrc){ ?>
			<div class="featured-image <?php echo $align;?>">
	        <?php 
	        do_action('ultimatum_before_featured_image',$args,$instance);
	        if($instance["gallery"]=='true'){
		    	if( get_post_meta($post->ID,'_image_ids',true) && $instance['ult_full_image']) {
		        	post_gallery($imgw, $instance["singleh"], $instance);
		        }elseif(get_post_meta($post->ID,'ultimatum_video',true) && !$gallery ) {
					$video =get_post_meta($post->ID,'ultimatum_video',true);
					$sc ='[ult_video width="'.$imgw.'" height="'.$instance["singleh"].'"]'.$video.'[/ult_video]';
					echo do_shortcode($sc); // fix!
				} else {
				?>
					<img  class="img-responsive" src="<?php echo $imgsrc;?>" alt="<?php the_title();?>" />
				<?php
		        }
			} else { ?>
				<img class="img-responsive" src="<?php echo $imgsrc;?>" alt="<?php the_title();?>" /><?php 
			}
			do_action('ultimatum_after_featured_image',$args,$instance);
	        ?>
	        </div><?php 
		}	
	} else {
		if(!$img && $instance["mnoimage"]=='true'){
			$img[0]= null;
			if(get_ultimatum_option('general', 'noimage')){
				$img[0]=	get_ultimatum_option('general', 'noimage');
			} 
			$imgsrc = UltimatumImageResizer( null, $img[0],$imgw, $instance["multipleh"], true );
		} elseif(is_array($img)) {
			$imgsrc = UltimatumImageResizer( get_post_thumbnail_id(), null,$imgw, $instance["multipleh"], true );
		} 
		if($imgsrc){ ?>
			<div class="featured-image <?php echo $align;?>" <?php if($gallery){?>style="position: relative"<?php } ?>>
			<?php
			do_action('ultimatum_before_featured_image',$args,$instance);
			$video =get_post_meta($post->ID,'ultimatum_video',true);
				if($gallery){
					if($video){ 
						$link = $video.'';
					} else {
						$link = $img[0];
						if(preg_match('/holder.js/i', $imgsrc)){
							$link = '';
							$rel =  '';
						}
					}
				}
				if($instance["mvideo"]=='true'){
					if( get_post_meta($post->ID,'_image_ids',true) && !$gallery && $instance['ult_full_image']) {
						post_gallery($imgw, $instance["multipleh"], $instance);
					}elseif(get_post_meta($post->ID,'ultimatum_video',true) && !$gallery ) {
						$sc ='[ult_video width="'.$imgw.'" height="'.$instance["multipleh"].'"]'.$video.'[/ult_video]';
						echo do_shortcode($sc);
					} else {?>
						<a href="<?php if($gallery){ echo $link; } else { the_permalink();} ?>" <?php echo $rel?> class="preload <?php if($gallery){ echo ' overlayed_image'; } ?>" <?php if($gallery){ if($video){ echo ' data-overlay="play"'; } else { echo ' data-overlay="image"';} } ?>>
							<img  class="img-responsive" src="<?php echo $imgsrc;?>" alt="<?php the_title();?>" />
		            	</a><?php
					}
				} else { ?>
					<a href="<?php if($gallery){ echo $link; } else { the_permalink();} ?>" <?php echo $rel?> class="preload <?php if($gallery){ echo ' overlayed_image'; } ?>" <?php if($gallery){ if($video){ echo ' data-overlay="play"'; } else { echo ' data-overlay="image"';} } ?>>
						<img  class="img-responsive" src="<?php echo $imgsrc;?>" alt="<?php the_title();?>" />
		            </a><?php
	            }
	            do_action('ultimatum_after_featured_image',$args,$instance); ?>
        	</div><?php 
		}
	}
}
	



add_filter( 'post_class', 'ultimatum_entry_post_class' );

function ultimatum_entry_post_class( $classes ) {

	/** Add "entry" to the post class array */
	$classes[] = 'entry';
	$classes[] = 'post-inner';

	return $classes;

}


function ultimatum_entry_post_class_half( $classes ) {

	/** Add "entry" to the post class array */
	$classes[] = 'one_half';

	return $classes;

}
function ultimatum_entry_post_class_third( $classes ) {

	/** Add "entry" to the post class array */
	$classes[] = 'one_third';

	return $classes;

}
function ultimatum_entry_post_class_fourth( $classes ) {

	/** Add "entry" to the post class array */
	$classes[] = 'one_fourth';

	return $classes;

}
function ultimatum_entry_post_class_last( $classes ) {

	/** Add "entry" to the post class array */
	$classes[] = 'last';

	return $classes;

}



add_action( 'ultimatum_post_title', 'ultimatum_do_post_title',10,2 );
function ultimatum_do_post_title($args,$instance) {

	$title = get_the_title();
	$tag = (get_ultimatum_option('tags', 'multi_article') ? get_ultimatum_option('tags', 'multi_article') : 'h2');
	$stag = (get_ultimatum_option('tags', 'single_article') ? get_ultimatum_option('tags', 'single_article') : 'h1');
	if ( 0 == strlen( $title ) )
		return;

	if ( is_singular() && $instance["title"]=='true' ){
		$title = sprintf( '<'.$stag.' class="entry-title post-header">%s</'.$stag.'>', $title );
		echo "$title \n";
	}
	if ( !is_singular() && $instance["mtitle"]=='true' ) {
		$title = sprintf( '<'.$tag.' class="entry-title post-header"><a href="%s" title="%s" rel="bookmark" class="post-title">%s</a></'.$tag.'>', get_permalink(), the_title_attribute( 'echo=0' ), apply_filters( 'ultimatum_post_title_text', $title ) );
		echo "$title \n";
	} elseif(!is_singular() && $instance["mtitle"]=='nolink') {
		$title = sprintf( '<'.$tag.' class="entry-title post-header">%s</'.$tag.'>', $title );
		echo "$title \n";
	}

}


add_action( 'ultimatum_post_content', 'ultimatum_do_post_content',10,1 );

function ultimatum_do_post_content($instance=null) {
	$loop_text_vars=$instance['loop_text_vars'];
	global $post;
	if ( is_singular() ) {
		the_content();
		if ( is_singular() && 'open' == get_option( 'default_ping_status' ) && post_type_supports( $post->post_type, 'trackbacks' ) ) {
			echo '<!--';
			trackback_rdf();
			echo '-->' . "\n";
		}
		if ( is_page() && apply_filters( 'ultimatum_edit_post_link', true ) ){
            edit_post_link( __( '(Edit)', 'ultimatum' ), '', '' );
        }
      	wp_link_pages( array( 'before' => '<p class="pages">' . __( 'Pages:', 'ultimatum' ), 'after' => '</p>' ) );
	} else {
		if ( $instance['excerpt']=='true' ) { 
			
			echo '<p>';
			echo ult_excerpt($instance['excerptlength']);
			if($instance['mreadmore']!='false'){
				if($instance['mreadmore']!='after'){
					
					echo '<br /><span style="float:'.$instance['mreadmore'].'"><a href="'.get_permalink().'" class="read-more">'.$loop_text_vars[$instance['rmtext']].'</a></span><br />';
				} else {
					echo ' <a href="'.get_permalink().'" class="read-more">'.$loop_text_vars[$instance['rmtext']].'</a>';
				}
			}
			echo '</p>';
		} elseif ( $instance['excerpt']=='content' ) {
			the_content();
			
		} else {
			
		}
	}

	

}

add_action( 'ultimatum_loop_else', 'ultimatum_do_noposts' );
function ultimatum_do_noposts() {

	printf( '<p>%s</p>', apply_filters( 'ultimatum_noposts_text', __( 'Sorry, no posts matched your criteria.', 'ultimatum' ) ) );

}
function ultimatum_meta_item($item,$instance=null){
    global $post;
    switch ($item) {
        case 'date':
            if(!is_singular()){
                $showtime = isset($instance['mshowtime']) ? $instance['mshowtime'] : false;
            } else {
                $showtime = isset($instance['showtime']) ? $instance['showtime'] : false;
            }

            if ($showtime) {
                $time = get_the_time();
            } else {
                $time = '';
            }
            $meta_back = '<span class="date"><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_date() . ' ' . $time . '</a></span>';
            $meta_back = apply_filters('ultimatum/loop/meta/date',$meta_back);
            break;
        case 'author':
            $meta_back = __('by ',  'ultimatum') . '<span class="entry-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"><a class="entry-author-link" itemprop="url" rel="author" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '"><span class="entry-author-name" itemprop="name">' . get_the_author() . '</span></a></span>';
            $meta_back = apply_filters('ultimatum/loop/meta/author',$meta_back);
            break;
        case 'comments':
            ob_start();
            comments_popup_link(__('No Comments',  'ultimatum'), __('1 Comment',  'ultimatum'), __('% Comments',  'ultimatum'), '');
            $meta_back = '<span class="comments">' . ob_get_clean() . '</span>';
            $meta_back = apply_filters('ultimatum/loop/meta/comments',$meta_back);
            break;

    }
    return $meta_back;
}
function ultimatum_post_meta($args,$instance)
{

	global $post;
	$tax =array();
	$out= array();
	$output = '';
	if(is_singular()){
        if(isset($instance['newmetas']) && strlen($instance['newmetas'])!=0){
            $mproper = explode(',',$instance['newmetas']);
            foreach ($mproper as $mprope){
                $out[]=ultimatum_meta_item($mprope,$instance);
            }
        } else {
            if ($instance["date"] == 'true') {
                $showtime = isset($instance['showtime']) ? $instance['showtime'] : '';
                if ($showtime) {
                    $time = get_the_time();
                } else {
                    $time = '';
                }
                $out[] = '<span class="date"><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_date() . ' ' . $time . '</a></span>';
            }
            if ($instance["author"] == 'true') {
                $out[] = __('by ',  'ultimatum') . '<span class="entry-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"><a class="entry-author-link" itemprop="url" rel="author" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '"><span class="entry-author-name" itemprop="name">' . get_the_author() . '</span></a></span>';
            } else {
                $out[] = '<span style="display:none" class="entry-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"><a class="entry-author-link" itemprop="url" rel="author" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '"><span class="entry-author-name" itemprop="name">' . get_the_author() . '</span></a></span>';
            }
            if ($instance["comments"] == "true" && ($post->comment_count > 0 || comments_open())) {
                ob_start();
                comments_popup_link(__('No Comments',  'ultimatum'), __('1 Comment',  'ultimatum'), __('% Comments',  'ultimatum'), '');
                $out[] = '<span class="comments">' . ob_get_clean() . '</span>';
            }
        }
        if (count($out) != 0) {
            $output = '<div class="post-meta">';
            $output .= join(' ' . $instance["mseperator"] . ' ', $out) . '</div>';
        }

		if ($instance["cats"]=='ameta' && !is_page()){
			$_tax = get_the_taxonomies();
			if ( empty($_tax) ){
			} else {
				foreach ( $_tax as $key => $value ) {
					preg_match( '/(.+?): /i', $value, $matches );
					$tax[] = '<span class="entry-tax-'. $key .'">' . str_replace( $matches[0], '<span class="entry-tax-meta">'. $matches[1] .':</span> ', $value ) . '</span>';
				}
			}
			if(count($tax)!=0){
				$output.= '<div class="post-taxonomy">'.join( '<br />', $tax ).'</div>';
			}
		}
	} else {
        if(isset($instance['newmetasm']) && strlen($instance['newmetasm'])!=0){
            $mproper = explode(',',$instance['newmetasm']);
            foreach ($mproper as $mprope){
                $out[]=ultimatum_meta_item($mprope,$instance);
            }
        } else {
            if ($instance["mdate"] == 'true') {
                $mshowtime = isset($instance['mshowtime']) ? $instance['mshowtime'] : '';
                if ($mshowtime) {
                    $mtime = get_the_time();
                    $out[] = '<span class="date"><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_date() . ' ' . $mtime . '</a></span>';
                } else {
                    $out[] = '<span class="date"><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_date() . '</a></span>';
                }
            }
            if ($instance["mauthor"] == 'true') {
                $out[] = __('by ',  'ultimatum') . '<span class="entry-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"><a class="entry-author-link" itemprop="url" rel="author" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '"><span class="entry-author-name" itemprop="name">' . get_the_author() . '</span></a></span>';
            } else {
                $out[] = '<span style="display:none" class="entry-author" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"><a class="entry-author-link" itemprop="url" rel="author" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '"><span class="entry-author-name" itemprop="name">' . get_the_author() . '</span></a></span>';
            }
            if ($instance["mcomments"] == "true" && ($post->comment_count > 0 || comments_open())) {
                ob_start();
                comments_popup_link(__('No Comments',  'ultimatum'), __('1 Comment',  'ultimatum'), __('% Comments',  'ultimatum'), '');
                $out[] = '<span class="comments">' . ob_get_clean() . '</span>';
            }
        }
		if(count($out)!=0){
			$output = '<div class="post-meta">';
			$output .= join( ' '.$instance["mmseperator"].' ', $out ).'</div>';
		}
		if ($instance["mcats"]=='ameta'){
			$_tax = get_the_taxonomies();
			if ( empty($_tax) ){
			} else {
				foreach ( $_tax as $key => $value ) {
					preg_match( '/(.+?): /i', $value, $matches );
					$tax[] = '<span class="entry-tax-'. $key .'">' . str_replace( $matches[0], '<span class="entry-tax-meta">'. $matches[1] .':</span> ', $value ) . '</span>';
				}
			}
			if(count($tax)!=0){
				$output.= '<div class="post-taxonomy">'.join( '<br />', $tax ).'</div>';
			}
		}
		
	}
	echo $output;
}

function ultimatum_post_tax() {
	global $post;
	$_tax = get_the_taxonomies();
	if (!empty($_tax) ){
		foreach ( $_tax as $key => $value ) {
			preg_match( '/(.+?): /i', $value, $matches );
			$tax[] = '<span class="entry-tax-'. $key .'">' . str_replace( $matches[0], '<span class="entry-tax-meta">'. $matches[1] .':</span> ', $value ) . '</span>';
		}
	}
	if(count($tax)!=0){
	echo '<div class="post-taxonomy">'.join( '<br />', $tax ).'</div>';
	}
}

add_action( 'ultimatum_after_post', 'ultimatum_do_author_box_single' ); 

function ultimatum_do_author_box_single() {
	global $post;
	if (!is_singular())
		return;

	if ( get_post_meta($post->ID,'ultimatum_author',true)=='true' )
		ultimatum_author_box( 'single' );

}

function ultimatum_author_box( $context = '', $echo = true ) {

	global $authordata;

	$authordata    = is_object( $authordata ) ? $authordata : get_userdata( get_query_var( 'author' ) );
	$gravatar_size = apply_filters( 'ultimatum_author_box_gravatar_size', 70, $context );
	$gravatar      = get_avatar( get_the_author_meta( 'email' ), $gravatar_size );
	$title         = apply_filters( 'ultimatum_author_box_title', sprintf( '<strong>%s %s</strong>', __( 'About', 'ultimatum' ), get_the_author() ), $context );
	$description   = wpautop( get_the_author_meta( 'description' ) );

	/** The author box markup, contextual */
	$pattern = $context == 'single' ? '<div class="well author-box"><div>%s %s<br />%s</div></div><!-- end .authorbox-->' : '<div class="author-box">%s<h1>%s</h1><div>%s</div></div><!-- end .authorbox-->';

	$output = apply_filters( 'ultimatum_author_box', sprintf( $pattern, $gravatar, $title, $description ), $context, $pattern, $gravatar, $title, $description );

	/** Echo or return */
	if ( $echo )
		echo $output;
	else
		return $output;

}

//Multi posts Navigation Controls
add_action( 'ultimatum_after_endwhile', 'ultimatum_posts_nav',10,1 );
function ultimatum_posts_nav($instance) {
	echo '<div style="clear:both"></div>';
	$nav = $instance['navigation'];
	if( 'prenext' == $nav )
		ultimatum_prev_next_posts_nav();
	elseif( 'numeric' == $nav )
		ultimatum_numeric_posts_nav();
	else
		ultimatum_older_newer_posts_nav();
}

function ultimatum_older_newer_posts_nav() {
	global $ultimatumlayout;
	$older_link = get_next_posts_link( apply_filters( 'ultimatum_older_link_text', '&#x000AB;' . __( 'Older Posts', 'ultimatum' ) ) );
	$newer_link = get_previous_posts_link( apply_filters( 'ultimatum_newer_link_text', __( 'Newer Posts', 'ultimatum' ) . '&#x000BB;' ) );
	if($ultimatumlayout->gridwork!="tbs3"){
		$older = $older_link ? '<ul class="alignleft"><li>' . $older_link . '</li></ul>' : '';
		$newer = $newer_link ? '<ul class="alignright"><li>' . $newer_link . '</li></ul>' : '';
		$nav = '<div class="pagination">' . $older . $newer . '</div><!-- end .navigation -->';
	} else {
		$older = $older_link ? '<li class="previous">' . $older_link . '</li>' : '';
		$newer = $newer_link ? '<li class="next">' . $newer_link . '</li>' : '';
		$nav = '<ul class="pager">' . $older . $newer . '</ul><!-- end .navigation -->';
	}
	
	if ( $older || $newer )
		echo $nav;
}

function ultimatum_prev_next_posts_nav() {
	global $ultimatumlayout;
	$prev_link = get_previous_posts_link( apply_filters( 'ultimatum_prev_link_text', '&#x000AB;' . __( 'Previous Page', 'ultimatum' ) ) );
	$next_link = get_next_posts_link( apply_filters( 'ultimatum_next_link_text', __( 'Next Page', 'ultimatum' ) . '&#x000BB;' ) );
	if($ultimatumlayout->gridwork!="tbs3"){
		$older = $prev_link ? '<ul class="alignleft"><li>' . $prev_link . '</li></ul>' : '';
		$newer = $next_link ? '<ul class="alignright"><li>' . $next_link . '</li></ul>' : '';
		$nav = '<div class="pagination">' . $older . $newer . '</div><!-- end .navigation -->';
	} else {
		$older = $prev_link ? '<li class="previous">' . $prev_link . '</li>' : '';
		$newer = $next_link ? '<li class="next">' . $next_link . '</li>' : '';
		$nav = '<ul class="pager">' . $older . $newer . '</ul><!-- end .navigation -->';
	}
	

	if ( $older || $newer )
		echo $nav;
}

function ultimatum_numeric_posts_nav() {
	if( is_singular() )
		return;
	global $wp_query;
	if( $wp_query->max_num_pages <= 1 )
		return;
	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );
	if ( $paged >= 1 )
		$links[] = $paged;
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}
	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}
	global $ultimatumlayout;
	if($ultimatumlayout->gridwork!="tbs3"){
		echo '<div class="pagination"><ul>' . "\n";
	} else {
		echo '<div><ul class="pagination">' . "\n";
	}
	
	if ( get_previous_posts_link() )
		printf( '<li>%s</li>' . "\n", get_previous_posts_link( apply_filters( 'ultimatum_prev_link_text', '&#x000AB;' . __( 'Previous Page', 'ultimatum' ) ) ) );
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
		if ( ! in_array( 2, $links ) )
			echo '<li><a>&#x02026;</a></li>';
	}
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li><a>&#x02026;</a></li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}
	if ( get_next_posts_link() )
		printf( '<li>%s</li>' . "\n", get_next_posts_link( apply_filters( 'ultimatum_next_link_text', __( 'Next Page', 'ultimatum' ) . '&#x000BB;' ) ) );

	echo '</ul></div>' . "\n";

}


function ultimatum_prev_next_post_nav() {
	if ( ! is_singular( 'post' ) )
		return;
	?>
    <?php
    $formatbefore = '&laquo; %link';
    $formatbefore = apply_filters('ultimatum/loop/prenextpost/formatbefore',$formatbefore);
    $formatafter = '%link &raquo;';
    $formatafter = apply_filters('ultimatum/loop/prenextpost/formatafter',$formatafter);
    $link = '%title';
    $link = apply_filters('ultimatum/loop/prenextpost/link',$link);
    $in_same_term = false;
    $in_same_term = apply_filters('ultimatum/loop/prenextpost/in_same_term',$in_same_term);
    $excluded_terms = '';
    $excluded_terms = apply_filters('ultimatum/loop/prenextpost/excluded_terms',$excluded_terms);
    $taxonomy = 'category';
    $taxonomy = apply_filters('ultimatum/loop/prenextpost/taxonomy',$taxonomy);
    ?>
    <div class="clearfix"></div>
	<div class="navigation prev-next-post-nav">
		<div class="alignleft prev-post"><?php previous_post_link( $formatbefore, $link, $in_same_term , $excluded_terms, $taxonomy ); ?></div>
		<div class="alignright next-post"><?php next_post_link( $formatafter, $link, $in_same_term , $excluded_terms, $taxonomy ); ?></div>
	</div>
    <div class="clearfix"></div>
	<?php
}

class UltimatumExcerpt {
	public static $length = 55;
	public static function length($new_length = 55) {
		UltimatumExcerpt::$length = $new_length;
		add_filter('excerpt_length', array('UltimatumExcerpt','new_length'),999);
		return UltimatumExcerpt::output();
	}
	public static function new_length() {
		return UltimatumExcerpt::$length;
	}
	public static function output() {
		return get_the_excerpt();
	}
}

// An alias to the class
function ult_excerpt($length = 55) {
	return UltimatumExcerpt::length($length);
}