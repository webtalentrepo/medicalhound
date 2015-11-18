<?php
class UltimatumRecent extends WP_Widget {

	function UltimatumRecent() {
        parent::WP_Widget(false, $name = 'Ultimatum Recent Posts');
    }

	function widget($args, $instance) {
		extract( $args );
		$source = $instance['source'];
		$count = $instance['count'];
		$class = '';
		$cat = false;
		$itemwidth = $grid_width;
		$instance["multipleh"] = $instance['height'];
		$instance["singleh"] = $instance['height'];
		$images=false;
		$cont_class= "vertical";
		$instance["noimage"]='true';
		$instance["mnoimage"]='true';
		if($instance['layout']==5 || $instance['layout']==6 || $instance['layout']==7 || $instance['layout']==8){
			switch ($instance['count']){
				case 1:
				break;
				case 2:
				 $class = 'one_half';
				 $itemwidth = $grid_width/2;
				break;
				case 3:
					$class = 'one_third';
					$itemwidth = $grid_width/3;
				break;
				case 4:
					$class = 'one_fourth';
					$itemwidth = $grid_width/4;
				break;
				case 5:
					$class = 'one_fifth';
					$itemwidth = $grid_width/5;
				break;
				case 6:
					$class = 'one_sixth';
					$itemwidth = $grid_width/5;
				break;
			}
			$cont_class= "horizontal";				
		} 
		if($instance['gallery']=='true'){
			$gallery = true;
			$rel = 'rel="prettyPhoto[]"';
		}
		
		global $wp_filter;
		$the_content_filter_backup = $wp_filter['the_content'];
		if(preg_match('/ptype-/i',$source)){
			$post_type= str_replace('ptype-', '', $source);
		} elseif(preg_match('/cat-/i',$source)){
			$post_type ='post';
			$cat = str_replace('cat-', '',$source);
		}elseif(preg_match('/taxonomy-/i',$source)){
	      	$prop = explode('|',str_replace('taxonomy-', '', $source));
	      	$post_type =$prop[0];
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
		}
		# set loop order and skip posts if defined
		$looporder1     = isset( $instance['looporder1'] ) ? $instance['looporder1'] : '';
		$looporder2     = isset( $instance['looporder2'] ) ? $instance['looporder2'] : '';
		$skip          = isset( $instance['skip'] ) ? $instance['skip'] : 0;
		
		// set order defaults
		$orderby = 'date';
		$order = 'DESC';
		
		$order      = isset( $instance['orderdir'] ) ? $instance['orderdir'] : 'DESC';
		
		if ($looporder1){
			$orderby = $looporder1;
		
			$setby1 =true;
		}
		
		if ($looporder2){
			if($setby1) {
				$orderby .= ' ' . $looporder2;
			}
			else
			{
				$orderby = $looporder2;
			}
		
		}
		$query = array(
            'posts_per_page' => (int)$count,
            'post_type'=>$post_type,
            'orderby'=>$orderby,
            'order'=>$order
        );
		if ( $skip > 0 ){
			$query['offset'] = $skip;
		}
		if($cat){
			$query['cat'] = $cat;
		}
		$query['showposts'] = $count;
		$r = new WP_Query($query);
		$j = 1;
		echo $before_widget;
		if ( $instance['title']) {
			echo $before_title . $instance['title'] . $after_title;
		}
		?>
		
		<div id="<?php echo $this->id.'-recent'; ?>">
		<?php 
		if ($r->have_posts()):
			while ($r->have_posts()) : $r->the_post();
			global $post;
			$link = get_permalink();
				?>
		
				<div class="recenposts<?php echo ' '.$cont_class;?>" >
				<div class="recentinner<?php echo ' '.$class;?><?php if($j==$count) echo ' last';?>" >

				<?php 
				if($instance['layout']==1 || $instance['layout']==5 ){
					$imgwidth = $itemwidth;
					$images = true;
					$align = '';
				} elseif ($instance['layout']=='2' || $instance['layout']=='6' || $instance['layout']=='3' || $instance['layout']=='7') {
					$imgwidth = $instance["width"];
					$images = true;	
					if($instance['layout']=='2' || $instance['layout']=='6'){
						$align = "fimage-align-left";
						
					} else {
						$align = "fimage-align-right";
						
					}				
				}
				if($images){
					if(!$gallery){?>
						<a href="<?php the_permalink(); ?>" <?php echo $rel?> class="preload">	
					<?php }
					 ultimatum_content_item_image($args,$instance,$imgwidth,$rel,$align,$gallery);
					 if(!$gallery){?>
					 </a>	
					 <?php }
				}
				?>
					<?php if($instance['showtitle']=='true') { ?>
						<?php if($instance['tlength']!=0) { 
							$post_title = get_the_title();
						if (strlen($post_title)>$instance['tlength']) $post_title=substr($post_title,0,$instance['tlength']).'...'; ?>
						<h4 class="recentposth3"><a href="<?php echo $link; ?>" class="recentlink"><?php echo $post_title;?></a></h4>
						<?php } else { ?>
						<h4 class="recentposth3"><a href="<?php echo $link; ?>" class="recentlink"><?php the_title();?></a></h4>
						<?php } ?>
					<?php } ?>
					<?php if($instance['showex']=='true') { ?>
						<p><?php echo wp_html_excerpt(get_the_excerpt(),$instance['exlength']);?>...</p>
					<?php } ?>
					<?php if($instance['showrm']=='true') { ?>
						<a href="<?php echo $link; ?>" class="recentreadmorelink"><span><?php _e($instance['rmtext'],'ultimatum') ?></span></a>
					<?php } ?>
				</div>
				</div>
				<?php
				$j++;
			endwhile;
		endif;
		?>
		</div>
		
		<?php 
		echo $after_widget;
		wp_reset_postdata();
		$wp_filter['the_content'] = $the_content_filter_backup;
		
		
    }

