<?php
if(get_ultimatum_option('extras','ultimatum_slideshows')){
class UltimatumSlide extends WP_Widget {

	function UltimatumSlide() {
        parent::WP_Widget(false, $name = 'Ultimatum SlideShow');
    }

function widget($args, $instance) {
      	global $wpdb;
      	$uslider=false;
      	extract( $args );
      	$instance["Width"]=$grid_width;
      	if(preg_match('/ptype-/i',$instance["slide"])){
			$post_type= str_replace('ptype-', '', $instance["slide"]);
			$query = array( 
				'post_type' => $post_type, 
				'showposts'=>$instance["number"], 
				'orderby'=>'date', 
				'order'=>'DESC',
				'meta_key'=>'_thumbnail_id',
			);
			
			$loop = new WP_Query($query);
			$images = array();
			while ( $loop->have_posts() ) : $loop->the_post();
				$image_id = get_post_thumbnail_id();
				$images[] = array(
					'image_id'=>$image_id,
					'id' => get_the_ID(),
					'title' => get_the_title(),
					'text'  => wp_html_excerpt(get_the_excerpt(),$instance["exlen"]).'...',
					'link' => get_permalink(),
					'video' =>get_post_meta(get_the_ID(),'ultimatum_video',true),
					'target' => '_self'
				);
			endwhile;
			
		} elseif(preg_match('/cat-/i',$instance["slide"])){
      		$catid = str_replace('cat-', '', $instance["slide"]);
      		$query = array( 
				'post_type' => 'post', 
				'showposts'=>$instance[number], 
				'orderby'=>'date', 
				'order'=>'DESC',
				'meta_key'=>'_thumbnail_id',
      			'cat'=>$catid,
			);
			
			$loop = new WP_Query($query);
			$images = array();
			while ( $loop->have_posts() ) : $loop->the_post();
				$image_id = get_post_thumbnail_id();
				$images[] = array(
					'image_id'=>$image_id,
					'id' => get_the_ID(),
					'title' => get_the_title(),
					'text'  => wp_html_excerpt(get_the_excerpt(),$instance["exlen"]).'...',
					'link' => get_permalink(),
					'target' => '_self',
					'video' =>get_post_meta(get_the_ID(),'ultimatum_video',true),
				);
			endwhile;
      		
      	} elseif(preg_match('/taxonomy-/i',$instance["slide"])){
      		$prop = explode('|',str_replace('taxonomy-', '', $instance["slide"]));
      		$query = array( 
				'post_type' => $prop[0], 
				'showposts'=>$instance["number"], 
				'orderby'=>'date', 
				'order'=>'DESC',
			);
			
				global $wp_version;
				if(version_compare($wp_version, "3.1", '>=')){
					$query['tax_query'] = array(
						array(
							'taxonomy' => $prop[1],
							'field' => 'slug',
							'terms' => explode(',', $prop[2])
						)
					);
				}else{
					$query['taxonomy'] = $prop[1];
					$query['term'] = $prop[2];
				}
			
			
			$loop = new WP_Query($query);
			$images = array();
			while ( $loop->have_posts() ) : $loop->the_post();
				$image_id = get_post_thumbnail_id();
				$images[] = array(
					'image_id'=>$image_id,
					'id' => get_the_ID(),
					'title' => get_the_title(),
					'text'  => wp_html_excerpt(get_the_excerpt(),$instance["exlen"]).'...',
					'link' => get_permalink(),
					'target' => '_self',
					'video' =>get_post_meta(get_the_ID(),'ultimatum_video',true),
				);
			endwhile;
      	} else {
      		$image_ids_str = get_post_meta($instance["slide"],'_image_ids',true);
      		$image_ids = explode(',',str_replace('image-','',$image_ids_str));
      		foreach($image_ids as $image_id){
      			$title = get_post_meta($image_id,'_ult_slide_title',true) ? get_post_meta($image_id,'_ult_slide_title',true) :get_post_field('post_title', $image_id);
      			$text = get_post_meta($image_id,'_ult_slide_text',true) ? get_post_meta($image_id,'_ult_slide_text',true) :get_post_field('post_excerpt', $image_id);
      			$link = get_post_meta($image_id,'_ult_slide_link',true) ? get_post_meta($image_id,'_ult_slide_link',true) :false;
      			$video = get_post_meta($image_id,'_ult_slide_video',true) ? get_post_meta($image_id,'_ult_slide_video',true) :false;
      			$target = get_post_meta($image_id,'_ult_slide_target',true) ? get_post_meta($image_id,'_ult_slide_target',true) :'_self';
      			$images[] = array(
					'image_id'=>$image_id,
					'title' => $title,
					'text'  => $text,
					'link' => $link,
					'target' => $target,
					'video' => $video
				);
      		}
      	}
      	if(count($images)>0){
      		
      	} else {
      		//return;
      	}
      	echo $before_widget;
      	if ( $instance["title"])
				echo $before_title . $instance["title"] . $after_title;
		if($instance["Slider"]=='nivo'){
			include(ULTIMATUM_WIDGETS.'/sliders/nivo.php');
		} elseif($instance["Slider"]=='s3'){
			include(ULTIMATUM_WIDGETS.'/sliders/s3.php');
	    } elseif ($instance["Slider"]=='slidedeck'){
	    	include(ULTIMATUM_WIDGETS.'/sliders/slidedeck.php');
		}elseif ($instance["Slider"]=='anything') {
			include(ULTIMATUM_WIDGETS.'/sliders/anything.php');
		}elseif ($instance["Slider"]=='flex') {
			include(ULTIMATUM_WIDGETS.'/sliders/flex.php');
		}elseif ($instance["Slider"]=='zaccordion') {
			include(ULTIMATUM_WIDGETS.'/sliders/zaccordion.php');
		}elseif ($instance["Slider"]=='supersized') {
			include(ULTIMATUM_WIDGETS.'/sliders/supersized.php');
		}elseif ($instance["Slider"]=='ei') {
				include(ULTIMATUM_WIDGETS.'/sliders/ei.php');
		} 
		echo $after_widget;
 
    }

 function update( $new_instance, $old_instance ) {
 		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['slide']					= $new_instance['slide'];
		$instance['number']					= $new_instance['number'];
		$instance['exlen']					= $new_instance['exlen'];
		$instance['Height']					= $new_instance['Height'];
		$instance['Slider']					= $new_instance['Slider'];
		
		$instance['nivo_effect']			= $new_instance['nivo_effect'];
		$instance['nivo_segments']			= $new_instance['nivo_segments'];
		$instance['nivo_animspeed']			= $new_instance['nivo_animspeed'];
		$instance['nivo_pausetime']			= $new_instance['nivo_pausetime'];
		$instance['nivo_nav']				= $new_instance['nivo_nav'];
		$instance['nivo_navhover']			= $new_instance['nivo_navhover'];
		$instance['nivo_controls']			= $new_instance['nivo_controls'];
		$instance['nivo_pausehover']		= $new_instance['nivo_pausehover'];
		$instance['nivo_captions']			= $new_instance['nivo_captions'];
		$instance['nivo_captionsopacity']	= $new_instance['nivo_captionsopacity'];
		$instance['nivo_color']				= $new_instance['nivo_color'];
		
		$instance['SDWidth']				= $new_instance['SDWidth'];
		$instance['SDHeight']				= $new_instance['SDHeight'];
		$instance['SDSpines']				= $new_instance['SDSpines'];
		$instance['SDAuto']					= $new_instance['SDAuto'];
		$instance['SDIndex']				= $new_instance['SDIndex'];
		$instance['SDVideo']				= $new_instance['SDVideo'];
		$instance['SDInterval']				= $new_instance['SDInterval'];
		
		$instance['AnyBg']					= $new_instance['AnyBg'];
		$instance['AnyType']				= $new_instance['AnyType'];
		$instance['AnyVideo']				= $new_instance['AnyVideo'];
		$instance['AnyWidth']				= $new_instance['AnyWidth'];
		$instance['AnyHeight']				= $new_instance['AnyHeight'];
		$instance['AnyEff']					= $new_instance['AnyEff'];
		$instance['AnyAuto']				= $new_instance['AnyAuto'];
		$instance['AnyHover']				= $new_instance['AnyHover'];
		$instance['AnyArrows']				= $new_instance['AnyArrows'];
		$instance['AnyNavi']				= $new_instance['AnyNavi'];
		$instance['AnyColor']				= $new_instance['AnyColor'];
		$instance['AnyCaption']				= $new_instance['AnyCaption'];
		$instance['AnyanimationTime']		= $new_instance['AnyanimationTime'];
		$instance['Anydelay']				= $new_instance['Anydelay'];
		$instance['AnyEasing']				= $new_instance['AnyEasing'];
		
		$instance['s3height']				= $new_instance['s3height'];
		$instance['s3width']				= $new_instance['s3width'];
		$instance['s3captions']				= $new_instance['s3captions'];
		$instance['s3timeout']				= $new_instance['s3timeout'];
		
		$instance['flexanimation'] 			= $new_instance['flexanimation'];
		$instance['flexslideDirection'] 	= $new_instance['flexslideDirection'];
		$instance['flexslideshow'] 			= $new_instance['flexslideshow']; 
		$instance['flexslideshowSpeed'] 	= $new_instance['flexslideshowSpeed'];
		$instance['flexanimationDuration']	= $new_instance['flexanimationDuration'];
		$instance['flexdirectionNav'] 		= $new_instance['flexdirectionNav']; 
		$instance['flexcontrolNav']			= $new_instance['flexcontrolNav'];	
		$instance['flexkeyboardNav']		= $new_instance['flexkeyboardNav'];
		$instance['flexmousewheel']			= $new_instance['flexmousewheel'];
		$instance['flexrandomize']			= $new_instance['flexrandomize'];
		$instance['flexanimationLoop']		= $new_instance['flexanimationLoop'];
		$instance['flexpauseOnAction']		= $new_instance['flexpauseOnAction'];
		$instance['flexpauseOnHover']		= $new_instance['flexpauseOnHover'];
		
		$instance['zAWidth']				= $new_instance['zAWidth'];
		$instance['zAAuto']					= $new_instance['zAAuto'];
		$instance['zAStyle']				= $new_instance['zAStyle'];
		$instance['zAColor']				= $new_instance['zAColor'];
		$instance['zABcolor']				= $new_instance['zABcolor'];
		$instance['zAspeed']				= $new_instance['zAspeed'];
		$instance['zAtimeout']				= $new_instance['zAtimeout'];
		$instance['zAEasing']				= $new_instance['zAEasing'];
		
		$instance['superTrans']				= $new_instance['superTrans'];
		$instance['superType']				= $new_instance['superType'];
		$instance['superHeight']			= $new_instance['superHeight'];
		$instance['superTop']				= $new_instance['superTop'];
		$instance['super_color']			= $new_instance['super_color'];
		$instance['superCaptions']			= $new_instance['superCaptions'];
		$instance['superCaptionsColor']		= $new_instance['superCaptionsColor'];
		$instance['superCaptionsText']		= $new_instance['superCaptionsText'];
		$instance['superSpeed']				= $new_instance['superSpeed'];
		$instance['superInterval']			= $new_instance['superInterval'];
		$instance['superControls']			= $new_instance['superControls'];
		$instance['ei_interval']			= $new_instance['ei_interval'];
		$instance['ei_autoplay']			= $new_instance['ei_autoplay'];
		return $instance;
	}
function form($instance) {
		$title = isset( $instance['title'] ) ? esc_attr($instance['title']) : '';
		$slide					= isset( $instance['slide'] ) ? $instance['slide'] : '';
		$number					= isset( $instance['number'] ) ? $instance['number'] : '5';
		$exlen					= isset( $instance['exlen'] ) ? $instance['exlen'] : '200';
		$Height					= isset( $instance['Height'] ) ? $instance['Height'] : '400';
		$Slider					= isset( $instance['Slider'] ) ? $instance['Slider'] : 'nivo';
		/* Nivo */
		$nivo_effect			= isset( $instance['nivo_effect'] ) ? $instance['nivo_effect'] : 'random';
		$nivo_segments			= isset( $instance['nivo_segments'] ) ? $instance['nivo_segments'] : '10';
		$nivo_animspeed 		= isset( $instance['nivo_animspeed'] ) ? $instance['nivo_animspeed'] : '700';
		$nivo_pausetime			= isset( $instance['nivo_pausetime'] ) ? $instance['nivo_pausetime'] : '4000';
		$nivo_nav				= isset( $instance['nivo_nav'] ) ? $instance['nivo_nav'] : '';
		$nivo_navhover			= isset( $instance['nivo_navhover'] ) ? $instance['nivo_navhover'] : '';
		$nivo_controls			= isset( $instance['nivo_controls'] ) ? $instance['nivo_controls'] : '';
		$nivo_pausehover		= isset( $instance['nivo_pausehover'] ) ? $instance['nivo_pausehover'] : '';
		$nivo_captions 			= isset( $instance['nivo_captions'] ) ? $instance['nivo_captions'] : '';
		$nivo_captionsopacity	= isset( $instance['nivo_captionsopacity'] ) ? $instance['nivo_captionsopacity'] : '0.5';
		$nivo_color				= isset( $instance['nivo_color'] ) ? $instance['nivo_color'] : 'grey';
		/* Slide Deck */
		$SDWidth				= isset( $instance['SDWidth'] ) ? $instance['SDWidth'] : '300';
		$SDHeight				= isset( $instance['SDHeight'] ) ? $instance['SDHeight'] : '300';
		$SDSpines				= isset( $instance['SDSpines'] ) ? $instance['SDSpines'] : 'false';
		$SDAuto					= isset( $instance['SDAuto'] ) ? $instance['SDAuto'] : 'false';
		$SDIndex				= isset( $instance['SDIndex'] ) ? $instance['SDIndex'] : 'false';
		$SDVideo				= isset( $instance['SDVideo'] ) ? $instance['SDVideo'] : 'false';
		$SDInterval				= isset( $instance['SDInterval'] ) ? $instance['SDInterval'] : '2500';
		/* Anything */
		$AnyBg					= isset( $instance['AnyBg'] ) ? $instance['AnyBg'] : '#FFFFFF';
		$AnyType				= isset( $instance['AnyType'] ) ? $instance['AnyType'] : 'full';
		$AnyVideo				= isset( $instance['AnyVideo'] ) ? $instance['AnyVideo'] : 'true';
		$AnyWidth				= isset( $instance['AnyWidth'] ) ? $instance['AnyWidth'] : '300';
		$AnyHeight				= isset( $instance['AnyHeight'] ) ? $instance['AnyHeight'] : '375';
		$AnyEff					= isset( $instance['AnyEff'] ) ? $instance['AnyEff'] : 'false';
		$AnyAuto				= isset( $instance['AnyAuto'] ) ? $instance['AnyAuto'] : 'true';
		$AnyHover				= isset( $instance['AnyHover'] ) ? $instance['AnyHover'] : 'true';
		$AnyArrows				= isset( $instance['AnyArrows'] ) ? $instance['AnyArrows'] : 'false';
		$AnyNavi				= isset( $instance['AnyNavi'] ) ? $instance['AnyNavi'] : 'true';
		$AnyColor				= isset( $instance['AnyColor'] ) ? $instance['AnyColor'] : 'grey';
		$AnyCaption				= isset( $instance['AnyCaption'] ) ? $instance['AnyCaption'] : 'false';
		$AnyanimationTime		= isset( $instance['AnyanimationTime'] ) ? $instance['AnyanimationTime'] : '600';
		$Anydelay				= isset( $instance['Anydelay'] ) ? $instance['Anydelay'] : '2000';
		$AnyEasing				= isset( $instance['AnyEasing'] ) ? $instance['AnyEasing'] : 'Back';
		/* S3 Slider */
		$s3height				= isset( $instance['s3height'] ) ? $instance['s3height'] : '200';//
		$s3width				= isset( $instance['s3width'] ) ? $instance['s3width'] : '350';
		$s3captions				= isset( $instance['s3captions'] ) ? $instance['s3captions'] : 'left';
		$s3timeout				= isset( $instance['s3timeout'] ) ? $instance['s3timeout'] : '4000';
		/* Flex Slider */
		$flexanimation			= isset( $instance['flexanimation'] ) ? $instance['flexanimation'] : 'fade';
		$flexslideDirection		= isset( $instance['flexslideDirection'] ) ? $instance['flexslideDirection'] : 'horizontal';
		$flexslideshow			= isset( $instance['flexslideshow'] ) ? $instance['flexslideshow'] : 'true';
		$flexslideshowSpeed		= isset( $instance['flexslideshowSpeed'] ) ? $instance['flexslideshowSpeed'] : '7000';
		$flexanimationDuration	= isset( $instance['flexanimationDuration'] ) ? $instance['flexanimationDuration'] : '600';
		$flexdirectionNav		= isset( $instance['flexdirectionNav'] ) ? $instance['flexdirectionNav'] : 'true';
		$flexcontrolNav			= isset( $instance['flexcontrolNav'] ) ? $instance['flexcontrolNav'] : 'true';
		$flexkeyboardNav		= isset( $instance['flexkeyboardNav'] ) ? $instance['flexkeyboardNav'] : 'true';
		$flexmousewheel			= isset( $instance['flexmousewheel'] ) ? $instance['flexmousewheel'] : 'false';
		$flexrandomize			= isset( $instance['flexrandomize'] ) ? $instance['flexrandomize'] : 'false';
		$flexanimationLoop		= isset( $instance['flexanimationLoop'] ) ? $instance['flexanimationLoop'] : 'true';
		$flexpauseOnAction		= isset( $instance['flexpauseOnAction'] ) ? $instance['flexpauseOnAction'] : 'true';
		$flexpauseOnHover		= isset( $instance['flexpauseOnHover'] ) ? $instance['flexpauseOnHover'] : 'false';
		/* zAccordion */
		$zAWidth				= isset( $instance['zAWidth'] ) ? $instance['zAWidth'] : '300';
		$zAAuto					= isset( $instance['zAAuto'] ) ? $instance['zAAuto'] : 'true';
		$zAStyle				= isset( $instance['zAStyle'] ) ? $instance['zAStyle'] : '1';
		$zAColor				= isset( $instance['zAColor'] ) ? $instance['zAColor'] : '000000';
		$zABcolor				= isset( $instance['zABcolor'] ) ? $instance['zABcolor'] : 'FFFFFF';
		$zAspeed				= isset( $instance['zAspeed'] ) ? $instance['zAspeed'] : '100';
		$zAtimeout				= isset( $instance['zAtimeout'] ) ? $instance['zAtimeout'] : '1000';
		$zAEasing				= isset( $instance['zAEasing'] ) ? $instance['zAEasing'] : 'null';
		/* SuperSized */
		$superTrans				=  isset( $instance['superTrans'] ) ? $instance['superTrans'] : '1';
		$superHeight			=  isset( $instance['superHeight'] ) ? $instance['superHeight'] : '300';
		$superType				=  isset( $instance['superType'] ) ? $instance['superType'] : 'full';
		$superTop				=  isset( $instance['superTop'] ) ? $instance['superTop'] : '0';
		$super_color			=  isset( $instance['super_color'] ) ? $instance['super_color'] : 'grey';
		$superCaptions			=  isset( $instance['superCaptions'] ) ? $instance['superCaptions'] : 'false';
		$superCaptionsColor		=  isset( $instance['superCaptionsColor'] ) ? $instance['superCaptionsColor'] : '000000';
		$superCaptionsText		=  isset( $instance['superCaptionsText'] ) ? $instance['superCaptionsText'] : 'ffffff';
		$superSpeed				=  isset( $instance['superSpeed'] ) ? $instance['superSpeed'] : '1000';
		$superInterval			=  isset( $instance['superInterval'] ) ? $instance['superInterval'] : '3000';
		$superControls			=  isset( $instance['superControls'] ) ? $instance['superControls'] : 'false';
		$ei_interval			=  isset( $instance['ei_interval'] ) ? $instance['ei_interval'] : '3000';
		$ei_autoplay			=  isset( $instance['ei_autoplay'] ) ? $instance['ei_autoplay'] : 'true';
		
		
		global $wpdb;
		$termstable = $wpdb->prefix.ULTIMATUM_PREFIX.'_tax';
	 	query_posts( array( 'post_type' => 'ult_slideshow','posts_per_page' => -1 ) );
	 	$result=array();
 		 if ( have_posts() ) :
 		 		$ult_slide= array();
 		 		while ( have_posts() ) : the_post();
	 				$ult_slide = array('id'=>get_the_ID(),'title'=>the_title('','',false));
 		 			$result[]=$ult_slide;
 		 			unset($ult_slide);
				endwhile; 
			endif; 
		//	print_r($result);
			wp_reset_query(); 
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ultimatum'); ?></label>
		<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" class="widefat" />
		</p>
		<p>
	 	<label for="<?php echo $this->get_field_id('slide'); ?>"><?php _e( 'Select Slide Source' ,'ultimatum' ); ?></label>
		<select class="widefat"  name="<?php echo $this->get_field_name('slide'); ?>" id="<?php echo $this->get_field_id('slide'); ?>" >
		
		<?php 
		echo '<optgroup label="Ultimatum Slides">';
		foreach($result as $f){
			?>
			<option value="<?php echo $f["id"];?>" <?php selected($slide,$f["id"]); ?>><?php echo $f["title"];?></option>
			<?php 
			}
		echo '</optgroup>';
		?>
		<optgroup label="Post Types">
		<?php 
			$args=array('public'   => true,'publicly_queryable' => true);
			$post_types=get_post_types($args,'names');
			foreach ($post_types as $post_type ) {
				if($post_type!='attachment')
				echo '<option value="ptype-'.$post_type.'" '.selected($slide,'ptype-'.$post_type,false).'>'.$post_type.'</option>';
			}
		?>
		</optgroup>
		<?php 
		$entries = get_categories('title_li=&orderby=name&hide_empty=1');
		if(count($entries)>=1){
			echo '<optgroup label="Categories(Post)">';
			foreach ($entries as $key => $entry) {
				echo '<option value="cat-'.$entry->term_id.'" '.selected($slide,'cat-'.$entry->term_id,false).'>'.$entry->name.'</option>';
			}
			echo '</optgroup>';
		}
			?>
		<?php 
		
		$termsql = "SELECT * FROM $termstable";
		$termresult = $wpdb->get_results($termsql,ARRAY_A);
		foreach ($termresult as $term){
			$properties = unserialize($term["properties"]);
			echo '<optgroup label="'.$properties["label"].'('.$term["pname"].')">';
			$entries = get_terms($properties["name"],'orderby=name&hide_empty=1');
			foreach($entries as $key => $entry) {
				$optiont='taxonomy-'.$term["pname"].'|'.$properties["name"].'|'.$entry->slug;
				echo '<option value="'.$optiont.'" '.selected($slide,$optiont,false).'>'.$entry->name.'</option>';
				}
			echo '</optgroup>';
		}
		
		?>
		</select>
		
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Item Count' ,'ultimatum' ); ?></label>
		<input class="widefat"  size="5" type="text" value="<?php echo $number; ?>"  id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" />
		<?php _e('If slideshow source is content', 'ultimatum');?>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('exlen'); ?>"><?php _e( 'Excerpt Length' ,'ultimatum' ); ?></label>
		<input class="widefat" size="5" type="text" value="<?php echo $exlen; ?>"  id="<?php echo $this->get_field_id('exlen'); ?>" name="<?php echo $this->get_field_name('exlen'); ?>" />
		<?php _e('If slideshow source is content', 'ultimatum');?>
		</p>
		<p>
      	<label for="<?php echo $this->get_field_id('Height'); ?>"><?php _e( 'Slide Height' ,'ultimatum' ); ?></label>
      	<input class="widefat"  size="5" type="text" value="<?php echo $Height; ?>"  id="<?php echo $this->get_field_id('Height'); ?>" name="<?php echo $this->get_field_name('Height'); ?>" />
      	</p>
     
      	<div class="slider-select-wrapper">
      		<label for="<?php echo $this->get_field_id('Slider'); ?>"><?php _e( 'Select a SlideShow Script' ,'ultimatum' ); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name('Slider'); ?>" id="<?php echo $this->get_field_id('Slider'); ?>" onchange="slideOpts(this);">
				<option value="">Select a Slider</option>
				<option value="nivo" <?php selected($Slider,'nivo'); ?>>Nivo</option>
				<option value="anything" <?php selected($Slider,'anything'); ?>>Anything -(NR)</option>
				<option value="slidedeck" <?php selected($Slider,'slidedeck'); ?>>SlideDeck -(NR)</option>
				<option value="s3" <?php selected($Slider,'s3'); ?>>S3 Slider -(NR)</option>
				<option value="flex" <?php selected($Slider,'flex'); ?>>Flex Slider</option>
				<option value="zaccordion" <?php selected($Slider,'zaccordion'); ?>>zAccordion -(NR)</option>
				<option value="supersized" <?php selected($Slider,'supersized'); ?>>Supersized</option>
				<option value="ei" <?php selected($Slider,'ei'); ?>>Elastic</option>
			</select>
			<div class="slider_options" style="margin-top:10px">
				<div class="ei options" style="<?php if($Slider!='ei'){ echo 'display:none'; }?>">
				<p>
					<label for="<?php echo $this->get_field_id('ei_interval'); ?>"><?php _e( 'Pause Time' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('ei_interval'); ?>" name="<?php echo $this->get_field_name('ei_interval'); ?>">
					<?php 
						for ($i=1000;$i<=30000;$i=$i+500){
							echo '<option value="'.$i.'" '.selected($ei_interval,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>			
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('ei_autoplay'); ?>"><?php _e( 'Auto Play' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('ei_autoplay'); ?>" name="<?php echo $this->get_field_name('ei_autoplay'); ?>" >
						<option value="true" <?php selected($ei_autoplay,'true'); ?> >ON</option>
						<option value="false" <?php selected($ei_autoplay,'false'); ?> >OFF</option>
					</select>	
				</p>
				</div>
				<div class="supersized options" style="<?php if($Slider!='supersized'){ echo 'display:none'; }?>">
					<p><label for="<?php echo $this->get_field_id('superTrans'); ?>"><?php _e( 'Slide Effect' ,'ultimatum' ); ?></label>
						<select class="widefat" name="<?php echo $this->get_field_name('superTrans'); ?>" id="<?php echo $this->get_field_id('superTrans'); ?>">
							<option value="0" <?php selected($superTrans,'0'); ?>>None</option>
							<option value="1" <?php selected($superTrans,'1'); ?>>Fade</option>
							<option value="2" <?php selected($superTrans,'2'); ?>>Slide Top</option>
							<option value="3" <?php selected($superTrans,'3'); ?>>Slide Right</option>
							<option value="4" <?php selected($superTrans,'4'); ?>>Slide Bottom</option>
							<option value="5" <?php selected($superTrans,'5'); ?>>Slide Left</option>
							<option value="6" <?php selected($superTrans,'6'); ?>>Carousel Right</option>
							<option value="7" <?php selected($superTrans,'7'); ?>>Carousel Left</option>
						
						</select></p>
					<p>
						<label for="<?php echo $this->get_field_id('superType'); ?>"><?php _e( 'Type' ,'ultimatum' ); ?></label>
						<select class="widefat" name="<?php echo $this->get_field_name('superType'); ?>" id="<?php echo $this->get_field_id('superType'); ?>">
							<option value="full" <?php selected($superType,'full'); ?>>Background Slider</option>
							<option value="part" <?php selected($superType,'part'); ?>>Full Width Slider</option>
						</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('superSpeed'); ?>"><?php _e( 'Animation Speed' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('superSpeed'); ?>" name="<?php echo $this->get_field_name('superSpeed'); ?>">
					<?php 
						for ($i=200;$i<=3000;$i=$i+100){
							echo '<option value="'.$i.'" '.selected($superSpeed,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('superInterval'); ?>"><?php _e( 'Pause Time' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('superInterval'); ?>" name="<?php echo $this->get_field_name('superInterval'); ?>">
					<?php 
						for ($i=1000;$i<=30000;$i=$i+500){
							echo '<option value="'.$i.'" '.selected($superInterval,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>			
					</p>
					<h3><?php _e('Full Width Slider options', 'ultimatum');?></h3>
					<p>
	      				<label for="<?php echo $this->get_field_id('superHeight'); ?>"><?php _e( 'Height' ,'ultimatum' ); ?></label>
	      				<input class="widefat" type="text" value="<?php echo $superHeight; ?>"  id="<?php echo $this->get_field_id('superHeight'); ?>" name="<?php echo $this->get_field_name('superHeight'); ?>" />
	      			</p>
	      			<p>
	      				<label for="<?php echo $this->get_field_id('superTop'); ?>"><?php _e( 'Space from Top in px' ,'ultimatum' ); ?></label>
	      				<input class="widefat" type="text" value="<?php echo $superTop; ?>"  id="<?php echo $this->get_field_id('superTop'); ?>" name="<?php echo $this->get_field_name('superTop'); ?>" />
	      			</p>
	      			<p>
					<label for="<?php echo $this->get_field_id('superCaptions'); ?>"><?php _e( 'Show Captions' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('superCaptions'); ?>" name="<?php echo $this->get_field_name('superCaptions'); ?>" >
						<option value="true" <?php selected($superCaptions,'true'); ?> >ON</option>
						<option value="false" <?php selected($superCaptions,'false'); ?> >OFF</option>
					</select>	
					</p>
					<p>
	      				<label for="<?php echo $this->get_field_id('superCaptionsColor'); ?>"><?php _e( 'Captions Background Color' ,'ultimatum' ); ?></label>
	      				<input class="widefat" type="text" value="<?php echo $superCaptionsColor; ?>"  id="<?php echo $this->get_field_id('superCaptionsColor'); ?>" name="<?php echo $this->get_field_name('superCaptionsColor'); ?>" />
	      			</p>
	      			<p>
	      				<label for="<?php echo $this->get_field_id('superCaptionsText'); ?>"><?php _e( 'Captions Text Color' ,'ultimatum' ); ?></label>
	      				<input class="widefat" type="text" value="<?php echo $superCaptionsText; ?>"  id="<?php echo $this->get_field_id('superCaptionsText'); ?>" name="<?php echo $this->get_field_name('superCaptionsText'); ?>" />
	      			</p>
	      			<p>
					<label for="<?php echo $this->get_field_id('superControls'); ?>"><?php _e( 'Show Next & Prev' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('superControls'); ?>" name="<?php echo $this->get_field_name('superControls'); ?>" >
						<option value="true" <?php selected($superControls,'true'); ?> >ON</option>
						<option value="false" <?php selected($superControls,'false'); ?> >OFF</option>
					</select>	
					</p>
	      			<p>
					<label for="<?php echo $this->get_field_id('super_color'); ?>"><?php _e( 'Theme' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('super_color'); ?>" name="<?php echo $this->get_field_name('super_color'); ?>" >
						<option value="grey" <?php selected($super_color,'grey'); ?> >Grey</option>
						<option value="blue" <?php selected($super_color,'blue'); ?> >Blue</option>
						<option value="green" <?php selected($super_color,'green'); ?> >Green</option>
						<option value="orange" <?php selected($super_color,'orange'); ?> >Orange</option>
						<option value="purple" <?php selected($super_color,'purple'); ?> >Purple</option>
						<option value="red" <?php selected($super_color,'red'); ?> >Red</option>
						<option value="yellow" <?php selected($super_color,'yellow'); ?> >Yellow</option>
					</select>
					</p>
				</div>
				<div class="nivo options" style="<?php if($Slider!='nivo'){ echo 'display:none'; }?>">
						<p><label for="<?php echo $this->get_field_id('nivo_effect'); ?>"><?php _e( 'Slide Effect' ,'ultimatum' ); ?></label>
						<select class="widefat" name="<?php echo $this->get_field_name('nivo_effect'); ?>" id="<?php echo $this->get_field_id('nivo_effect'); ?>">
							<option value="random" <?php selected($nivo_effect,'random'); ?>>random</option>
							<option value="sliceDown" <?php selected($nivo_effect,'sliceDown'); ?>>sliceDown</option>
							<option value="sliceDownLeft" <?php selected($nivo_effect,'sliceDownLeft'); ?>>sliceDownLeft</option>
							<option value="sliceUp" <?php selected($nivo_effect,'sliceUp'); ?>>sliceUp</option>
							<option value="sliceUpLeft" <?php selected($nivo_effect,'sliceUpLeft'); ?>>sliceUpLeft</option>
							<option value="sliceUpDown" <?php selected($nivo_effect,'sliceUpDown'); ?>>sliceUpDown</option>
							<option value="sliceUpDownLeft" <?php selected($nivo_effect,'sliceUpDownLeft'); ?>>sliceUpDownLeft</option>
							<option value="fold" <?php selected($nivo_effect,'fold'); ?>>fold</option>
							<option value="fade" <?php selected($nivo_effect,'fade'); ?>>fade</option>
							<option value="slideInRight" <?php selected($nivo_effect,'slideInRight'); ?>>slideInRight</option>
							<option value="slideInLeft" <?php selected($nivo_effect,'slideInLeft'); ?>>slideInLeft</option>
							<option value="boxRandom" <?php selected($nivo_effect,'boxRandom'); ?>>boxRandom</option>
							<option value="boxRain" <?php selected($nivo_effect,'boxRain'); ?>>boxRain</option>
							<option value="boxRainReverse" <?php selected($nivo_effect,'boxRainReverse'); ?>>boxRainReverse</option>
							<option value="boxRainGrow" <?php selected($nivo_effect,'boxRainGrow'); ?>>boxRainGrow</option>
							<option value="boxRainGrowReverse" <?php selected($nivo_effect,'boxRainGrowReverse'); ?>>boxRainGrowReverse</option>
						</select></p>
					<p>
					<label for="<?php echo $this->get_field_id('nivo_segments'); ?>"><?php _e( 'Segments' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('nivo_segments'); ?>" name="<?php echo $this->get_field_name('nivo_segments'); ?>">
					<?php 
						for ($i=1;$i<=30;$i++){
							echo '<option value="'.$i.'" '.selected($nivo_segments,$i,false).'>'.$i.'</option>';
						}
					?>
					</select>	
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('nivo_animspeed'); ?>"><?php _e( 'Animation Speed' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('nivo_animspeed'); ?>" name="<?php echo $this->get_field_name('nivo_animspeed'); ?>">
					<?php 
						for ($i=200;$i<=3000;$i=$i+100){
							echo '<option value="'.$i.'" '.selected($nivo_animspeed,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('nivo_pausetime'); ?>"><?php _e( 'Pause Time' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('nivo_pausetime'); ?>" name="<?php echo $this->get_field_name('nivo_pausetime'); ?>">
					<?php 
						for ($i=1000;$i<=30000;$i=$i+500){
							echo '<option value="'.$i.'" '.selected($nivo_pausetime,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>			
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('nivo_nav'); ?>"><?php _e( 'Show Next & Prev' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('nivo_nav'); ?>" name="<?php echo $this->get_field_name('nivo_nav'); ?>" >
						<option value="true" <?php selected($nivo_nav,'true'); ?> >ON</option>
						<option value="false" <?php selected($nivo_nav,'false'); ?> >OFF</option>
					</select>	
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('nivo_navhover'); ?>"><?php _e( 'Next & Prev on Hover' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('nivo_navhover'); ?>" name="<?php echo $this->get_field_name('nivo_navhover'); ?>" >
						<option value="true" <?php selected($nivo_navhover,'true'); ?> >ON</option>
						<option value="false" <?php selected($nivo_navhover,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('nivo_controls'); ?>"><?php _e( 'Control Navigation' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('nivo_controls'); ?>" name="<?php echo $this->get_field_name('nivo_controls'); ?>" >
						<option value="true" <?php selected($nivo_controls,'true'); ?> >ON</option>
						<option value="false" <?php selected($nivo_controls,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('nivo_pausehover'); ?>"><?php _e( 'Pause on Hover' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('nivo_pausehover'); ?>" name="<?php echo $this->get_field_name('nivo_pausehover'); ?>" >
						<option value="true" <?php selected($nivo_pausehover,'true'); ?> >ON</option>
						<option value="false" <?php selected($nivo_pausehover,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('nivo_captions'); ?>"><?php _e( 'Captions' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('nivo_captions'); ?>" name="<?php echo $this->get_field_name('nivo_captions'); ?>" >
						<option value="true" <?php selected($nivo_captions,'true'); ?> >ON</option>
						<option value="false" <?php selected($nivo_captions,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('nivo_captionsopacity'); ?>"><?php _e( 'Caption Opacity' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('nivo_captionsopacity'); ?>" name="<?php echo $this->get_field_name('nivo_captionsopacity'); ?>">
					<?php 
						for ($i=0;$i<=1;$i=$i+0.1){
							echo '<option value="'.$i.'" '.selected($nivo_captionsopacity,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('nivo_color'); ?>"><?php _e( 'Theme' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('nivo_color'); ?>" name="<?php echo $this->get_field_name('nivo_color'); ?>" >
						<option value="grey" <?php selected($nivo_color,'grey'); ?> >Grey</option>
						<option value="blue" <?php selected($nivo_color,'blue'); ?> >Blue</option>
						<option value="green" <?php selected($nivo_color,'green'); ?> >Green</option>
						<option value="orange" <?php selected($nivo_color,'orange'); ?> >Orange</option>
						<option value="purple" <?php selected($nivo_color,'purple'); ?> >Purple</option>
						<option value="red" <?php selected($nivo_color,'red'); ?> >Red</option>
						<option value="yellow" <?php selected($nivo_color,'yellow'); ?> >Yellow</option>
						<option value="theme-bar" <?php selected($nivo_color,'theme-bar'); ?> >Nivo Bar</option>
						<option value="theme-dark" <?php selected($nivo_color,'theme-dark'); ?> >Nivo Dark</option>
						<option value="theme-default" <?php selected($nivo_color,'theme-default'); ?> >Nivo Default</option>
						<option value="theme-light" <?php selected($nivo_color,'theme-light'); ?> >Nivo Light</option>
						
					</select>
					</p>
				</div>
				<div class="anything options" style="<?php if($Slider!='anything'){ echo 'display:none'; }?>">
					<p>
					<label for="<?php echo $this->get_field_id('AnyBg'); ?>"><?php _e( 'Background Color' ,'ultimatum' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id('AnyBg'); ?>" name="<?php echo $this->get_field_name('AnyBg'); ?>" type="text" value="<?php echo $AnyBg;?>"/>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('AnyType'); ?>"><?php _e( 'Slider Type' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('AnyType'); ?>" name="<?php echo $this->get_field_name('AnyType'); ?>" >
						<option value="full" <?php selected($AnyType,'full'); ?> >Full Image/Video</option>
						<option value="html" <?php selected($AnyType,'html'); ?> >Image/Video with Text</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('AnyVideo'); ?>"><?php _e( 'Show Video Instead of Image' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('AnyVideo'); ?>" name="<?php echo $this->get_field_name('AnyVideo'); ?>" >
						<option value="true" <?php selected($AnyVideo,'true'); ?> >ON</option>
						<option value="false" <?php selected($AnyVideo,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<i>Needed if Image/Video with Text option is selected</i><br/>
					<label for="<?php echo $this->get_field_id('AnyWidth'); ?>"><?php _e( 'Image Width in Slide' ,'ultimatum' ); ?></label>
					<input class="widefat" type="text" value="<?php echo $AnyWidth; ?>"  id="<?php echo $this->get_field_id('AnyWidth'); ?>" name="<?php echo $this->get_field_name('AnyWidth'); ?>" /><br />
	      			<label for="<?php echo $this->get_field_id('AnyHeight'); ?>"><?php _e( 'Image Height in Slide' ,'ultimatum' ); ?></label>
	      			<input class="widefat" type="text" value="<?php echo $AnyHeight; ?>"  id="<?php echo $this->get_field_id('AnyHeight'); ?>" name="<?php echo $this->get_field_name('AnyHeight'); ?>" />
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('AnyCaption'); ?>"><?php _e( 'Captions' ,'ultimatum' ); ?><i><?php _e('for full ones', 'ultimatum')?></i></label>
					<select class="widefat" id="<?php echo $this->get_field_id('AnyCaption'); ?>" name="<?php echo $this->get_field_name('AnyCaption'); ?>" >
						<option value="true" <?php selected($AnyCaption,'true'); ?> >ON</option>
						<option value="false" <?php selected($AnyCaption,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('AnyAuto'); ?>"><?php _e( 'Auto Start Slideshow' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('AnyAuto'); ?>" name="<?php echo $this->get_field_name('AnyAuto'); ?>" >
						<option value="true" <?php selected($AnyAuto,'true'); ?> >ON</option>
						<option value="false" <?php selected($AnyAuto,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('Anydelay'); ?>"><?php _e( 'Delay between slides' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('Anydelay'); ?>" name="<?php echo $this->get_field_name('Anydelay'); ?>">
					<?php 
						for ($i=1000;$i<=6000;$i=$i+200){
							echo '<option value="'.$i.'" '.selected($Anydelay,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('AnyanimationTime'); ?>"><?php _e( 'Animation Time' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('AnyanimationTime'); ?>" name="<?php echo $this->get_field_name('AnyanimationTime'); ?>">
					<?php 
						for ($i=300;$i<=1000;$i=$i+100){
							echo '<option value="'.$i.'" '.selected($AnyanimationTime,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('AnyHover'); ?>"><?php _e( 'Pause On Hover' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('AnyHover'); ?>" name="<?php echo $this->get_field_name('AnyHover'); ?>" >
						<option value="true" <?php selected($AnyHover,'true'); ?> >ON</option>
						<option value="false" <?php selected($AnyHover,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('AnyArrows'); ?>"><?php _e( 'Show Arrows' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('AnyArrows'); ?>" name="<?php echo $this->get_field_name('AnyArrows'); ?>" >
						<option value="true" <?php selected($AnyArrows,'true'); ?> >ON</option>
						<option value="false" <?php selected($AnyArrows,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('AnyNavi'); ?>"><?php _e( 'Bottom Navigation' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('AnyNavi'); ?>" name="<?php echo $this->get_field_name('AnyNavi'); ?>" >
						<option value="true" <?php selected($AnyNavi,'true'); ?> >ON</option>
						<option value="false" <?php selected($AnyNavi,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('AnyEasing'); ?>"><?php _e( 'Animation (easing)' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('AnyEasing'); ?>" name="<?php echo $this->get_field_name('AnyEasing'); ?>" >
						<option value="Quad" <?php selected($AnyEasing,'Quad'); ?> >Quad</option>
						<option value="Cubic" <?php selected($AnyEasing,'Cubic'); ?> >Cubic</option>
						<option value="Quart" <?php selected($AnyEasing,'Quart'); ?> >Quart</option>
						<option value="Quint" <?php selected($AnyEasing,'Quint'); ?> >Quint</option>
						<option value="Sine" <?php selected($AnyEasing,'Sine'); ?> >Sine</option>
						<option value="Expo" <?php selected($AnyEasing,'Expo'); ?> >Expo</option>
						<option value="Circ" <?php selected($AnyEasing,'Circ'); ?> >Circ</option>
						<option value="Elastic" <?php selected($AnyEasing,'Elastic'); ?> >Elastic</option>
						<option value="Back" <?php selected($AnyEasing,'Back'); ?> >Back</option>
						<option value="Bounce" <?php selected($AnyEasing,'Bounce'); ?> >Bounce</option>
					</select>
					</p>	
					<p>
					<label for="<?php echo $this->get_field_id('AnyColor'); ?>"><?php _e( 'Theme' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('AnyColor'); ?>" name="<?php echo $this->get_field_name('AnyColor'); ?>" >
						<option value="grey" <?php selected($AnyColor,'grey'); ?> >Grey</option>
						<option value="blue" <?php selected($AnyColor,'blue'); ?> >Blue</option>
						<option value="green" <?php selected($AnyColor,'green'); ?> >Green</option>
						<option value="orange" <?php selected($AnyColor,'orange'); ?> >Orange</option>
						<option value="purple" <?php selected($AnyColor,'purple'); ?> >Purple</option>
						<option value="red" <?php selected($AnyColor,'red'); ?> >Red</option>
						<option value="yellow" <?php selected($AnyColor,'yellow'); ?> >Yellow</option>
					</select>
					</p>		
				</div>
				<!--  Flex slider Form -->
				<div class="flex options" style="<?php if($Slider!='flex'){ echo 'display:none'; }?>">
				<p>
					<label for="<?php echo $this->get_field_id('flexanimation'); ?>"><?php _e( 'Animation' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexanimation'); ?>" name="<?php echo $this->get_field_name('flexanimation'); ?>" >
						<option value="fade" <?php selected($flexanimation,'fade'); ?> >fade</option>
						<option value="slide" <?php selected($flexanimation,'slide'); ?> >slide</option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexslideDirection'); ?>"><?php _e( 'Slide Direction' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexslideDirection'); ?>" name="<?php echo $this->get_field_name('flexslideDirection'); ?>" >
						<option value="horizontal" <?php selected($flexslideDirection,'horizontal'); ?> >fade</option>
						<option value="vertical" <?php selected($flexslideDirection,'vertical'); ?> >vertical</option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexslideshow'); ?>"><?php _e( 'Auto Start' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexslideshow'); ?>" name="<?php echo $this->get_field_name('flexslideshow'); ?>" >
						<option value="true" <?php selected($flexslideshow,'true'); ?> >ON</option>
						<option value="false" <?php selected($flexslideshow,'false'); ?> >OFF</option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexslideshowSpeed'); ?>"><?php _e( 'Slide Speed' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexslideshowSpeed'); ?>" name="<?php echo $this->get_field_name('flexslideshowSpeed'); ?>" >
						<?php 
						for ($i=1000;$i<=10000;$i=$i+1000){
							echo '<option value="'.$i.'" '.selected($flexslideshowSpeed,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexanimationDuration'); ?>"><?php _e( 'Animation Speed' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexanimationDuration'); ?>" name="<?php echo $this->get_field_name('flexanimationDuration'); ?>" >
						<?php 
						for ($i=200;$i<=3000;$i=$i+100){
							echo '<option value="'.$i.'" '.selected($flexanimationDuration,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexdirectionNav'); ?>"><?php _e( 'Navigation' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexdirectionNav'); ?>" name="<?php echo $this->get_field_name('flexdirectionNav'); ?>" >
						<option value="true" <?php selected($flexdirectionNav,'true'); ?> >ON</option>
						<option value="false" <?php selected($flexdirectionNav,'false'); ?> >OFF</option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexcontrolNav'); ?>"><?php _e( 'Control Navigation' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexcontrolNav'); ?>" name="<?php echo $this->get_field_name('flexcontrolNav'); ?>" >
						<option value="true" <?php selected($flexcontrolNav,'true'); ?> >ON</option>
						<option value="false" <?php selected($flexcontrolNav,'false'); ?> >OFF</option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexkeyboardNav'); ?>"><?php _e( 'Keyboard Navigation' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexkeyboardNav'); ?>" name="<?php echo $this->get_field_name('flexkeyboardNav'); ?>" >
						<option value="true" <?php selected($flexkeyboardNav,'true'); ?> >ON</option>
						<option value="false" <?php selected($flexkeyboardNav,'false'); ?> >OFF</option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexmousewheel'); ?>"><?php _e( 'Mouse Wheel' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexmousewheel'); ?>" name="<?php echo $this->get_field_name('flexmousewheel'); ?>" >
						<option value="false" <?php selected($flexmousewheel,'false'); ?> >OFF</option>
						<option value="true" <?php selected($flexmousewheel,'true'); ?> >ON</option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexrandomize'); ?>"><?php _e( 'Random Slides' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexrandomize'); ?>" name="<?php echo $this->get_field_name('flexrandomize'); ?>" >
						<option value="false" <?php selected($flexrandomize,'false'); ?> >OFF</option>
						<option value="true" <?php selected($flexrandomize,'true'); ?> >ON</option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexanimationLoop'); ?>"><?php _e( 'Loop Slides' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexanimationLoop'); ?>" name="<?php echo $this->get_field_name('flexanimationLoop'); ?>" >
					<option value="true" <?php selected($flexanimationLoop,'true'); ?> >ON</option>
						<option value="false" <?php selected($flexanimationLoop,'false'); ?> >OFF</option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexpauseOnAction'); ?>"><?php _e( 'Pause on action' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexpauseOnAction'); ?>" name="<?php echo $this->get_field_name('flexpauseOnAction'); ?>" >
						<option value="true" <?php selected($flexpauseOnAction,'true'); ?> >ON</option>
						<option value="false" <?php selected($flexpauseOnAction,'false'); ?> >OFF</option>
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('flexpauseOnHover'); ?>"><?php _e( 'Pause on hover' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('flexpauseOnHover'); ?>" name="<?php echo $this->get_field_name('flexpauseOnHover'); ?>" >
						<option value="true" <?php selected($flexpauseOnHover,'true'); ?> >ON</option>
						<option value="false" <?php selected($flexpauseOnHover,'false'); ?> >OFF</option>
					</select>
				</p>
					
				</div>
				<!--  Flex slider Form -->
				<div class="s3 options" style="<?php if($Slider!='s3'){ echo 'display:none'; }?>">
					<i>Captions width applies to left-right captions while height applying to top-bottom captions</i>
					<p>
					<label for="<?php echo $this->get_field_id('s3width'); ?>"><?php _e( 'Captions Width' ,'ultimatum' ); ?></label>
					<input class="widefat" type="text" value="<?php echo $s3width; ?>"  id="<?php echo $this->get_field_id('s3width'); ?>" name="<?php echo $this->get_field_name('s3width'); ?>" />
					</p>
					<p>
	      			<label for="<?php echo $this->get_field_id('s3height'); ?>"><?php _e( 'Captions Height' ,'ultimatum' ); ?></label>
	      			<input class="widefat" type="text" value="<?php echo $s3height; ?>"  id="<?php echo $this->get_field_id('s3height'); ?>" name="<?php echo $this->get_field_name('s3height'); ?>" />
	      			</p>
	      			<p>
					<label for="<?php echo $this->get_field_id('s3captions'); ?>"><?php _e( 'Captions' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('s3captions'); ?>" name="<?php echo $this->get_field_name('s3captions'); ?>" >
						<option value="top" <?php selected($s3captions,'top'); ?> ><?php _e('top', 'ultimatum');?></option>
						<option value="bottom" <?php selected($s3captions,'bottom'); ?> ><?php _e('bottom', 'ultimatum');?></option>
						<option value="left" <?php selected($s3captions,'left'); ?> ><?php _e('left', 'ultimatum');?></option>
						<option value="right" <?php selected($s3captions,'right'); ?> ><?php _e('right', 'ultimatum');?></option>
					</select>
					</p>
					<p>
	      			<label for="<?php echo $this->get_field_id('s3timeout'); ?>"><?php _e( 'Slide duration' ,'ultimatum' ); ?></label>
	      			<input class="widefat" type="text" value="<?php echo $s3timeout; ?>"  id="<?php echo $this->get_field_id('s3timeout'); ?>" name="<?php echo $this->get_field_name('s3timeout'); ?>" />
	      			</p>
				</div>
				<div class="zaccordion options" style="<?php if($Slider!='zaccordion'){ echo 'display:none'; }?>">
					<p>
					<label for="<?php echo $this->get_field_id('zAWidth'); ?>"><?php _e( 'Image Width in Slide' ,'ultimatum' ); ?></label>
	      			<input class="widefat" type="text" value="<?php echo $zAWidth; ?>"  id="<?php echo $this->get_field_id('zAWidth'); ?>" name="<?php echo $this->get_field_name('zAWidth'); ?>" />
					</p>
	      			<p>
	      			<p>
					<label for="<?php echo $this->get_field_id('zAAuto'); ?>"><?php _e( 'Auto Slide' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('zAAuto'); ?>" name="<?php echo $this->get_field_name('zAAuto'); ?>" >
						<option value="true" <?php selected($zAAuto,'true'); ?> >ON</option>
						<option value="false" <?php selected($zAAuto,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('zAStyle'); ?>"><?php _e( 'Captions' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('zAStyle'); ?>" name="<?php echo $this->get_field_name('zAStyle'); ?>" >
						<option value="0" <?php selected($zAStyle,'0'); ?> ><?php _e( 'No Captions ' ,'ultimatum' ); ?></option>
						<option value="1" <?php selected($zAStyle,'1'); ?> ><?php _e( 'Bottom Captions' ,'ultimatum' ); ?></option>
						<option value="2" <?php selected($zAStyle,'2'); ?> ><?php _e( 'Fancy Captions' ,'ultimatum' ); ?></option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('zABcolor'); ?>"><?php _e( 'Caption BG Color' ,'ultimatum' ); ?></label>
	      			<input class="widefat" type="text" value="<?php echo $zABcolor; ?>"  id="<?php echo $this->get_field_id('zABcolor'); ?>" name="<?php echo $this->get_field_name('zABcolor'); ?>" />
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('zAColor'); ?>"><?php _e( 'Caption Text Color' ,'ultimatum' ); ?></label>
	      			<input class="widefat" type="text" value="<?php echo $zAColor; ?>"  id="<?php echo $this->get_field_id('zAColor'); ?>" name="<?php echo $this->get_field_name('zAColor'); ?>" />
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('zAtimeout'); ?>"><?php _e( 'Delay Between Slides' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('zAtimeout'); ?>" name="<?php echo $this->get_field_name('zAtimeout'); ?>" >
						<?php 
						for ($i=1000;$i<=10000;$i=$i+500){
							echo '<option value="'.$i.'" '.selected($zAtimeout,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>
				</p>
					<p>
					<label for="<?php echo $this->get_field_id('zAspeed'); ?>"><?php _e( 'Animation Speed' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('zAspeed'); ?>" name="<?php echo $this->get_field_name('zAspeed'); ?>" >
						<?php 
						for ($i=100;$i<=1000;$i=$i+100){
							echo '<option value="'.$i.'" '.selected($zAspeed,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>
				</p>
				<p>
					<label for="<?php echo $this->get_field_id('zAEasing'); ?>"><?php _e( 'Animation (easing)' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('zAEasing'); ?>" name="<?php echo $this->get_field_name('zAEasing'); ?>" >
						<option value="null" <?php selected($zAEasing,'null'); ?> >none</option>
						<option value="Quad" <?php selected($zAEasing,'Quad'); ?> >Quad</option>
						<option value="Cubic" <?php selected($zAEasing,'Cubic'); ?> >Cubic</option>
						<option value="Quart" <?php selected($zAEasing,'Quart'); ?> >Quart</option>
						<option value="Quint" <?php selected($zAEasing,'Quint'); ?> >Quint</option>
						<option value="Sine" <?php selected($zAEasing,'Sine'); ?> >Sine</option>
						<option value="Expo" <?php selected($zAEasing,'Expo'); ?> >Expo</option>
						<option value="Circ" <?php selected($zAEasing,'Circ'); ?> >Circ</option>
						<option value="Elastic" <?php selected($zAEasing,'Elastic'); ?> >Elastic</option>
						<option value="Back" <?php selected($zAEasing,'Back'); ?> >Back</option>
						<option value="Bounce" <?php selected($zAEasing,'Bounce'); ?> >Bounce</option>
					</select>
					</p>	
				</div>
				<div class="slidedeck options" style="<?php if($Slider!='slidedeck'){ echo 'display:none'; }?>">
					<p>
					<label for="<?php echo $this->get_field_id('SDWidth'); ?>"><?php _e( 'Image Width in Slide' ,'ultimatum' ); ?></label>
					<input class="widefat" type="text" value="<?php echo $SDWidth; ?>"  id="<?php echo $this->get_field_id('SDWidth'); ?>" name="<?php echo $this->get_field_name('SDWidth'); ?>" />
					</p>
					<p>
	      			<label for="<?php echo $this->get_field_id('SDHeight'); ?>"><?php _e( 'Image Height in Slide' ,'ultimatum' ); ?></label>
	      			<input class="widefat" type="text" value="<?php echo $SDHeight; ?>"  id="<?php echo $this->get_field_id('SDHeight'); ?>" name="<?php echo $this->get_field_name('SDHeight'); ?>" />
	      			</p>
	      			<p>
					<label for="<?php echo $this->get_field_id('SDSpines'); ?>"><?php _e( 'Spines' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('SDSpines'); ?>" name="<?php echo $this->get_field_name('SDSpines'); ?>" >
						<option value="false" <?php selected($SDSpines,'false'); ?> >ON</option>
						<option value="true" <?php selected($SDSpines,'true'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('SDAuto'); ?>"><?php _e( 'Auto Slide' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('SDAuto'); ?>" name="<?php echo $this->get_field_name('SDAuto'); ?>" >
						<option value="true" <?php selected($SDAuto,'true'); ?> >ON</option>
						<option value="false" <?php selected($SDAuto,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('SDIndex'); ?>"><?php _e( 'Show Index Number' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('SDIndex'); ?>" name="<?php echo $this->get_field_name('SDIndex'); ?>" >
						<option value="true" <?php selected($SDIndex,'true'); ?> >ON</option>
						<option value="false" <?php selected($SDIndex,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('SDVideo'); ?>"><?php _e( 'Show Video Instead of Image' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('SDVideo'); ?>" name="<?php echo $this->get_field_name('SDVideo'); ?>" >
						<option value="true" <?php selected($SDVideo,'true'); ?> >ON</option>
						<option value="false" <?php selected($SDVideo,'false'); ?> >OFF</option>
					</select>
					</p>
					<p>
					<label for="<?php echo $this->get_field_id('SDInterval'); ?>"><?php _e( 'Slide Speed' ,'ultimatum' ); ?></label>
					<select class="widefat" id="<?php echo $this->get_field_id('SDInterval'); ?>" name="<?php echo $this->get_field_name('SDInterval'); ?>">
					<?php 
						for ($i=1000;$i<=4000;$i=$i+100){
							echo '<option value="'.$i.'" '.selected($SDInterval,$i,false).'>'.$i.'</option>';
						}
					?>	
					</select>
					</p>
				</div>
			</div>
		</div>
		
		<?php 
	}
} //Class End
add_action('widgets_init', create_function('', 'return register_widget("UltimatumSlide");'));
}

