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



require_once (ULTIMATUM_FUNCTIONS.DS.'loop'.DS.'loop-functions.php');
require_once (ULTIMATUM_FUNCTIONS.DS.'comments.php');
add_action('ultimatum_loop', 'ultimatum_standard_loop',10,2);
function ultimatum_standard_loop($args=null,$instance=null) {
	global $ultimatum_inline_css;
	extract( $args );
	$per_page = $instance["perpage"];
	$loop_text_vars = $instance['loop_text_vars'];
	$gallery=false;
	$noimage=false;
	$imgw=false;
	$clear=true;
	$rel='';
	$instance['ult_full_image']= true;
	if(is_singular()){ // Build the Loop structure for single content pages
		if(preg_match('/.php/i', $instance["single"])) {
			$loopfile = $instance["single"];
		}
		switch ($instance["single"]){
			case 'rimage':
				$image = true;
				$align = "fimage-align-right";
				$imgw=$instance["singlew"];
				$instance['ult_full_image']= false;
				break;
			case 'limage':
				$image = true;
				$align = "fimage-align-left";
				$imgw=$instance["singlew"];
				$instance['ult_full_image']= false;
				break;
			case 'fimage':
				$image = true;
				$imgw = $grid_width;
				$align='';
				break;
			default:
				$image= false;
				$align='';
				break;
		}
	} else {
		global $wp_query;
		$paged = (get_query_var('paged') && get_query_var('paged') > 1) ? get_query_var('paged') : 1;
		$args = array_merge(
				$wp_query->query,
				array(
						'posts_per_page' =>$per_page,
						"paged"=>$paged,
				)
		);
		query_posts( $args );
		if(preg_match('/.php/i', $instance["multiple"])) {
			$loopfile = $instance["multiple"];
		}
		$title = apply_filters('widget_title', $instance['title']);
		$colprops = explode('-', $instance["multiple"]);
		$colcount = $colprops[0];
		switch ($colcount){
			case '1':
				$imgw = $grid_width;
				$cols = 1;
				break;
			case '2':
				$imgw = $grid_width/2;
				$cols = 2;
				add_filter( 'post_class', 'ultimatum_entry_post_class_half' );
				break;
			case '3':
				$imgw = $grid_width/3;
				$cols = 3;
				add_filter( 'post_class', 'ultimatum_entry_post_class_third' );
				break;
			case '4':
				$imgw = $grid_width/4;
				$cols = 4;
				add_filter( 'post_class', 'ultimatum_entry_post_class_fourth' );
				break;
		}
		$colcount=$cols;
		if($colcount==1 && ($colprops[2]=='ri' || $colprops[2]=='li' || $colprops[2]=='gl' || $colprops[2]=='gr') ){
			$imgw=$instance["multiplew"];
			$instance['ult_full_image']= false;
		}
		$gallery =false;
		switch($colprops[2]){
			
			case 'ri':
				$align = "fimage-align-right";
				$image = true;
				
				break;
			case 'li':
				$align = "fimage-align-left";
				$image = true;
				break;
			case 'gl':
				$align = "fimage-align-left";
				$rel = 'rel="prettyPhoto[]"';
				$gallery =true;
				$image = true;
				break;
			case 'gr':
				$align = "fimage-align-right";;
				$rel = 'rel="prettyPhoto[]"';
				$gallery =true;
				$image = true;
				break;
			case 'g':
				$rel = 'rel="prettyPhoto[]"';
				$gallery =true;
				$align='';
				$image = true;
				break;
			case 'i':
				$align='';
				$image = true;
				break;
			default:
				$image = false;
				$align='';
				break;
		}
	}
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(isset($loopfile) && file_exists(THEME_LOOPS_DIR.DS.$loopfile)){
		include(THEME_LOOPS_DIR.DS.$loopfile);
	} elseif (is_plugin_active( 'wonderloops/wonderloops.php' ) && isset($loopfile) && file_exists(ULTLOOPBUILDER_DIR.DS.$loopfile) ) { //Wonder Loop include
		include(ULTLOOPBUILDER_DIR.DS.$loopfile);
	} else {
 	global $loop_counter;
 
 	$loop_counter = 0;
 	$igogrid=1;
 	?>
 	<div id="content" role="main">
 	<?php 
 	if(!is_singular() && $instance['atitle']=='ON') {
	$tag = (get_ultimatum_option('tags', 'archive_title') ? get_ultimatum_option('tags', 'archive_title') : 'h1');
 	?>
 	<<?php echo $tag;?> class="multi-post-title">
	    <?php if ( is_day() ) : ?>
		    <?php printf( $loop_text_vars['daily'], '<span>' . get_the_date() . '</span>' ); ?>
	    <?php elseif ( is_month() ) : ?>
		    <?php printf( $loop_text_vars['monthly'], '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'ultimatum' ) ) . '</span>' ); ?>
	    <?php elseif ( is_year() ) : ?>
		    <?php printf( $loop_text_vars['yearly'], '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'ultimatum' ) ) . '</span>' ); ?>
	    <?php elseif(is_search()) : ?>
		    <?php printf( $loop_text_vars['search'], '<span>' . get_search_query() . '</span>' ); ?>
	    <?php elseif(is_author()) : ?>
		    <?php printf( $loop_text_vars['author'], '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?>
	    <?php else:
            if(single_term_title( '', false )) {
                printf($loop_text_vars['archives'], '<span>' . single_term_title('', false) . '</span>');
            }
	        endif; ?>
    </<?php echo $tag;?>>
    <?php  } ?>
 	<?php 
 	
 	if ( have_posts() ) : while ( have_posts() ) : the_post();
        if($instance['postnavigation']=='ontop'){
            ultimatum_prev_next_post_nav();
        }
 	$currentpostbefore = 'ultimatum_before_post_'.$loop_counter;
 	$currentpostafter = 'ultimatum_after_post_'.$loop_counter;
 	
 	do_action( 'ultimatum_before_post' );
 	if(!is_singular()){
 		do_action($currentpostbefore);
 		$clear=true;
 		if($colcount!=1)://gridd
 		if($igogrid==1){
 			$igogrid++;
 			remove_filter( 'post_class', 'ultimatum_entry_post_class_last' );
 			$clear=false;
 		} elseif($igogrid==$colcount){
 			add_filter( 'post_class', 'ultimatum_entry_post_class_last' );
 			$clear=true;
 			$igogrid=1;
 		} else{
 			$igogrid++;
 			remove_filter( 'post_class', 'ultimatum_entry_post_class_last' );
 			$clear=false;
 		}
 		
 		endif;//gridd
 	}
 	
 	if($image){
 		if(is_singular()){
 			if($instance['imgpos']!='btitle'){
				add_action('ultimatum_after_post_title','ultimatum_content_item_image',10,6);
			} else {
				add_action('ultimatum_before_post_title','ultimatum_content_item_image',10,6);
			}
 		} else {
 			if($instance['mimgpos']!='btitle'){
 				add_action('ultimatum_after_post_title','ultimatum_content_item_image',10,6);
 			} else {
 				add_action('ultimatum_before_post_title','ultimatum_content_item_image',10,6);
 			}
 		}
 	} else { //controller for meta 
 		if((is_singular() && $instance['meta']=='aimage')){
 			$instance['meta']='atitle';
 		}
 		if((is_singular() && $instance['meta']=='bimage')){
 			$instance['meta']='atitle';
 		}
 		if((!is_singular() && $instance['mmeta']=='aimage')){
 			$instance['mmeta']='atitle';
 		}
 	}
 	if((is_singular() && $instance['meta']=='atext')){
 		add_action( 'ultimatum_after_post_content', 'ultimatum_post_meta',10,2);
 	}
 	if((is_singular() && $instance['meta']=='atitle')){
 		add_action( 'ultimatum_after_post_title', 'ultimatum_post_meta',10,2);
 	}
 	if((is_singular() && $instance['meta']=='aimage')){
 		add_action( 'ultimatum_after_featured_image', 'ultimatum_post_meta',10,2);
 	}
 	if((is_singular() && $instance['meta']=='bimage')){
 		add_action( 'ultimatum_before_featured_image', 'ultimatum_post_meta',10,2);
 	}
 	if((is_singular() && $instance['cats']=='acontent')){
 		add_action( 'ultimatum_after_post_content', 'ultimatum_post_tax' );
 	}
 	if((!is_singular() && $instance['mmeta']=='atitle')){
 		add_action( 'ultimatum_after_post_title', 'ultimatum_post_meta',10,2 );
 	}
 	if((!is_singular() && $instance['mmeta']=='atext')){
 		add_action( 'ultimatum_after_post_content', 'ultimatum_post_meta',10,2 );
 	}
 	if((!is_singular() && $instance['mmeta']=='aimage')){
 		add_action( 'ultimatum_after_featured_image', 'ultimatum_post_meta',10,2 );
 	}
 	if((!is_singular() && $instance['mcats']=='acontent')){
 		add_action( 'ultimatum_after_post_content', 'ultimatum_post_tax' );
 	}

 	?>
 	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

 		<?php do_action( 'ultimatum_before_post_title',$args,$instance,$imgw,$rel,$align,$gallery); ?>
 		<?php do_action( 'ultimatum_post_title',$args,$instance ); ?>
 		<?php do_action( 'ultimatum_after_post_title',$args,$instance,$imgw,$rel,$align,$gallery); ?>
 
 		<?php do_action( 'ultimatum_before_post_content',$args,$instance ); ?>
 		<div class="entry-content">
 			<?php do_action( 'ultimatum_post_content',$instance ); ?>
 		</div>
 		<?php do_action( 'ultimatum_after_post_content',$args,$instance ); ?>
 		<div class="clearfix"></div>
 	</article>
 	<?php
        if($instance['postnavigation']=='atbottom'){
            ultimatum_prev_next_post_nav();
        }
  	do_action( 'ultimatum_after_post',$instance );
  	if(!is_singular()){do_action($currentpostafter);}
  	if($clear) echo '<div class="clearfix"></div>';

 	$loop_counter++;
 
 	endwhile; /** end of one post **/
 	do_action( 'ultimatum_after_endwhile',$instance );
 
 	else : /** if no posts exist **/
 	do_action( 'ultimatum_loop_else' );
 	endif; /** end loop **/
 	?>
 	</div>
 	<?php
 }
}