	function update($new_instance, $old_instance) {
		$instance['title']			= $new_instance['title'];
		$instance['layout']			= $new_instance['layout'];
		$instance['source']			= $new_instance['source'];
		$instance['count']			= $new_instance['count'];
		$instance['width']			= $new_instance['width'];
		$instance['height']			= $new_instance['height'];
		$instance['showtitle']		= $new_instance['showtitle'];
		$instance['tlength']		= $new_instance['tlength'];
		$instance['showex']			= $new_instance['showex'];
		$instance['exlength']		= $new_instance['exlength'];
		$instance['showrm']			= $new_instance['showrm'];
		$instance['rmtext']			= $new_instance['rmtext'];
		$instance['slide']			= $new_instance['slide'];
		$instance['sitems']			= $new_instance['sitems'];
		$instance['sitemh']			= $new_instance['sitemh'];
		$instance['gallery']		= $new_instance['gallery'];		
		$instance['margin']			= $new_instance['margin'];
		$instance['AnyColor']		= $new_instance['AnyColor'];

		$instance['looporder1'] = $new_instance['looporder1'];
		$instance['looporder2'] = $new_instance['looporder2'];
		$instance['orderdir']   = $new_instance['orderdir'];
		$instance['skip']       = $new_instance['skip'];
		
	    return $instance;
    }
    
	function form($instance) {
        $title 		= isset( $instance['title'] ) ? esc_attr($instance['title']):'';
       	$source 	= isset( $instance['source'] ) ? $instance['source'] : 'post';
       	$layout	 	= isset( $instance['layout'] ) ? $instance['layout'] : '2';
        $count	 	= isset( $instance['count'] ) ? $instance['count'] : '5';
        $width 		= isset( $instance['width'] ) ? $instance['width'] : '100';
        $height 	= isset( $instance['height'] ) ? $instance['height'] : '100';
        $showtitle	= isset( $instance['showtitle'] ) ? $instance['showtitle'] : 'true';
        $tlength	= isset( $instance['tlength'] ) ? $instance['tlength'] : '0';
        $showex		= isset( $instance['showex'] ) ? $instance['showex'] : 'true';
        $exlength	= isset( $instance['exlength'] ) ? $instance['exlength'] : '100';
        $showrm 	= isset( $instance['showrm'] ) ? $instance['showrm'] : 'true';
        $rmtext		= isset( $instance['rmtext'] ) ? $instance['rmtext'] : 'Read More';
        $slide		= isset( $instance['slide'] ) ? $instance['slide'] : 'false';
        $gallery	= isset( $instance['gallery'] ) ? $instance['gallery'] : 'false';
        $sitems		= isset( $instance['sitems'] ) ? $instance['sitems'] : '3';
        $sitemh		= isset( $instance['sitemh'] ) ? $instance['sitemh'] : '200';
        
        $margin		= isset( $instance['margin'] ) ? $instance['margin'] : '20';
        $AnyColor		= isset( $instance['AnyColor'] ) ? $instance['AnyColor'] : 'gray';//
        
        $looporder1     = isset( $instance['looporder1'] ) ? $instance['looporder1'] : '';
        $looporder2     = isset( $instance['looporder2'] ) ? $instance['looporder2'] : '';
        $orderdir       = isset( $instance['orderdir'] ) ? $instance['orderdir'] : 'DESC';
        $skip             = isset( $instance['skip'] ) ? $instance['skip'] : '';
        
        global $wpdb;
		$termstable = $wpdb->prefix.ULTIMATUM_PREFIX.'_tax';
        ?>
        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'ultimatum'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
        <p>
		<label for="<?php echo $this->get_field_id('source'); ?>"><?php _e( 'Select Content Source' ,'ultimatum' ); ?></label>
		<select  class="widefat" name="<?php echo $this->get_field_name('source'); ?>" id="<?php echo $this->get_field_id('source'); ?>" >
		<optgroup label="Post Type">
		<?php 
			$args=array('public'   => true,'publicly_queryable' => true);
			$post_types=get_post_types($args,'names');
			foreach ($post_types as $post_type ) {
				if($post_type!='attachment')
				echo '<option value="ptype-'.$post_type.'" '.selected($source,'ptype-'.$post_type,false).'>'.$post_type.'</option>';
			}
		?>
		</optgroup>
		<?php 
		$entries = get_categories('title_li=&orderby=name&hide_empty=0');
		if(count($entries)>=1){
			echo '<optgroup label="Categories(Post)">';
			foreach ($entries as $key => $entry) {
				echo '<option value="cat-'.$entry->term_id.'" '.selected($source,'cat-'.$entry->term_id,false).'>'.$entry->name.'</option>';
			}
			echo '</optgroup>';
		}
			?>
		<?php 
		unset($entries);
		$termsql = "SELECT * FROM $termstable";
		$termresult = $wpdb->get_results($termsql,ARRAY_A);
		foreach ($termresult as $term){
			$properties = unserialize($term['properties']);
			$entries = get_terms($term['tname'],'orderby=name');
			if(isset($entries) && is_array($entries)){
			echo '<optgroup label="'.$properties['label'].'('.$term['pname'].')">';
			foreach($entries as $key => $entry) {
				$optiont='taxonomy-'.$term['pname'].'|'.$properties['name'].'|'.$entry->slug;
				echo '<option value="'.$optiont.'" '.selected($source,$optiont,false).'>'.$entry->name.'</option>';
				}
			echo '</optgroup>';
			}
		}
		
		?>
		</select>
		</p>
		 <fieldset><legend>Post Ordering Options</legend>

        <p>
            <label for="<?php echo $this->get_field_id('looporder1'); ?>"><?php _e('Loop Order first', 'ultimatum') ?></label>
            <select class="widefat" name="<?php echo $this->get_field_name('looporder1'); ?>" id="<?php echo $this->get_field_id('looporder1'); ?>">
            <option value=''            <?php selected($looporder1, ''           );?>><?php _e( 'None'           , 'ultimatum') ?></option>
            <option value='ID'              <?php selected($looporder1, 'ID'             );?>><?php _e( 'ID'             , 'ultimatum') ?></option>
            <option value='author'          <?php selected($looporder1, 'author'         );?>><?php _e( 'author'         , 'ultimatum') ?></option>
            <option value='title'           <?php selected($looporder1, 'title'          );?>><?php _e( 'title'          , 'ultimatum') ?></option>
            <option value='name'            <?php selected($looporder1, 'name'           );?>><?php _e( 'name'           , 'ultimatum') ?></option>
            <option value='date'            <?php selected($looporder1, 'date'           );?>><?php _e( 'date {default}'           , 'ultimatum') ?></option>
            <option value='modified'        <?php selected($looporder1, 'modified'       );?>><?php _e( 'modified'       , 'ultimatum') ?></option>
            <option value='parent'          <?php selected($looporder1, 'parent'         );?>><?php _e( 'parent'         , 'ultimatum') ?></option>
            <option value='rand'            <?php selected($looporder1, 'rand'           );?>><?php _e( 'rand'           , 'ultimatum') ?></option>
            <option value='comment_count'   <?php selected($looporder1, 'comment_count'  );?>><?php _e( 'comment_count'  , 'ultimatum') ?></option>
            <option value='menu_order'      <?php selected($looporder1, 'menu_order'     );?>><?php _e( 'menu_order'     , 'ultimatum') ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('looporder2'); ?>"><?php _e('Loop Order second', 'ultimatum') ?></label>
            <select class="widefat" name="<?php echo $this->get_field_name('looporder2'); ?>" id="<?php echo $this->get_field_id('looporder2'); ?>">
            <option value=''            <?php selected($looporder2, ''           );?>><?php _e( 'None'           , 'ultimatum') ?></option>
            <option value='ID'              <?php selected($looporder2, 'ID'             );?>><?php _e( 'ID'             , 'ultimatum') ?></option>
            <option value='author'          <?php selected($looporder2, 'author'         );?>><?php _e( 'author'         , 'ultimatum') ?></option>
            <option value='title'           <?php selected($looporder2, 'title'          );?>><?php _e( 'title'          , 'ultimatum') ?></option>
            <option value='name'            <?php selected($looporder2, 'name'           );?>><?php _e( 'name'           , 'ultimatum') ?></option>
            <option value='date'            <?php selected($looporder2, 'date'           );?>><?php _e( 'date {default}'           , 'ultimatum') ?></option>
            <option value='modified'        <?php selected($looporder2, 'modified'       );?>><?php _e( 'modified'       , 'ultimatum') ?></option>
            <option value='parent'          <?php selected($looporder2, 'parent'         );?>><?php _e( 'parent'         , 'ultimatum') ?></option>
            <option value='rand'            <?php selected($looporder2, 'rand'           );?>><?php _e( 'rand'           , 'ultimatum') ?></option>
            <option value='comment_count'   <?php selected($looporder2, 'comment_count'  );?>><?php _e( 'comment_count'  , 'ultimatum') ?></option>
            <option value='menu_order'      <?php selected($looporder2, 'menu_order'     );?>><?php _e( 'menu_order'     , 'ultimatum') ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('orderdir'); ?>"><?php _e('Order Direction', 'ultimatum') ?></label>
            <select class="widefat" name="<?php echo $this->get_field_name('orderdir'); ?>" id="<?php echo $this->get_field_id('orderdir'); ?>">
            <option value='DESC'            <?php selected($orderdir, 'DESC'           );?>><?php _e( 'Descending'           , 'ultimatum') ?></option>
            <option value='ASC'             <?php selected($orderdir, 'ASC'             );?>><?php _e( 'Ascending'             , 'ultimatum') ?></option>

            </select>
        </p>
		<p>
		<label for="<?php echo $this->get_field_id('skip'); ?>"><?php _e('Skip first', 'ultimatum') ?>:</label>
		<input name="<?php echo $this->get_field_name('skip'); ?>" id="<?php echo $this->get_field_id('skip'); ?>" value="<?php echo $skip;?>"/>
		</p>
        </fieldset>
		<p>
		<label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('Layout', 'ultimatum') ?></label>
		<select class="widefat" name="<?php echo $this->get_field_name('layout'); ?>" id="<?php echo $this->get_field_id('layout'); ?>">
			<option value="1" <?php selected($layout,'1');?>><?php _e('Vertical with Full Image', 'ultimatum'); ?></option>
			<option value="2" <?php selected($layout,'2');?>><?php _e('Vertical with Image on Left', 'ultimatum'); ?></option>
			<option value="3" <?php selected($layout,'3');?>><?php _e('Vertical with Image on Right', 'ultimatum'); ?></option>
			<option value="4" <?php selected($layout,'4');?>><?php _e('Vertical with no Image', 'ultimatum'); ?></option>
			<option value="5" <?php selected($layout,'5');?>><?php _e('Horizontal with Full Image', 'ultimatum'); ?></option>
			<option value="6" <?php selected($layout,'6');?>><?php _e('Horizontal with Image on Left', 'ultimatum'); ?></option>
			<option value="7" <?php selected($layout,'7');?>><?php _e('Horizontal with Image on Right', 'ultimatum'); ?></option>
			<option value="8" <?php selected($layout,'8');?>><?php _e('Horizontal with no Image', 'ultimatum'); ?></option>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('gallery'); ?>"><?php _e('Act As Gallery?', 'ultimatum') ?></label>
		<select class="widefat" name="<?php echo $this->get_field_name('gallery'); ?>" id="<?php echo $this->get_field_id('gallery'); ?>">
		<option value="true" <?php selected($gallery,'true');?>>ON</option>
		<option value="false" <?php selected($gallery,'false');?>>OFF</option>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Item Count', 'ultimatum') ?></label>
		<select class="widefat" name="<?php echo $this->get_field_name('count'); ?>" id="<?php echo $this->get_field_id('count'); ?>">
			<option value="1" <?php selected($count,'1');?>>1</option>
			<option value="2" <?php selected($count,'2');?>>2</option>
			<option value="3" <?php selected($count,'3');?>>3</option>
			<option value="4" <?php selected($count,'4');?>>4</option>
			<option value="5" <?php selected($count,'5');?>>5</option>
			<option value="6" <?php selected($count,'6');?>>6</option>
		</select>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Image Width', 'ultimatum') ?></label>
		<input class="widefat" name="<?php echo $this->get_field_name('width'); ?>" id="<?php echo $this->get_field_id('width'); ?>"  value="<?php echo $width;?>"/><i>Used only on Image Left/Right Layouts</i>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Image Height', 'ultimatum') ?></label>
		<input class="widefat" name="<?php echo $this->get_field_name('height'); ?>" id="<?php echo $this->get_field_id('height'); ?>" value="<?php echo $height;?>"/>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('showtitle'); ?>"><?php _e('Show Title', 'ultimatum') ?></label>
		<select class="widefat" name="<?php echo $this->get_field_name('showtitle'); ?>" id="<?php echo $this->get_field_id('showtitle'); ?>">
		<option value="true" <?php selected($showtitle,'true');?>>ON</option>
		<option value="false" <?php selected($showtitle,'false');?>>OFF</option>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('tlength'); ?>"><?php _e('Title Length(Chars)', 'ultimatum') ?></label>
		<input class="widefat" name="<?php echo $this->get_field_name('tlength'); ?>" id="<?php echo $this->get_field_id('tlength'); ?>" value="<?php echo $tlength;?>"/><i>0 for no limit</i>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('showex'); ?>"><?php _e('Show Excerpt', 'ultimatum') ?></label>
		<select class="widefat" name="<?php echo $this->get_field_name('showex'); ?>" id="<?php echo $this->get_field_id('showex'); ?>">
		<option value="true" <?php selected($showex,'true');?>>ON</option>
		<option value="false" <?php selected($showex,'false');?>>OFF</option>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('exlength'); ?>"><?php _e('Excerpt Length(Chars)', 'ultimatum') ?></label>
		<input class="widefat" name="<?php echo $this->get_field_name('exlength'); ?>" id="<?php echo $this->get_field_id('exlength'); ?>" value="<?php echo $exlength;?>"/>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('showrm'); ?>"><?php _e('Show Read More', 'ultimatum') ?></label>
		<select class="widefat" name="<?php echo $this->get_field_name('showrm'); ?>" id="<?php echo $this->get_field_id('showrm'); ?>">
		<option value="true" <?php selected($showrm,'true');?>>ON</option>
		<option value="false" <?php selected($showrm,'false');?>>OFF</option>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('rmtext'); ?>"><?php _e('Read More Text', 'ultimatum') ?></label>
		<select class="widefat" name="<?php echo $this->get_field_name('rmtext'); ?>" id="<?php echo $this->get_field_id('rmtext'); ?>">
		<option value="Read More" <?php selected($rmtext,'Read More');?>><?php _e('Read More','ultimatum') ?></option>
		<option value="More" <?php selected($rmtext,'More');?>><?php _e('More','ultimatum') ?></option>
		<option value="Continue Reading" <?php selected($rmtext,'Continue Reading');?>><?php _e('Continue Reading','ultimatum') ?></option>
		<option value="Continue" <?php selected($rmtext,'Continue');?>><?php _e('Continue','ultimatum') ?></option>
		<option value="Details" <?php selected($rmtext,'Details');?>><?php _e('Details','ultimatum') ?></option>
		
		</select>
		</p>
		
		<?php 
    }

}
add_action('widgets_init', create_function('', 'return register_widget("UltimatumRecent");'));
?>